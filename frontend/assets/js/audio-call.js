/* audio-call.js
   LiveKit audio call logic for voice chatrooms only.
   Requires in header.php:
   <script src="https://cdn.jsdelivr.net/npm/livekit-client/dist/livekit-client.umd.min.js"></script>
*/

(function () {
    'use strict';

    const TOKEN_ENDPOINT = 'https://chat.crazynaters.com/crazynaters-call-backend/get-token';

    const {
        Room,
        RoomEvent,
        Track,
        createLocalAudioTrack,
    } = window.LivekitClient || {};

    let room = null;
    let localAudioTrack = null;
    let isMuted = false;
    let participantsRenderTimer = null;

    const els = {};

    function $(id) {
        return document.getElementById(id);
    }

    function initElements() {
        els.controls = $('voiceCallControls');
        els.callBtn = $('voiceCallBtn');
        els.connectedWrap = $('voiceCallConnectedWrap');
        els.participantsBtn = $('callParticipantsBtn');
        els.avatars = $('callParticipantsAvatars');
        els.count = $('callParticipantsCount');
        els.muteBtn = $('callMuteBtn');
        els.endBtn = $('callEndBtn');
        els.list = $('callParticipantsList');
        els.modalEl = $('callParticipantsModal');
        els.statusText = $('callStatusText');
    }

    function getState() {
        if (typeof window.getChatroomAudioCallState === 'function') {
            return window.getChatroomAudioCallState();
        }
        return window.ChatroomAudioCallState || {};
    }

    function getDisplayName(user) {
        if (!user) return '';
        return user.displayName || user.email || user.uid || 'User';
    }

    function getInitials(name) {
        return String(name || 'U')
            .trim()
            .split(/\s+/)
            .slice(0, 2)
            .map(part => part.charAt(0).toUpperCase())
            .join('') || 'U';
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function showCallUIForMode() {
        const state = getState();
        if (!els.controls) return;

        const shouldShow = state.activeMode === 'voice';
        els.controls.classList.toggle('d-none', !shouldShow);

        if (!shouldShow && room) {
            endCall();
        }

        if (shouldShow && room && room.name && state.selectedVoiceRoomId && room.name !== state.selectedVoiceRoomId) {
            endCall();
        }
    }

    function setDisconnectedUI() {
        if (els.callBtn) els.callBtn.classList.remove('d-none');
        if (els.connectedWrap) els.connectedWrap.classList.add('d-none');
        if (els.statusText) els.statusText.textContent = 'Connected';
        if (els.count) els.count.textContent = '0';
        isMuted = false;
        updateMuteButton();
        renderParticipants();
    }

    function setConnectedUI() {
        if (els.callBtn) els.callBtn.classList.add('d-none');
        if (els.connectedWrap) els.connectedWrap.classList.remove('d-none');
        if (els.statusText) els.statusText.textContent = 'Connected';
        updateParticipantsCount();
        renderParticipants();
    }

    async function fetchToken(identity, roomName, avatarUrl) {
        const response = await fetch(TOKEN_ENDPOINT, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                identity,
                roomName,
                name: identity,
                avatarUrl: avatarUrl || ''
            })
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            throw new Error(data.error || data.message || 'Unable to get LiveKit token.');
        }

        const token = data.token || data.accessToken || data.jwt;
        const serverUrl = data.livekitUrl || data.url || data.wsUrl || data.serverUrl || window.LIVEKIT_URL || '';

        if (!token) throw new Error('Token response missing token.');
        if (!serverUrl) throw new Error('Token response missing LiveKit server URL. Return { token, livekitUrl } from backend or set window.LIVEKIT_URL.');

        return { token, serverUrl };
    }

    async function startCall() {
        const state = getState();
        const user = state.currentUser;

        if (state.activeMode !== 'voice' || !state.selectedVoiceRoomId) {
            alert('Please select a voice chatroom first.');
            return;
        }

        if (!user || user.isAnonymous) {
            alert('Only registered users can join audio calls.');
            return;
        }

        if (!window.LivekitClient || !Room || !createLocalAudioTrack) {
            alert('LiveKit client not loaded. Please add the LiveKit CDN in header.php.');
            return;
        }

        try {
            if (els.callBtn) {
                els.callBtn.disabled = true;
                els.callBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            }

            const identity = getDisplayName(user);
            const roomName = state.selectedVoiceRoomId;
            const { token, serverUrl } = await fetchToken(identity, roomName, user.avatarUrl || '');

            room = new Room({
                adaptiveStream: true,
                dynacast: true,
            });

            setupRoomEvents();

            await room.connect(serverUrl, token);

            localAudioTrack = await createLocalAudioTrack({
                echoCancellation: true,
                noiseSuppression: true,
                autoGainControl: true,
            });

            await room.localParticipant.publishTrack(localAudioTrack);

            isMuted = false;
            updateMuteButton();
            setConnectedUI();
            startParticipantsRenderLoop();
            renderParticipants();
        } catch (error) {
            console.error('LiveKit call start error:', error);
            alert(error.message || 'Could not start audio call.');
            await endCall();
        } finally {
            if (els.callBtn) {
                els.callBtn.disabled = false;
                els.callBtn.innerHTML = '<i class="fas fa-phone-alt"></i>';
            }
        }
    }

    function setupRoomEvents() {
        if (!room) return;

        room.on(RoomEvent.ParticipantConnected, renderParticipants);
        room.on(RoomEvent.ParticipantDisconnected, renderParticipants);
        room.on(RoomEvent.ActiveSpeakersChanged, renderParticipants);
        room.on(RoomEvent.TrackMuted, renderParticipants);
        room.on(RoomEvent.TrackUnmuted, renderParticipants);
        room.on(RoomEvent.ConnectionStateChanged, renderParticipants);

        room.on(RoomEvent.TrackSubscribed, (track) => {
            if (track.kind === Track.Kind.Audio || track.kind === 'audio') {
                const audioElement = track.attach();
                audioElement.autoplay = true;
                audioElement.playsInline = true;
                audioElement.classList.add('remote-audio');
                document.body.appendChild(audioElement);

                const playPromise = audioElement.play();
                if (playPromise && typeof playPromise.catch === 'function') {
                    playPromise.catch(() => {
                        console.warn('Remote audio autoplay blocked until user interaction.');
                    });
                }
            }
        });

        room.on(RoomEvent.TrackUnsubscribed, (track) => {
            track.detach().forEach((element) => element.remove());
        });

        room.on(RoomEvent.Disconnected, resetCallUI);
    }

    function startParticipantsRenderLoop() {
        stopParticipantsRenderLoop();
        participantsRenderTimer = setInterval(() => {
            if (room) renderParticipants();
        }, 180);
    }

    function stopParticipantsRenderLoop() {
        if (participantsRenderTimer) {
            clearInterval(participantsRenderTimer);
            participantsRenderTimer = null;
        }
    }

    function getParticipants() {
        if (!room) return [];

        const state = getState();
        const user = state.currentUser || {};
        const local = room.localParticipant;
        const participants = [];

        const localIsSpeaking = Boolean(local?.isSpeaking) || getNumericAudioLevel(local) > 0.04;

        participants.push({
            sid: local.sid || 'local',
            identity: local.identity || getDisplayName(user),
            name: 'You',
            avatarUrl: user.avatarUrl || '',
            isLocal: true,
            isSpeaking: localIsSpeaking,
            isMuted: isMuted,
            audioLevel: getVisualAudioLevel(local, localIsSpeaking)
        });

        room.remoteParticipants.forEach((participant) => {
            const isSpeaking = Boolean(participant.isSpeaking) || getNumericAudioLevel(participant) > 0.04;
            let metadata = {};
            try {
                metadata = participant.metadata ? JSON.parse(participant.metadata) : {};
            } catch (_) {}

            participants.push({
                sid: participant.sid,
                identity: participant.identity,
                name: metadata.name || participant.name || participant.identity || 'Participant',
                avatarUrl: metadata.avatarUrl || '',
                isLocal: false,
                isSpeaking,
                isMuted: isParticipantMuted(participant),
                audioLevel: getVisualAudioLevel(participant, isSpeaking)
            });
        });

        return participants;
    }

    function updateParticipantsCount() {
        if (!els.count) return;
        const total = room ? getParticipants().length : 0;
        els.count.textContent = String(total);
    }


    function renderParticipantsAvatars(participants) {
        if (!els.avatars) return;

        if (!participants || !participants.length) {
            els.avatars.innerHTML = '';
            return;
        }

        const visibleParticipants = participants.slice(0, 5);

        els.avatars.innerHTML = visibleParticipants.map((participant) => {
            if (participant.avatarUrl) {
                return `<img src="${escapeHtml(participant.avatarUrl)}" class="call-mini-avatar" alt="">`;
            }

            return `<span class="call-mini-avatar-fallback">${escapeHtml(getInitials(participant.name || participant.identity))}</span>`;
        }).join('');
    }

    function renderParticipants() {
        updateParticipantsCount();

        const participants = getParticipants();
        renderParticipantsAvatars(participants);

        if (!els.list) return;

        if (!participants.length) {
            els.list.innerHTML = '<div class="text-muted small">No active participants.</div>';
            return;
        }

        participants.sort((a, b) => Number(b.isLocal) - Number(a.isLocal));

        els.list.innerHTML = participants.map((participant) => {
            const avatar = participant.avatarUrl
                ? `<img src="${escapeHtml(participant.avatarUrl)}" class="call-participant-avatar" alt="">`
                : `<div class="call-participant-avatar-fallback">${escapeHtml(getInitials(participant.name))}</div>`;

            const waveClass = participant.isMuted ? 'muted' : '';
            const muteLabel = participant.isMuted ? 'Muted' : 'Mic on';
            const speakLabel = participant.isSpeaking && !participant.isMuted ? 'Speaking' : muteLabel;

            return `
                <div class="call-participant-row">
                    ${avatar}
                    <div class="call-participant-info">
                        <div class="call-participant-name">${escapeHtml(participant.name)}</div>
                        <div class="call-participant-meta">
                            <span class="call-speaking-wave ${waveClass}">
                                <span></span><span></span><span></span>
                            </span>
                            <span>${escapeHtml(speakLabel)}</span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    async function toggleMute() {
        if (!localAudioTrack) return;

        const nextMutedState = !isMuted;

        try {
            if (nextMutedState) {
                if (typeof localAudioTrack.mute === 'function') await localAudioTrack.mute();
                else if (localAudioTrack.mediaStreamTrack) localAudioTrack.mediaStreamTrack.enabled = false;
            } else {
                if (typeof localAudioTrack.unmute === 'function') await localAudioTrack.unmute();
                else if (localAudioTrack.mediaStreamTrack) localAudioTrack.mediaStreamTrack.enabled = true;
            }

            isMuted = nextMutedState;
            updateMuteButton();
            renderParticipants();
        } catch (error) {
            console.error('Mute toggle error:', error);
            alert('Could not toggle microphone. Please check browser microphone permission.');
        }
    }

    function updateMuteButton() {
        if (!els.muteBtn) return;

        els.muteBtn.classList.toggle('muted', isMuted);
        els.muteBtn.innerHTML = isMuted
            ? '<i class="fas fa-microphone-slash"></i>'
            : '<i class="fas fa-microphone"></i>';
        els.muteBtn.title = isMuted ? 'Unmute' : 'Mute';
    }

    async function endCall() {
        stopParticipantsRenderLoop();

        try {
            document.querySelectorAll('audio.remote-audio').forEach((audio) => audio.remove());

            if (localAudioTrack) {
                localAudioTrack.stop();
                localAudioTrack = null;
            }

            if (room) {
                room.disconnect();
            }
        } catch (error) {
            console.error('End call error:', error);
        }

        resetCallUI();
    }

    function resetCallUI() {
        document.querySelectorAll('audio.remote-audio').forEach((audio) => audio.remove());
        stopParticipantsRenderLoop();

        room = null;
        localAudioTrack = null;
        isMuted = false;

        setDisconnectedUI();
    }

    function openParticipantsModal() {
        renderParticipants();
        if (els.modalEl && window.bootstrap) {
            bootstrap.Modal.getOrCreateInstance(els.modalEl).show();
        }
    }

    function isParticipantMuted(participant) {
        if (!participant?.audioTrackPublications) return false;

        for (const publication of participant.audioTrackPublications.values()) {
            if (typeof publication.isMuted === 'boolean') return publication.isMuted;
        }

        return false;
    }

    function getNumericAudioLevel(participant) {
        if (!participant || typeof participant.audioLevel !== 'number') return 0;
        if (!Number.isFinite(participant.audioLevel)) return 0;
        return Math.max(0, Math.min(1, participant.audioLevel));
    }

    function getVisualAudioLevel(participant, isSpeaking) {
        const actualLevel = getNumericAudioLevel(participant);
        if (actualLevel > 0) return actualLevel;
        return isSpeaking ? 0.55 : 0.02;
    }

    function bindEvents() {
        if (els.callBtn) els.callBtn.addEventListener('click', startCall);
        if (els.endBtn) els.endBtn.addEventListener('click', endCall);
        if (els.muteBtn) els.muteBtn.addEventListener('click', toggleMute);
        if (els.participantsBtn) els.participantsBtn.addEventListener('click', openParticipantsModal);

        window.addEventListener('chatroom-call-state-updated', showCallUIForMode);
        window.addEventListener('beforeunload', () => {
            if (room) room.disconnect();
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initElements();
        bindEvents();
        setDisconnectedUI();
        showCallUIForMode();
    });

    window.ChatroomAudioCall = {
        startCall,
        endCall,
        toggleMute,
        getParticipants
    };
})();
