
<?php
include('frontend/includes/header.php');
?>

<div class="container-fluid py-3 chat-neon-shell">
    <div class="chat-neon-topbar mb-3">
        <div class="chat-neon-brand">
            <img src="./assets/images/logo.png" class="chat-neon-logo" alt="Chatroom Logo">
            <div class="chat-neon-title-wrap">
                <h1 class="chat-neon-title">Crazynaters.com</h1>
                <p class="chat-neon-subtitle">Discover rooms, start conversations, and connect with others</p>
            </div>
        </div>

        <div class="neon-search-wrap voice-search-wrap top-voice-search">
            <i class="fas fa-search"></i>
            <input type="text" id="voiceRoomSearch" class="form-control" placeholder="Search voice chatrooms...">
        </div>

        <div class="chat-neon-actions header-control-cluster">
            <button type="button" id="createRoomBtn" class="neon-create-room-btn d-none">
                <i class="fas fa-plus-circle"></i>
                Create Room
            </button>

            <button type="button" id="paymentPlansBtn" class="round-payment-btn d-none" title="Private Room Plans">
                <i class="fas fa-credit-card"></i>
            </button>

            <button type="button" id="profileSettingsBtn" class="round-settings-btn d-none" title="Profile Settings">
                <i class="fas fa-cog"></i>
            </button>

            <div id="currentUserBox" class="top-current-user-box">
                <span class="badge bg-light text-dark">Checking user...</span>
            </div>

            <button type="button" id="logoutBtn" class="round-logout-btn d-none" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>

    <div class="row g-3 dashboard-main-layout">
        <div class="col-md-4 col-lg-3 dashboard-left-col">
            <div class="card shadow-sm h-100 room-sidebar-card">
                <div class="card-header bg-dark text-white room-sidebar-header">
                    <div class="d-flex align-items-center justify-content-between w-100">
                        <h5 class="mb-0">Recent Active Chatrooms</h5>
                        <small>See all</small>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="mobile-drawer-head d-lg-none">
                        <button type="button" id="mobileTextDrawerClose" class="mobile-drawer-close" aria-label="Close chatrooms drawer"><i class="fas fa-times"></i></button>
                        <div id="mobileTextDrawerProfile" class="mobile-drawer-profile">
                            <div class="mobile-drawer-avatar-fallback"><i class="fas fa-user"></i></div>
                            <div>
                                <div class="mobile-drawer-username">Guest</div>
                                <small>Text Chatrooms</small>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 border-bottom room-search-area">
                        <div class="neon-search-wrap text-search-wrap"><i class="fas fa-search"></i><input type="text" id="textRoomSearch" class="form-control" placeholder="Search chatrooms..."></div>
                    </div>

                    <div id="roomList" class="list-group list-group-flush modern-room-list" style="height: 70vh; overflow-y: auto;">
                        <div class="p-3 text-muted">Loading chatrooms...</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-lg-9 dashboard-right-col">
            <div class="right-content-stack">
                <div class="card shadow-sm voice-rooms-showcase-card">
                    <div class="card-body voice-carousel-body">
                        <div class="mobile-drawer-head mobile-voice-drawer-head d-lg-none">
                            <button type="button" id="mobileVoiceDrawerClose" class="mobile-drawer-close" aria-label="Close voice rooms drawer"><i class="fas fa-times"></i></button>
                            <div id="mobileVoiceDrawerProfile" class="mobile-drawer-profile">
                                <div class="mobile-drawer-avatar-fallback"><i class="fas fa-user"></i></div>
                                <div>
                                    <div class="mobile-drawer-username">Guest</div>
                                    <small>Voice Chatrooms</small>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-voice-search-wrap d-lg-none">
                            <div class="neon-search-wrap voice-drawer-search-wrap">
                                <i class="fas fa-search"></i>
                                <input type="text" id="mobileVoiceRoomSearch" class="form-control" placeholder="Search voice chatrooms...">
                            </div>
                        </div>

                        <button type="button" id="voicePrevBtn" class="voice-carousel-arrow voice-carousel-prev" title="Previous voice rooms">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div id="voiceRoomList" class="d-flex gap-3 overflow-auto voice-room-list-modern">
                            <div class="text-muted">Loading voice chatrooms...</div>
                        </div>

                        <button type="button" id="voiceNextBtn" class="voice-carousel-arrow voice-carousel-next" title="Next voice rooms">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="card shadow-sm position-relative chat-panel-card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2 chat-panel-header">
                        <div>
                            <h5 class="mb-0" id="selectedRoomTitle">Select a chatroom</h5>
                            <small id="selectedRoomMeta">Messages will appear here</small>
                        </div>
                        <div id="voiceCallControls" class="voice-call-controls d-none">
                            <button type="button" id="voiceCallBtn" class="call-round-btn call-start-btn" title="Start audio call">
                                <i class="fas fa-phone-alt"></i>
                            </button>

                            <div id="voiceCallConnectedWrap" class="call-connected-wrap d-none">
                                <span id="callStatusDot" class="call-status-dot"></span>
                                <span id="callStatusText" class="call-status-text">Connected</span>

                                <button type="button" id="callParticipantsBtn" class="call-participants-btn" title="Participants">
                                    <span id="callParticipantsAvatars" class="call-participants-avatars"></span>
                                    <span id="callParticipantsCount">0</span>
                                    <span class="call-participants-label">listeners</span>
                                </button>

                                <button type="button" id="callMuteBtn" class="call-round-btn call-mute-btn" title="Mute / Unmute">
                                    <i class="fas fa-microphone"></i>
                                </button>

                                <button type="button" id="callEndBtn" class="call-round-btn call-end-btn" title="End call">
                                    <i class="fas fa-phone-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                <div id="chatMessages" class="card-body chat-messages-body">
                    <div class="text-center text-muted mt-5">Select a text room from the left side or choose a voice room above.</div>
                </div>

                <div id="authEntryOverlay" class="auth-entry-overlay d-none">
                    <div class="auth-entry-card text-center">
                        <h5 class="mb-2">Join the chat</h5>
                        <p class="text-muted mb-3">Join as guest or login/register to start chatting.</p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <button type="button" id="joinGuestBtn" class="btn btn-primary">
                                Join as Guest
                            </button>
                            <button type="button" id="openAuthModalBtn" class="btn btn-outline-primary">
                                Login / Register
                            </button>
                        </div>
                    </div>
                </div>

                <div id="privateAccessOverlay" class="private-access-overlay d-none">
                    <div class="private-access-card text-center">
                        <div class="private-access-icon"><i class="fas fa-lock"></i></div>
                        <h5 class="mb-2">Private Chatroom</h5>
                        <p id="privateAccessMessage" class="mb-3">Purchase a plan to access this private chatroom.</p>
                        <button type="button" id="privateAccessPayBtn" class="btn btn-primary">
                            <i class="fas fa-credit-card me-1"></i> Purchase Plan
                        </button>
                        <button type="button" id="privateAccessLoginBtn" class="btn btn-outline-primary d-none mt-2">
                            Login / Register
                        </button>
                    </div>
                </div>

                <div id="loadOlderIndicator" class="small text-center text-muted py-2 d-none border-top">
                    Loading older messages...
                </div>

                <div id="typingIndicator" class="px-3 py-2 small text-muted d-none border-top bg-light">
                    Someone is typing...
                </div>

                <div id="voiceControlsWrap" class="border-top bg-white p-3 d-none">
                    <div class="voice-recorder-wrap">
                        <button id="discardVoiceBtn" class="voice-icon-btn voice-discard-btn" disabled title="Discard">
                            <i class="fas fa-trash"></i>
                        </button>

                        <button id="voiceAttachmentBtn" class="voice-icon-btn voice-attach-btn" disabled title="Attach file">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <input type="file" id="voiceAttachmentInput" class="d-none">

                        <button id="pauseRecordingBtn" class="voice-icon-btn voice-pause-btn" disabled title="Pause">
                            <i class="fas fa-pause"></i>
                        </button>

                        <div class="voice-wave-area flex-grow-1">
                            <div id="recordingStatus" class="small text-muted mb-1">Tap mic to record</div>

                            <div id="voiceWaveBars" class="voice-wave-bars d-none">
                                <span></span><span></span><span></span><span></span><span></span>
                                <span></span><span></span><span></span><span></span><span></span>
                            </div>

                            <audio id="voicePreview" controls class="w-100 d-none mt-2"></audio>
                            <div id="voiceAttachmentPreview" class="attachment-preview d-none"></div>
                        </div>

                        <button id="sendVoiceAttachmentBtn" class="voice-icon-btn voice-send-attachment-btn d-none" disabled title="Send attachment">
                            <i class="fas fa-paper-plane"></i>
                        </button>

                        <button id="recordToggleBtn" class="voice-main-btn" title="Record / Stop / Send">
                            <i id="recordToggleIcon" class="fas fa-microphone"></i>
                        </button>
                    </div>
                </div>

                <div class="card-footer" id="textComposerWrap">
                    <div class="input-group align-items-center position-relative">
                        <button id="emojiToggleBtn" class="emoji-btn" type="button" title="Emoji">😊</button>

                        <button id="textAttachmentBtn" class="attachment-btn" type="button" title="Attach file" disabled>
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <input type="file" id="textAttachmentInput" class="d-none">

                        <div id="textVoiceRecordPanel" class="text-voice-inline-panel d-none">
                            <button id="textDiscardVoiceBtn" class="composer-round-btn composer-danger-btn" type="button" title="Discard recording" disabled>
                                <i class="fas fa-trash"></i>
                            </button>
                            <button id="textPauseRecordingBtn" class="composer-round-btn composer-pause-btn" type="button" title="Pause recording" disabled>
                                <i class="fas fa-pause"></i>
                            </button>
                            <div class="text-voice-inline-wave">
                                <div id="textInlineRecordingStatus" class="text-voice-status">Recording...</div>
                                <div id="textInlineWaveBars" class="text-inline-wave-bars">
                                    <span></span><span></span><span></span><span></span><span></span>
                                    <span></span><span></span><span></span><span></span><span></span>
                                </div>
                            </div>
                        </div>

                        <input type="text" id="messageInput" class="form-control" placeholder="Type your message..." disabled>

                        <button id="textRecordToggleBtn" class="send-airplane-btn text-record-btn" disabled title="Record voice message">
                            <i id="textRecordToggleIcon" class="fas fa-microphone"></i>
                        </button>

                        <button id="sendBtn" class="send-airplane-btn d-none" disabled title="Send message">
                            <i class="fas fa-paper-plane"></i>
                        </button>

                        <div id="emojiPickerWrap" class="emoji-picker-wrap d-none">
                            <emoji-picker id="emojiPicker"></emoji-picker>
                        </div>
                    </div>
                    <div id="textAttachmentPreview" class="attachment-preview d-none"></div>
                    <!--<small class="text-muted d-block mt-2">-->
                    <!--    Login / Join as Guest from the center panel to send messages.-->
                    <!--</small>-->
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Drawer Overlay + Bottom Navigation -->
<div id="mobileDrawerOverlay" class="mobile-drawer-overlay d-lg-none"></div>

<nav id="mobileBottomNav" class="mobile-bottom-nav d-lg-none" aria-label="Mobile chat navigation">
    <button type="button" id="mobileChatroomsBtn" class="mobile-nav-btn active">
        <i class="fas fa-comments"></i>
        <span>Chatrooms</span>
    </button>
    <button type="button" id="mobileVoiceBtn" class="mobile-nav-btn">
        <i class="fas fa-microphone-alt"></i>
        <span>Voice</span>
    </button>
    <button type="button" id="mobilePaymentBtn" class="mobile-nav-btn">
        <i class="fas fa-credit-card"></i>
        <span>Payment</span>
    </button>
    <button type="button" id="mobileSettingsBtn" class="mobile-nav-btn">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
    </button>
    <button type="button" id="mobileProfileBtn" class="mobile-nav-btn mobile-profile-nav-btn">
        <span id="mobileProfileAvatar" class="mobile-profile-avatar"><i class="fas fa-user"></i></span>
        <span id="mobileProfileLabel">Login</span>
    </button>
    <button type="button" id="mobileLogoutBtn" class="mobile-nav-btn mobile-logout-nav-btn d-none">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </button>
</nav>


<!-- Message User Popup Modal -->
<div class="modal fade" id="messageUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content message-user-modal">
            <div class="modal-header">
                <h5 class="modal-title">User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="messageUserAvatarBox" class="message-user-popup-avatar mb-3"></div>
                <h5 id="messageUserNameText" class="message-user-popup-name mb-1">User</h5>
                <div id="messageUserFullNameText" class="message-user-popup-fullname small text-muted d-none"></div>
                <small class="text-muted">Chatroom user</small>
                <div id="messageUserLinkBox" class="message-user-popup-link-box mt-3 d-none"></div>
            </div>
        </div>
    </div>
</div>

<!-- Login/Register Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Join Chatroom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="d-flex gap-2 mb-3">
                    <button type="button" id="showLoginMode" class="btn btn-primary btn-sm">Login</button>
                    <button type="button" id="showRegisterMode" class="btn btn-outline-primary btn-sm">Register</button>
                    <button type="button" id="showForgotMode" class="btn btn-outline-primary btn-sm">Forgot Password?</button>
                </div>

                <div id="authAlertBox"></div>

                <div id="registerNameWrap" class="mb-3 d-none">
                    <label for="authName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="authName" placeholder="Enter your full name">

                    <label for="authUsername" class="form-label mt-3">Username</label>
                    <input type="text" class="form-control" id="authUsername" placeholder="Enter your username">
                    <small class="text-muted">This username will be shown everywhere in chat.</small>
                </div>

                <div id="registerAvatarWrap" class="mb-3 d-none">
                    <label for="authAvatarFile" class="form-label">Avatar Upload</label>
                    <input type="file" class="form-control" id="authAvatarFile" accept="image/*">
                    <small class="text-muted">Optional. Uploaded to Cloudinary folder: avatars</small>
                </div>

                <div class="mb-3">
                    <label for="authEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="authEmail" placeholder="Enter your email">
                </div>

                <div id="authPasswordWrap" class="mb-3">
                    <label for="authPassword" class="form-label">Password</label>
                    <input type="password" class="form-control" id="authPassword" placeholder="Enter password">
                </div>

                <div id="resetPasswordWrap" class="d-none">
                    <div class="mb-3">
                        <label for="resetNewPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="resetNewPassword" placeholder="Enter new password">
                    </div>
                    <div class="mb-3">
                        <label for="resetConfirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="resetConfirmPassword" placeholder="Confirm new password">
                    </div>
                </div>

                <input type="hidden" id="authMode" value="login">
                <input type="hidden" id="resetOobCode" value="">
            </div>

            <div class="modal-footer d-flex justify-content-between gap-2 flex-wrap">
                <button type="button" id="authActionBtn" class="btn btn-primary">Login</button>
            </div>
        </div>
    </div>
</div>

<!-- Profile Settings Modal -->
<div class="modal fade" id="profileSettingsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-settings-modern-modal">
            <div class="modal-header">
                <h5 class="modal-title">Profile Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="profileAlertBox"></div>

                <div class="mb-3">
                    <label for="profileEmail" class="form-label">Email</label>
                    <input type="email" id="profileEmail" class="form-control" placeholder="Email" disabled readonly>
                </div>

                <div class="mb-3">
                    <label for="profileUsername" class="form-label">Username</label>
                    <input type="text" id="profileUsername" class="form-control" placeholder="Update username">
                    <small class="text-muted">This username is shown everywhere in the chatroom.</small>
                </div>

                <div class="mb-3">
                    <label for="profileName" class="form-label">Full Name</label>
                    <input type="text" id="profileName" class="form-control" placeholder="Update full name">
                </div>

                <div class="mb-3">
                    <label for="profileAvatarFile" class="form-label">Avatar Upload</label>
                    <input type="file" id="profileAvatarFile" class="form-control" accept="image/*">
                    <small class="text-muted">Optional. Uploaded to Cloudinary folder: avatars</small>
                </div>

                <div class="mb-3">
                    <label for="profilePassword" class="form-label">New Password</label>
                    <input type="password" id="profilePassword" class="form-control" placeholder="Leave blank if unchanged">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="saveProfileBtn" class="btn btn-primary">Save Profile</button>
            </div>
        </div>
    </div>
</div>


<!-- Voice Call Participants Modal -->
<div class="modal fade" id="callParticipantsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content call-participants-modal">
            <div class="modal-header">
                <h5 class="modal-title">Call Participants</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="callParticipantsList" class="call-participants-list">
                    <div class="text-muted small">No active participants.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Plans Modal -->
<div class="modal fade" id="paymentPlansModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Private Room Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="paymentAlertBox"></div>
                <div id="currentPurchasedPlanBox" class="current-plan-box d-none"></div>

                <div id="paymentPlansLoading" class="small text-muted mb-3">Loading payment plans...</div>
                <div id="dynamicPaymentPlansList" class="row g-3 mb-3"></div>

                <div id="selectedPlanInfo" class="small text-muted mb-3">Select a plan to continue.</div>

                <div id="paymentCardWrap" class="d-none">
                    <label class="form-label">Card Details</label>
                    <div id="paymentCardElement" class="form-control py-3"></div>
                    <!--<small class="text-muted d-block mt-2">Use Stripe test card: 4242 4242 4242 4242</small>-->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="confirmPaymentBtn" class="btn btn-primary" disabled>Confirm Payment</button>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>

<style>
    .chat-messages-body {
        height: 60vh;
        overflow-y: auto;
        background: #f3f4f6;
        padding: 18px;
        position: relative;
    }

    .auth-entry-overlay {
        position: absolute;
        inset: 57px 0 70px 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(243,244,246,0.92);
        z-index: 5;
    }

    .auth-entry-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        width: min(420px, 92%);
    }

    .room-item {
        cursor: pointer;
        transition: 0.2s ease;
        border: none;
        border-bottom: 1px solid #eee;
    }
    .room-item:hover { background: #f5f9ff; }
    .active-room {
        background: #e8f1ff !important;
        border-left: 4px solid #0d6efd !important;
    }

    .room-row-wrap {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .room-logo {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #ddd;
    }

    .room-default-logo {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: 14px;
        flex-shrink: 0;
    }

    .voice-room-card {
        min-width: 260px;
        max-width: 260px;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 14px;
        background: #fff;
        cursor: pointer;
        transition: 0.2s ease;
        flex-shrink: 0;
    }
    .voice-room-card:hover {
        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
        transform: translateY(-1px);
    }
    .voice-room-card.active {
        border: 2px solid #0d6efd;
        background: #eef5ff;
    }

    .room-name { font-weight: 600; margin-bottom: 2px; }
    .room-id { font-size: 12px; color: #777; }
    .room-last-message {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .message-wrap { margin-bottom: 14px; }
    .message-wrap.text-start .message-row { justify-content: flex-start; }
    .message-wrap.text-end .message-row { justify-content: flex-end; }

    .message-row {
        display: flex;
        align-items: flex-end;
        gap: 8px;
    }

    .message-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #ddd;
    }

    .message-avatar-fallback {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #6c757d;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .message-bubble {
        max-width: 72%;
        padding: 10px 14px;
        border-radius: 12px;
        position: relative;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }

    .message-own {
        background: #0095d9;
        color: #fff;
        border-top-right-radius: 4px;
    }

    .message-other {
        background: #ffffff;
        color: #222;
        border-top-left-radius: 4px;
    }

    .message-meta {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 4px;
        opacity: 0.9;
    }

    .message-own .message-meta,
    .message-own .message-time {
        color: rgba(255,255,255,0.92);
    }

    .message-other .message-time {
        color: #8a8f98;
    }

    .message-text {
        font-size: 15px;
        line-height: 1.4;
        word-break: break-word;
    }

    .message-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
    }

    .message-time {
        font-size: 11px;
        white-space: nowrap;
    }

    .voice-note-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px 12px;
        max-width: 360px;
    }

    .voice-own .voice-note-card {
        background: #eaf6ff;
    }

    .voice-note-player {
        width: 100%;
        display: block;
        margin-top: 6px;
    }

    .voice-badge {
        display: inline-block;
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 999px;
        background: #eef2f7;
        color: #5a6472;
        margin-bottom: 6px;
    }

    .voice-recorder-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .voice-main-btn {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        border: none;
        background: #25d366;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        transition: 0.2s ease;
        flex-shrink: 0;
    }
    .voice-main-btn:hover { transform: scale(1.05); }
    .voice-main-btn.recording {
        background: #dc3545;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    .voice-main-btn.ready-send {
        background: #0d6efd;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .voice-icon-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #fff;
        flex-shrink: 0;
        transition: 0.2s ease;
    }
    .voice-icon-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .voice-discard-btn { background: #dc3545; }
    .voice-pause-btn { background: #6c757d; }

    .voice-wave-area {
        min-height: 54px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .voice-wave-bars {
        display: flex;
        align-items: center;
        gap: 4px;
        height: 26px;
    }
    .voice-wave-bars span {
        width: 4px;
        height: 10px;
        background: #25d366;
        border-radius: 10px;
        animation: waveAnim 1s infinite ease-in-out;
    }
    .voice-wave-bars span:nth-child(2) { animation-delay: 0.1s; }
    .voice-wave-bars span:nth-child(3) { animation-delay: 0.2s; }
    .voice-wave-bars span:nth-child(4) { animation-delay: 0.3s; }
    .voice-wave-bars span:nth-child(5) { animation-delay: 0.4s; }
    .voice-wave-bars span:nth-child(6) { animation-delay: 0.5s; }
    .voice-wave-bars span:nth-child(7) { animation-delay: 0.6s; }
    .voice-wave-bars span:nth-child(8) { animation-delay: 0.7s; }
    .voice-wave-bars span:nth-child(9) { animation-delay: 0.8s; }
    .voice-wave-bars span:nth-child(10) { animation-delay: 0.9s; }

    .send-airplane-btn {
        width: 48px;
        min-width: 48px;
        height: 48px;
        border: none;
        border-radius: 50%;
        background: #0d6efd;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        cursor: pointer;
        transition: 0.2s ease;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        margin-left: 10px;
    }

    .send-airplane-btn:hover:not(:disabled) {
        transform: scale(1.05);
    }

    .send-airplane-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        box-shadow: none;
    }

    .round-logout-btn {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background: #dc3545;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .round-logout-btn:hover {
        transform: scale(1.05);
    }

    .round-settings-btn {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background: rgba(255,255,255,0.18);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .round-settings-btn:hover {
        transform: scale(1.05);
        background: rgba(255,255,255,0.28);
    }

    .round-payment-btn {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        background: #198754;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .round-payment-btn:hover {
        transform: scale(1.05);
    }

    .room-access-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 999px;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .room-access-public {
        background: #e8f7ee;
        color: #157347;
    }

    .room-access-private {
        background: #fff3cd;
        color: #997404;
    }

    .purchased-plan-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 10px;
        font-weight: 700;
        padding: 3px 7px;
        border-radius: 999px;
        background: rgba(255,255,255,0.18);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.22);
        margin-top: 3px;
        width: fit-content;
    }

    .current-user-chip {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 999px;
        padding: 6px 10px 6px 6px;
    }

    .current-user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.6);
        flex-shrink: 0;
    }

    .current-user-avatar-fallback {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #ffffff;
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        flex-shrink: 0;
    }

    .current-user-info {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .current-user-name {
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        max-width: 160px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .current-user-type {
        font-size: 11px;
        color: rgba(255,255,255,0.82);
    }

    .emoji-btn {
        width: 42px;
        height: 42px;
        border: none;
        background: transparent;
        font-size: 20px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .emoji-picker-wrap {
        position: absolute;
        bottom: 60px;
        left: 0;
        z-index: 20;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        border-radius: 12px;
        overflow: hidden;
    }

    emoji-picker {
        --border-size: 0;
        width: 320px;
        height: 380px;
    }

    @keyframes waveAnim {
        0%, 100% { height: 8px; opacity: 0.5; }
        50% { height: 26px; opacity: 1; }
    }

    /* ===== Neon modern UI refresh - visual only ===== */
    :root {
        --neon-bg-1: #02051a;
        --neon-bg-2: #07144a;
        --neon-panel: rgba(7, 18, 70, 0.72);
        --neon-panel-2: rgba(10, 20, 82, 0.88);
        --neon-border: rgba(56, 104, 255, 0.38);
        --neon-border-soft: rgba(95, 140, 255, 0.22);
        --neon-cyan: #00e5ff;
        --neon-blue: #1a6dff;
        --neon-purple: #a500ff;
        --neon-pink: #ff31d8;
        --neon-green: #00e497;
        --neon-text: #f6fbff;
        --neon-muted: #98a7d8;
    }
    body {
        background: radial-gradient(circle at top left, rgba(26, 109, 255, 0.22), transparent 34%), radial-gradient(circle at 82% 12%, rgba(165, 0, 255, 0.22), transparent 28%), radial-gradient(circle at bottom right, rgba(97, 0, 255, 0.28), transparent 38%), linear-gradient(135deg, #020514 0%, #06153e 45%, #050021 100%) !important;
        color: var(--neon-text);
    }
    .chat-neon-shell { min-height: calc(100vh - 20px); color: var(--neon-text); }
    .chat-neon-topbar { display: grid; grid-template-columns: minmax(220px, 1fr) minmax(280px, 604px); align-items: center; gap: 22px; padding: 10px 8px 2px; }
    .chat-neon-title { margin: 0; color: #fff; font-size: clamp(24px, 3vw, 34px); font-weight: 800; letter-spacing: -0.04em; text-shadow: 0 0 28px rgba(0, 229, 255, 0.16); }
    .chat-neon-subtitle { margin: 4px 0 0; color: var(--neon-muted); font-size: 14px; }
    .chat-neon-actions { display: flex; align-items: center; justify-content: flex-end; gap: 14px; flex-wrap: wrap; }
    .neon-search-wrap { position: relative; flex: 1 1 260px; }
    .neon-search-wrap i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #aac0ff; z-index: 2; font-size: 14px; }
    .neon-search-wrap .form-control { height: 52px; padding-left: 48px; border-radius: 14px; background: rgba(3, 15, 62, 0.8) !important; border: 1px solid var(--neon-border) !important; color: #fff !important; box-shadow: inset 0 0 18px rgba(41, 111, 255, 0.08), 0 0 30px rgba(16, 83, 255, 0.08); }
    .neon-search-wrap .form-control::placeholder { color: #8ea1d6; }
    .neon-search-wrap .form-control:focus { box-shadow: 0 0 0 0.16rem rgba(0, 229, 255, 0.18), 0 0 28px rgba(0, 229, 255, 0.16) !important; }
    .neon-create-room-btn { height: 52px; border: 0; border-radius: 14px; padding: 0 22px; color: #fff; font-weight: 800; background: linear-gradient(135deg, #8e2cff, #116dff 72%, #00e5ff); box-shadow: 0 0 22px rgba(35, 112, 255, 0.45), inset 0 0 16px rgba(255,255,255,0.18); display: inline-flex; align-items: center; gap: 9px; white-space: nowrap; transition: .22s ease; }
    .neon-create-room-btn:hover { transform: translateY(-1px); box-shadow: 0 0 30px rgba(0, 229, 255, 0.42), 0 0 28px rgba(165, 0, 255, 0.26); }
    .voice-rooms-showcase-card, .room-sidebar-card, .chat-panel-card { background: linear-gradient(180deg, rgba(10, 25, 92, 0.78), rgba(6, 14, 60, 0.78)) !important; border: 1px solid var(--neon-border) !important; border-radius: 16px !important; box-shadow: 0 20px 70px rgba(0, 0, 0, 0.35), inset 0 0 32px rgba(25, 98, 255, 0.08) !important; overflow: hidden; backdrop-filter: blur(14px); }
    .voice-rooms-showcase-card .card-body { padding: 14px; }
    .voice-room-list-modern { scrollbar-width: thin; scrollbar-color: rgba(0,229,255,.65) transparent; }
    .room-sidebar-card .card-body, .chat-panel-card .card-body, .chat-panel-card .card-footer { background: transparent !important; }
    .room-sidebar-header, .chat-panel-header { background: rgba(4, 11, 46, 0.5) !important; border-bottom: 1px solid var(--neon-border-soft) !important; color: #fff !important; padding: 16px 18px; }
    .room-sidebar-header h5, .chat-panel-header h5 { font-weight: 800; letter-spacing: -0.02em; }
    .room-sidebar-header small { color: #9fb4ff; }
    .room-search-area { border-color: var(--neon-border-soft) !important; }
    .text-search-wrap .form-control { height: 44px; border-radius: 12px; }
    .modern-room-list { background: transparent !important; padding: 8px 8px 14px; scrollbar-width: thin; scrollbar-color: rgba(0,229,255,.65) transparent; }
    .room-item { background: transparent !important; color: #eaf2ff !important; border: 0 !important; border-bottom: 1px solid rgba(120, 149, 255, 0.12) !important; border-radius: 12px !important; margin-bottom: 6px; padding: 12px 10px !important; }
    .room-item:hover { background: rgba(20, 72, 180, 0.25) !important; box-shadow: inset 0 0 22px rgba(0, 229, 255, 0.06); }
    .active-room { background: linear-gradient(90deg, rgba(0, 229, 255, 0.16), rgba(107, 35, 255, 0.16)) !important; border-left: 4px solid var(--neon-cyan) !important; box-shadow: 0 0 26px rgba(0, 229, 255, 0.16), inset 0 0 28px rgba(26, 109, 255, 0.08); }
    .room-logo, .room-default-logo { width: 46px; height: 46px; border: 1px solid rgba(0, 229, 255, 0.48); box-shadow: 0 0 18px rgba(0, 229, 255, 0.16); }
    .room-default-logo { background: linear-gradient(135deg, rgba(0,229,255,.15), rgba(165,0,255,.18)); color: #00e5ff; }
    .room-name { color: #fff; font-weight: 800; }
    .room-id, .room-last-message, .text-muted, small.text-muted { color: #94a6d6 !important; }
    .badge.bg-success, .badge.bg-primary { background: rgba(0, 228, 151, 0.16) !important; color: #00f5b1 !important; border: 1px solid rgba(0, 228, 151, 0.38); border-radius: 999px; font-weight: 800; letter-spacing: .02em; }
    .badge.bg-warning, .badge.bg-warning.text-dark { background: rgba(255, 180, 0, 0.16) !important; color: #ffc451 !important; border: 1px solid rgba(255, 180, 0, 0.36); border-radius: 999px; font-weight: 800; }
    .voice-room-card { min-width: 220px; max-width: 240px; border-radius: 14px; border: 1px solid rgba(75, 119, 255, 0.34); background: linear-gradient(180deg, rgba(13, 31, 106, .72), rgba(9, 20, 78, .72)); color: #fff; box-shadow: inset 0 0 22px rgba(0, 229, 255, 0.06); }
    .voice-room-card:hover, .voice-room-card.active { border-color: rgba(0, 229, 255, .8); background: linear-gradient(180deg, rgba(21, 47, 146, .82), rgba(12, 27, 98, .86)); box-shadow: 0 0 30px rgba(0, 229, 255, 0.16), inset 0 0 24px rgba(0, 229, 255, 0.06); }
    .chat-messages-body { background: radial-gradient(circle at top right, rgba(47, 83, 255, 0.16), transparent 42%), rgba(4, 10, 45, 0.66) !important; height: 60vh; border-bottom: 1px solid var(--neon-border-soft); }
    .message-bubble { border: 1px solid rgba(91, 126, 255, 0.16); box-shadow: 0 10px 28px rgba(0,0,0,.18); }
    .message-own { background: linear-gradient(135deg, #006dff, #9a20ff) !important; color: #fff; }
    .message-other { background: rgba(11, 25, 80, 0.78) !important; color: #eaf2ff; }
    .message-meta { color: #00e5ff; }
    .message-own .message-meta { color: #fff; }
    .message-avatar, .message-avatar-fallback, .current-user-avatar, .current-user-avatar-fallback { border: 1px solid rgba(0, 229, 255, 0.55); box-shadow: 0 0 14px rgba(0, 229, 255, 0.16); }
    .auth-entry-overlay { background: rgba(2, 8, 36, 0.62); backdrop-filter: blur(8px); height: 100% !important; top: 0; }
    .auth-entry-card { background: linear-gradient(180deg, rgba(15, 34, 109, 0.94), rgba(8, 19, 78, 0.96)); border: 1px solid rgba(0,229,255,.32); color: #fff; box-shadow: 0 0 36px rgba(0, 229, 255, 0.16); }
    .auth-entry-card .btn-primary, .modal-content .btn-primary { border: 0; background: linear-gradient(135deg, #006dff, #9a20ff) !important; box-shadow: 0 0 22px rgba(35, 112, 255, 0.28); font-weight: 700; }
    .auth-entry-card .btn-outline-primary, .modal-content .btn-outline-primary { color: #d9e7ff; border-color: rgba(0,229,255,.45); background: rgba(14, 28, 93, 0.55); }
    #textComposerWrap, #voiceControlsWrap { background: rgba(5, 13, 54, 0.88) !important; border-top: 1px solid var(--neon-border-soft) !important; }
    #messageInput { background: rgba(10, 24, 78, .72) !important; color: #fff !important; border: 1px solid rgba(80, 116, 255, .38) !important; border-radius: 14px !important; height: 48px; }
    #messageInput::placeholder { color: #90a1d0; }
    .emoji-btn { color: #dbe8ff; background: rgba(14, 31, 93, .68); border: 1px solid rgba(80, 116, 255, .32); border-radius: 12px; margin-right: 8px; }
    .send-airplane-btn, .voice-main-btn { background: linear-gradient(135deg, #006dff, #0047ff 55%, #00e5ff) !important; box-shadow: 0 0 24px rgba(0, 92, 255, .45) !important; }
    .voice-main-btn.recording { background: linear-gradient(135deg, #ff315f, #a500ff) !important; }
    .voice-main-btn.ready-send { background: linear-gradient(135deg, #00d084, #006dff) !important; }
    .current-user-chip { background: rgba(9, 24, 82, 0.8); border: 1px solid rgba(0,229,255,.28); box-shadow: inset 0 0 18px rgba(0,229,255,.05); }
    .purchased-plan-badge { display: inline-flex; align-items: center; gap: 4px; margin-top: 3px; color: #ffd166; font-size: 10px; font-weight: 800; }
    .round-payment-btn, .round-settings-btn, .round-logout-btn { border: 1px solid rgba(0,229,255,.26) !important; background: rgba(9, 24, 82, 0.82) !important; color: #fff !important; box-shadow: 0 0 18px rgba(0, 229, 255, .08); }
    .round-logout-btn { background: rgba(220, 53, 69, 0.72) !important; }
    .modal-content { background: linear-gradient(180deg, rgba(10, 24, 89, 0.98), rgba(5, 10, 45, 0.98)) !important; color: #f8fbff; border: 1px solid rgba(0,229,255,.35); border-radius: 18px; box-shadow: 0 24px 70px rgba(0,0,0,.5), 0 0 34px rgba(0,229,255,.12); }
    .modal-header, .modal-footer { border-color: rgba(95, 140, 255, 0.20) !important; }
    .modal-content .form-control { background: rgba(5, 16, 61, 0.82) !important; border: 1px solid rgba(95, 140, 255, 0.34) !important; color: #fff !important; border-radius: 12px; }
    .modal-content .form-label { color: #dbe7ff; }
    .btn-close { filter: invert(1) grayscale(100%); }
    .payment-plan-btn { border-radius: 14px; min-height: 88px; background: rgba(10, 26, 88, .82); }
    .payment-plan-btn.active, .payment-plan-btn:hover { background: linear-gradient(135deg, rgba(0,109,255,.35), rgba(165,0,255,.35)); border-color: rgba(0,229,255,.75); color: #fff; }
    .payment-empty-state { border: 1px dashed rgba(0,229,255,.35); border-radius: 14px; background: rgba(10, 26, 88, .42); color: #b7c7f3; font-weight: 700; }


/* ===== Profile settings modal polish ===== */
#profileSettingsModal .modal-dialog {
    max-width: 560px;
}

#profileSettingsModal .profile-settings-modern-modal {
    border-radius: 22px !important;
    overflow: hidden;
    background:
        radial-gradient(circle at 18% 0%, rgba(0, 216, 255, .20), transparent 34%),
        radial-gradient(circle at 88% 14%, rgba(126, 0, 255, .24), transparent 38%),
        linear-gradient(145deg, rgba(2, 14, 52, .98), rgba(7, 6, 45, .98)) !important;
    border: 1px solid rgba(0, 207, 255, .42) !important;
    box-shadow: 0 0 44px rgba(0, 191, 255, .24), 0 24px 80px rgba(0, 0, 0, .52) !important;
}

#profileSettingsModal .modal-header {
    padding: 18px 22px !important;
    background: linear-gradient(90deg, rgba(0, 188, 255, .16), rgba(122, 40, 255, .14)) !important;
    border-bottom: 1px solid rgba(0, 207, 255, .26) !important;
}

#profileSettingsModal .modal-title {
    color: #ffffff !important;
    font-weight: 900 !important;
    letter-spacing: -.02em;
}

#profileSettingsModal .modal-body {
    padding: 22px 24px !important;
}

#profileSettingsModal .form-label {
    color: #dff5ff !important;
    font-weight: 800 !important;
    font-size: 13px;
    margin-bottom: 7px;
}

#profileSettingsModal .form-control {
    min-height: 48px;
    border-radius: 14px !important;
    background: rgba(8, 21, 62, .92) !important;
    border: 1px solid rgba(0, 207, 255, .34) !important;
    color: #ffffff !important;
    box-shadow: inset 0 0 20px rgba(0, 0, 0, .16), 0 0 16px rgba(0, 194, 255, .06) !important;
}

#profileSettingsModal .form-control:focus {
    border-color: rgba(0, 234, 255, .78) !important;
    box-shadow: 0 0 0 .18rem rgba(0, 207, 255, .16), 0 0 26px rgba(0, 207, 255, .18) !important;
}

#profileSettingsModal .form-control:disabled,
#profileSettingsModal .form-control[readonly] {
    background: rgba(60, 75, 105, .45) !important;
    color: rgba(231, 241, 255, .74) !important;
    border-color: rgba(180, 205, 255, .20) !important;
}

#profileSettingsModal small.text-muted {
    color: rgba(175, 205, 255, .82) !important;
}

#profileSettingsModal .modal-footer {
    padding: 16px 22px !important;
    background: rgba(1, 10, 38, .60) !important;
    border-top: 1px solid rgba(0, 207, 255, .22) !important;
}

#profileSettingsModal #saveProfileBtn {
    border-radius: 14px !important;
    padding: 11px 22px !important;
    font-weight: 900 !important;
    background: linear-gradient(135deg, #00cfff, #6e12ff) !important;
    border: 1px solid rgba(255, 255, 255, .30) !important;
    box-shadow: 0 0 28px rgba(0, 207, 255, .42) !important;
}

#profileSettingsModal .btn-close {
    filter: invert(1) brightness(1.8);
    opacity: .9;
}

    @media (max-width: 991px) { .chat-neon-topbar { grid-template-columns: 1fr; } .chat-neon-actions { justify-content: stretch; } .neon-create-room-btn { flex: 1 1 160px; justify-content: center; } }
    @media (max-width: 576px) { .chat-neon-title { font-size: 26px; } .voice-room-card { min-width: 200px; } .chat-messages-body { height: 58vh; } }


    /* ===== Screenshot closer layout overrides ===== */
    .chat-neon-shell {
        min-height: calc(100vh - 18px);
        height: calc(100vh - 18px);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .chat-neon-topbar {
        grid-template-columns: minmax(250px, 1.05fr) minmax(260px, 520px) auto !important;
        padding: 10px 8px 6px !important;
        gap: 18px !important;
        flex: 0 0 auto;
    }

    .chat-neon-brand {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .chat-neon-logo {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: radial-gradient(circle at 30% 20%, rgba(0,229,255,.95), rgba(0,89,255,.88) 48%, rgba(165,0,255,.82));
        box-shadow: 0 0 24px rgba(0,229,255,.35), inset 0 0 18px rgba(255,255,255,.14);
        border: 1px solid rgba(0,229,255,.45);
        flex: 0 0 auto;
    }

    .top-voice-search { max-width: 560px; width: 100%; justify-self: stretch; }
    .header-control-cluster { justify-content: flex-end !important; flex-wrap: nowrap !important; gap: 12px !important; }

    .dashboard-main-layout {
        flex: 1 1 auto;
        min-height: 0;
        height: calc(100vh - 116px);
    }

    .dashboard-left-col,
    .dashboard-right-col,
    .right-content-stack {
        min-height: 0;
        height: 100%;
    }

    .right-content-stack {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .room-sidebar-card {
        height: 100% !important;
    }

    .modern-room-list {
        height: calc(100vh - 245px) !important;
        padding-bottom: 12px;
    }

    .voice-rooms-showcase-card {
        flex: 0 0 auto;
        margin-bottom: 0 !important;
    }

    .voice-carousel-body {
        position: relative;
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr) 42px;
        gap: 10px;
        align-items: center;
        padding: 12px !important;
    }

    .voice-room-list-modern {
        padding: 0 !important;
        overflow-x: auto !important;
        scroll-behavior: smooth;
    }

    .voice-room-list-modern::-webkit-scrollbar { height: 0; }
    .voice-room-list-modern { scrollbar-width: none; }

    .voice-carousel-arrow {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid rgba(0,229,255,.36);
        background: rgba(5, 17, 72, .82);
        color: #dfeaff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 18px rgba(0,229,255,.10);
        transition: .2s ease;
    }

    .voice-carousel-arrow:hover {
        transform: translateY(-1px);
        border-color: rgba(0,229,255,.72);
        box-shadow: 0 0 24px rgba(0,229,255,.22);
    }

    .chat-panel-card {
        flex: 1 1 auto;
        min-height: 0;
        display: flex;
        flex-direction: column;
    }

    .chat-panel-header {
        flex: 0 0 auto;
        min-height: 46px;
        padding: 10px 16px !important;
    }

    .hide-chat-visual-btn {
        border: 0;
        color: #b8c6ee;
        background: transparent;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
    }

    .chat-messages-body {
        flex: 1 1 auto;
        min-height: 260px;
        height: auto !important;
    }

    #textComposerWrap,
    #voiceControlsWrap {
        flex: 0 0 auto;
    }

    .current-user-chip {
        min-height: 48px;
        padding: 6px 10px 6px 6px !important;
        cursor: default;
    }

    .current-user-chip::after {
        content: '\f078';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 11px;
        color: #b9c9ff;
        margin-left: 2px;
    }

    .round-payment-btn, .round-settings-btn, .round-logout-btn {
        width: 48px !important;
        height: 48px !important;
        min-width: 48px;
        border-radius: 14px !important;
    }

    .round-logout-btn {
        border-radius: 50% !important;
    }

    .room-item .room-row-wrap { align-items: center !important; }
    .room-last-message { max-width: 160px; }
    .room-access-badge.public .access-dot,
    .room-access-badge .online-dot,
    .online-dot,
    .user-online-dot,
    .green-dot,
    .voice-online-dot { display: none !important; }

    .voice-room-card {
        min-width: 190px !important;
        max-width: 210px !important;
        padding: 12px !important;
    }

    .voice-room-card .room-logo,
    .voice-room-card .room-default-logo {
        width: 54px !important;
        height: 54px !important;
        box-shadow: 0 0 18px rgba(0,229,255,.20);
    }

    .voice-room-card .small.mb-2 { display: none; }

    @media (max-width: 991px) {
        .chat-neon-shell { height: auto; overflow: visible; }
        .chat-neon-topbar { grid-template-columns: 1fr !important; }
        .header-control-cluster { flex-wrap: wrap !important; justify-content: flex-start !important; }
        .dashboard-main-layout { height: auto; }
        .room-sidebar-card, .dashboard-left-col, .dashboard-right-col, .right-content-stack { height: auto !important; }
        .modern-room-list { height: 52vh !important; }
        .chat-panel-card { min-height: 68vh; }
    }


/* ===== Screenshot-inspired message thread + voice carousel polish ===== */
body.chat-dashboard-modern,
body {
    background:
        radial-gradient(circle at 78% 4%, rgba(115, 0, 255, 0.28), transparent 34%),
        radial-gradient(circle at 18% 100%, rgba(0, 190, 255, 0.18), transparent 32%),
        linear-gradient(135deg, #020716 0%, #03133b 46%, #100027 100%) !important;
}

.modern-topbar,
.dashboard-topbar,
.chat-dashboard-header {
    background: transparent !important;
    border-bottom: 0 !important;
}

.card,
.modern-card,
.chat-shell-card {
    background: rgba(2, 13, 45, 0.76) !important;
    border: 1px solid rgba(0, 180, 255, 0.28) !important;
    box-shadow: 0 0 28px rgba(0, 132, 255, 0.14), inset 0 0 42px rgba(68, 0, 255, 0.08) !important;
    backdrop-filter: blur(18px);
}

.chat-messages-body {
    height: 62vh !important;
    background:
        radial-gradient(circle at 88% 22%, rgba(102, 0, 255, 0.18), transparent 32%),
        linear-gradient(135deg, rgba(1, 16, 55, 0.94), rgba(0, 4, 26, 0.98)) !important;
    padding: 22px 24px 18px !important;
    border-top: 1px solid rgba(0, 183, 255, 0.18);
    border-bottom: 1px solid rgba(0, 183, 255, 0.18);
    scrollbar-color: rgba(190, 210, 255, .72) rgba(255, 255, 255, .08);
    scrollbar-width: thin;
}

.chat-messages-body::-webkit-scrollbar {
    width: 10px;
}
.chat-messages-body::-webkit-scrollbar-track {
    background: rgba(255,255,255,.06);
    border-radius: 999px;
}
.chat-messages-body::-webkit-scrollbar-thumb {
    background: linear-gradient(180deg, rgba(255,255,255,.55), rgba(0,180,255,.42));
    border-radius: 999px;
}

.message-wrap {
    margin-bottom: 18px !important;
}

.message-row {
    gap: 12px !important;
    align-items: flex-end !important;
}

.message-wrap.text-end .message-row {
    justify-content: flex-end !important;
}

.message-wrap.text-start .message-row {
    justify-content: flex-start !important;
}

.message-avatar,
.current-user-avatar,
.room-logo {
    border: 1px solid rgba(0, 225, 255, .85) !important;
    box-shadow: 0 0 16px rgba(0, 208, 255, .34);
}

.message-avatar-fallback,
.current-user-avatar-fallback,
.room-default-logo {
    background: linear-gradient(135deg, #0b8fc6, #7635dd) !important;
    border: 1px solid rgba(0, 225, 255, .85) !important;
    box-shadow: 0 0 16px rgba(0, 208, 255, .32);
}

.message-bubble {
    max-width: min(62%, 420px) !important;
    padding: 13px 16px !important;
    border-radius: 14px !important;
    border: 1px solid rgba(0, 195, 255, .24);
    background: rgba(14, 36, 78, .86) !important;
    color: #eaf2ff !important;
    box-shadow: 0 0 18px rgba(0, 160, 255, .14), inset 0 0 22px rgba(255,255,255,.035) !important;
}

.message-own {
    background: linear-gradient(135deg, rgba(0, 145, 255, .92), rgba(102, 0, 255, .95)) !important;
    border: 1px solid rgba(0, 225, 255, .75) !important;
    box-shadow: 0 0 22px rgba(0, 190, 255, .42), inset 0 0 22px rgba(255,255,255,.08) !important;
    border-top-right-radius: 5px !important;
}

.message-other {
    background: rgba(17, 38, 78, .86) !important;
    border-top-left-radius: 5px !important;
}

.message-meta {
    color: #00d7ff !important;
    font-size: 13px !important;
    font-weight: 800 !important;
    margin-bottom: 5px !important;
}

.message-own .message-meta {
    color: #ffffff !important;
}

.message-text {
    color: #ffffff !important;
    font-size: 16px !important;
    line-height: 1.45 !important;
}

.message-time {
    color: rgba(205, 220, 255, .72) !important;
    font-size: 12px !important;
}

.message-own .message-time {
    color: rgba(255,255,255,.85) !important;
}

.voice-note-card {
    width: min(440px, 68vw) !important;
    max-width: 440px !important;
    padding: 13px 15px !important;
    border-radius: 16px !important;
    background: rgba(21, 43, 89, .9) !important;
    border: 1px solid rgba(0, 185, 255, .22) !important;
    box-shadow: 0 0 22px rgba(0, 162, 255, .13), inset 0 0 24px rgba(255,255,255,.045) !important;
}

.voice-own .voice-note-card {
    background: linear-gradient(135deg, rgba(0, 99, 218, .95), rgba(35, 13, 145, .95)) !important;
    border-color: rgba(0, 220, 255, .65) !important;
    box-shadow: 0 0 28px rgba(0, 161, 255, .38), inset 0 0 26px rgba(255,255,255,.08) !important;
}

.voice-badge {
    display: none !important;
}

.voice-note-card .message-meta {
    color: #ffffff !important;
    display: inline-block;
    margin-right: 10px;
}

.voice-note-player {
    margin-top: 8px !important;
    height: 40px !important;
    filter: drop-shadow(0 0 9px rgba(0, 210, 255, .25));
}

.card-footer,
#textComposerWrap,
#voiceControlsWrap {
    background: rgba(1, 16, 55, .96) !important;
    border-top: 1px solid rgba(0, 183, 255, .28) !important;
    box-shadow: 0 -12px 38px rgba(0, 105, 255, .12);
}

#messageInput {
    height: 58px !important;
    background: rgba(13, 25, 63, .92) !important;
    border: 1px solid rgba(0, 191, 255, .34) !important;
    color: #e9f3ff !important;
    border-radius: 14px !important;
    padding-left: 18px !important;
    box-shadow: inset 0 0 18px rgba(0,0,0,.2);
}

#messageInput::placeholder {
    color: rgba(210, 225, 255, .62) !important;
}

.emoji-btn {
    width: 58px !important;
    height: 58px !important;
    border-radius: 14px !important;
    background: rgba(13, 25, 63, .92) !important;
    border: 1px solid rgba(0, 191, 255, .34) !important;
    margin-right: 10px;
}

.send-airplane-btn,
.voice-main-btn {
    width: 64px !important;
    height: 64px !important;
    min-width: 64px !important;
    background: linear-gradient(135deg, #00cfff, #6e12ff) !important;
    box-shadow: 0 0 28px rgba(0, 208, 255, .58), 0 0 50px rgba(105, 0, 255, .32) !important;
    border: 1px solid rgba(255,255,255,.34) !important;
}

.voice-recorder-wrap {
    min-height: 68px;
}

.voice-icon-btn {
    background: rgba(255, 57, 110, .18) !important;
    color: #ff557e !important;
    border: 1px solid rgba(255, 95, 136, .22) !important;
}

.voice-wave-area {
    background: rgba(7, 19, 52, .55);
    border-left: 1px solid rgba(255,255,255,.08);
    padding-left: 20px;
    border-radius: 12px;
}

#recordingStatus {
    color: rgba(220,232,255,.68) !important;
}

#voiceRoomList {
    position: relative;
    min-height: 170px;
    padding: 28px 70px !important;
    background:
        radial-gradient(circle at 50% 0%, rgba(0, 191, 255, .22), transparent 38%),
        radial-gradient(circle at 95% 50%, rgba(174, 0, 255, .2), transparent 36%),
        linear-gradient(135deg, rgba(0, 12, 48, .9), rgba(16, 0, 58, .72)) !important;
    border: 1px solid rgba(132, 84, 255, .52) !important;
    border-radius: 26px !important;
    box-shadow: 0 0 38px rgba(0, 170, 255, .22), inset 0 0 35px rgba(138, 0, 255, .1) !important;
}

.voice-room-card {
    min-width: 300px !important;
    max-width: 300px !important;
    padding: 24px !important;
    border-radius: 22px !important;
    background:
        radial-gradient(circle at 20% 10%, rgba(0, 206, 255, .15), transparent 36%),
        linear-gradient(135deg, rgba(7, 31, 82, .95), rgba(6, 9, 42, .96)) !important;
    border: 1px solid rgba(0, 178, 255, .52) !important;
    box-shadow: 0 0 24px rgba(0, 151, 255, .22), inset 0 0 28px rgba(255,255,255,.035) !important;
}

.voice-room-card.active {
    border-color: rgba(184, 86, 255, .9) !important;
    box-shadow: 0 0 34px rgba(144, 57, 255, .36), inset 0 0 30px rgba(0, 194, 255, .1) !important;
}

.voice-room-card .room-logo,
.voice-room-card .room-default-logo {
    width: 78px !important;
    height: 78px !important;
    font-size: 24px !important;
}

.voice-room-card .fw-bold,
.voice-room-card .room-name {
    font-size: 23px !important;
    line-height: 1.18 !important;
    color: #ffffff !important;
    font-weight: 900 !important;
}

.voice-room-card .small,
.voice-room-card .text-muted {
    font-size: 15px !important;
    color: rgba(218, 225, 255, .7) !important;
}

.room-access-badge,
.badge-private,
.badge-public {
    border-radius: 999px !important;
    font-size: 10px !important;
    font-weight: 900 !important;
    letter-spacing: .04em;
    padding: 5px 9px !important;
    border: 1px solid currentColor;
    box-shadow: 0 0 18px currentColor;
}

.room-access-public,
.badge-public {
    color: #2fffd0 !important;
    background: rgba(0, 255, 184, .12) !important;
}

.room-access-private,
.badge-private {
    color: #ffd166 !important;
    background: rgba(255, 193, 7, .14) !important;
}

.room-item {
    background: transparent !important;
    border-bottom: 1px solid rgba(0, 180, 255, .09) !important;
    color: #f1f5ff !important;
    border-radius: 14px !important;
    margin: 3px 8px !important;
}

.room-item:hover,
.room-item.active-room {
    background: linear-gradient(90deg, rgba(0, 185, 255, .22), rgba(88, 0, 255, .12)) !important;
    box-shadow: inset 4px 0 0 #00d4ff, 0 0 24px rgba(0, 196, 255, .12);
}

.room-name {
    color: #ffffff !important;
    font-weight: 800 !important;
}

.room-id,
.room-last-message {
    color: rgba(213, 224, 255, .64) !important;
}

.card-header {
    background: rgba(0, 13, 45, .72) !important;
    border-bottom: 1px solid rgba(0, 183, 255, .22) !important;
    color: #ffffff !important;
}

#selectedRoomTitle {
    font-weight: 900 !important;
    font-size: 20px !important;
}

#selectedRoomMeta {
    color: rgba(220, 230, 255, .72) !important;
}

.modal-content {
    background:
        radial-gradient(circle at 90% 0%, rgba(141, 0, 255, .22), transparent 34%),
        linear-gradient(135deg, rgba(2, 14, 48, .98), rgba(10, 0, 38, .98)) !important;
    border: 1px solid rgba(0, 194, 255, .32) !important;
    color: #f3f7ff !important;
    box-shadow: 0 0 40px rgba(0, 194, 255, .18);
}

.modal-header,
.modal-footer {
    border-color: rgba(0, 194, 255, .18) !important;
}

.modal .form-control {
    background: rgba(7, 19, 52, .82) !important;
    border: 1px solid rgba(0, 194, 255, .26) !important;
    color: #fff !important;
}

.btn-primary,
#authActionBtn,
#joinGuestBtn {
    background: linear-gradient(135deg, #00b7ff, #7113ff) !important;
    border: 1px solid rgba(255,255,255,.24) !important;
    box-shadow: 0 0 20px rgba(0, 194, 255, .34) !important;
}

.btn-outline-primary,
#openAuthModalBtn {
    color: #fff !important;
    border-color: rgba(189, 80, 255, .8) !important;
    background: linear-gradient(135deg, rgba(71, 0, 255, .35), rgba(210, 0, 255, .35)) !important;
}

.auth-entry-card {
    background: rgba(2, 18, 58, .86) !important;
    border: 1px solid rgba(0, 194, 255, .25) !important;
    color: #fff !important;
}

.auth-entry-overlay {
    background: rgba(0, 7, 27, .7) !important;
    backdrop-filter: blur(6px);

}

@media (max-width: 991px) {
    .voice-room-card {
        min-width: 250px !important;
        max-width: 250px !important;
    }
    #voiceRoomList {
        padding: 20px 16px !important;
    }
    .message-bubble,
    .voice-note-card {
        max-width: 78vw !important;
    }
}


/* ===== Final layout refinements: spacing, footer, compact messages, simplified carousel ===== */
.container-fluid.py-3,
.chat-dashboard-page,
.dashboard-shell,
body > .container-fluid {
    padding: 18px 18px 22px !important;
    max-width: 1600px !important;
}

body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

body > .container-fluid,
.chat-dashboard-page,
.dashboard-shell {
    flex: 1 0 auto;
}

footer,
.footer,
.main-footer,
.copyright,
.site-footer {
    position: static !important;
    width: 100% !important;
    margin: 14px auto 0 !important;
    padding: 12px 18px !important;
    text-align: center !important;
    background: rgba(3, 8, 32, .82) !important;
    border-top: 1px solid rgba(0, 190, 255, .18) !important;
    color: rgba(235, 242, 255, .84) !important;
    flex-shrink: 0;
}

.card,
.modern-card,
.chat-shell-card {
    border-radius: 16px !important;
}

.chat-messages-body {
    height: 58vh !important;
    padding: 18px 18px 14px !important;
}

.message-bubble {
    max-width: min(56%, 340px) !important;
    padding: 10px 13px !important;
    border-radius: 12px !important;
}

.message-meta {
    display: inline !important;
    margin: 0 8px 0 0 !important;
    font-size: 12px !important;
    line-height: 1.25 !important;
}

.message-text {
    display: inline !important;
    font-size: 14px !important;
    line-height: 1.35 !important;
}

.message-footer {
    display: inline-flex !important;
    margin: 0 0 0 8px !important;
    gap: 4px !important;
    vertical-align: baseline;
}

.message-time {
    font-size: 10px !important;
    opacity: .72 !important;
    white-space: nowrap !important;
}

.message-wrap {
    margin-bottom: 13px !important;
}

.voice-note-card {
    width: min(330px, 58vw) !important;
    max-width: 330px !important;
    padding: 9px 11px !important;
    border-radius: 13px !important;
}

.voice-note-card .message-meta {
    display: inline-block !important;
    font-size: 12px !important;
    margin: 0 6px 6px 0 !important;
}

.voice-note-card .message-footer {
    display: inline-flex !important;
    margin-left: 6px !important;
}

.voice-note-card .message-time {
    font-size: 10px !important;
}

.voice-note-player {
    height: 32px !important;
    margin-top: 5px !important;
}

.voice-player-shell {
    min-height: 34px !important;
}

.voice-fake-play-btn,
.voice-waveform-visual {
    display: none !important;
}

.voice-player-shell .voice-note-player {
    position: static !important;
    opacity: 1 !important;
    width: 100% !important;
    height: 34px !important;
    display: block !important;
    cursor: pointer;
}

.voice-carousel-body,
.voice-carousel-wrap,
.voice-carousel-section {
    background: rgba(2, 13, 45, 0.76) !important;
    border: 1px solid rgba(0, 180, 255, 0.28) !important;
    border-radius: 16px !important;
    padding: 18px 58px !important;
    box-shadow: 0 0 28px rgba(0, 132, 255, 0.14), inset 0 0 42px rgba(68, 0, 255, 0.08) !important;
}

#voiceRoomList {
    min-height: 128px !important;
    padding: 0 !important;
    background: transparent !important;
    border: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    gap: 16px !important;
}

.voice-room-card {
    min-width: 270px !important;
    max-width: 270px !important;
    padding: 18px 20px !important;
    border-radius: 18px !important;
}

.voice-room-card .room-logo,
.voice-room-card .room-default-logo {
    width: 62px !important;
    height: 62px !important;
}

.voice-room-card .fw-bold,
.voice-room-card .room-name {
    font-size: 18px !important;
}

.voice-room-card .small,
.voice-room-card .text-muted {
    font-size: 12px !important;
}

.voice-carousel-arrow,
.voice-arrow-btn,
#voicePrevBtn,
#voiceNextBtn {
    width: 42px !important;
    height: 42px !important;
    border-radius: 50% !important;
    background: rgba(0, 25, 75, .88) !important;
    border: 1px solid rgba(0, 203, 255, .45) !important;
    color: #dff7ff !important;
    box-shadow: 0 0 18px rgba(0, 183, 255, .25) !important;
}

.row.g-3 {
    margin-bottom: 10px !important;
}

@media (max-width: 991px) {
    .container-fluid.py-3,
    body > .container-fluid {
        padding: 12px !important;
    }
    .message-bubble,
    .voice-note-card {
        max-width: 78vw !important;
    }
}


/* ===== Small final fixes: text meta stacking + voice carousel badge position ===== */
.message-bubble .message-meta {
    display: block !important;
    margin: 0 0 5px 0 !important;
}

.message-bubble .message-text {
    display: inline !important;
}

.message-bubble .message-footer {
    display: inline-flex !important;
    margin-left: 8px !important;
}

/* keep voice room access badge inside the card, under the name */
.voice-room-card .room-access-badge,
.voice-room-card .badge-public,
.voice-room-card .badge-private,
.voice-room-card [class*="room-access-"] {
    position: static !important;
    display: inline-flex !important;
    width: fit-content !important;
    max-width: max-content !important;
    margin: 7px 0 5px 0 !important;
    transform: none !important;
    right: auto !important;
    top: auto !important;
    float: none !important;
}

.voice-room-card .d-flex.justify-content-between,
.voice-room-card .d-flex.align-items-center {
    flex-wrap: wrap !important;
    gap: 6px !important;
}

.voice-room-card .fw-bold,
.voice-room-card .room-name {
    display: block !important;
    width: 100% !important;
    padding-right: 0 !important;
}


/* ===== Logo image + simplified 3-card voice carousel ===== */
.chat-neon-logo {
    width: 46px !important;
    height: 46px !important;
    min-width: 46px !important;
    border-radius: 14px !important;
    object-fit: cover !important;
    display: block !important;
    padding: 0 !important;
    background: transparent !important;
    box-shadow: 0 0 20px rgba(0, 214, 255, .4), 0 0 34px rgba(115, 0, 255, .28) !important;
}

.voice-carousel-body,
.voice-carousel-wrap,
.voice-carousel-section {
    overflow: hidden !important;
}

#voiceRoomList {
    display: flex !important;
    overflow-x: auto !important;
    overflow-y: hidden !important;
    scroll-behavior: smooth !important;
    gap: 18px !important;
    padding-bottom: 2px !important;
    scrollbar-width: none !important;
}

#voiceRoomList::-webkit-scrollbar {
    display: none !important;
}

.voice-room-card {
    flex: 0 0 calc((100% - 36px) / 3) !important;
    min-width: calc((100% - 36px) / 3) !important;
    max-width: calc((100% - 36px) / 3) !important;
    height: 112px !important;
    padding: 18px 20px !important;
    display: flex !important;
    align-items: center !important;
}

.voice-card-simple {
    display: flex !important;
    align-items: center !important;
    gap: 16px !important;
    width: 100% !important;
    min-width: 0 !important;
}

.voice-card-simple .room-logo,
.voice-card-simple .room-default-logo {
    width: 68px !important;
    height: 68px !important;
    min-width: 68px !important;
    border-radius: 50% !important;
}

.voice-card-simple-info {
    min-width: 0 !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-start !important;
}

.voice-card-simple-name {
    color: #ffffff !important;
    font-size: 19px !important;
    font-weight: 900 !important;
    line-height: 1.15 !important;
    max-width: 100% !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    margin-bottom: 8px !important;
}

.voice-card-simple-info .room-access-badge,
.voice-card-simple-info .badge-public,
.voice-card-simple-info .badge-private,
.voice-card-simple-info [class*="room-access-"] {
    position: static !important;
    display: inline-flex !important;
    width: fit-content !important;
    margin: 0 !important;
}

@media (max-width: 1100px) {
    .voice-room-card {
        flex-basis: calc((100% - 18px) / 2) !important;
        min-width: calc((100% - 18px) / 2) !important;
        max-width: calc((100% - 18px) / 2) !important;
    }
}

@media (max-width: 700px) {
    .voice-room-card {
        flex-basis: 86% !important;
        min-width: 86% !important;
        max-width: 86% !important;
    }
}


/* ===== Mobile responsive experience - desktop remains unchanged ===== */
@media (max-width: 991.98px) {
    html, body {
        overflow: hidden !important;
    }

    body {
        min-height: 100dvh;
    }

    div#voiceCallControls {
        position: fixed;
        right: 15px;
    }

    .container-fluid.py-3,
    body > .container-fluid {
        padding: 10px !important;
    }

    .dashboard-topbar,
    .modern-topbar,
    .chat-dashboard-header,
    .chat-topbar {
        display: flex !important;
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 12px !important;
        padding: 10px 2px 12px !important;
    }

    .chat-brand,
    .dashboard-brand,
    .topbar-brand {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        min-width: 0 !important;
    }

    .chat-neon-logo {
        width: 40px !important;
        height: 40px !important;
        min-width: 40px !important;
        border-radius: 12px !important;
    }

    .chat-brand h1,
    .dashboard-brand h1,
    .topbar-brand h1,
    .page-title,
    .dashboard-title {
        font-size: 24px !important;
        line-height: 1.1 !important;
        margin: 0 !important;
    }

    .chat-brand p,
    .dashboard-brand p,
    .topbar-brand p,
    .page-subtitle,
    .dashboard-subtitle {
        font-size: 12px !important;
        margin: 2px 0 0 !important;
        white-space: normal !important;
    }

    .topbar-actions,
    .dashboard-actions,
    .chat-top-actions,
    .header-actions {
        width: 100% !important;
        display: grid !important;
        grid-template-columns: 1fr auto auto auto !important;
        gap: 8px !important;
        align-items: center !important;
    }

    #voiceRoomSearch,
    #textRoomSearch,
    .topbar-search input,
    .dashboard-search input {
        min-width: 0 !important;
        width: 100% !important;
        height: 44px !important;
        font-size: 14px !important;
    }

    #createRoomBtn,
    .create-room-btn {
        height: 44px !important;
        min-width: 44px !important;
        padding: 0 12px !important;
        border-radius: 12px !important;
        white-space: nowrap !important;
        font-size: 0 !important;
    }

    #createRoomBtn i,
    .create-room-btn i {
        font-size: 16px !important;
        margin: 0 !important;
    }

    .round-settings-btn,
    .round-logout-btn,
    #profileSettingsBtn,
    #logoutBtn {
        width: 44px !important;
        height: 44px !important;
        min-width: 44px !important;
        border-radius: 12px !important;
    }

    .current-user-chip {
        max-width: 100% !important;
        padding: 5px 8px 5px 5px !important;
        border-radius: 14px !important;
    }

    .current-user-name {
        max-width: 100px !important;
        font-size: 12px !important;
    }

    .current-user-type {
        font-size: 10px !important;
    }

    .current-user-avatar,
    .current-user-avatar-fallback {
        width: 32px !important;
        height: 32px !important;
        min-width: 32px !important;
    }

    .row.g-3 {
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
    }

    .row.g-3 > [class*="col-"] {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 auto !important;
    }

    #roomList {
        height: auto !important;
        max-height: 230px !important;
        overflow-y: auto !important;
        padding: 4px 4px 8px !important;
        -webkit-overflow-scrolling: touch;
    }

    .room-item {
        margin: 4px 4px !important;
        padding: 12px !important;
        border-radius: 16px !important;
    }

    .room-row-wrap {
        gap: 10px !important;
        align-items: center !important;
    }

    .room-logo,
    .room-default-logo {
        width: 44px !important;
        height: 44px !important;
        min-width: 44px !important;
    }

    .room-name {
        font-size: 14px !important;
    }

    .room-id,
    .room-last-message {
        font-size: 11px !important;
    }

    .room-access-badge,
    .badge-public,
    .badge-private {
        font-size: 9px !important;
        padding: 4px 7px !important;
    }

    .voice-carousel-body,
    .voice-carousel-wrap,
    .voice-carousel-section {
        padding: 12px 44px !important;
        border-radius: 16px !important;
        min-height: 124px !important;
    }

    #voiceRoomList {
        min-height: 98px !important;
        gap: 12px !important;
        overflow-x: auto !important;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }

    .voice-room-card {
        flex: 0 0 82% !important;
        min-width: 82% !important;
        max-width: 82% !important;
        height: 96px !important;
        padding: 14px !important;
        scroll-snap-align: center;
        border-radius: 16px !important;
    }

    .voice-card-simple {
        gap: 12px !important;
    }

    .voice-card-simple .room-logo,
    .voice-card-simple .room-default-logo {
        width: 54px !important;
        height: 54px !important;
        min-width: 54px !important;
    }

    .voice-card-simple-name {
        font-size: 16px !important;
        margin-bottom: 6px !important;
    }

    .voice-carousel-arrow,
    .voice-arrow-btn,
    #voicePrevBtn,
    #voiceNextBtn {
        width: 36px !important;
        height: 36px !important;
        min-width: 36px !important;
        z-index: 3 !important;
    }

    .card-header {
        padding: 12px 14px !important;
        gap: 8px !important;
    }

    #selectedRoomTitle {
        font-size: 18px !important;
    }

    #selectedRoomMeta {
        font-size: 12px !important;
    }

    .chat-messages-body {
        height: calc(100dvh - 430px) !important;
        min-height: 360px !important;
        max-height: 62dvh !important;
        padding: 14px 12px !important;
        -webkit-overflow-scrolling: touch;
    }

    .message-wrap {
        margin-bottom: 12px !important;
    }

    .message-row {
        gap: 8px !important;
    }

    .message-avatar,
    .message-avatar-fallback {
        width: 32px !important;
        height: 32px !important;
        min-width: 32px !important;
        font-size: 10px !important;
    }

    .message-bubble {
        max-width: calc(100vw - 100px) !important;
        padding: 9px 11px !important;
        border-radius: 13px !important;
    }

    .message-meta {
        font-size: 11px !important;
    }

    .message-text {
        font-size: 14px !important;
    }

    .message-time {
        font-size: 9px !important;
    }

    .voice-note-card {
        width: calc(100vw - 105px) !important;
        max-width: calc(100vw - 105px) !important;
        padding: 8px 10px !important;
    }

    .voice-note-player {
        height: 32px !important;
    }

    #textComposerWrap,
    .card-footer {
        padding: 10px !important;
        border-radius: 0 0 16px 16px !important;
    }

    #textComposerWrap .input-group {
        gap: 8px !important;
        flex-wrap: nowrap !important;
    }

    .emoji-btn {
        width: 46px !important;
        height: 46px !important;
        min-width: 46px !important;
        border-radius: 12px !important;
        margin-right: 0 !important;
    }

    #messageInput {
        height: 46px !important;
        min-width: 0 !important;
        font-size: 14px !important;
        border-radius: 12px !important;
        padding: 0 12px !important;
    }

    .send-airplane-btn {
        width: 50px !important;
        height: 50px !important;
        min-width: 50px !important;
        margin-left: 0 !important;
        border-radius: 14px !important;
    }

    #textComposerWrap small {
        font-size: 11px !important;
        margin-top: 8px !important;
    }

    .emoji-picker-wrap {
        left: 0 !important;
        right: auto !important;
        bottom: 58px !important;
        max-width: calc(100vw - 30px) !important;
    }

    emoji-picker {
        width: min(320px, calc(100vw - 30px)) !important;
        height: 330px !important;
    }

    #voiceControlsWrap {
        padding: 10px !important;
    }

    .voice-recorder-wrap {
        gap: 8px !important;
        min-height: 58px !important;
    }

    .voice-icon-btn {
        width: 42px !important;
        height: 42px !important;
        min-width: 42px !important;
    }

    .voice-main-btn {
        width: 56px !important;
        height: 56px !important;
        min-width: 56px !important;
    }

    .voice-wave-area {
        min-width: 0 !important;
        padding-left: 10px !important;
    }

    #recordingStatus {
        font-size: 12px !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #voicePreview {
        max-height: 34px !important;
    }

    .auth-entry-overlay {
        inset: 52px 0 62px 0 !important;
        padding: 12px !important;
    }

    .auth-entry-card {
        width: 100% !important;
        max-width: 360px !important;
        padding: 18px !important;
        border-radius: 16px !important;
    }

    .auth-entry-card h5 {
        font-size: 18px !important;
    }

    .auth-entry-card p {
        font-size: 13px !important;
    }

    .auth-entry-card .btn {
        width: 100% !important;
        margin-bottom: 6px !important;
    }

    .modal-dialog {
        margin: 10px !important;
    }

    .modal-content {
        border-radius: 18px !important;
    }

    .modal-body {
        padding: 16px !important;
    }

    .modal-footer,
    .modal-header {
        padding: 12px 16px !important;
    }

    .payment-plan-card,
    .plan-card {
        width: 100% !important;
    }

    footer,
    .footer,
    .main-footer,
    .copyright,
    .site-footer {
        font-size: 12px !important;
        padding: 10px 12px !important;
        margin-top: 10px !important;
    }
}

@media (max-width: 575.98px) {
    .container-fluid.py-3,
    body > .container-fluid {
        padding: 8px !important;
    }

    .chat-brand h1,
    .dashboard-brand h1,
    .topbar-brand h1,
    .page-title,
    .dashboard-title {
        font-size: 21px !important;
    }

    .topbar-actions,
    .dashboard-actions,
    .chat-top-actions,
    .header-actions {
        grid-template-columns: 1fr auto auto !important;
    }

    .current-user-chip {
        grid-column: 1 / -1;
        justify-content: flex-start;
        width: 100%;
    }

    #roomList {
        max-height: 210px !important;
    }

    .voice-carousel-body,
    .voice-carousel-wrap,
    .voice-carousel-section {
        padding: 10px 38px !important;
    }

    .voice-room-card {
        flex-basis: 88% !important;
        min-width: 88% !important;
        max-width: 88% !important;
    }

    .chat-messages-body {
        height: calc(100dvh - 455px) !important;
        min-height: 330px !important;
    }

    .message-bubble {
        max-width: calc(100vw - 82px) !important;
    }

    .voice-note-card {
        width: calc(100vw - 88px) !important;
        max-width: calc(100vw - 88px) !important;
    }

    .message-avatar,
    .message-avatar-fallback {
        width: 30px !important;
        height: 30px !important;
        min-width: 30px !important;
    }

    #textComposerWrap small {
        display: none !important;
    }
}

@media (max-width: 390px) {
    .chat-messages-body {
        min-height: 300px !important;
        height: calc(100dvh - 470px) !important;
    }

    .voice-room-card {
        flex-basis: 92% !important;
        min-width: 92% !important;
        max-width: 92% !important;
    }

    #messageInput {
        font-size: 13px !important;
    }

    .send-airplane-btn {
        width: 46px !important;
        height: 46px !important;
        min-width: 46px !important;
    }

    .emoji-btn {
        width: 44px !important;
        height: 44px !important;
        min-width: 44px !important;
    }
}


/* ===== Mobile app-style room list UX ===== */
.mobile-room-tabs,
.mobile-bottom-nav {
    display: none;
}

@media (max-width: 991.98px) {
    html, body {
        overflow-x: hidden !important;
    }

    body.mobile-view-rooms .col-md-8,
    body.mobile-view-rooms .col-lg-9 {
        display: none !important;
    }

    body.mobile-view-chat .mobile-room-tabs,
    body.mobile-view-chat .col-md-4,
    body.mobile-view-chat .col-lg-3,
    body.mobile-view-chat .voice-carousel-body,
    body.mobile-view-chat .voice-carousel-wrap,
    body.mobile-view-chat .voice-carousel-section,
    body.mobile-view-chat #voiceRoomList {
        display: none !important;
    }

    body.mobile-view-chat .col-md-8,
    body.mobile-view-chat .col-lg-9 {
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    .mobile-room-tabs {
        display: grid !important;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin: 10px 0 12px;
        padding: 7px;
        border-radius: 18px;
        background: rgba(3, 13, 46, .82);
        border: 1px solid rgba(0, 200, 255, .22);
        box-shadow: inset 0 0 24px rgba(117, 0, 255, .12), 0 0 20px rgba(0, 180, 255, .12);
    }

    .mobile-room-tab {
        border: 0;
        border-radius: 14px;
        min-height: 44px;
        color: rgba(226, 237, 255, .75);
        background: transparent;
        font-weight: 800;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .mobile-room-tab.active {
        color: #fff;
        background: linear-gradient(135deg, #006dff, #8a16ff);
        box-shadow: 0 0 22px rgba(0, 190, 255, .4);
    }

    body.mobile-tab-text .voice-carousel-body,
    body.mobile-tab-text .voice-carousel-wrap,
    body.mobile-tab-text .voice-carousel-section {
        display: none !important;
    }

    body.mobile-tab-voice .col-md-4,
    body.mobile-tab-voice .col-lg-3 {
        display: none !important;
    }

    body.mobile-tab-voice .voice-carousel-body,
    body.mobile-tab-voice .voice-carousel-wrap,
    body.mobile-tab-voice .voice-carousel-section {
        display: block !important;
    }

    body.mobile-tab-voice #voiceRoomList {
        display: flex !important;
        flex-direction: column !important;
        gap: 10px !important;
        overflow: visible !important;
        min-height: 0 !important;
        padding: 0 !important;
    }

    body.mobile-tab-voice .voice-carousel-arrow,
    body.mobile-tab-voice .voice-arrow-btn,
    body.mobile-tab-voice #voicePrevBtn,
    body.mobile-tab-voice #voiceNextBtn {
        display: none !important;
    }

    body.mobile-tab-voice .voice-room-card {
        width: 100% !important;
        min-width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 auto !important;
        height: auto !important;
        min-height: 78px !important;
        padding: 12px 14px !important;
        border-radius: 18px !important;
    }

    body.mobile-tab-voice .voice-card-simple .room-logo,
    body.mobile-tab-voice .voice-card-simple .room-default-logo {
        width: 52px !important;
        height: 52px !important;
        min-width: 52px !important;
    }

    body.mobile-tab-voice .voice-card-simple-name {
        font-size: 15px !important;
        margin-bottom: 5px !important;
        white-space: normal !important;
    }

    #roomList {
        max-height: none !important;
        height: auto !important;
        overflow: visible !important;
        padding: 0 0 74px !important;
    }

    .room-item {
        border-radius: 18px !important;
        margin: 9px 0 !important;
        padding: 12px !important;
        background: rgba(3, 20, 60, .86) !important;
        border: 1px solid rgba(0, 190, 255, .16) !important;
        box-shadow: 0 0 18px rgba(0, 150, 255, .08) !important;
    }

    .room-item.active-room,
    .room-item:hover {
        background: linear-gradient(135deg, rgba(0, 124, 255, .28), rgba(117, 0, 255, .16)) !important;
        border-color: rgba(0, 215, 255, .48) !important;
    }

    .room-row-wrap::after,
    .voice-card-simple::after {
        content: "\f054";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        margin-left: auto;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(0, 32, 92, .78);
        border: 1px solid rgba(0, 208, 255, .16);
        color: rgba(225, 240, 255, .8);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .room-last-message {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        max-width: 190px !important;
    }

    .mobile-back-to-rooms {
        display: none;
    }

    body.mobile-view-chat .mobile-back-to-rooms {
        display: inline-flex !important;
        align-items: center;
        gap: 7px;
        border: 1px solid rgba(0, 203, 255, .32);
        background: rgba(0, 26, 76, .78);
        color: #eaf8ff;
        border-radius: 12px;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 800;
        margin: 0 0 10px 0;
    }

    body.mobile-view-chat .chat-messages-body {
        min-height: calc(100dvh - 260px) !important;
        height: calc(100dvh - 260px) !important;
        max-height: none !important;
    }

    body.mobile-view-rooms .chat-messages-body {
        min-height: 0 !important;
        height: 0 !important;
    }

    .mobile-bottom-nav {
        display: grid !important;
        position: fixed;
        left: 8px;
        right: 8px;
        bottom: 8px;
        z-index: 999;
        grid-template-columns: repeat(3, 1fr);
        gap: 6px;
        padding: 8px;
        border-radius: 18px;
        background: rgba(3, 13, 46, .94);
        border: 1px solid rgba(0, 203, 255, .22);
        box-shadow: 0 0 26px rgba(0, 160, 255, .22), inset 0 0 18px rgba(117, 0, 255, .1);
        backdrop-filter: blur(14px);
    }

    .mobile-bottom-nav button {
        border: 0;
        background: transparent;
        color: rgba(226, 237, 255, .7);
        border-radius: 13px;
        padding: 9px 4px;
        font-size: 11px;
        font-weight: 800;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .mobile-bottom-nav button.active {
        color: #fff;
        background: rgba(0, 125, 255, .22);
        box-shadow: inset 0 0 14px rgba(0, 204, 255, .14);
    }

    .mobile-bottom-nav i {
        font-size: 16px;
    }

    footer,
    .footer,
    .main-footer,
    .copyright,
    .site-footer {
        margin-bottom: 74px !important;
    }
}


/* ===== Mobile requested order: top actions, search, voice carousel, recent rooms, then chat scroll ===== */
@media (max-width: 991.98px) {
    .dashboard-topbar,
    .modern-topbar,
    .chat-dashboard-header,
    .chat-topbar {
        display: grid !important;
        grid-template-columns: 1fr auto !important;
        align-items: center !important;
        gap: 10px !important;
    }

    .chat-brand,
    .dashboard-brand,
    .topbar-brand {
        grid-column: 1 / 2 !important;
        grid-row: 1 !important;
    }

    .topbar-actions,
    .dashboard-actions,
    .chat-top-actions,
    .header-actions {
        grid-column: 2 / 3 !important;
        grid-row: 1 !important;
        width: auto !important;
        display: flex !important;
        align-items: center !important;
        justify-content: flex-end !important;
        gap: 8px !important;
    }

    #voiceRoomSearch {
        width: 100% !important;
        margin-top: 10px !important;
    }

    #createRoomBtn,
    .create-room-btn {
        display: none !important;
    }

    .current-user-chip {
        width: auto !important;
        max-width: 135px !important;
    }

    .current-user-info {
        display: none !important;
    }

    #profileSettingsBtn,
    #logoutBtn,
    .round-settings-btn,
    .round-logout-btn {
        display: inline-flex !important;
    }

    .mobile-room-tabs,
    .mobile-bottom-nav,
    .mobile-back-to-rooms {
        display: none !important;
    }

    body.mobile-view-rooms .col-md-8,
    body.mobile-view-rooms .col-lg-9,
    body.mobile-view-chat .col-md-4,
    body.mobile-view-chat .col-lg-3,
    body.mobile-view-chat .voice-carousel-body,
    body.mobile-view-chat .voice-carousel-wrap,
    body.mobile-view-chat .voice-carousel-section,
    body.mobile-view-chat #voiceRoomList {
        display: block !important;
    }

    body.mobile-tab-text .voice-carousel-body,
    body.mobile-tab-text .voice-carousel-wrap,
    body.mobile-tab-text .voice-carousel-section,
    body.mobile-tab-voice .col-md-4,
    body.mobile-tab-voice .col-lg-3 {
        display: block !important;
    }

    .row.g-3 {
        display: flex !important;
        flex-direction: column !important;
    }

    .voice-carousel-body,
    .voice-carousel-wrap,
    .voice-carousel-section {
        order: 1 !important;
        display: block !important;
        margin-top: 10px !important;
        margin-bottom: 12px !important;
    }

    .col-md-4,
    .col-lg-3 {
        order: 2 !important;
    }

    .col-md-8,
    .col-lg-9 {
        order: 3 !important;
        display: block !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    #voiceRoomList {
        display: flex !important;
        flex-direction: row !important;
        overflow-x: auto !important;
        overflow-y: hidden !important;
        gap: 12px !important;
        scroll-snap-type: x mandatory !important;
        -webkit-overflow-scrolling: touch;
    }

    .voice-room-card {
        flex: 0 0 82% !important;
        min-width: 82% !important;
        max-width: 82% !important;
        scroll-snap-align: center !important;
    }

    .voice-carousel-arrow,
    .voice-arrow-btn,
    #voicePrevBtn,
    #voiceNextBtn {
        display: inline-flex !important;
    }

    #roomList {
        max-height: none !important;
        height: auto !important;
        overflow: visible !important;
        padding-bottom: 12px !important;
    }

    .chat-messages-body {
        min-height: 420px !important;
        height: 62dvh !important;
        max-height: none !important;
    }

    footer,
    .footer,
    .main-footer,
    .copyright,
    .site-footer {
        margin-bottom: 0 !important;
    }
}

@media (max-width: 575.98px) {
    .chat-brand h1,
    .dashboard-brand h1,
    .topbar-brand h1,
    .page-title,
    .dashboard-title {
        font-size: 20px !important;
    }

    .topbar-actions,
    .dashboard-actions,
    .chat-top-actions,
    .header-actions {
        gap: 6px !important;
    }

    #profileSettingsBtn,
    #logoutBtn,
    .round-settings-btn,
    .round-logout-btn {
        width: 38px !important;
        height: 38px !important;
        min-width: 38px !important;
    }

    .current-user-avatar,
    .current-user-avatar-fallback {
        width: 34px !important;
        height: 34px !important;
        min-width: 34px !important;
    }

    .voice-room-card {
        flex-basis: 88% !important;
        min-width: 88% !important;
        max-width: 88% !important;
    }
}


/* ===== Chatroom file attachment UI ===== */
.attachment-btn {
    width: 42px;
    height: 42px;
    border: none;
    background: rgba(13, 25, 63, .92);
    color: #dcecff;
    border: 1px solid rgba(0, 191, 255, .34);
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
    transition: .2s ease;
}

.attachment-btn:hover:not(:disabled) {
    color: #fff;
    box-shadow: 0 0 16px rgba(0, 203, 255, .28);
    transform: translateY(-1px);
}

.attachment-btn:disabled {
    opacity: .5;
    cursor: not-allowed;
}

.attachment-preview {
    margin-top: 10px;
}

.attachment-preview-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    max-width: 100%;
    padding: 8px 10px;
    border-radius: 12px;
    background: rgba(0, 35, 92, .7);
    border: 1px solid rgba(0, 198, 255, .24);
    color: #eaf6ff;
    box-shadow: 0 0 14px rgba(0, 180, 255, .12);
}

.attachment-preview-chip span {
    max-width: 220px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.attachment-preview-chip small {
    color: rgba(225, 235, 255, .65);
}

.attachment-clear-btn {
    border: 0;
    background: rgba(255, 82, 122, .18);
    color: #ff7d9c;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    line-height: 1;
}

.voice-attach-btn {
    background: rgba(0, 132, 255, .18) !important;
    color: #cfefff !important;
    border-color: rgba(0, 195, 255, .26) !important;
}

.voice-send-attachment-btn {
    background: linear-gradient(135deg, #00b7ff, #7113ff) !important;
    color: #fff !important;
    border-color: rgba(255,255,255,.24) !important;
    box-shadow: 0 0 18px rgba(0, 194, 255, .28);
}

.message-attachment {
    display: block;
    margin-top: 8px;
    color: #eaf6ff;
    text-decoration: none;
    border-radius: 12px;
    border: 1px solid rgba(0, 195, 255, .22);
    background: rgba(2, 16, 52, .55);
    padding: 8px;
    max-width: 260px;
}

.message-attachment:hover {
    color: #fff;
    border-color: rgba(0, 225, 255, .48);
}

.message-attachment-image img {
    display: block;
    width: 100%;
    max-height: 180px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 6px;
}

.message-attachment-file {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    max-width: 260px;
}

.message-attachment-file span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.message-attachment-media {
    width: 100%;
    max-height: 180px;
    border-radius: 10px;
    display: block;
    margin-bottom: 6px;
}

@media (max-width: 991.98px) {
    .attachment-btn {
        width: 46px !important;
        height: 46px !important;
        min-width: 46px !important;
        margin-right: 0 !important;
    }
    .attachment-preview-chip span {
        max-width: 150px;
    }
    .message-attachment {
        max-width: calc(100vw - 120px);
    }
}


/* Current purchased plan display in payment modal */
.current-plan-box {
    margin-bottom: 14px;
    padding: 12px 14px;
    border-radius: 14px;
    background: linear-gradient(135deg, rgba(0, 214, 255, .14), rgba(132, 0, 255, .16));
    border: 1px solid rgba(0, 225, 255, .28);
    box-shadow: 0 0 18px rgba(0, 185, 255, .14);
    color: #eef8ff;
}

.current-plan-title {
    font-size: 12px;
    color: rgba(224, 238, 255, .72);
    font-weight: 800;
    margin-bottom: 3px;
}

.current-plan-label {
    font-size: 16px;
    font-weight: 900;
    color: #ffffff;
}

.current-plan-status {
    font-size: 11px;
    font-weight: 900;
    color: #2fffd0;
    padding: 5px 9px;
    border-radius: 999px;
    background: rgba(0, 255, 184, .12);
    border: 1px solid rgba(47, 255, 208, .34);
}

/* Desktop private room access overlay */
.private-thread-blurred {
    filter: blur(4px);
    pointer-events: none;
    user-select: none;
}

.private-access-overlay {
    position: absolute;
    inset: 57px 0 70px 0;
    z-index: 7;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px;
    background: rgba(0, 7, 27, .48);
    backdrop-filter: blur(3px);
}

.private-access-card {
    width: min(390px, 92%);
    border-radius: 18px;
    padding: 24px 20px;
    background:
        radial-gradient(circle at 80% 0%, rgba(154, 0, 255, .24), transparent 34%),
        linear-gradient(135deg, rgba(2, 14, 48, .96), rgba(10, 0, 38, .96));
    border: 1px solid rgba(0, 203, 255, .35);
    box-shadow: 0 0 32px rgba(0, 194, 255, .22);
    color: #f2f8ff;
}

.private-access-icon {
    width: 56px;
    height: 56px;
    margin: 0 auto 12px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffd166;
    background: rgba(255, 193, 7, .14);
    border: 1px solid rgba(255, 209, 102, .36);
    box-shadow: 0 0 22px rgba(255, 209, 102, .20);
}

.private-access-card p {
    color: rgba(230, 239, 255, .75);
    font-size: 14px;
}


/* Initial full-screen loader */
.initial-page-loader {
    position: fixed;
    inset: 0;
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    background:
        radial-gradient(circle at 70% 20%, rgba(119, 0, 255, .34), transparent 34%),
        radial-gradient(circle at 25% 80%, rgba(0, 200, 255, .22), transparent 34%),
        linear-gradient(135deg, #020716 0%, #03133b 48%, #100027 100%);
    backdrop-filter: blur(18px);
    transition: opacity .35s ease, visibility .35s ease;
}

.initial-page-loader.loader-hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

.initial-loader-card {
    min-width: 260px;
    padding: 30px 28px;
    border-radius: 24px;
    text-align: center;
    color: #ffffff;
    background: rgba(2, 13, 45, .76);
    border: 1px solid rgba(0, 203, 255, .32);
    box-shadow: 0 0 44px rgba(0, 180, 255, .24), inset 0 0 34px rgba(115, 0, 255, .14);
}

.initial-loader-logo {
    width: 72px;
    height: 72px;
    margin: 0 auto 16px;
    border-radius: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    background: linear-gradient(135deg, #00cfff, #7615ff);
    box-shadow: 0 0 28px rgba(0, 207, 255, .5), 0 0 46px rgba(117, 0, 255, .32);
}

.initial-loader-title {
    font-size: 18px;
    font-weight: 900;
    margin-bottom: 18px;
    letter-spacing: .02em;
}

.initial-loader-spinner {
    width: 42px;
    height: 42px;
    margin: 0 auto;
    border-radius: 50%;
    border: 3px solid rgba(255,255,255,.16);
    border-top-color: #00d7ff;
    border-right-color: #8a2cff;
    animation: initialLoaderSpin .75s linear infinite;
}

@keyframes initialLoaderSpin {
    to {
        transform: rotate(360deg);
    }
}


/* Voice recorder available in text chatrooms too */
#voiceControlsWrap {
    border-top: 1px solid rgba(0, 183, 255, .22) !important;
}

.text-mode-voice-hint {
    font-size: 11px;
    color: rgba(220, 230, 255, .65);
}


/* Text chatroom inline voice record button */
.text-record-btn {
    background: linear-gradient(135deg, #006dff, #7a18ff) !important;
}

.text-record-btn.recording {
    background: linear-gradient(135deg, #ff3868, #8b1dff) !important;
    box-shadow: 0 0 24px rgba(255, 56, 104, .38), 0 0 38px rgba(0, 180, 255, .22) !important;
}

.text-record-btn.ready-send {
    background: linear-gradient(135deg, #00c3ff, #21c178) !important;
    box-shadow: 0 0 24px rgba(0, 214, 255, .46), 0 0 32px rgba(33, 193, 120, .26) !important;
}


/* Inline text voice recorder polish */
#textComposerWrap .input-group {
    gap: 10px !important;
    align-items: center !important;
    flex-wrap: nowrap !important;
}

#textComposerWrap .emoji-btn,
#textComposerWrap .attachment-btn,
#textComposerWrap .send-airplane-btn,
#textComposerWrap .composer-round-btn {
    width: 58px !important;
    height: 58px !important;
    min-width: 58px !important;
    border-radius: 18px !important;
    margin: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

#textComposerWrap #messageInput {
    height: 58px !important;
    border-radius: 18px !important;
}

.text-voice-inline-panel {
    height: 58px;
    flex: 1 1 auto;
    min-width: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    border-radius: 18px;
}

.composer-round-btn {
    border: 1px solid rgba(0, 191, 255, .34);
    background: rgba(13, 25, 63, .92);
    color: #eaf6ff;
    box-shadow: inset 0 0 18px rgba(0,0,0,.16);
}

.composer-danger-btn {
    color: #ff6d91 !important;
    background: rgba(255, 57, 110, .16) !important;
    border-color: rgba(255, 95, 136, .24) !important;
}

.composer-pause-btn {
    color: #d6d8ff !important;
    background: rgba(122, 24, 255, .18) !important;
    border-color: rgba(157, 94, 255, .28) !important;
}

.text-voice-inline-wave {
    height: 58px;
    flex: 1;
    min-width: 0;
    border-radius: 18px;
    padding: 8px 16px;
    background: rgba(13, 25, 63, .92);
    border: 1px solid rgba(0, 191, 255, .34);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.text-voice-status {
    color: rgba(230, 240, 255, .75);
    font-size: 12px;
    margin-bottom: 5px;
}

.text-inline-wave-bars {
    display: flex;
    align-items: center;
    gap: 4px;
    height: 22px;
}

.text-inline-wave-bars span {
    width: 4px;
    border-radius: 999px;
    background: linear-gradient(180deg, #00d8ff, #8c2cff);
    animation: textWavePulse 1s ease-in-out infinite;
}

.text-inline-wave-bars span:nth-child(1){height:8px;animation-delay:.0s}
.text-inline-wave-bars span:nth-child(2){height:15px;animation-delay:.05s}
.text-inline-wave-bars span:nth-child(3){height:22px;animation-delay:.1s}
.text-inline-wave-bars span:nth-child(4){height:12px;animation-delay:.15s}
.text-inline-wave-bars span:nth-child(5){height:18px;animation-delay:.2s}
.text-inline-wave-bars span:nth-child(6){height:10px;animation-delay:.25s}
.text-inline-wave-bars span:nth-child(7){height:20px;animation-delay:.3s}
.text-inline-wave-bars span:nth-child(8){height:13px;animation-delay:.35s}
.text-inline-wave-bars span:nth-child(9){height:19px;animation-delay:.4s}
.text-inline-wave-bars span:nth-child(10){height:9px;animation-delay:.45s}

.text-inline-wave-bars.paused span {
    animation-play-state: paused;
    opacity: .55;
}

@keyframes textWavePulse {
    0%, 100% { transform: scaleY(.6); opacity: .55; }
    50% { transform: scaleY(1); opacity: 1; }
}

@media (max-width: 991px) {
    #textComposerWrap .emoji-btn,
    #textComposerWrap .attachment-btn,
    #textComposerWrap .send-airplane-btn,
    #textComposerWrap .composer-round-btn {
        width: 48px !important;
        height: 48px !important;
        min-width: 48px !important;
        border-radius: 14px !important;
    }
    #textComposerWrap #messageInput,
    .text-voice-inline-panel,
    .text-voice-inline-wave {
        height: 48px !important;
        border-radius: 14px !important;
    }
}


/* Unified recorder controls for both text and voice rooms */
#voiceControlsWrap .voice-recorder-wrap {
    gap: 10px !important;
    align-items: center !important;
}

#voiceControlsWrap .voice-icon-btn,
#voiceControlsWrap .voice-main-btn {
    width: 58px !important;
    height: 58px !important;
    min-width: 58px !important;
    border-radius: 18px !important;
    margin: 0 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

#voiceControlsWrap .voice-wave-area {
    height: 58px !important;
    border-radius: 18px !important;
    padding: 8px 16px !important;
    background: rgba(13, 25, 63, .92) !important;
    border: 1px solid rgba(0, 191, 255, .34) !important;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
}

#voiceControlsWrap #recordingStatus {
    font-size: 12px !important;
    margin-bottom: 5px !important;
    color: rgba(230, 240, 255, .75) !important;
}

#voiceControlsWrap .voice-wave-bars span {
    border-radius: 999px !important;
    background: linear-gradient(180deg, #00d8ff, #8c2cff) !important;
}

#voiceControlsWrap .voice-main-btn.recording,
.text-record-btn.recording {
    background: linear-gradient(135deg, #ff3868, #8b1dff) !important;
}

#voiceControlsWrap .voice-main-btn.ready-send,
.text-record-btn.ready-send {
    background: linear-gradient(135deg, #00c3ff, #21c178) !important;
}


/* LiveKit voice call controls */
.voice-call-controls {
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.call-round-btn,
.call-participants-btn {
    border: 1px solid rgba(0, 203, 255, .35);
    background: rgba(4, 24, 70, .78);
    color: #eaf8ff;
    box-shadow: 0 0 18px rgba(0, 183, 255, .18);
    transition: .2s ease;
}

.call-round-btn {
    width: 44px;
    height: 44px;
    min-width: 44px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.call-round-btn:hover,
.call-participants-btn:hover {
    transform: translateY(-1px);
    color: #fff;
    border-color: rgba(0, 225, 255, .7);
    box-shadow: 0 0 24px rgba(0, 205, 255, .32);
}

.call-start-btn {
    background: linear-gradient(135deg, #00b7ff, #6f18ff);
}

.call-end-btn {
    background: linear-gradient(135deg, #ff365f, #a10f35);
    border-color: rgba(255, 94, 130, .5);
}

.call-mute-btn.muted {
    background: linear-gradient(135deg, #ffb020, #ff4d6d);
    border-color: rgba(255, 196, 87, .5);
}

.call-connected-wrap {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 6px 8px;
    border-radius: 999px;
    background: rgba(3, 18, 56, .82);
    border: 1px solid rgba(0, 203, 255, .22);
}

.call-status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #22ff9a;
    box-shadow: 0 0 12px rgba(34, 255, 154, .8);
}

.call-status-text {
    color: #eafff5;
    font-size: 12px;
    font-weight: 800;
}

.call-participants-btn {
    height: 34px;
    padding: 0 11px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-weight: 900;
    font-size: 12px;
    cursor: pointer;
}

.call-participants-modal {
    background:
        radial-gradient(circle at 90% 0%, rgba(141, 0, 255, .22), transparent 34%),
        linear-gradient(135deg, rgba(2, 14, 48, .98), rgba(10, 0, 38, .98)) !important;
    border: 1px solid rgba(0, 194, 255, .32) !important;
    color: #f3f7ff !important;
}

.call-participant-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 8px;
    border-radius: 14px;
    background: rgba(6, 22, 62, .72);
    border: 1px solid rgba(0, 203, 255, .14);
    margin-bottom: 8px;
}

.call-participant-avatar,
.call-participant-avatar-fallback {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 50%;
    border: 1px solid rgba(0, 225, 255, .65);
    box-shadow: 0 0 12px rgba(0, 208, 255, .24);
    object-fit: cover;
}

.call-participant-avatar-fallback {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #0b8fc6, #7635dd);
    color: #fff;
    font-size: 12px;
    font-weight: 900;
}

.call-participant-info {
    min-width: 0;
    flex: 1;
}

.call-participant-name {
    font-size: 13px;
    font-weight: 900;
    color: #fff;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.call-participant-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 3px;
    font-size: 11px;
    color: rgba(225, 238, 255, .7);
}

.call-speaking-wave {
    display: inline-flex;
    align-items: center;
    gap: 2px;
    height: 12px;
}

.call-speaking-wave span {
    width: 3px;
    border-radius: 999px;
    background: #22ff9a;
    animation: callWave 0.8s ease-in-out infinite;
}

.call-speaking-wave span:nth-child(1) { height: 5px; animation-delay: 0s; }
.call-speaking-wave span:nth-child(2) { height: 10px; animation-delay: .1s; }
.call-speaking-wave span:nth-child(3) { height: 7px; animation-delay: .2s; }

.call-speaking-wave.muted span {
    background: rgba(255,255,255,.35);
    animation: none;
}

@keyframes callWave {
    0%, 100% { transform: scaleY(.5); opacity: .55; }
    50% { transform: scaleY(1); opacity: 1; }
}

@media (max-width: 768px) {
    .call-status-text {
        display: none;
    }
    .call-connected-wrap {
        gap: 6px;
        padding: 5px;
    }
}


/* Composer send visibility + voice room text-only messaging */
#sendBtn.d-none {
    display: none !important;
}

body .chat-panel-card #textComposerWrap .send-airplane-btn {
    transition: .2s ease;
}

.voice-text-only-mode #textRecordToggleBtn {
    display: none !important;
}


/* Call participants avatar stack */
.call-participants-btn {
    gap: 8px !important;
}

.call-participants-avatars {
    display: inline-flex;
    align-items: center;
    margin-right: 2px;
}

.call-mini-avatar,
.call-mini-avatar-fallback {
    width: 26px;
    height: 26px;
    min-width: 26px;
    border-radius: 50%;
    border: 2px solid rgba(7, 15, 48, .95);
    object-fit: cover;
    box-shadow: 0 0 10px rgba(0, 208, 255, .22);
    margin-left: -8px;
    background: linear-gradient(135deg, #0b8fc6, #7635dd);
}

.call-mini-avatar:first-child,
.call-mini-avatar-fallback:first-child {
    margin-left: 0;
}

.call-mini-avatar-fallback {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 10px;
    font-weight: 900;
}

.call-participants-label {
    font-size: 12px;
    font-weight: 900;
    color: rgba(240, 248, 255, .92);
}

@media (max-width: 900px) {
    .call-participants-label {
        display: none;
    }

    .call-mini-avatar,
    .call-mini-avatar-fallback {
        width: 22px;
        height: 22px;
        min-width: 22px;
    }
}


/* Username field helper */
#authUsername {
    margin-top: 2px;
}


/* ===== Clickable message user popup ===== */
.message-user-meta {
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    width: fit-content;
    transition: color .18s ease, text-shadow .18s ease, opacity .18s ease;
}

.message-user-meta:hover,
.message-user-meta:focus {
    opacity: 1 !important;
    text-decoration: underline;
    text-underline-offset: 3px;
    text-shadow: 0 0 12px rgba(0, 229, 255, .45);
    outline: none;
}

.message-user-popup-avatar {
    width: 96px;
    height: 96px;
    margin: 0 auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(0, 229, 255, .72);
    box-shadow: 0 0 28px rgba(0, 208, 255, .32), inset 0 0 20px rgba(255,255,255,.06);
    overflow: hidden;
    background: linear-gradient(135deg, rgba(0, 157, 255, .32), rgba(126, 42, 255, .32));
}

.message-user-popup-avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.message-user-popup-avatar-fallback {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 30px;
    font-weight: 900;
    text-transform: uppercase;
    background: linear-gradient(135deg, #0b8fc6, #7635dd);
}

.message-user-popup-name {
    color: #ffffff;
    font-weight: 900;
    word-break: break-word;
}

.message-user-popup-fullname {
    word-break: break-word;
}

.message-user-popup-link-box {
    display: flex;
    justify-content: center;
}

.message-user-link-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    max-width: 100%;
    padding: 8px 14px;
    border-radius: 999px;
    background: linear-gradient(135deg, rgba(0, 207, 255, .20), rgba(110, 18, 255, .28));
    border: 1px solid rgba(0, 229, 255, .65);
    color: #ffffff !important;
    font-size: 12px;
    font-weight: 900;
    letter-spacing: .02em;
    text-decoration: none;
    box-shadow: 0 0 22px rgba(0, 208, 255, .22);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.message-user-link-badge:hover,
.message-user-link-badge:focus {
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 0 28px rgba(0, 208, 255, .34), 0 0 24px rgba(110, 18, 255, .24);
}

.message-user-modal .modal-body {
    padding: 26px 22px 30px;
}


.current-user-chip {
    cursor: pointer !important;
}

.current-user-chip:hover,
.current-user-chip:focus {
    border-color: rgba(0, 229, 255, .78) !important;
    box-shadow: 0 0 24px rgba(0, 208, 255, .22), inset 0 0 18px rgba(0, 229, 255, .08) !important;
}



/* ===== chat-mobile.php dedicated mobile shell ===== */
@media (max-width: 991.98px) {
    html,
    body {
        width: 100%;
        max-width: 100%;
        min-height: 100%;
        overflow-x: hidden !important;
        background:
            radial-gradient(circle at 85% 0%, rgba(109, 18, 255, .28), transparent 34%),
            radial-gradient(circle at 12% 100%, rgba(0, 208, 255, .18), transparent 32%),
            linear-gradient(135deg, #020716 0%, #04113b 54%, #100027 100%) !important;
    }

    body.chat-mobile-page {
        padding-bottom: calc(82px + env(safe-area-inset-bottom, 0px));
    }

    body.chat-mobile-page .chat-neon-shell {
        min-height: 100dvh !important;
        height: 100dvh !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    body.chat-mobile-page .chat-neon-topbar {
        display: none !important;
    }

    body.chat-mobile-page .dashboard-main-layout {
        display: block !important;
        height: calc(100dvh - 82px - env(safe-area-inset-bottom, 0px)) !important;
        margin: 0 !important;
        min-height: 0 !important;
    }

    body.chat-mobile-page .dashboard-right-col,
    body.chat-mobile-page .right-content-stack {
        width: 100% !important;
        max-width: 100% !important;
        height: 100% !important;
        padding: 0 !important;
        min-height: 0 !important;
    }

    body.chat-mobile-page .right-content-stack {
        gap: 0 !important;
    }

    body.chat-mobile-page .chat-panel-card {
        height: 100% !important;
        min-height: 0 !important;
        border-radius: 0 !important;
        border-left: 0 !important;
        border-right: 0 !important;
        display: flex !important;
        flex-direction: column !important;
        background: rgba(2, 13, 45, .92) !important;
    }

    body.chat-mobile-page .chat-panel-header {
        min-height: 64px !important;
        padding: 12px 14px !important;
        border-bottom: 1px solid rgba(0, 183, 255, .26) !important;
        background:
            radial-gradient(circle at 90% 0%, rgba(110, 18, 255, .28), transparent 38%),
            rgba(2, 14, 50, .95) !important;
        flex-wrap: nowrap !important;
    }

    body.chat-mobile-page #selectedRoomTitle {
        font-size: 18px !important;
        line-height: 1.15 !important;
        max-width: 58vw;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    body.chat-mobile-page #selectedRoomMeta {
        font-size: 11px !important;
        display: block;
        max-width: 58vw;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    body.chat-mobile-page .chat-messages-body {
        height: auto !important;
        min-height: 0 !important;
        flex: 1 1 auto !important;
        padding: 16px 12px 18px !important;
        overflow-y: auto !important;
        background:
            radial-gradient(circle at 92% 12%, rgba(102, 0, 255, .18), transparent 32%),
            linear-gradient(135deg, rgba(1, 16, 55, .96), rgba(0, 4, 26, .99)) !important;
    }

    body.chat-mobile-page .message-row {
        gap: 8px !important;
    }

    body.chat-mobile-page .message-avatar,
    body.chat-mobile-page .message-avatar-fallback {
        width: 31px !important;
        height: 31px !important;
        font-size: 10px !important;
    }

    body.chat-mobile-page .message-bubble {
        max-width: min(78%, 330px) !important;
        padding: 10px 12px !important;
        border-radius: 13px !important;
    }

    body.chat-mobile-page .message-meta {
        font-size: 12px !important;
    }

    body.chat-mobile-page .message-text {
        font-size: 14px !important;
    }

    body.chat-mobile-page .voice-note-card {
        width: min(76vw, 330px) !important;
        max-width: min(76vw, 330px) !important;
        padding: 10px 11px !important;
    }

    body.chat-mobile-page #textComposerWrap,
    body.chat-mobile-page #voiceControlsWrap {
        padding: 10px 10px calc(10px + env(safe-area-inset-bottom, 0px)) !important;
        flex: 0 0 auto !important;
        background: rgba(1, 16, 55, .98) !important;
    }

    body.chat-mobile-page #textComposerWrap small.text-muted {
        display: none !important;
    }

    body.chat-mobile-page #messageInput {
        height: 48px !important;
        font-size: 14px !important;
        border-radius: 13px !important;
        padding-left: 12px !important;
    }

    body.chat-mobile-page .emoji-btn {
        width: 48px !important;
        height: 48px !important;
        margin-right: 6px !important;
    }

    body.chat-mobile-page .attachment-btn {
        width: 48px !important;
        height: 48px !important;
        margin-right: 6px !important;
        flex: 0 0 auto !important;
    }

    body.chat-mobile-page .send-airplane-btn,
    body.chat-mobile-page .voice-main-btn {
        width: 52px !important;
        min-width: 52px !important;
        height: 52px !important;
        margin-left: 7px !important;
    }

    body.chat-mobile-page .voice-call-controls {
        margin-left: auto;
        transform: scale(.86);
        transform-origin: right center;
    }

    body.chat-mobile-page .call-connected-wrap {
        gap: 6px !important;
        padding: 6px !important;
    }

    body.chat-mobile-page .call-status-text,
    body.chat-mobile-page .call-participants-label {
        display: none !important;
    }

    body.chat-mobile-page .call-participants-btn {
        padding: 4px 7px !important;
    }

    body.chat-mobile-page .dashboard-left-col,
    body.chat-mobile-page .voice-rooms-showcase-card {
        position: fixed !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        z-index: 1070 !important;
        width: min(88vw, 380px) !important;
        max-width: min(88vw, 380px) !important;
        height: 100dvh !important;
        padding: 0 !important;
        margin: 0 !important;
        transform: translateX(-105%) !important;
        transition: transform .28s ease !important;
        display: block !important;
    }

    body.chat-mobile-page.mobile-chat-drawer-open .dashboard-left-col,
    body.chat-mobile-page.mobile-voice-drawer-open .voice-rooms-showcase-card {
        transform: translateX(0) !important;
    }

    body.chat-mobile-page .room-sidebar-card,
    body.chat-mobile-page .voice-rooms-showcase-card {
        border-radius: 0 22px 22px 0 !important;
        height: 100dvh !important;
        min-height: 100dvh !important;
        overflow: hidden !important;
        background:
            radial-gradient(circle at 90% 0%, rgba(110, 18, 255, .22), transparent 32%),
            linear-gradient(180deg, rgba(4, 20, 68, .98), rgba(2, 8, 36, .98)) !important;
        border: 1px solid rgba(0, 190, 255, .34) !important;
        border-left: 0 !important;
        box-shadow: 20px 0 70px rgba(0,0,0,.58), inset 0 0 34px rgba(0,208,255,.05) !important;
    }

    body.chat-mobile-page .room-sidebar-header {
        display: none !important;
    }

    body.chat-mobile-page .mobile-drawer-head {
        padding: 18px 16px 14px !important;
        border-bottom: 1px solid rgba(0, 183, 255, .2) !important;
        background: rgba(0, 13, 45, .72) !important;
    }

    body.chat-mobile-page .mobile-drawer-close {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 38px;
        height: 38px;
        border-radius: 13px;
        border: 1px solid rgba(0, 208, 255, .28);
        background: rgba(13, 25, 63, .92);
        color: #dfeaff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
    }

    body.chat-mobile-page .mobile-drawer-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-right: 48px;
        min-height: 58px;
    }

    body.chat-mobile-page .mobile-drawer-profile .current-user-chip {
        width: 100%;
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        padding: 0 !important;
        border-radius: 0 !important;
    }

    body.chat-mobile-page .mobile-drawer-profile .current-user-chip::after {
        display: none !important;
    }

    body.chat-mobile-page .mobile-drawer-avatar-fallback,
    body.chat-mobile-page .mobile-drawer-profile img,
    body.chat-mobile-page .mobile-drawer-profile .current-user-avatar,
    body.chat-mobile-page .mobile-drawer-profile .current-user-avatar-fallback {
        width: 48px !important;
        height: 48px !important;
        border-radius: 16px !important;
        border: 1px solid rgba(0, 225, 255, .75) !important;
        box-shadow: 0 0 20px rgba(0, 208, 255, .22) !important;
        flex: 0 0 auto;
        object-fit: cover;
    }

    body.chat-mobile-page .mobile-drawer-avatar-fallback {
        background: linear-gradient(135deg, #006dff, #6e12ff) !important;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    body.chat-mobile-page .mobile-drawer-username,
    body.chat-mobile-page .mobile-drawer-profile .current-user-name {
        color: #ffffff !important;
        font-weight: 900 !important;
        font-size: 16px !important;
        max-width: 190px !important;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    body.chat-mobile-page .mobile-drawer-profile small,
    body.chat-mobile-page .mobile-drawer-profile .current-user-type {
        color: rgba(219, 232, 255, .72) !important;
        font-size: 12px !important;
    }

    body.chat-mobile-page .room-search-area,
    body.chat-mobile-page .mobile-voice-search-wrap {
        padding: 14px !important;
        border-bottom: 1px solid rgba(0, 183, 255, .14) !important;
    }

    body.chat-mobile-page .text-search-wrap .form-control,
    body.chat-mobile-page .voice-drawer-search-wrap .form-control {
        height: 46px !important;
        border-radius: 14px !important;
    }

    body.chat-mobile-page #roomList,
    body.chat-mobile-page #voiceRoomList {
        height: calc(100dvh - 148px) !important;
        max-height: none !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
        padding: 10px 9px 18px !important;
        display: block !important;
        min-height: 0 !important;
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 208, 255, .62) rgba(255,255,255,.06);
    }

    body.chat-mobile-page #voiceRoomList {
        height: calc(100dvh - 218px) !important;
    }

    body.chat-mobile-page .room-item,
    body.chat-mobile-page .voice-room-card {
        width: 100% !important;
        min-width: 0 !important;
        max-width: 100% !important;
        margin: 0 0 9px !important;
        border-radius: 16px !important;
        padding: 13px 12px !important;
        background: rgba(8, 28, 81, .76) !important;
        border: 1px solid rgba(0, 183, 255, .2) !important;
        box-shadow: inset 0 0 20px rgba(255,255,255,.025) !important;
        display: block !important;
    }

    body.chat-mobile-page .room-item.active-room,
    body.chat-mobile-page .voice-room-card.active {
        background: linear-gradient(90deg, rgba(0, 185, 255, .22), rgba(110, 18, 255, .22)) !important;
        border-color: rgba(0, 225, 255, .64) !important;
        box-shadow: inset 4px 0 0 #00d4ff, 0 0 24px rgba(0, 196, 255, .14) !important;
    }

    body.chat-mobile-page .voice-room-card .voice-card-simple {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
    }

    body.chat-mobile-page .voice-room-card .room-logo,
    body.chat-mobile-page .voice-room-card .room-default-logo,
    body.chat-mobile-page .room-logo,
    body.chat-mobile-page .room-default-logo {
        width: 48px !important;
        height: 48px !important;
        border-radius: 16px !important;
    }

    body.chat-mobile-page .voice-card-simple-name,
    body.chat-mobile-page .room-name {
        color: #fff !important;
        font-size: 15px !important;
        font-weight: 900 !important;
        line-height: 1.15 !important;
    }

    body.chat-mobile-page .voice-carousel-body {
        display: block !important;
        padding: 0 !important;
        height: 100% !important;
        overflow: hidden !important;
    }

    body.chat-mobile-page .voice-carousel-arrow {
        display: none !important;
    }

    body.chat-mobile-page .voice-rooms-showcase-card {
        margin: 0 !important;
    }

    body.chat-mobile-page .mobile-drawer-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .62);
        backdrop-filter: blur(8px);
        z-index: 1060;
        opacity: 0;
        pointer-events: none;
        transition: opacity .22s ease;
    }

    body.chat-mobile-page.mobile-chat-drawer-open .mobile-drawer-overlay,
    body.chat-mobile-page.mobile-voice-drawer-open .mobile-drawer-overlay {
        opacity: 1;
        pointer-events: auto;
    }

    body.chat-mobile-page .mobile-bottom-nav {
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1050;
        height: calc(72px + env(safe-area-inset-bottom, 0px));
        padding: 8px 9px calc(8px + env(safe-area-inset-bottom, 0px));
        display: grid !important;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 7px;
        background:
            radial-gradient(circle at 50% 0%, rgba(0, 208, 255, .16), transparent 38%),
            rgba(2, 9, 37, .98);
        border-top: 1px solid rgba(0, 190, 255, .32);
        box-shadow: 0 -20px 55px rgba(0,0,0,.45), 0 0 28px rgba(0, 208, 255, .12);
        backdrop-filter: blur(18px);
    }

    body.chat-mobile-page .mobile-nav-btn {
        border: 1px solid rgba(0, 183, 255, .18);
        border-radius: 16px;
        background: rgba(11, 25, 70, .8);
        color: rgba(226, 238, 255, .78);
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: -.02em;
        line-height: 1;
        transition: .2s ease;
    }

    body.chat-mobile-page .mobile-nav-btn i {
        font-size: 17px;
    }

    body.chat-mobile-page .mobile-nav-btn.active,
    body.chat-mobile-page .mobile-nav-btn:active,
    body.chat-mobile-page .mobile-nav-btn:hover {
        color: #fff;
        border-color: rgba(0, 225, 255, .58);
        background: linear-gradient(135deg, rgba(0, 145, 255, .36), rgba(110, 18, 255, .38));
        box-shadow: 0 0 20px rgba(0, 208, 255, .18);
    }

    body.chat-mobile-page .mobile-profile-avatar {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: linear-gradient(135deg, #006dff, #6e12ff);
        border: 1px solid rgba(0, 225, 255, .7);
        color: #fff;
        font-size: 11px;
    }

    body.chat-mobile-page .mobile-profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }


    body.chat-mobile-page .dashboard-main-layout {
        height: calc(100dvh - 98px - env(safe-area-inset-bottom, 0px)) !important;
    }

    body.chat-mobile-page .chat-panel-card {
        height: calc(100dvh - 98px - env(safe-area-inset-bottom, 0px)) !important;
        max-height: calc(100dvh - 98px - env(safe-area-inset-bottom, 0px)) !important;
        margin-bottom: 14px !important;
    }

    body.chat-mobile-page .chat-panel-header {
        position: sticky !important;
        top: 0 !important;
        z-index: 12 !important;
        flex: 0 0 auto !important;
    }

    body.chat-mobile-page .chat-messages-body {
        padding-bottom: 26px !important;
        overscroll-behavior: contain;
    }

    body.chat-mobile-page #textComposerWrap,
    body.chat-mobile-page #voiceControlsWrap {
        margin-bottom: 10px !important;
        border-radius: 0 0 16px 16px !important;
    }

    body.chat-mobile-page .room-row-wrap::after,
    body.chat-mobile-page .voice-card-simple::after {
        content: none !important;
        display: none !important;
    }

    body.chat-mobile-page .mobile-drawer-profile {
        color: #ffffff !important;
    }

    body.chat-mobile-page .mobile-drawer-identity-text {
        min-width: 0;
        flex: 1 1 auto;
    }

    body.chat-mobile-page .mobile-drawer-avatar-img {
        width: 48px !important;
        height: 48px !important;
        border-radius: 16px !important;
        object-fit: cover !important;
        border: 1px solid rgba(0, 225, 255, .75) !important;
        box-shadow: 0 0 20px rgba(0, 208, 255, .22) !important;
    }

    body.chat-mobile-page .mobile-logout-nav-btn {
        color: #ffd7df !important;
        border-color: rgba(255, 83, 126, .36) !important;
        background: rgba(97, 16, 39, .62) !important;
    }

    body.chat-mobile-page .mobile-logout-nav-btn:hover,
    body.chat-mobile-page .mobile-logout-nav-btn:active {
        background: linear-gradient(135deg, rgba(255, 49, 95, .46), rgba(110, 18, 255, .36)) !important;
        border-color: rgba(255, 118, 152, .72) !important;
    }

    body.chat-mobile-page .mobile-bottom-nav {
        grid-template-columns: repeat(auto-fit, minmax(0, 1fr)) !important;
        height: calc(76px + env(safe-area-inset-bottom, 0px)) !important;
        padding-top: 7px !important;
    }

    body.chat-mobile-page .mobile-nav-btn {
        font-size: 9px !important;
        padding: 4px 2px !important;
    }

    body.chat-mobile-page .modal-dialog {
        margin: 10px !important;
    }

    body.chat-mobile-page .modal-content {
        border-radius: 20px !important;
    }

    body.chat-mobile-page .emoji-picker-wrap {
        left: 4px !important;
        right: 4px !important;
        bottom: 62px !important;
    }

    body.chat-mobile-page emoji-picker {
        width: calc(100vw - 18px) !important;
        max-width: 380px !important;
        height: 340px !important;
    }

    button#voicePrevBtn {
        display:none !important;
    }
    
    button#voiceNextBtn {
     display:none !important;
    }
}

div#paymentCardElement {
    background: white !important;
}


</style>

<script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
    import {
        getFirestore,
        collection,
        doc,
        addDoc,
        setDoc,
        updateDoc,
        getDoc,
        onSnapshot,
        getDocs,
        query,
        where,
        orderBy,
        limit,
        startAfter,
        serverTimestamp,
        increment
    } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";

    import {
        getAuth,
        onAuthStateChanged,
        signInAnonymously,
        createUserWithEmailAndPassword,
        signInWithEmailAndPassword,
        signInWithCustomToken,
        updateProfile,
        updatePassword,
        confirmPasswordReset,
        verifyPasswordResetCode,
        signOut
    } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-auth.js";

    const firebaseConfig = {
        apiKey: "<?= $_ENV['FIREBASE_API_KEY'] ?>",
        authDomain: "<?= $_ENV['FIREBASE_AUTH_DOMAIN'] ?>",
        projectId: "<?= $_ENV['FIREBASE_PROJECT_ID'] ?>",
        storageBucket: "<?= $_ENV['FIREBASE_STORAGE_BUCKET'] ?>",
        messagingSenderId: "<?= $_ENV['FIREBASE_MESSAGING_SENDER_ID'] ?>",
        appId: "<?= $_ENV['FIREBASE_APP_ID'] ?>"
    };

    const CLOUDINARY_CLOUD_NAME = "<?= $_ENV['CLOUDINARY_CLOUD_NAME'] ?>";
    const CLOUDINARY_UPLOAD_PRESET = "<?= $_ENV['CLOUDINARY_UPLOAD_PRESET'] ?>";
    const CLOUDINARY_IMAGE_UPLOAD_URL = `https://api.cloudinary.com/v1_1/${CLOUDINARY_CLOUD_NAME}/image/upload`;
    const CLOUDINARY_VIDEO_UPLOAD_URL = `https://api.cloudinary.com/v1_1/${CLOUDINARY_CLOUD_NAME}/video/upload`;
    const CLOUDINARY_AUTO_UPLOAD_URL = `https://api.cloudinary.com/v1_1/${CLOUDINARY_CLOUD_NAME}/auto/upload`;
    const PAGE_SIZE = 20;

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);
    const auth = getAuth(app);
    const MOBILE_CURRENT_PAGE_URL = `${window.location.origin}${window.location.pathname}`;
    const QUICK_LOGIN_LANDING_URL = MOBILE_CURRENT_PAGE_URL;
    const initialUrlParams = new URLSearchParams(window.location.search);
    const initialRoomIdFromUrl = (initialUrlParams.get('room_id') || '').trim();
    const initialRoomTypeFromUrl = (initialUrlParams.get('room_type') || initialUrlParams.get('type') || '').trim().toLowerCase();

    function buildMobileRoomUrl(roomId) {
        const cleanRoomId = (roomId || '').trim();
        if (!cleanRoomId) return MOBILE_CURRENT_PAGE_URL;

        const params = new URLSearchParams();
        params.set('room_id', cleanRoomId);
        return `${MOBILE_CURRENT_PAGE_URL}?${params.toString()}`;
    }

    function shouldReplaceCurrentRoomUrl(nextRoomId) {
        const currentUrl = new URL(window.location.href);
        const currentRoomId = currentUrl.searchParams.get('room_id') || '';

        return !currentRoomId || currentRoomId === nextRoomId;
    }

    function updateMobileRoomUrl(roomId, mode = 'auto') {
        const cleanRoomId = (roomId || '').trim();
        if (!cleanRoomId || !window.history || !window.history.pushState) return;

        const nextUrl = buildMobileRoomUrl(cleanRoomId);
        if (window.location.href === nextUrl) return;

        const useReplace = mode === 'replace' || (mode === 'auto' && shouldReplaceCurrentRoomUrl(cleanRoomId));
        const state = { room_id: cleanRoomId };

        if (useReplace) {
            window.history.replaceState(state, document.title, nextUrl);
        } else {
            window.history.pushState(state, document.title, nextUrl);
        }
    }

    const roomList = document.getElementById('roomList');
    const voiceRoomList = document.getElementById('voiceRoomList');
    const textRoomSearch = document.getElementById('textRoomSearch');
    const voiceRoomSearch = document.getElementById('voiceRoomSearch');

    const chatMessages = document.getElementById('chatMessages');
    const authEntryOverlay = document.getElementById('authEntryOverlay');
    const privateAccessOverlay = document.getElementById('privateAccessOverlay');
    const privateAccessMessage = document.getElementById('privateAccessMessage');
    const privateAccessPayBtn = document.getElementById('privateAccessPayBtn');
    const privateAccessLoginBtn = document.getElementById('privateAccessLoginBtn');
    const loadOlderIndicator = document.getElementById('loadOlderIndicator');
    const selectedRoomTitle = document.getElementById('selectedRoomTitle');
    const selectedRoomMeta = document.getElementById('selectedRoomMeta');
    const currentUserBox = document.getElementById('currentUserBox');
    const typingIndicator = document.getElementById('typingIndicator');

    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const textComposerWrap = document.getElementById('textComposerWrap');
    const textAttachmentBtn = document.getElementById('textAttachmentBtn');
    const textAttachmentInput = document.getElementById('textAttachmentInput');
    const textAttachmentPreview = document.getElementById('textAttachmentPreview');
    const textRecordToggleBtn = document.getElementById('textRecordToggleBtn');
    const textRecordToggleIcon = document.getElementById('textRecordToggleIcon');
    const textVoiceRecordPanel = document.getElementById('textVoiceRecordPanel');
    const textDiscardVoiceBtn = document.getElementById('textDiscardVoiceBtn');
    const textPauseRecordingBtn = document.getElementById('textPauseRecordingBtn');
    const textInlineRecordingStatus = document.getElementById('textInlineRecordingStatus');
    const textInlineWaveBars = document.getElementById('textInlineWaveBars');

    const emojiToggleBtn = document.getElementById('emojiToggleBtn');
    const emojiPickerWrap = document.getElementById('emojiPickerWrap');
    const emojiPicker = document.getElementById('emojiPicker');

    const voiceControlsWrap = document.getElementById('voiceControlsWrap');
    const recordToggleBtn = document.getElementById('recordToggleBtn');
    const recordToggleIcon = document.getElementById('recordToggleIcon');
    const pauseRecordingBtn = document.getElementById('pauseRecordingBtn');
    const discardVoiceBtn = document.getElementById('discardVoiceBtn');
    const recordingStatus = document.getElementById('recordingStatus');
    const voicePreview = document.getElementById('voicePreview');
    const voiceWaveBars = document.getElementById('voiceWaveBars');
    const voiceAttachmentBtn = document.getElementById('voiceAttachmentBtn');
    const voiceAttachmentInput = document.getElementById('voiceAttachmentInput');
    const voiceAttachmentPreview = document.getElementById('voiceAttachmentPreview');
    const sendVoiceAttachmentBtn = document.getElementById('sendVoiceAttachmentBtn');

    const joinGuestBtn = document.getElementById('joinGuestBtn');
    const openAuthModalBtn = document.getElementById('openAuthModalBtn');
    const paymentPlansBtn = document.getElementById('paymentPlansBtn');
    const createRoomBtn = document.getElementById('createRoomBtn');
    const profileSettingsBtn = document.getElementById('profileSettingsBtn');
    const logoutBtn = document.getElementById('logoutBtn');

    const authAlertBox = document.getElementById('authAlertBox');
    const authName = document.getElementById('authName');
    const authUsername = document.getElementById('authUsername');
    const authEmail = document.getElementById('authEmail');
    const authPassword = document.getElementById('authPassword');
    const authAvatarFile = document.getElementById('authAvatarFile');
    const authMode = document.getElementById('authMode');
    const authActionBtn = document.getElementById('authActionBtn');
    const registerNameWrap = document.getElementById('registerNameWrap');
    const registerAvatarWrap = document.getElementById('registerAvatarWrap');
    const showLoginModeBtn = document.getElementById('showLoginMode');
    const showRegisterModeBtn = document.getElementById('showRegisterMode');
    const showForgotModeBtn = document.getElementById('showForgotMode');

    const profileAlertBox = document.getElementById('profileAlertBox');
    const profileEmail = document.getElementById('profileEmail');
    const profileUsername = document.getElementById('profileUsername');
    const profileName = document.getElementById('profileName');
    const profileAvatarFile = document.getElementById('profileAvatarFile');
    const profilePassword = document.getElementById('profilePassword');
    const saveProfileBtn = document.getElementById('saveProfileBtn');

    const authModal = new bootstrap.Modal(document.getElementById('authModal'));
    const profileSettingsModal = new bootstrap.Modal(document.getElementById('profileSettingsModal'));
    const messageUserModalEl = document.getElementById('messageUserModal');
    const messageUserModal = messageUserModalEl ? new bootstrap.Modal(messageUserModalEl) : null;
    const messageUserAvatarBox = document.getElementById('messageUserAvatarBox');
    const messageUserNameText = document.getElementById('messageUserNameText');
    const messageUserFullNameText = document.getElementById('messageUserFullNameText');
    const messageUserLinkBox = document.getElementById('messageUserLinkBox');
    let messageUserPopupRequestId = 0;
    const paymentPlansModalEl = document.getElementById('paymentPlansModal');
    const paymentPlansModal = paymentPlansModalEl ? new bootstrap.Modal(paymentPlansModalEl) : null;
    const paymentAlertBox = document.getElementById('paymentAlertBox');
    const currentPurchasedPlanBox = document.getElementById('currentPurchasedPlanBox');
    const selectedPlanInfo = document.getElementById('selectedPlanInfo');
    const paymentCardWrap = document.getElementById('paymentCardWrap');
    const paymentCardElementWrap = document.getElementById('paymentCardElement');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
    const dynamicPaymentPlansList = document.getElementById('dynamicPaymentPlansList');
    const paymentPlansLoading = document.getElementById('paymentPlansLoading');
    let paymentPlanBtns = [];
    
    const STRIPE_PUBLISHABLE_KEY = "<?= $_ENV['STRIPE_PUBLISHABLE_KEY'] ?>";
    const stripe = window.Stripe ? Stripe(STRIPE_PUBLISHABLE_KEY) : null;

    let currentUser = null;
    let currentAvatarUrl = '';
    let currentUsername = '';
    let currentFullName = '';
    let currentUserProfileUrl = '';
    let currentUserLinkName = '';
    const messageUserProfileCache = new Map();
    const callParticipantProfileCache = new Map();
    let callParticipantsEnhanceObserver = null;
    let callParticipantsEnhanceQueued = false;
    let hasPrivateRoomAccess = false;
    let currentPurchasedPlanLabel = '';
    const defaultMessagePlaceholder = 'Type your message...';

    const mobileDrawerOverlay = document.getElementById('mobileDrawerOverlay');
    const mobileBottomNav = document.getElementById('mobileBottomNav');
    const mobileChatroomsBtn = document.getElementById('mobileChatroomsBtn');
    const mobileVoiceBtn = document.getElementById('mobileVoiceBtn');
    const mobilePaymentBtn = document.getElementById('mobilePaymentBtn');
    const mobileSettingsBtn = document.getElementById('mobileSettingsBtn');
    const mobileProfileBtn = document.getElementById('mobileProfileBtn');
    const mobileLogoutBtn = document.getElementById('mobileLogoutBtn');
    const mobileProfileAvatar = document.getElementById('mobileProfileAvatar');
    const mobileProfileLabel = document.getElementById('mobileProfileLabel');
    const mobileTextDrawerProfile = document.getElementById('mobileTextDrawerProfile');
    const mobileVoiceDrawerProfile = document.getElementById('mobileVoiceDrawerProfile');
    const mobileTextDrawerClose = document.getElementById('mobileTextDrawerClose');
    const mobileVoiceDrawerClose = document.getElementById('mobileVoiceDrawerClose');
    const mobileVoiceRoomSearch = document.getElementById('mobileVoiceRoomSearch');
    document.body.classList.add('chat-mobile-page');

    function setMobileNavActive(button) {
        if (!mobileBottomNav) return;
        mobileBottomNav.querySelectorAll('.mobile-nav-btn').forEach(navBtn => navBtn.classList.remove('active'));
        if (button) button.classList.add('active');
    }

    function closeMobileDrawers() {
        document.body.classList.remove('mobile-chat-drawer-open', 'mobile-voice-drawer-open');
    }

    function openMobileChatDrawer() {
        closeMobileDrawers();
        document.body.classList.add('mobile-chat-drawer-open');
        setMobileNavActive(mobileChatroomsBtn);
        setTimeout(() => textRoomSearch?.focus(), 180);
    }

    function openMobileVoiceDrawer() {
        closeMobileDrawers();
        document.body.classList.add('mobile-voice-drawer-open');
        setMobileNavActive(mobileVoiceBtn);
        // setTimeout(() => mobileVoiceRoomSearch?.focus(), 180);
    }

    function scrollMobileThreadToBottom(delay = 220) {
        setTimeout(() => {
            if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;
        }, delay);
    }

    function renderMobileFallbackProfile(target, subtitle) {
        if (!target) return;
        target.innerHTML = `
            <div class="mobile-drawer-avatar-fallback"><i class="fas fa-user"></i></div>
            <div class="mobile-drawer-identity-text">
                <div class="mobile-drawer-username">Guest</div>
                <small>${escapeHtml(subtitle)}</small>
            </div>
        `;
    }

    function getMobileDrawerAvatarHtml(label) {
        if (currentAvatarUrl) {
            return `<img src="${escapeHtml(currentAvatarUrl)}" class="mobile-drawer-avatar-img" alt="avatar">`;
        }

        return `<div class="mobile-drawer-avatar-fallback">${escapeHtml(getInitials(label || 'Guest'))}</div>`;
    }

    function renderMobileDrawerProfile(target, subtitle) {
        if (!target) return;

        if (!currentUser) {
            renderMobileFallbackProfile(target, subtitle);
            return;
        }

        const label = getCurrentSenderName() || currentUser.email || 'Guest User';
        const type = currentUser.isAnonymous ? 'Guest' : 'Registered';

        target.innerHTML = `
            ${getMobileDrawerAvatarHtml(label)}
            <div class="mobile-drawer-identity-text">
                <div class="mobile-drawer-username">${escapeHtml(label)}</div>
                <small>${escapeHtml(type)} · ${escapeHtml(subtitle)}</small>
            </div>
        `;
    }

    function updateMobileChrome() {
        const chip = currentUserBox?.querySelector('.current-user-chip');
        const avatarImg = chip?.querySelector('img.current-user-avatar');
        const fallback = chip?.querySelector('.current-user-avatar-fallback');
        const userNameText = currentUsername || chip?.querySelector('.current-user-name')?.textContent?.trim() || currentFullName || 'Login';

        renderMobileDrawerProfile(mobileTextDrawerProfile, 'Text Chatrooms');
        renderMobileDrawerProfile(mobileVoiceDrawerProfile, 'Voice Chatrooms');

        if (mobileProfileAvatar) {
            if (currentAvatarUrl) {
                mobileProfileAvatar.innerHTML = `<img src="${escapeHtml(currentAvatarUrl)}" alt="Profile avatar">`;
            } else if (avatarImg?.src) {
                mobileProfileAvatar.innerHTML = `<img src="${escapeHtml(avatarImg.src)}" alt="Profile avatar">`;
            } else if (fallback?.textContent?.trim()) {
                mobileProfileAvatar.innerHTML = `<span>${escapeHtml(fallback.textContent.trim().substring(0, 2))}</span>`;
            } else if (currentUser) {
                mobileProfileAvatar.innerHTML = `<span>${escapeHtml(getInitials(userNameText).substring(0, 2))}</span>`;
            } else {
                mobileProfileAvatar.innerHTML = `<i class="fas fa-user"></i>`;
            }
        }

        if (mobileProfileLabel) {
            mobileProfileLabel.textContent = currentUser ? (userNameText.length > 8 ? `${userNameText.substring(0, 7)}…` : userNameText) : 'Login';
        }

        if (mobileLogoutBtn) {
            mobileLogoutBtn.classList.toggle('d-none', !currentUser);
        }
    }

    if (currentUserBox) {
        const mobileUserObserver = new MutationObserver(updateMobileChrome);
        mobileUserObserver.observe(currentUserBox, { childList: true, subtree: true, attributes: true });
    }
    updateMobileChrome();

    let activeMode = null;
    let selectedTextRoomId = null;
    let selectedVoiceRoomId = null;
    let currentLoadedTextRoomId = null;
    let currentLoadedVoiceRoomId = null;

    let unsubscribeLatestText = null;
    let unsubscribeLatestVoice = null;
    let unsubscribeTyping = null;
    let unsubscribeCurrentUserStatus = null;
    let bannedSignOutInProgress = false;

    let textRoomsCache = [];
    let voiceRoomsCache = [];

    let currentTextSearch = '';
    let currentVoiceSearch = '';
    let initialUrlRoomHandled = !initialRoomIdFromUrl;
    let initialUrlRoomResolving = false;
    let textRoomsLoaded = false;
    let voiceRoomsLoaded = false;

    let latestTextDocs = [];
    let latestVoiceDocs = [];
    let olderTextDocs = [];
    let olderVoiceDocs = [];
    let oldestTextCursor = null;
    let oldestVoiceCursor = null;
    let hasMoreOldText = true;
    let hasMoreOldVoice = true;
    let loadingOlder = false;

    let mediaRecorder = null;
    let mediaStream = null;
    let recordedChunks = [];
    let recordedBlob = null;
    let recordingStartedAt = null;
    let isRecording = false;
    let isPaused = false;

    let selectedTextAttachmentFile = null;
    let selectedVoiceAttachmentFile = null;
    let discardRecordingRequested = false;

    let typingWriteTimeout = null;
    let typingStopTimeout = null;
    let lastTypingState = false;
    let stripeCardElement = null;
    let selectedPlanAmount = 0;
    let selectedPlanLabel = '';
    let selectedPlanId = '';
    let paymentPlansCache = [];

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function shortTime(timestamp) {
        if (!timestamp || !timestamp.toDate) return '';
        return timestamp.toDate().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function fullDateTime(timestamp) {
        if (!timestamp || !timestamp.toDate) return '';
        return timestamp.toDate().toLocaleString();
    }


    function compactDateTime(timestamp) {
        if (!timestamp || !timestamp.toDate) return '';
        const date = timestamp.toDate();
        const now = new Date();
        const sameDay = date.toDateString() === now.toDateString();

        if (sameDay) {
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }

        return date.toLocaleDateString([], { day: '2-digit', month: 'short' }) + ' • ' +
            date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function randomGuestName() {
        return 'Guest-' + Math.random().toString(36).substring(2, 8).toUpperCase();
    }

    function generateLoginToken() {
        const bytes = new Uint8Array(32);
        crypto.getRandomValues(bytes);
        return Array.from(bytes, byte => byte.toString(16).padStart(2, '0')).join('');
    }

    function getInitials(name) {
        const cleaned = (name || 'US').trim().split(/\s+/).slice(0, 2).map(part => part[0] || '').join('');
        return (cleaned || 'US').substring(0, 2).toUpperCase();
    }

    function renderAvatar(url, name, cls = 'message-avatar') {
        if (url) return `<img src="${escapeHtml(url)}" class="${cls}" alt="avatar">`;
        return `<div class="message-avatar-fallback">${escapeHtml(getInitials(name))}</div>`;
    }

    function sanitizeExternalUrl(url) {
        const trimmed = (url || '').trim();
        if (!trimmed) return '';

        const normalized = /^[a-zA-Z][a-zA-Z\d+\-.]*:/.test(trimmed) ? trimmed : `https://${trimmed}`;

        try {
            const parsed = new URL(normalized);
            if (parsed.protocol !== 'http:' && parsed.protocol !== 'https:') return '';
            return parsed.href;
        } catch (error) {
            return '';
        }
    }

    function getCachedMessageUserProfile(uid = '') {
        if (!uid) return null;
        return messageUserProfileCache.get(uid) || null;
    }

    function getMessageDisplayName(data = {}) {
        const cachedProfile = getCachedMessageUserProfile(data.uid || '');
        return cachedProfile?.username || data.username || data.sender_name || data.full_name || 'User';
    }

    function getMessageProfileFromData(data = {}) {
        const cachedProfile = getCachedMessageUserProfile(data.uid || '');
        const userName = cachedProfile?.username || getMessageDisplayName(data);

        return {
            uid: data.uid || '',
            userName: userName,
            fullName: cachedProfile?.full_name || data.full_name || '',
            avatarUrl: cachedProfile?.avatar_url || data.avatar_url || '',
            userUrl: cachedProfile?.user_url || data.user_url || '',
            linkName: cachedProfile?.link_name || data.link_name || data.linkName || ''
        };
    }

    async function fetchLatestMessageUserProfile(uid) {
        if (!uid) return null;

        try {
            const snap = await getDoc(doc(db, 'users', uid));
            if (!snap.exists()) return null;

            const data = snap.data() || {};
            const profile = {
                uid: uid,
                username: data.username || data.sender_name || data.full_name || 'User',
                full_name: data.full_name || '',
                avatar_url: data.avatar_url || '',
                user_url: data.user_url || '',
                link_name: data.link_name || data.linkName || ''
            };

            messageUserProfileCache.set(uid, profile);
            return profile;
        } catch (error) {
            console.error('Message profile refresh error:', error);
            return null;
        }
    }

    async function refreshRenderedMessageProfiles() {
        const metaNodes = Array.from(document.querySelectorAll('.message-user-meta[data-user-uid]'));
        const uniqueUids = [...new Set(metaNodes.map(node => node.dataset.userUid || '').filter(Boolean))];
        if (!uniqueUids.length) return;

        await Promise.all(uniqueUids.map(uid => fetchLatestMessageUserProfile(uid)));

        metaNodes.forEach(meta => {
            const uid = meta.dataset.userUid || '';
            const profile = getCachedMessageUserProfile(uid);
            if (!profile) return;

            const displayName = profile.username || 'User';
            meta.textContent = displayName;
            meta.dataset.userName = displayName;
            meta.dataset.userFullName = profile.full_name || '';
            meta.dataset.userAvatar = profile.avatar_url || '';
            meta.dataset.userUrl = profile.user_url || '';
            meta.dataset.linkName = profile.link_name || '';

            const row = meta.closest('.message-row');
            if (!row) return;

            row.querySelectorAll('.message-avatar, .message-avatar-fallback').forEach(avatarNode => {
                avatarNode.outerHTML = renderAvatar(profile.avatar_url || '', displayName);
            });
        });
    }

    function messageUserMetaHtml(msg) {
        const profile = getMessageProfileFromData(msg || {});

        return `<div class="message-meta message-user-meta" role="button" tabindex="0" title="View user profile" data-user-uid="${escapeHtml(profile.uid)}" data-user-name="${escapeHtml(profile.userName)}" data-user-full-name="${escapeHtml(profile.fullName)}" data-user-avatar="${escapeHtml(profile.avatarUrl)}" data-user-url="${escapeHtml(profile.userUrl)}" data-link-name="${escapeHtml(profile.linkName)}">${escapeHtml(profile.userName)}</div>`;
    }

    function renderMessageUserPopupAvatar(url, name) {
        if (url) {
            return `<img src="${escapeHtml(url)}" class="message-user-popup-avatar-img" alt="${escapeHtml(name || 'User')} avatar">`;
        }

        return `<div class="message-user-popup-avatar-fallback">${escapeHtml(getInitials(name || 'User'))}</div>`;
    }

    function renderMessageUserLink(profile) {
        if (!messageUserLinkBox) return;

        messageUserLinkBox.innerHTML = '';
        messageUserLinkBox.classList.add('d-none');

        const safeUrl = sanitizeExternalUrl(profile.userUrl || '');
        if (!safeUrl) return;

        const link = document.createElement('a');
        link.className = 'message-user-link-badge';
        link.href = safeUrl;
        link.target = '_blank';
        link.rel = 'noopener noreferrer';
        link.title = safeUrl;
        link.innerHTML = `<i class="fas fa-link"></i><span></span>`;
        link.querySelector('span').textContent = profile.linkName || 'Open Link';

        messageUserLinkBox.appendChild(link);
        messageUserLinkBox.classList.remove('d-none');
    }

    function setMessageUserPopupContent(profile = {}) {
        if (!messageUserAvatarBox || !messageUserNameText) return;

        const safeName = profile.userName || profile.username || profile.sender_name || 'User';
        const fullName = profile.fullName || profile.full_name || '';

        messageUserNameText.textContent = safeName;
        messageUserAvatarBox.innerHTML = renderMessageUserPopupAvatar(profile.avatarUrl || profile.avatar_url || '', safeName);

        if (messageUserFullNameText) {
            if (fullName && fullName !== safeName) {
                messageUserFullNameText.textContent = fullName;
                messageUserFullNameText.classList.remove('d-none');
            } else {
                messageUserFullNameText.textContent = '';
                messageUserFullNameText.classList.add('d-none');
            }
        }

        renderMessageUserLink(profile);
    }

    async function openMessageUserPopup(profile = {}) {
        if (!messageUserModal || !messageUserAvatarBox || !messageUserNameText) return;

        const requestId = ++messageUserPopupRequestId;
        setMessageUserPopupContent(profile);
        messageUserModal.show();

        if (!profile.uid) return;

        try {
            const userSnap = await getDoc(doc(db, 'users', profile.uid));
            if (requestId !== messageUserPopupRequestId || !userSnap.exists()) return;

            const data = userSnap.data() || {};
            setMessageUserPopupContent({
                uid: profile.uid,
                userName: data.username || profile.userName || data.sender_name || data.full_name || 'User',
                fullName: data.full_name || profile.fullName || '',
                avatarUrl: data.avatar_url || profile.avatarUrl || '',
                userUrl: data.user_url || profile.userUrl || '',
                linkName: data.link_name || data.linkName || profile.linkName || ''
            });
        } catch (error) {
            console.error('Message user profile fetch error:', error);
        }
    }

    function getMessageProfileFromMeta(meta) {
        return {
            uid: meta.dataset.userUid || '',
            userName: meta.dataset.userName || 'User',
            fullName: meta.dataset.userFullName || '',
            avatarUrl: meta.dataset.userAvatar || '',
            userUrl: meta.dataset.userUrl || '',
            linkName: meta.dataset.linkName || ''
        };
    }

    function getCurrentSenderName() {
        return currentUsername || currentUser?.displayName || currentUser?.email || 'Guest';
    }

    function getCurrentFullName() {
        return currentFullName || '';
    }

    function getCurrentUserUrl() {
        return currentUserProfileUrl || '';
    }

    function getCurrentUserLinkName() {
        return currentUserLinkName || '';
    }

    function getCurrentMessageProfilePayload() {
        return {
            username: getCurrentSenderName(),
            sender_name: getCurrentSenderName(),
            full_name: getCurrentFullName(),
            user_url: getCurrentUserUrl(),
            link_name: getCurrentUserLinkName()
        };
    }

    function getCurrentUserPopupProfile() {
        if (!currentUser) return null;

        return {
            uid: currentUser.uid || '',
            userName: getCurrentSenderName(),
            fullName: getCurrentFullName(),
            avatarUrl: getCurrentAvatarUrl(),
            userUrl: getCurrentUserUrl(),
            linkName: getCurrentUserLinkName()
        };
    }

    function normalizeCallLookupText(value) {
        return String(value || '').trim().toLowerCase();
    }

    function getCallProfileDisplayName(profile = {}) {
        return profile.username || profile.sender_name || profile.full_name || profile.email || 'User';
    }

    function cacheCallProfile(uid, profile = {}) {
        if (!uid) return;

        callParticipantProfileCache.set(uid, {
            uid: uid,
            username: profile.username || profile.sender_name || profile.full_name || profile.email || 'User',
            sender_name: profile.sender_name || profile.username || profile.full_name || profile.email || 'User',
            full_name: profile.full_name || '',
            email: profile.email || '',
            avatar_url: profile.avatar_url || '',
            user_url: profile.user_url || '',
            link_name: profile.link_name || profile.linkName || ''
        });
    }

    function getCurrentCallProfile() {
        if (!currentUser) return null;

        return {
            uid: currentUser.uid || '',
            username: getCurrentSenderName(),
            sender_name: getCurrentSenderName(),
            full_name: getCurrentFullName(),
            email: currentUser.email || '',
            avatar_url: getCurrentAvatarUrl(),
            user_url: getCurrentUserUrl(),
            link_name: getCurrentUserLinkName()
        };
    }

    function getCallProfileByUid(uid = '') {
        if (!uid) return null;
        if (currentUser && uid === currentUser.uid) return getCurrentCallProfile();
        return callParticipantProfileCache.get(uid) || null;
    }

    function getCallProfileByName(name = '') {
        const lookup = normalizeCallLookupText(name);
        if (!lookup) return null;

        if (lookup === 'you' || lookup === 'me') return getCurrentCallProfile();

        if (currentUser) {
            const currentProfile = getCurrentCallProfile();
            const currentValues = [
                currentProfile?.username,
                currentProfile?.sender_name,
                currentProfile?.full_name,
                currentProfile?.email,
                currentUser.uid
            ].map(normalizeCallLookupText).filter(Boolean);

            if (currentValues.includes(lookup)) return currentProfile;
        }

        for (const profile of callParticipantProfileCache.values()) {
            const values = [
                profile.uid,
                profile.username,
                profile.sender_name,
                profile.full_name,
                profile.email,
                (profile.email || '').split('@')[0]
            ].map(normalizeCallLookupText).filter(Boolean);

            if (values.includes(lookup)) return profile;
        }

        return null;
    }

    function getCallProfileByInitial(initial = '') {
        const lookup = normalizeCallLookupText(initial).replace(/[^a-z0-9]/g, '');
        if (!lookup || lookup.length > 2) return null;

        const matches = [];
        const currentProfile = getCurrentCallProfile();
        if (currentProfile) {
            const currentName = getCallProfileDisplayName(currentProfile);
            if (normalizeCallLookupText(getInitials(currentName)) === lookup || normalizeCallLookupText(currentName[0] || '') === lookup) {
                matches.push(currentProfile);
            }
        }

        for (const profile of callParticipantProfileCache.values()) {
            if (currentUser && profile.uid === currentUser.uid) continue;
            const displayName = getCallProfileDisplayName(profile);
            if (normalizeCallLookupText(getInitials(displayName)) === lookup || normalizeCallLookupText(displayName[0] || '') === lookup) {
                matches.push(profile);
            }
        }

        return matches.length === 1 ? matches[0] : null;
    }

    function renderCallParticipantAvatar(profile, fallbackName = 'User') {
        const displayName = (profile && (profile.username || profile.sender_name || profile.full_name || profile.email)) || fallbackName || 'User';
        const avatarUrl = profile?.avatar_url || '';

        if (avatarUrl) {
            return `<img src="${escapeHtml(avatarUrl)}" class="call-participant-avatar" alt="${escapeHtml(displayName)} avatar" data-call-avatar-enhanced="1">`;
        }

        return `<div class="call-participant-avatar-fallback" data-call-avatar-enhanced="1">${escapeHtml(getInitials(displayName || fallbackName))}</div>`;
    }

    function renderCallMiniAvatar(profile, fallbackName = 'User') {
        const displayName = (profile && (profile.username || profile.sender_name || profile.full_name || profile.email)) || fallbackName || 'User';
        const avatarUrl = profile?.avatar_url || '';

        if (avatarUrl) {
            return `<img src="${escapeHtml(avatarUrl)}" class="call-mini-avatar" alt="${escapeHtml(displayName)} avatar" title="${escapeHtml(displayName)}">`;
        }

        return `<span class="call-mini-avatar-fallback" title="${escapeHtml(displayName)}">${escapeHtml(getInitials(displayName || fallbackName))}</span>`;
    }

    function extractCallParticipantRows() {
        const list = document.getElementById('callParticipantsList');
        if (!list) return [];

        return Array.from(list.querySelectorAll('.call-participant-row')).map((row) => {
            const explicitUid = row.dataset.uid || row.dataset.userUid || row.getAttribute('data-uid') || '';
            const nameNode = row.querySelector('.call-participant-name') || row.querySelector('[data-participant-name]');
            const rawName = (nameNode ? nameNode.textContent : row.textContent || '').trim().split(/\n/)[0].trim();
            const cleanName = rawName || 'User';
            const profile = getCallProfileByUid(explicitUid) || getCallProfileByName(cleanName) || getCallProfileByInitial(cleanName);

            return { row, name: cleanName, profile };
        });
    }

    function enhanceCallParticipantsModalAvatars() {
        const rows = extractCallParticipantRows();
        rows.forEach(({ row, name, profile }) => {
            if (!profile) return;

            const avatarNode = row.querySelector('.call-participant-avatar, .call-participant-avatar-fallback');
            if (!avatarNode) return;

            const avatarUrl = profile.avatar_url || '';
            const currentSrc = avatarNode.tagName === 'IMG' ? (avatarNode.getAttribute('src') || '') : '';
            const displayName = getCallProfileDisplayName(profile) || name;

            if (avatarUrl && currentSrc !== avatarUrl) {
                avatarNode.outerHTML = renderCallParticipantAvatar(profile, displayName);
            } else if (!avatarUrl && avatarNode.classList.contains('call-participant-avatar-fallback')) {
                avatarNode.textContent = getInitials(displayName);
            }

            const nameNode = row.querySelector('.call-participant-name');
            if (nameNode && name !== 'You') nameNode.textContent = displayName;
        });
    }

    function getOrderedCallParticipantProfilesFromModal() {
        const rows = extractCallParticipantRows();
        if (!rows.length) return [];

        return rows.map(({ name, profile }) => ({
            name,
            profile: profile || getCallProfileByName(name) || getCallProfileByInitial(name)
        }));
    }

    function enhanceCallParticipantsAvatarStack() {
        const stack = document.getElementById('callParticipantsAvatars');
        if (!stack) return;

        let ordered = getOrderedCallParticipantProfilesFromModal();

        if (!ordered.length) {
            const existing = Array.from(stack.children);
            ordered = existing.map((node, index) => {
                const rawName = node.dataset.userName || node.dataset.participantName || node.title || node.getAttribute('aria-label') || node.textContent || '';
                const cleanName = String(rawName || '').trim();
                const profile = getCallProfileByName(cleanName) || getCallProfileByInitial(cleanName) || (index === 0 ? getCurrentCallProfile() : null);
                return { name: cleanName || getCallProfileDisplayName(profile || {}) || 'User', profile };
            }).filter(item => item.profile || item.name);
        }

        if (!ordered.length) return;

        const desiredHtml = ordered.map(({ name, profile }) => {
            return renderCallMiniAvatar(profile || {}, name || 'User');
        }).join('');

        if (stack.innerHTML !== desiredHtml) {
            stack.innerHTML = desiredHtml;
        }
    }

    function enhanceCallParticipantDisplays() {
        enhanceCallParticipantsModalAvatars();
        enhanceCallParticipantsAvatarStack();
    }

    function scheduleEnhanceCallParticipantDisplays() {
        if (callParticipantsEnhanceQueued) return;
        callParticipantsEnhanceQueued = true;

        requestAnimationFrame(() => {
            callParticipantsEnhanceQueued = false;
            enhanceCallParticipantDisplays();
        });
    }

    function initCallParticipantAvatarEnhancer() {
        if (callParticipantsEnhanceObserver) return;

        const list = document.getElementById('callParticipantsList');
        const stack = document.getElementById('callParticipantsAvatars');
        const modal = document.getElementById('callParticipantsModal');
        const btn = document.getElementById('callParticipantsBtn');

        callParticipantsEnhanceObserver = new MutationObserver(scheduleEnhanceCallParticipantDisplays);

        [list, stack].filter(Boolean).forEach(target => {
            callParticipantsEnhanceObserver.observe(target, {
                childList: true,
                subtree: true,
                characterData: true,
                attributes: true,
                attributeFilter: ['src', 'title', 'data-user-name', 'data-participant-name', 'data-uid', 'data-user-uid']
            });
        });

        if (modal) {
            modal.addEventListener('shown.bs.modal', () => {
                setTimeout(scheduleEnhanceCallParticipantDisplays, 30);
            });
        }

        if (btn) {
            btn.addEventListener('click', () => {
                setTimeout(scheduleEnhanceCallParticipantDisplays, 30);
                setTimeout(scheduleEnhanceCallParticipantDisplays, 180);
            });
        }

        scheduleEnhanceCallParticipantDisplays();
    }

    function listenCallParticipantUserProfiles() {
        onSnapshot(collection(db, 'users'), (snapshot) => {
            snapshot.docs.forEach(docSnap => {
                cacheCallProfile(docSnap.id, docSnap.data() || {});
            });

            if (currentUser) {
                cacheCallProfile(currentUser.uid, getCurrentCallProfile() || {});
            }

            scheduleEnhanceCallParticipantDisplays();
        }, (error) => {
            console.error('Call participant user profile load error:', error);
        });
    }

    function getCurrentSenderType() {
        if (!currentUser) return null;
        return currentUser.isAnonymous ? 'guest' : 'registered';
    }

    function getCurrentAvatarUrl() {
        return currentAvatarUrl || '';
    }

    function setTextComposerState(enabled) {
        messageInput.disabled = !enabled;
        emojiToggleBtn.disabled = !enabled;
        if (textAttachmentBtn) textAttachmentBtn.disabled = !enabled;
        updateSendButtonState();
    }

    function updateAuthEntryVisibility() {
        if (!currentUser) authEntryOverlay.classList.remove('d-none');
        else authEntryOverlay.classList.add('d-none');
        updatePrivateAccessOverlay();
    }

    function showAuthAlert(message, type = 'danger') {
        authAlertBox.innerHTML = `<div class="alert alert-${type} py-2">${escapeHtml(message)}</div>`;
    }

    function clearAuthAlert() {
        authAlertBox.innerHTML = '';
    }

    function getFriendlyLoginErrorMessage(error) {
        const code = (error?.code || '').toLowerCase();

        if (['auth/invalid-credential', 'auth/wrong-password', 'auth/user-not-found'].includes(code)) {
            return 'Invalid Credentials!';
        }

        return error?.message || 'Login failed.';
    }

    function showProfileAlert(message, type = 'danger') {
        profileAlertBox.innerHTML = `<div class="alert alert-${type} py-2">${escapeHtml(message)}</div>`;
    }

    function clearProfileAlert() {
        profileAlertBox.innerHTML = '';
    }

    function showPaymentAlert(message, type = 'danger') {
        if (!paymentAlertBox) return;
        paymentAlertBox.innerHTML = `<div class="alert alert-${type} py-2">${escapeHtml(message)}</div>`;
    }

    function clearPaymentAlert() {
        if (!paymentAlertBox) return;
        paymentAlertBox.innerHTML = '';
    }

    function roomAccessBadgeHtml(access) {
        const normalized = (access || 'public') === 'private' ? 'private' : 'public';
        const icon = normalized === 'private' ? 'fa-lock' : 'fa-globe';
        const label = normalized === 'private' ? 'Private' : 'Public';
        return `<span class="room-access-badge room-access-${normalized}"><i class="fas ${icon}"></i>${label}</span>`;
    }

    function setAuthMode(mode) {
        authMode.value = mode;

        registerNameWrap.classList.toggle('d-none', mode !== 'register');
        registerAvatarWrap.classList.toggle('d-none', mode !== 'register');
        authPasswordWrap.classList.toggle('d-none', mode === 'forgot' || mode === 'reset');
        resetPasswordWrap.classList.toggle('d-none', mode !== 'reset');

        if (mode === 'register') {
            authActionBtn.textContent = 'Register';
            showRegisterModeBtn.className = 'btn btn-primary btn-sm';
            showLoginModeBtn.className = 'btn btn-outline-primary btn-sm';
            showForgotModeBtn.className = 'btn btn-outline-primary btn-sm';
        } else if (mode === 'forgot') {
            authActionBtn.textContent = 'Send Reset Email';
            showForgotModeBtn.className = 'btn btn-primary btn-sm';
            showLoginModeBtn.className = 'btn btn-outline-primary btn-sm';
            showRegisterModeBtn.className = 'btn btn-outline-primary btn-sm';
        } else if (mode === 'reset') {
            authActionBtn.textContent = 'Reset Password';
            showForgotModeBtn.className = 'btn btn-primary btn-sm';
            showLoginModeBtn.className = 'btn btn-outline-primary btn-sm';
            showRegisterModeBtn.className = 'btn btn-outline-primary btn-sm';
        } else {
            registerNameWrap.classList.add('d-none');
            registerAvatarWrap.classList.add('d-none');
            authPasswordWrap.classList.remove('d-none');
            resetPasswordWrap.classList.add('d-none');
            authActionBtn.textContent = 'Login';
            showLoginModeBtn.className = 'btn btn-primary btn-sm';
            showRegisterModeBtn.className = 'btn btn-outline-primary btn-sm';
            showForgotModeBtn.className = 'btn btn-outline-primary btn-sm';
        }
    }

    function clearAuthForm() {
        authName.value = '';
        if (authUsername) authUsername.value = '';
        authEmail.value = '';
        authPassword.value = '';
        if (resetNewPassword) resetNewPassword.value = '';
        if (resetConfirmPassword) resetConfirmPassword.value = '';
        if (resetOobCode) resetOobCode.value = '';
        authAvatarFile.value = '';
        clearAuthAlert();
    }

    async function getUserProfileDoc(userId) {
        if (!userId) return null;
        try {
            const userSnap = await getDoc(doc(db, 'users', userId));
            return userSnap.exists() ? (userSnap.data() || {}) : null;
        } catch (error) {
            console.error('User profile fetch error:', error);
            return null;
        }
    }

    function isUserBannedFromProfile(userProfile) {
        if (!userProfile) return false;
        return Boolean(
            userProfile.is_banned === true ||
            userProfile.banned === true ||
            userProfile.status === 'banned'
        );
    }

    function stopCurrentUserStatusListener() {
        if (unsubscribeCurrentUserStatus) {
            unsubscribeCurrentUserStatus();
            unsubscribeCurrentUserStatus = null;
        }
    }

    async function handleBannedUser(user = null) {
        if (bannedSignOutInProgress) return;
        bannedSignOutInProgress = true;

        stopCurrentUserStatusListener();

        try {
            if (user || auth.currentUser) {
                await signOut(auth);
            }
        } catch (error) {
            console.error('Banned user sign out error:', error);
        }

        currentUser = null;
        currentAvatarUrl = '';
        currentUsername = '';
        currentFullName = '';
        currentUserProfileUrl = '';
        currentUserLinkName = '';
        hasPrivateRoomAccess = false;
        currentPurchasedPlanLabel = '';
        renderCurrentUser();
        updateAuthEntryVisibility();
        updateActiveComposerAccess();
        showAuthAlert('Your account has been banned. Please contact the admin.', 'danger');
        if (authModal) authModal.show();

        setTimeout(() => {
            bannedSignOutInProgress = false;
        }, 400);
    }

    function startCurrentUserStatusListener(user) {
        stopCurrentUserStatusListener();
        if (!user || !user.uid) return;

        unsubscribeCurrentUserStatus = onSnapshot(doc(db, 'users', user.uid), async (snapshot) => {
            if (!snapshot.exists()) return;

            const profile = snapshot.data() || {};
            if (isUserBannedFromProfile(profile)) {
                await handleBannedUser(user);
                return;
            }

            currentAvatarUrl = profile.avatar_url || currentAvatarUrl || '';
            currentUsername = profile.username || profile.sender_name || currentUsername || user.displayName || user.email || 'Registered User';
            currentFullName = profile.full_name || currentFullName || '';
            currentUserProfileUrl = profile.user_url || currentUserProfileUrl || '';
            currentUserLinkName = profile.link_name || profile.linkName || currentUserLinkName || '';
            renderCurrentUser();
        }, (error) => {
            console.error('Current user status listener error:', error);
        });
    }



    async function sendQuickLoginLink(email, name = '') {
        const response = await fetch('frontend/chatroom_email.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, name })
        });

        const data = await response.json();

        if (!data.success) {
            throw new Error(data.error || 'Failed to send quick login email.');
        }

        return data;
    }


    async function sendForgotPasswordEmail() {
        const email = authEmail.value.trim();

        if (!email) {
            showAuthAlert('Please enter your email address.');
            return;
        }

        try {
            authActionBtn.disabled = true;
            clearAuthAlert();

            const response = await fetch('frontend/forgot_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.error || 'Failed to send reset password email.');
            }

            showAuthAlert('Password reset email sent. Please check your inbox.', 'success');
        } catch (error) {
            console.error('Forgot password error:', error);
            showAuthAlert(error.message || 'Failed to send reset password email.');
        } finally {
            authActionBtn.disabled = false;
        }
    }

    async function resetPasswordFromEmailLink() {
        const code = resetOobCode.value || new URLSearchParams(window.location.search).get('oobCode') || '';
        const newPassword = resetNewPassword.value.trim();
        const confirmPassword = resetConfirmPassword.value.trim();

        if (!code) {
            showAuthAlert('Invalid or missing password reset code.');
            return;
        }

        if (!newPassword || !confirmPassword) {
            showAuthAlert('Please enter and confirm your new password.');
            return;
        }

        if (newPassword !== confirmPassword) {
            showAuthAlert('Passwords do not match.');
            return;
        }

        if (newPassword.length < 6) {
            showAuthAlert('Password must be at least 6 characters.');
            return;
        }

        try {
            authActionBtn.disabled = true;
            clearAuthAlert();

            await confirmPasswordReset(auth, code, newPassword);

            showAuthAlert('Password reset successfully. You can login now.', 'success');
            window.history.replaceState({}, document.title, QUICK_LOGIN_LANDING_URL);
            setAuthMode('login');
            authPassword.value = '';
            resetNewPassword.value = '';
            resetConfirmPassword.value = '';
            resetOobCode.value = '';
        } catch (error) {
            console.error('Reset password error:', error);
            showAuthAlert(error.message || 'Password reset failed.');
        } finally {
            authActionBtn.disabled = false;
        }
    }

    async function handlePasswordResetLanding() {
        const params = new URLSearchParams(window.location.search);
        const mode = params.get('mode') || '';
        const code = params.get('oobCode') || '';

        if (mode === 'resetPassword' && code) {
            resetOobCode.value = code;
            setAuthMode('reset');
            clearAuthAlert();

            try {
                const resetEmail = await verifyPasswordResetCode(auth, code);
                if (resetEmail) authEmail.value = resetEmail;
            } catch (error) {
                showAuthAlert('Reset link may be expired or invalid. Please request a new one.', 'warning');
            }

            authModal.show();
        }
    }

    let tokenSignInInProgress = false;

    async function handleLoginTokenSignIn() {
        const params = new URLSearchParams(window.location.search);
        const loginToken = params.get('login_token');

        if (!loginToken || tokenSignInInProgress) return;

        tokenSignInInProgress = true;

        try {
            clearAuthAlert();

            const response = await fetch('frontend/verify-login-token.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ token: loginToken })
            });

            const data = await response.json();

            if (!data.success || !data.customToken) {
                throw new Error(data.error || 'Invalid quick login link.');
            }

            if (auth.currentUser && auth.currentUser.isAnonymous) {
                await signOut(auth);
            }

            const result = await signInWithCustomToken(auth, data.customToken);
            const user = result.user;

            const userProfile = await getUserProfileDoc(user.uid);
            if (isUserBannedFromProfile(userProfile)) {
                await handleBannedUser(user);
                return;
            }

            currentUser = user;
            currentAvatarUrl = userProfile?.avatar_url || '';

            await loadCurrentUserAvatar();
            await saveUserProfile(
                user,
                userProfile?.username || userProfile?.sender_name || user.displayName || user.email || 'Registered User',
                'registered',
                currentAvatarUrl || userProfile?.avatar_url || '',
                userProfile?.full_name || ''
            );

            renderCurrentUser();
            updateAuthEntryVisibility();
            updateActiveComposerAccess();

            if (activeMode === 'text' && selectedTextRoomId) {
                await ensureParticipantInRoom(selectedTextRoomId, 'text');
                renderCombinedTextMessages(selectedTextRoomId);
            } else if (activeMode === 'voice' && selectedVoiceRoomId) {
                await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');
                renderCombinedVoiceMessages(selectedVoiceRoomId);
            }

            if (authModal) authModal.hide();
            clearAuthForm();
            window.history.replaceState({}, document.title, QUICK_LOGIN_LANDING_URL);
        } catch (error) {
            console.error('Quick token sign-in error:', error);
            showAuthAlert(error.message || 'Quick login failed.');
            setAuthMode('login');
            authEmail.value = '';
            authModal.show();
        } finally {
            tokenSignInInProgress = false;
        }
    }

    async function fillProfileForm() {
        if (!currentUser || currentUser.isAnonymous) {
            if (profileEmail) profileEmail.value = '';
            if (profileUsername) profileUsername.value = '';
            profileName.value = '';
            profilePassword.value = '';
            profileAvatarFile.value = '';
            showProfileAlert('Guest users cannot update profile settings. Please register/login with email.', 'warning');
            return;
        }

        clearProfileAlert();
        const profile = await loadCurrentUserProfile();
        if (profileEmail) profileEmail.value = currentUser.email || profile?.email || '';
        if (profileUsername) profileUsername.value = currentUsername || profile?.username || profile?.sender_name || '';
        profileName.value = currentFullName || profile?.full_name || '';
        profilePassword.value = '';
        profileAvatarFile.value = '';
    }

    function renderCurrentUser() {
        if (!currentUser) {
            currentUserBox.innerHTML = `<span class="badge bg-light text-dark">Not logged in</span>`;
            logoutBtn.classList.add('d-none');
            profileSettingsBtn.classList.add('d-none');
            paymentPlansBtn.classList.add('d-none');
            if (createRoomBtn) createRoomBtn.classList.add('d-none');
            if (mobileLogoutBtn) mobileLogoutBtn.classList.add('d-none');
            updateMobileChrome();
            updateAudioCallSharedState();
            return;
        }

        const label = getCurrentSenderName() || currentUser.email || 'Guest User';
        const type = currentUser.isAnonymous ? 'Guest' : 'Registered';

        currentUserBox.innerHTML = `
            <div class="current-user-chip" role="button" tabindex="0" title="View your profile">
                ${currentAvatarUrl
                    ? `<img src="${escapeHtml(currentAvatarUrl)}" class="current-user-avatar" alt="avatar">`
                    : `<div class="current-user-avatar-fallback">${escapeHtml(getInitials(label))}</div>`
                }
                <div class="current-user-info">
                    <div class="current-user-name">${escapeHtml(label)}</div>
                    <div class="current-user-type">${escapeHtml(type)}</div>
                    ${hasPrivateRoomAccess ? `<div class="purchased-plan-badge"><i class="fas fa-crown"></i>${escapeHtml(currentPurchasedPlanLabel || 'Private Plan')}</div>` : ''}
                </div>
            </div>
        `;

        logoutBtn.classList.remove('d-none');
        if (mobileLogoutBtn) mobileLogoutBtn.classList.remove('d-none');
        profileSettingsBtn.classList.remove('d-none');
        if (!currentUser.isAnonymous) paymentPlansBtn.classList.remove('d-none');
        else paymentPlansBtn.classList.add('d-none');

        if (createRoomBtn) {
            if (!currentUser.isAnonymous && hasPrivateRoomAccess) {
                
            }
            else {
                createRoomBtn.classList.add('d-none');
}
        }

        cacheCallProfile(currentUser.uid, getCurrentCallProfile() || {});
        updateMobileChrome();
        updateAudioCallSharedState();
        scheduleEnhanceCallParticipantDisplays();
    }



    function buildAudioCallSharedState() {
        return {
            activeMode: activeMode,
            selectedVoiceRoomId: selectedVoiceRoomId,
            currentUser: currentUser ? {
                uid: currentUser.uid || '',
                displayName: getCurrentSenderName() || currentUser.displayName || currentUser.email || 'User',
                username: getCurrentSenderName() || '',
                fullName: getCurrentFullName() || '',
                email: currentUser.email || '',
                isAnonymous: !!currentUser.isAnonymous,
                avatarUrl: getCurrentAvatarUrl() || ''
            } : null
        };
    }

    function updateAudioCallSharedState() {
        window.ChatroomAudioCallState = buildAudioCallSharedState();

        window.dispatchEvent(new CustomEvent('chatroom-call-state-updated', {
            detail: window.ChatroomAudioCallState
        }));
    }

    window.getChatroomAudioCallState = function () {
        window.ChatroomAudioCallState = buildAudioCallSharedState();
        return window.ChatroomAudioCallState;
    };

    function updateTextInlineVoicePanel(state = 'idle') {
        if (!textVoiceRecordPanel) return;

        const isTextMode = activeMode === 'text';
        const isActive = isTextMode && (state === 'recording' || state === 'paused' || state === 'ready' || isRecording || !!recordedBlob);

        textVoiceRecordPanel.classList.toggle('d-none', !isActive);
        messageInput.classList.toggle('d-none', isActive);
        if (textAttachmentBtn) textAttachmentBtn.classList.toggle('d-none', isActive);
        if (emojiToggleBtn) emojiToggleBtn.classList.toggle('d-none', isActive);

        if (!isActive) {
            if (textInlineRecordingStatus) textInlineRecordingStatus.textContent = 'Recording...';
            if (textInlineWaveBars) textInlineWaveBars.classList.remove('paused');
            if (textDiscardVoiceBtn) textDiscardVoiceBtn.disabled = true;
            if (textPauseRecordingBtn) {
                textPauseRecordingBtn.disabled = true;
                textPauseRecordingBtn.innerHTML = '<i class="fas fa-pause"></i>';
            }
            return;
        }

        if (textDiscardVoiceBtn) textDiscardVoiceBtn.disabled = false;

        if (state === 'recording') {
            if (textInlineRecordingStatus) textInlineRecordingStatus.textContent = 'Recording...';
            if (textInlineWaveBars) textInlineWaveBars.classList.remove('paused');
            if (textPauseRecordingBtn) {
                textPauseRecordingBtn.disabled = false;
                textPauseRecordingBtn.innerHTML = '<i class="fas fa-pause"></i>';
            }
        } else if (state === 'paused') {
            if (textInlineRecordingStatus) textInlineRecordingStatus.textContent = 'Paused';
            if (textInlineWaveBars) textInlineWaveBars.classList.add('paused');
            if (textPauseRecordingBtn) {
                textPauseRecordingBtn.disabled = false;
                textPauseRecordingBtn.innerHTML = '<i class="fas fa-play"></i>';
            }
        } else if (state === 'ready') {
            if (textInlineRecordingStatus) textInlineRecordingStatus.textContent = 'Ready to send';
            if (textInlineWaveBars) textInlineWaveBars.classList.add('paused');
            if (textPauseRecordingBtn) textPauseRecordingBtn.disabled = true;
        }
    }

    function resetVoiceRecorderUI() {
        isRecording = false;
        isPaused = false;
        voicePreview.pause();
        voicePreview.src = '';
        voicePreview.classList.add('d-none');
        voiceWaveBars.classList.add('d-none');
        recordToggleIcon.className = 'fas fa-microphone';
        if (textRecordToggleIcon) textRecordToggleIcon.className = 'fas fa-microphone';
        recordToggleBtn.classList.remove('recording', 'ready-send');
        if (textRecordToggleBtn) textRecordToggleBtn.classList.remove('recording', 'ready-send');
        pauseRecordingBtn.disabled = true;
        pauseRecordingBtn.innerHTML = '<i class="fas fa-pause"></i>';
        discardVoiceBtn.disabled = true;
        recordingStatus.textContent = 'Tap mic to record';
        updateTextInlineVoicePanel('idle');
    }

    async function uploadImageToCloudinary(file, folderName = 'avatars') {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);
        formData.append('folder', folderName);

        const response = await fetch(CLOUDINARY_IMAGE_UPLOAD_URL, {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data?.error?.message || 'Cloudinary image upload failed');
        return data.secure_url;
    }

    function formatFileSize(bytes) {
        const size = Number(bytes || 0);
        if (!size) return '';
        if (size < 1024) return `${size} B`;
        if (size < 1024 * 1024) return `${(size / 1024).toFixed(1)} KB`;
        return `${(size / (1024 * 1024)).toFixed(1)} MB`;
    }

    function getAttachmentIcon(mimeType = '') {
        if (mimeType.startsWith('image/')) return 'fa-file-image';
        if (mimeType.startsWith('video/')) return 'fa-file-video';
        if (mimeType.startsWith('audio/')) return 'fa-file-audio';
        if (mimeType.includes('pdf')) return 'fa-file-pdf';
        if (mimeType.includes('zip') || mimeType.includes('rar')) return 'fa-file-archive';
        return 'fa-file-alt';
    }

    function attachmentPreviewHtml(file) {
        if (!file) return '';
        return `
            <div class="attachment-preview-chip">
                <i class="fas ${getAttachmentIcon(file.type)}"></i>
                <span>${escapeHtml(file.name)}</span>
                <small>${escapeHtml(formatFileSize(file.size))}</small>
                <button type="button" class="attachment-clear-btn" title="Remove attachment">&times;</button>
            </div>
        `;
    }

    function renderSelectedTextAttachment() {
        if (!textAttachmentPreview) return;
        if (!selectedTextAttachmentFile) {
            textAttachmentPreview.classList.add('d-none');
            textAttachmentPreview.innerHTML = '';
            return;
        }
        textAttachmentPreview.innerHTML = attachmentPreviewHtml(selectedTextAttachmentFile);
        textAttachmentPreview.classList.remove('d-none');
        const clearBtn = textAttachmentPreview.querySelector('.attachment-clear-btn');
        if (clearBtn) clearBtn.addEventListener('click', clearSelectedTextAttachment);
    }

    function renderSelectedVoiceAttachment() {
        if (!voiceAttachmentPreview) return;
        if (!selectedVoiceAttachmentFile) {
            voiceAttachmentPreview.classList.add('d-none');
            voiceAttachmentPreview.innerHTML = '';
            if (sendVoiceAttachmentBtn) sendVoiceAttachmentBtn.classList.add('d-none');
            return;
        }
        voiceAttachmentPreview.innerHTML = attachmentPreviewHtml(selectedVoiceAttachmentFile);
        voiceAttachmentPreview.classList.remove('d-none');
        if (sendVoiceAttachmentBtn) {
            sendVoiceAttachmentBtn.classList.remove('d-none');
            sendVoiceAttachmentBtn.disabled = false;
        }
        const clearBtn = voiceAttachmentPreview.querySelector('.attachment-clear-btn');
        if (clearBtn) clearBtn.addEventListener('click', clearSelectedVoiceAttachment);
    }

    function clearSelectedTextAttachment() {
        selectedTextAttachmentFile = null;
        if (textAttachmentInput) textAttachmentInput.value = '';
        renderSelectedTextAttachment();
        updateSendButtonState();
    }

    function clearSelectedVoiceAttachment() {
        selectedVoiceAttachmentFile = null;
        if (voiceAttachmentInput) voiceAttachmentInput.value = '';
        renderSelectedVoiceAttachment();
    }

    async function uploadAttachmentToCloudinary(file, folderName = 'chatroom_uploads') {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);
        formData.append('folder', folderName);

        const response = await fetch(CLOUDINARY_AUTO_UPLOAD_URL, {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data?.error?.message || 'Cloudinary attachment upload failed');
        }

        return {
            url: data.secure_url,
            public_id: data.public_id || '',
            name: file.name,
            mime_type: file.type || '',
            resource_type: data.resource_type || '',
            bytes: data.bytes || file.size || 0,
            format: data.format || ''
        };
    }

    function renderAttachmentHtml(msg) {
        const attachmentUrl = msg.attachment_url || msg.file_url || '';
        if (!attachmentUrl) return '';

        const attachmentName = msg.attachment_name || msg.file_name || 'Attachment';
        const mimeType = msg.attachment_type || msg.mime_type || '';
        const isImage = mimeType.startsWith('image/');
        const isVideo = mimeType.startsWith('video/');
        const isAudio = mimeType.startsWith('audio/');

        if (isImage) {
            return `
                <a href="${escapeHtml(attachmentUrl)}" target="_blank" class="message-attachment message-attachment-image">
                    <img src="${escapeHtml(attachmentUrl)}" alt="${escapeHtml(attachmentName)}">
                    <span>${escapeHtml(attachmentName)}</span>
                </a>
            `;
        }

        if (isVideo) {
            return `
                <div class="message-attachment">
                    <video controls preload="metadata" class="message-attachment-media">
                        <source src="${escapeHtml(attachmentUrl)}" type="${escapeHtml(mimeType || 'video/mp4')}">
                    </video>
                    <a href="${escapeHtml(attachmentUrl)}" target="_blank"><i class="fas fa-file-video"></i> ${escapeHtml(attachmentName)}</a>
                </div>
            `;
        }

        if (isAudio) {
            return `
                <div class="message-attachment">
                    <audio controls preload="metadata" class="message-attachment-media">
                        <source src="${escapeHtml(attachmentUrl)}" type="${escapeHtml(mimeType || 'audio/mpeg')}">
                    </audio>
                    <a href="${escapeHtml(attachmentUrl)}" target="_blank"><i class="fas fa-file-audio"></i> ${escapeHtml(attachmentName)}</a>
                </div>
            `;
        }

        return `
            <a href="${escapeHtml(attachmentUrl)}" target="_blank" class="message-attachment message-attachment-file">
                <i class="fas ${getAttachmentIcon(mimeType)}"></i>
                <span>${escapeHtml(attachmentName)}</span>
            </a>
        `;
    }

    async function loadCurrentUserProfile() {
        if (!currentUser) {
            currentAvatarUrl = '';
            currentUsername = '';
            currentFullName = '';
            currentUserProfileUrl = '';
            currentUserLinkName = '';
            return null;
        }

        try {
            const userSnap = await getDoc(doc(db, 'users', currentUser.uid));
            const profile = userSnap.exists() ? (userSnap.data() || {}) : {};

            currentAvatarUrl = profile.avatar_url || '';
            currentUsername = profile.username || profile.sender_name || currentUser.displayName || currentUser.email || (currentUser.isAnonymous ? 'Guest' : 'Registered User');
            currentFullName = profile.full_name || '';
            currentUserProfileUrl = profile.user_url || '';
            currentUserLinkName = profile.link_name || profile.linkName || '';

            return profile;
        } catch (error) {
            console.error('User profile fetch error:', error);
            currentAvatarUrl = '';
            currentUsername = currentUser.displayName || currentUser.email || (currentUser.isAnonymous ? 'Guest' : 'Registered User');
            currentFullName = '';
            currentUserProfileUrl = '';
            currentUserLinkName = '';
            return null;
        }
    }

    async function loadCurrentUserAvatar() {
        return await loadCurrentUserProfile();
    }

    async function saveUserProfile(user, username, senderType, avatarUrl = null, fullName = null) {
        const finalAvatar = avatarUrl !== null ? avatarUrl : (currentAvatarUrl || '');
        const finalUsername = username || currentUsername || user.displayName || user.email || (user.isAnonymous ? 'Guest' : 'Registered User');
        const finalFullName = fullName !== null ? fullName : (currentFullName || '');

        await setDoc(doc(db, 'users', user.uid), {
            uid: user.uid,
            username: finalUsername,
            sender_name: finalUsername,
            full_name: finalFullName,
            sender_type: senderType,
            email: user.email || '',
            avatar_url: finalAvatar,
            user_url: currentUserProfileUrl || '',
            link_name: currentUserLinkName || '',
            last_seen: serverTimestamp(),
            created_at: serverTimestamp(),
            updated_at: serverTimestamp()
        }, { merge: true });

        currentAvatarUrl = finalAvatar;
        currentUsername = finalUsername;
        currentFullName = finalFullName;
    }


    async function loadCurrentPrivateAccess() {
        hasPrivateRoomAccess = false;
        currentPurchasedPlanLabel = '';

        if (!currentUser || currentUser.isAnonymous) return;

        try {
            const userSnap = await getDoc(doc(db, 'users', currentUser.uid));
            if (!userSnap.exists()) return;

            const data = userSnap.data() || {};
            hasPrivateRoomAccess = Boolean(
                data.private_access_active ||
                data.has_private_access ||
                data.private_access ||
                data.purchased_private_plan
            );
            currentPurchasedPlanLabel = data.private_plan_label || data.private_plan_name || data.purchased_plan_label || data.purchased_plan || '';

            if (hasPrivateRoomAccess && paymentPlansModal) {
                paymentPlansModal.hide();
            }
        } catch (error) {
            console.error('Private access fetch error:', error);
            hasPrivateRoomAccess = false;
            currentPurchasedPlanLabel = '';
        }
    }

    function getSelectedRoomData() {
        if (activeMode === 'text' && selectedTextRoomId) {
            return textRoomsCache.find(room => room.room_id === selectedTextRoomId) || null;
        }
        if (activeMode === 'voice' && selectedVoiceRoomId) {
            return voiceRoomsCache.find(room => room.room_id === selectedVoiceRoomId) || null;
        }
        return null;
    }

    function roomRequiresPayment(roomData) {
        return (roomData?.room_access || 'public') === 'private';
    }

    function canCurrentUserUsePrivateRoom() {
        return !!currentUser && !currentUser.isAnonymous && hasPrivateRoomAccess;
    }


    function updatePrivateAccessOverlay() {
        if (!privateAccessOverlay) return;

        const activeRoom = getSelectedRoomData();
        const isPrivateRoom = roomRequiresPayment(activeRoom);
        const hasAccess = canCurrentUserUsePrivateRoom();

        if (isPrivateRoom && !hasAccess) {
            privateAccessOverlay.classList.remove('d-none');
            chatMessages.classList.add('private-thread-blurred');

            if (!currentUser || currentUser.isAnonymous) {
                if (privateAccessMessage) {
                    privateAccessMessage.textContent = 'This is a private chatroom. Please login or register first, then purchase a plan to access it.';
                }
                if (privateAccessPayBtn) privateAccessPayBtn.classList.add('d-none');
                if (privateAccessLoginBtn) privateAccessLoginBtn.classList.remove('d-none');
            } else {
                if (privateAccessMessage) {
                    privateAccessMessage.textContent = 'Purchase a plan to access this private chatroom.';
                }
                if (privateAccessPayBtn) privateAccessPayBtn.classList.remove('d-none');
                if (privateAccessLoginBtn) privateAccessLoginBtn.classList.add('d-none');
            }
        } else {
            privateAccessOverlay.classList.add('d-none');
            chatMessages.classList.remove('private-thread-blurred');
        }
    }


    function updateSendButtonState() {
        if (!sendBtn || !messageInput) return;

        const hasMessageText = messageInput.value.trim().length > 0;
        const hasAttachment = activeMode === 'text' && !!selectedTextAttachmentFile;
        const hasVoiceAttachment = activeMode === 'voice' && !!selectedTextAttachmentFile;

        const activeRoom = getSelectedRoomData();
        const isPrivateRoom = roomRequiresPayment(activeRoom);
        const hasPaidAccess = canCurrentUserUsePrivateRoom();

        const canSendInText = activeMode === 'text' && !!currentUser && !!selectedTextRoomId && (!isPrivateRoom || hasPaidAccess);
        const canSendInVoice = activeMode === 'voice' && !!currentUser && !!selectedVoiceRoomId && (!isPrivateRoom || hasPaidAccess);

        const hasSomethingToSend = hasMessageText || hasAttachment || hasVoiceAttachment;
        const canSend = (canSendInText || canSendInVoice) && hasSomethingToSend;

        sendBtn.disabled = !canSend;
        sendBtn.classList.toggle('d-none', !hasSomethingToSend);
    }

    function updateActiveComposerAccess() {
        const activeRoom = getSelectedRoomData();
        const isPrivateRoom = roomRequiresPayment(activeRoom);
        const hasPaidAccess = canCurrentUserUsePrivateRoom();

        if (activeMode === 'text') {
            const canUseTextRoom = !!currentUser && !!selectedTextRoomId && (!isPrivateRoom || hasPaidAccess);
            setTextComposerState(canUseTextRoom);
            messageInput.placeholder = isPrivateRoom && !hasPaidAccess
                ? 'Private room. Complete payment to send messages...'
                : defaultMessagePlaceholder;

            const canRecordTextVoice = canUseTextRoom;
            if (textRecordToggleBtn) textRecordToggleBtn.disabled = !canRecordTextVoice;

            recordToggleBtn.disabled = true;
            if (voiceAttachmentBtn) voiceAttachmentBtn.disabled = true;
            if (sendVoiceAttachmentBtn) sendVoiceAttachmentBtn.disabled = true;

            if (isPrivateRoom && !hasPaidAccess && !isRecording && !recordedBlob) {
                recordingStatus.textContent = 'Private room. Complete payment to record';
            } else if (!isRecording && !recordedBlob) {
                recordingStatus.textContent = 'Tap mic to record voice message';
            }
        } else if (activeMode === 'voice') {
            const canUseVoiceRoomText = !!currentUser && !!selectedVoiceRoomId && (!isPrivateRoom || hasPaidAccess);
            setTextComposerState(canUseVoiceRoomText);
            messageInput.placeholder = isPrivateRoom && !hasPaidAccess
                ? 'Private room. Complete payment to send messages...'
                : 'Type your message...';

            if (textRecordToggleBtn) textRecordToggleBtn.disabled = true;
            recordToggleBtn.disabled = true;
            if (voiceAttachmentBtn) voiceAttachmentBtn.disabled = true;
            if (sendVoiceAttachmentBtn) sendVoiceAttachmentBtn.disabled = true;
            recordingStatus.textContent = 'Audio call is available from the header';
        } else {
            setTextComposerState(false);
            messageInput.placeholder = defaultMessagePlaceholder;
            if (textRecordToggleBtn) textRecordToggleBtn.disabled = true;
            recordToggleBtn.disabled = true;
            if (voiceAttachmentBtn) voiceAttachmentBtn.disabled = true;
            if (sendVoiceAttachmentBtn) sendVoiceAttachmentBtn.disabled = true;
        }

        updateSendButtonState();
        updatePrivateAccessOverlay();
    }

    function initializeStripeCardElement() {
        if (!stripe || !paymentCardElementWrap || stripeCardElement) return;
        const elements = stripe.elements();
        stripeCardElement = elements.create('card', {
            hidePostalCode: true
        });
        stripeCardElement.mount('#paymentCardElement');
    }


    function formatPaymentAmount(amount) {
        const value = Number(amount || 0);
        if (!Number.isFinite(value)) return '$0';
        return `$${Number.isInteger(value) ? value.toFixed(0) : value.toFixed(2)}`;
    }

    function getPaymentPlanLabel(plan) {
        const amount = Number(plan.amount ?? plan.plan_amount ?? 0);
        const savedLabel = (plan.plan_label || plan.label || '').toString().trim();
        return savedLabel || `${formatPaymentAmount(amount)} Plan`;
    }

    function getSortedActivePaymentPlans(plans) {
        return (plans || [])
            .filter(plan => plan && plan.is_active !== false && Number(plan.amount ?? plan.plan_amount ?? 0) > 0)
            .sort((a, b) => {
                const sortA = Number(a.sort_order ?? 9999);
                const sortB = Number(b.sort_order ?? 9999);
                if (sortA !== sortB) return sortA - sortB;
                return Number(a.amount ?? a.plan_amount ?? 0) - Number(b.amount ?? b.plan_amount ?? 0);
            });
    }

    function renderPaymentPlans(plans) {
        if (!dynamicPaymentPlansList) return;

        const activePlans = getSortedActivePaymentPlans(plans);
        paymentPlanBtns = [];

        if (paymentPlansLoading) {
            paymentPlansLoading.classList.add('d-none');
        }

        if (!activePlans.length) {
            dynamicPaymentPlansList.innerHTML = `
                <div class="col-12">
                    <div class="payment-empty-state text-center py-3">
                        No active payment plans are available right now.
                    </div>
                </div>
            `;
            selectedPlanAmount = 0;
            selectedPlanLabel = '';
            selectedPlanId = '';
            if (confirmPaymentBtn) confirmPaymentBtn.disabled = true;
            if (selectedPlanInfo) selectedPlanInfo.textContent = 'No active payment plan is available. Please contact the admin.';
            return;
        }

        dynamicPaymentPlansList.innerHTML = activePlans.map(plan => {
            const amount = Number(plan.amount ?? plan.plan_amount ?? 0);
            const label = getPaymentPlanLabel(plan);
            const planId = plan.id || '';
            return `
                <div class="col-6">
                    <button type="button" class="btn btn-outline-primary w-100 payment-plan-btn" data-plan-id="${escapeHtml(planId)}" data-plan-amount="${escapeHtml(amount)}" data-plan-label="${escapeHtml(label)}">
                        <div class="fw-bold">${escapeHtml(formatPaymentAmount(amount))}</div>
                        <small>${escapeHtml(label)}</small>
                    </button>
                </div>
            `;
        }).join('');

        paymentPlanBtns = Array.from(dynamicPaymentPlansList.querySelectorAll('.payment-plan-btn'));
        paymentPlanBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                selectPaymentPlan(btn.getAttribute('data-plan-amount'), btn.getAttribute('data-plan-label'), btn.getAttribute('data-plan-id'));
            });
        });

        const selectedStillAvailable = selectedPlanId
            ? activePlans.some(plan => (plan.id || '') === selectedPlanId)
            : activePlans.some(plan => Number(plan.amount ?? plan.plan_amount ?? 0) === selectedPlanAmount && getPaymentPlanLabel(plan) === selectedPlanLabel);

        if (selectedPlanAmount && selectedStillAvailable) {
            selectPaymentPlan(selectedPlanAmount, selectedPlanLabel, selectedPlanId);
        } else if (!selectedPlanAmount && selectedPlanInfo) {
            selectedPlanInfo.textContent = hasPrivateRoomAccess && currentPurchasedPlanLabel
                ? `You already have ${currentPurchasedPlanLabel}. You can select another plan if needed.`
                : 'Select a plan to continue.';
        }
    }

    function listenPaymentPlans() {
        if (!dynamicPaymentPlansList) return;

        onSnapshot(collection(db, 'payment_plans'), (snapshot) => {
            paymentPlansCache = snapshot.docs.map(docSnap => ({ id: docSnap.id, ...docSnap.data() }));
            renderPaymentPlans(paymentPlansCache);
        }, (error) => {
            console.error('Failed to load payment plans:', error);
            if (paymentPlansLoading) paymentPlansLoading.classList.add('d-none');
            dynamicPaymentPlansList.innerHTML = `
                <div class="col-12">
                    <div class="payment-empty-state text-center py-3 text-danger">
                        Failed to load payment plans. Please try again later.
                    </div>
                </div>
            `;
            if (selectedPlanInfo) selectedPlanInfo.textContent = 'Payment plans could not be loaded.';
            if (confirmPaymentBtn) confirmPaymentBtn.disabled = true;
        });
    }

    function updateCurrentPurchasedPlanBox() {
        if (!currentPurchasedPlanBox) return;

        if (hasPrivateRoomAccess && currentPurchasedPlanLabel) {
            currentPurchasedPlanBox.classList.remove('d-none');
            currentPurchasedPlanBox.innerHTML = `
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div>
                        <div class="current-plan-title"><i class="fas fa-check-circle me-1"></i>Current Purchased Plan</div>
                        <div class="current-plan-label">${escapeHtml(currentPurchasedPlanLabel)}</div>
                    </div>
                    <span class="current-plan-status">Active</span>
                </div>
            `;
        } else if (hasPrivateRoomAccess) {
            currentPurchasedPlanBox.classList.remove('d-none');
            currentPurchasedPlanBox.innerHTML = `
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <div>
                        <div class="current-plan-title"><i class="fas fa-check-circle me-1"></i>Current Purchased Plan</div>
                        <div class="current-plan-label">Private Access</div>
                    </div>
                    <span class="current-plan-status">Active</span>
                </div>
            `;
        } else {
            currentPurchasedPlanBox.classList.add('d-none');
            currentPurchasedPlanBox.innerHTML = '';
        }
    }

    function resetPaymentModalState() {
        selectedPlanAmount = 0;
        selectedPlanLabel = '';
        selectedPlanId = '';
        clearPaymentAlert();
        updateCurrentPurchasedPlanBox();
        if (selectedPlanInfo) {
            selectedPlanInfo.textContent = hasPrivateRoomAccess && currentPurchasedPlanLabel
                ? `You already have ${currentPurchasedPlanLabel}. You can select another plan if needed.`
                : 'Select a plan to continue.';
        }
        if (paymentCardWrap) {
            paymentCardWrap.classList.add('d-none');
        }
        if (confirmPaymentBtn) {
            confirmPaymentBtn.disabled = true;
            confirmPaymentBtn.textContent = 'Confirm Payment';
        }
        paymentPlanBtns.forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        });
        if (stripeCardElement && typeof stripeCardElement.clear === 'function') {
            stripeCardElement.clear();
        }
    }

    function selectPaymentPlan(amount, label, planId = '') {
        selectedPlanAmount = Number(amount || 0);
        selectedPlanLabel = label || '';
        selectedPlanId = planId || '';
        paymentPlanBtns.forEach(btn => {
            const btnPlanId = btn.getAttribute('data-plan-id') || '';
            const btnAmount = Number(btn.getAttribute('data-plan-amount'));
            const btnLabel = btn.getAttribute('data-plan-label') || '';
            const isSelected = selectedPlanId
                ? btnPlanId === selectedPlanId
                : (btnAmount === selectedPlanAmount && btnLabel === selectedPlanLabel);
            btn.classList.toggle('btn-primary', isSelected);
            btn.classList.toggle('btn-outline-primary', !isSelected);
        });
        if (selectedPlanInfo) {
            selectedPlanInfo.textContent = selectedPlanLabel
                ? `Selected plan: ${selectedPlanLabel}`
                : 'Select a plan to continue.';
        }
        if (paymentCardWrap) {
            paymentCardWrap.classList.remove('d-none');
        }
        initializeStripeCardElement();
        if (confirmPaymentBtn) {
            confirmPaymentBtn.disabled = !selectedPlanAmount;
        }
    }

    async function processPrivateRoomPayment() {
        if (!currentUser || currentUser.isAnonymous) {
            showPaymentAlert('Only registered users can purchase private room access.', 'warning');
            return;
        }
        if (!selectedPlanAmount || !selectedPlanLabel) {
            showPaymentAlert('Please select a plan first.', 'warning');
            return;
        }
        if (!stripe) {
            showPaymentAlert('Stripe failed to load. Please refresh and try again.');
            return;
        }

        initializeStripeCardElement();

        try {
            confirmPaymentBtn.disabled = true;
            confirmPaymentBtn.textContent = 'Processing...';
            clearPaymentAlert();

            const response = await fetch('frontend/stripe-create-payment-intent.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    amount: selectedPlanAmount,
                    email: currentUser.email || '',
                    uid: currentUser.uid
                })
            });

            const data = await response.json();
            if (!response.ok || !data.clientSecret) {
                throw new Error(data?.error || 'Unable to start payment.');
            }

            const result = await stripe.confirmCardPayment(data.clientSecret, {
                payment_method: {
                    card: stripeCardElement,
                    billing_details: {
                        name: currentUser.displayName || currentUser.email || 'User',
                        email: currentUser.email || ''
                    }
                }
            });

            if (result.error) {
                throw new Error(result.error.message || 'Payment failed.');
            }

            const paymentIntent = result.paymentIntent;
            if (!paymentIntent || paymentIntent.status !== 'succeeded') {
                throw new Error('Payment was not successful.');
            }

            await setDoc(doc(db, 'users', currentUser.uid), {
                private_access_active: true,
                has_private_access: true,
                private_access: true,
                purchased_private_plan: true,
                private_plan_label: selectedPlanLabel,
                purchased_plan_label: selectedPlanLabel,
                private_plan_amount: selectedPlanAmount,
                private_plan_id: selectedPlanId || '',
                private_payment_intent_id: paymentIntent.id || '',
                private_access_purchased_at: serverTimestamp(),
                last_seen: serverTimestamp()
            }, { merge: true });

            hasPrivateRoomAccess = true;
            currentPurchasedPlanLabel = selectedPlanLabel;
            updateCurrentPurchasedPlanBox();
            renderCurrentUser();
            updateActiveComposerAccess();
            updatePrivateAccessOverlay();
            showPaymentAlert('Payment successful. Private room access activated.', 'success');

            setTimeout(() => {
                if (paymentPlansModal) paymentPlansModal.hide();
            }, 800);
        } catch (error) {
            console.error('Private room payment error:', error);
            showPaymentAlert(error.message || 'Payment failed.');
        } finally {
            if (confirmPaymentBtn) {
                confirmPaymentBtn.disabled = !selectedPlanAmount;
                confirmPaymentBtn.textContent = 'Confirm Payment';
            }
        }
    }

    async function ensureParticipantInRoom(roomId, mode) {
        if (!currentUser || !roomId || !mode) return;
        const collectionName = mode === 'voice' ? 'voice_chatrooms' : 'chatrooms';

        await setDoc(doc(db, collectionName, roomId, 'participants', currentUser.uid), {
            uid: currentUser.uid,
            ...getCurrentMessageProfilePayload(),
            sender_type: getCurrentSenderType(),
            email: currentUser.email || '',
            avatar_url: getCurrentAvatarUrl(),
            joined_at: serverTimestamp(),
            last_seen: serverTimestamp(),
            is_typing: false,
            typing_updated_at: serverTimestamp()
        }, { merge: true });
    }

    function roomLogoHtml(room, mode) {
        if (room.room_logo) {
            return `<img src="${escapeHtml(room.room_logo)}" class="room-logo" alt="logo">`;
        }
        return `<div class="room-default-logo"><i class="fas ${mode === 'voice' ? 'fa-microphone' : 'fa-comments'}"></i></div>`;
    }

    function getFilteredTextRooms() {
        if (!currentTextSearch) return textRoomsCache;
        const q = currentTextSearch.toLowerCase();
        return textRoomsCache.filter(room =>
            (room.display_name || '').toLowerCase().includes(q) ||
            (room.room_id || '').toLowerCase().includes(q) ||
            (room.last_message || '').toLowerCase().includes(q)
        );
    }

    function getFilteredVoiceRooms() {
        if (!currentVoiceSearch) return voiceRoomsCache;
        const q = currentVoiceSearch.toLowerCase();
        return voiceRoomsCache.filter(room =>
            (room.display_name || '').toLowerCase().includes(q) ||
            (room.room_id || '').toLowerCase().includes(q) ||
            (room.last_voice_message_by || '').toLowerCase().includes(q)
        );
    }

    function addRoomToCacheIfMissing(cache, roomData) {
        if (!roomData || !roomData.room_id) return cache;
        const existingIndex = cache.findIndex(room => room.room_id === roomData.room_id);
        if (existingIndex >= 0) {
            const nextCache = [...cache];
            nextCache[existingIndex] = { ...nextCache[existingIndex], ...roomData };
            return nextCache;
        }
        return [roomData, ...cache];
    }

    async function resolveRoomByUrlParam(collectionName, cache) {
        if (!initialRoomIdFromUrl) return null;

        const cachedRoom = cache.find(room => room.room_id === initialRoomIdFromUrl);
        if (cachedRoom) return cachedRoom;

        try {
            const roomSnap = await getDoc(doc(db, collectionName, initialRoomIdFromUrl));
            if (!roomSnap.exists()) return null;

            const data = roomSnap.data() || {};
            if (data.is_active === false) return null;

            return {
                ...data,
                room_id: data.room_id || roomSnap.id
            };
        } catch (error) {
            console.error(`URL room lookup failed for ${collectionName}:`, error);
            return null;
        }
    }

    async function openInitialRoomFromUrl() {
        if (initialUrlRoomHandled || initialUrlRoomResolving || !initialRoomIdFromUrl) return;

        initialUrlRoomResolving = true;

        try {
            const preferVoice = initialRoomTypeFromUrl === 'voice' || initialRoomTypeFromUrl === 'voice_chatroom';
            const preferText = initialRoomTypeFromUrl === 'text' || initialRoomTypeFromUrl === 'chatroom';

            if (!preferVoice) {
                const textRoom = await resolveRoomByUrlParam('chatrooms', textRoomsCache);
                if (textRoom) {
                    textRoomsCache = addRoomToCacheIfMissing(textRoomsCache, textRoom);
                    renderTextRooms(getFilteredTextRooms());
                    initialUrlRoomHandled = true;
                    closeMobileDrawers();
                    await loadSelectedTextRoom(textRoom.room_id, 'replace');
                    scrollMobileThreadToBottom(450);
                    return;
                }
            }

            if (!preferText) {
                const voiceRoom = await resolveRoomByUrlParam('voice_chatrooms', voiceRoomsCache);
                if (voiceRoom) {
                    voiceRoomsCache = addRoomToCacheIfMissing(voiceRoomsCache, voiceRoom);
                    renderVoiceRooms(getFilteredVoiceRooms());
                    initialUrlRoomHandled = true;
                    closeMobileDrawers();
                    await loadSelectedVoiceRoom(voiceRoom.room_id, 'replace');
                    scrollMobileThreadToBottom(450);
                    return;
                }
            }

            if (textRoomsLoaded && voiceRoomsLoaded) {
                initialUrlRoomHandled = true;
                if (!activeMode && textRoomsCache.length > 0) {
                    await loadSelectedTextRoom(textRoomsCache[0].room_id, 'replace');
                    scrollMobileThreadToBottom(450);
                }
            }
        } finally {
            initialUrlRoomResolving = false;
        }
    }

    function renderTextRooms(rooms) {
        if (!rooms.length) {
            roomList.innerHTML = `<div class="p-3 text-muted">No active chatrooms found.</div>`;
            return;
        }

        let html = '';
        rooms.forEach(room => {
            const isActive = activeMode === 'text' && selectedTextRoomId === room.room_id;

            html += `
                <button type="button"
                        class="list-group-item list-group-item-action room-item ${isActive ? 'active-room' : ''}"
                        data-room-id="${escapeHtml(room.room_id)}">
                    <div class="room-row-wrap">
                        ${roomLogoHtml(room, 'text')}
                        <div class="text-start me-2 w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="room-name">${escapeHtml(room.display_name || room.room_id)}</div>
                                ${roomAccessBadgeHtml(room.room_access)}
                            </div>
                            <div class="room-id">${escapeHtml(room.room_id)}</div>
                            <div class="room-last-message">${escapeHtml(room.last_message || 'No messages yet')}</div>
                        </div>
                        <small class="text-muted">${shortTime(room.last_message_at)}</small>
                    </div>
                </button>
            `;
        });

        roomList.innerHTML = html;
        document.querySelectorAll('.room-item').forEach(item => {
            item.addEventListener('click', () => loadSelectedTextRoom(item.getAttribute('data-room-id')));
        });
    }

    function renderVoiceRooms(rooms) {
        if (!rooms.length) {
            voiceRoomList.innerHTML = `<div class="text-muted">No voice chatrooms found.</div>`;
            return;
        }

        let html = '';
        rooms.forEach(room => {
            const isActive = activeMode === 'voice' && selectedVoiceRoomId === room.room_id;

            html += `
                <div class="voice-room-card ${isActive ? 'active' : ''}" data-voice-room-id="${escapeHtml(room.room_id)}">
                    <div class="voice-card-simple">
                        ${roomLogoHtml(room, 'voice')}
                        <div class="voice-card-simple-info">
                            <div class="voice-card-simple-name">${escapeHtml(room.display_name || room.room_id)}</div>
                            ${roomAccessBadgeHtml(room.room_access)}
                        </div>
                    </div>
                </div>
            `;
        });

        voiceRoomList.innerHTML = html;
        document.querySelectorAll('[data-voice-room-id]').forEach(card => {
            card.addEventListener('click', () => loadSelectedVoiceRoom(card.getAttribute('data-voice-room-id')));
        });
    }

    function subscribeTypingIndicator(roomId) {
        if (unsubscribeTyping) {
            unsubscribeTyping();
            unsubscribeTyping = null;
        }

        typingIndicator.textContent = 'Someone is typing...';
        typingIndicator.classList.add('d-none');

        unsubscribeTyping = onSnapshot(collection(db, 'chatrooms', roomId, 'participants'), (snapshot) => {
            const typers = [];
            snapshot.forEach(docSnap => {
                const data = docSnap.data();
                if (currentUser && data.uid !== currentUser.uid && data.is_typing === true) {
                    typers.push(data.username || data.sender_name || data.full_name || 'User');
                }
            });

            if (typers.length > 0) {
                typingIndicator.textContent = `${typers[0]} is typing...`;
                typingIndicator.classList.remove('d-none');
            } else {
                typingIndicator.classList.add('d-none');
            }
        });
    }

    function switchToTextMode(roomData) {
        activeMode = 'text';
        document.body.classList.remove('voice-text-only-mode');
        selectedRoomTitle.textContent = roomData.display_name || roomData.room_id;
        selectedRoomMeta.textContent = `Text Room ID: ${roomData.room_id}`;
        voiceControlsWrap.classList.add('d-none');
        textComposerWrap.classList.remove('d-none');
        typingIndicator.textContent = 'Someone is typing...';
        typingIndicator.classList.add('d-none');
        updateActiveComposerAccess();
        updateAuthEntryVisibility();
        renderTextRooms(getFilteredTextRooms());
        renderVoiceRooms(getFilteredVoiceRooms());
        updateAudioCallSharedState();
    }

    function switchToVoiceMode(roomData) {
        activeMode = 'voice';
        document.body.classList.add('voice-text-only-mode');
        selectedRoomTitle.textContent = roomData.display_name || roomData.room_id;
        selectedRoomMeta.textContent = `Voice Room ID: ${roomData.room_id}`;
        textComposerWrap.classList.remove('d-none');
        voiceControlsWrap.classList.add('d-none');
        typingIndicator.textContent = 'Someone is typing...';
        typingIndicator.classList.add('d-none');
        resetVoiceRecorderUI();
        updateActiveComposerAccess();
        updateAuthEntryVisibility();
        renderTextRooms(getFilteredTextRooms());
        renderVoiceRooms(getFilteredVoiceRooms());
        updateAudioCallSharedState();
    }

    function clearMessageState() {
        latestTextDocs = [];
        latestVoiceDocs = [];
        olderTextDocs = [];
        olderVoiceDocs = [];
        oldestTextCursor = null;
        oldestVoiceCursor = null;
        hasMoreOldText = true;
        hasMoreOldVoice = true;
        loadingOlder = false;
        typingIndicator.textContent = 'Someone is typing...';
        typingIndicator.classList.add('d-none');
        chatMessages.innerHTML = `<div class="text-center text-muted mt-5">Loading messages...</div>`;
    }

    function combineTextDocs() {
        const map = new Map();
        [...olderTextDocs, ...latestTextDocs].forEach(docSnap => map.set(docSnap.id, docSnap));
        return Array.from(map.values()).sort((a, b) => {
            const at = a.data().created_at?.toDate ? a.data().created_at.toDate().getTime() : 0;
            const bt = b.data().created_at?.toDate ? b.data().created_at.toDate().getTime() : 0;
            return at - bt;
        });
    }

    function combineVoiceDocs() {
        const map = new Map();
        [...olderVoiceDocs, ...latestVoiceDocs].forEach(docSnap => map.set(docSnap.id, docSnap));
        return Array.from(map.values()).sort((a, b) => {
            const at = a.data().created_at?.toDate ? a.data().created_at.toDate().getTime() : 0;
            const bt = b.data().created_at?.toDate ? b.data().created_at.toDate().getTime() : 0;
            return at - bt;
        });
    }

    function renderCombinedTextMessages(roomId) {
        if (!currentUser) {
            chatMessages.innerHTML = `<div class="text-center text-muted mt-5">Join the chat to view and send messages.</div>`;
            updateAuthEntryVisibility();
            return;
        }

        const docs = combineTextDocs();
        if (!docs.length) {
            chatMessages.innerHTML = `<div class="text-center text-muted mt-5">No messages in this chatroom yet.</div>`;
            updateAuthEntryVisibility();
            return;
        }

        let html = '';
        docs.forEach((docSnap) => {
            const msg = docSnap.data();
            const isMine = currentUser && msg.uid === currentUser.uid;
            const isTextVoice = msg.message_type === 'voice' && !!msg.audio_url;

            if (isTextVoice) {
                html += `
                    <div class="message-wrap ${isMine ? 'text-end voice-own' : 'text-start'}">
                        <div class="message-row">
                            ${!isMine ? renderAvatar(msg.avatar_url || '', getMessageDisplayName(msg)) : ''}
                            <div class="voice-note-card">
                                <div class="voice-badge">Voice Message</div>
                                ${messageUserMetaHtml(msg)}
                                <div class="voice-player-shell">
                                    <button type="button" class="voice-fake-play-btn" aria-hidden="true"><i class="fas fa-play"></i></button>
                                    <div class="voice-waveform-visual" aria-hidden="true">
                                        <span></span><span></span><span></span><span></span><span></span>
                                        <span></span><span></span><span></span><span></span><span></span>
                                        <span></span><span></span><span></span><span></span><span></span>
                                    </div>
                                    <audio controls preload="metadata" class="voice-note-player">
                                        <source src="${escapeHtml(msg.audio_url || '')}" type="${escapeHtml(msg.mime_type || 'audio/webm')}">
                                    </audio>
                                </div>
                                <div class="message-footer">
                                    <span class="message-time">
                                        ${compactDateTime(msg.created_at)} ${msg.duration ? '• ' + escapeHtml(String(msg.duration)) + 's' : ''}
                                    </span>
                                </div>
                            </div>
                            ${isMine ? renderAvatar(msg.avatar_url || '', getMessageDisplayName(msg)) : ''}
                        </div>
                    </div>
                `;
                return;
            }

            html += `
                <div class="message-wrap ${isMine ? 'text-end' : 'text-start'}">
                    <div class="message-row">
                        ${!isMine ? renderAvatar(msg.avatar_url || '', getMessageDisplayName(msg)) : ''}
                        <div class="message-bubble ${isMine ? 'message-own' : 'message-other'}">
                            ${messageUserMetaHtml(msg)}
                            ${msg.message ? `<div class="message-text">${escapeHtml(msg.message || '')}</div>` : ''}
                            ${renderAttachmentHtml(msg)}
                            <div class="message-footer">
                                <span class="message-time">${compactDateTime(msg.created_at)}</span>
                            </div>
                        </div>
                        ${isMine ? renderAvatar(msg.avatar_url || '', getMessageDisplayName(msg)) : ''}
                    </div>
                </div>
            `;
        });

        chatMessages.innerHTML = html;
        refreshRenderedMessageProfiles();
        updateAuthEntryVisibility();
    }

    function renderCombinedVoiceMessages(roomId) {
        if (!currentUser) {
            chatMessages.innerHTML = `<div class="text-center text-muted mt-5">Join the chat to view and send messages.</div>`;
            updateAuthEntryVisibility();
            return;
        }

        const docs = combineVoiceDocs();
        if (!docs.length) {
            chatMessages.innerHTML = `<div class="text-center text-muted mt-5">No messages in this voice room yet.</div>`;
            updateAuthEntryVisibility();
            return;
        }

        let html = '';
        docs.forEach((docSnap) => {
            const msg = docSnap.data();
            const isMine = currentUser && msg.uid === currentUser.uid;
            const isOldVoice = msg.message_type === 'voice' && !!msg.audio_url;

            if (isOldVoice) {
                html += `
                    <div class="message-wrap ${isMine ? 'text-end voice-own' : 'text-start'}">
                        <div class="message-row">
                            ${!isMine ? renderAvatar(msg.avatar_url || '', getMessageDisplayName(msg)) : ''}
                            <div class="voice-note-card">
                                <div class="voice-badge">Old Voice Message</div>
                                ${messageUserMetaHtml(msg)}
                                <div class="voice-player-shell">
                                    <audio controls preload="metadata" class="voice-note-player">
                                        <source src="${escapeHtml(msg.audio_url || '')}" type="${escapeHtml(msg.mime_type || 'audio/webm')}">
                                    </audio>
                                </div>
                                <div class="message-footer">
                                    <span class="message-time">
                                        ${compactDateTime(msg.created_at)} ${msg.duration ? '• ' + escapeHtml(String(msg.duration)) + 's' : ''}
                                    </span>
                                </div>
                            </div>
                            ${isMine ? renderAvatar(msg.avatar_url || '', getMessageDisplayName(msg)) : ''}
                        </div>
                    </div>
                `;
                return;
            }

            html += `
                <div class="message-wrap ${isMine ? 'text-end' : 'text-start'}">
                    <div class="message-row">
                        ${!isMine ? renderAvatar(msg.avatar_url || '', getMessageDisplayName(msg)) : ''}
                        <div class="message-bubble ${isMine ? 'message-own' : 'message-other'}">
                            ${messageUserMetaHtml(msg)}
                            ${msg.message ? `<div class="message-text">${escapeHtml(msg.message || '')}</div>` : ''}
                            ${renderAttachmentHtml(msg)}
                            <div class="message-footer">
                                <span class="message-time">${compactDateTime(msg.created_at)}</span>
                            </div>
                        </div>
                        ${isMine ? renderAvatar(msg.avatar_url || '', getMessageDisplayName(msg)) : ''}
                    </div>
                </div>
            `;
        });

        chatMessages.innerHTML = html;
        refreshRenderedMessageProfiles();
        updateAuthEntryVisibility();
    }

    async function loadOlderTextMessages() {
        if (!selectedTextRoomId || loadingOlder || !hasMoreOldText || !oldestTextCursor || !currentUser) return;

        loadingOlder = true;
        loadOlderIndicator.classList.remove('d-none');
        const previousHeight = chatMessages.scrollHeight;

        try {
            const q = query(
                collection(db, 'chatrooms', selectedTextRoomId, 'messages'),
                orderBy('created_at', 'desc'),
                startAfter(oldestTextCursor),
                limit(PAGE_SIZE)
            );

            const snap = await getDocs(q);

            if (snap.empty) {
                hasMoreOldText = false;
            } else {
                olderTextDocs = [...snap.docs.reverse(), ...olderTextDocs];
                oldestTextCursor = snap.docs[snap.docs.length - 1];
                if (snap.docs.length < PAGE_SIZE) hasMoreOldText = false;
                renderCombinedTextMessages(selectedTextRoomId);

                const newHeight = chatMessages.scrollHeight;
                chatMessages.scrollTop = newHeight - previousHeight;
            }
        } catch (error) {
            console.error('Load older text messages error:', error);
        } finally {
            loadingOlder = false;
            loadOlderIndicator.classList.add('d-none');
        }
    }

    async function loadOlderVoiceMessages() {
        if (!selectedVoiceRoomId || loadingOlder || !hasMoreOldVoice || !oldestVoiceCursor || !currentUser) return;

        loadingOlder = true;
        loadOlderIndicator.classList.remove('d-none');
        const previousHeight = chatMessages.scrollHeight;

        try {
            const q = query(
                collection(db, 'voice_chatrooms', selectedVoiceRoomId, 'messages'),
                orderBy('created_at', 'desc'),
                startAfter(oldestVoiceCursor),
                limit(PAGE_SIZE)
            );

            const snap = await getDocs(q);

            if (snap.empty) {
                hasMoreOldVoice = false;
            } else {
                olderVoiceDocs = [...snap.docs.reverse(), ...olderVoiceDocs];
                oldestVoiceCursor = snap.docs[snap.docs.length - 1];
                if (snap.docs.length < PAGE_SIZE) hasMoreOldVoice = false;
                renderCombinedVoiceMessages(selectedVoiceRoomId);

                const newHeight = chatMessages.scrollHeight;
                chatMessages.scrollTop = newHeight - previousHeight;
            }
        } catch (error) {
            console.error('Load older voice messages error:', error);
        } finally {
            loadingOlder = false;
            loadOlderIndicator.classList.add('d-none');
        }
    }

    chatMessages.addEventListener('click', (event) => {
        const meta = event.target.closest('.message-user-meta');
        if (!meta || !chatMessages.contains(meta)) return;

        openMessageUserPopup(getMessageProfileFromMeta(meta));
    });

    chatMessages.addEventListener('keydown', (event) => {
        if (event.key !== 'Enter' && event.key !== ' ') return;

        const meta = event.target.closest('.message-user-meta');
        if (!meta || !chatMessages.contains(meta)) return;

        event.preventDefault();
        openMessageUserPopup(getMessageProfileFromMeta(meta));
    });

    chatMessages.addEventListener('scroll', async () => {
        if (chatMessages.scrollTop > 60) return;
        if (activeMode === 'text') await loadOlderTextMessages();
        else if (activeMode === 'voice') await loadOlderVoiceMessages();
    });

    async function loadSelectedTextRoom(roomId, urlMode = 'auto') {
        updateMobileRoomUrl(roomId, urlMode);
        if (currentLoadedTextRoomId === roomId && activeMode === 'text') return;

        currentLoadedTextRoomId = roomId;
        currentLoadedVoiceRoomId = null;
        selectedTextRoomId = roomId;
        selectedVoiceRoomId = null;
        clearMessageState();

        const roomData = textRoomsCache.find(r => r.room_id === roomId) || { room_id: roomId, display_name: roomId };
        switchToTextMode(roomData);
        updateActiveComposerAccess();

        if (currentUser) {
            try {
                await ensureParticipantInRoom(roomId, 'text');
            } catch (e) {
                console.error('Text participant add error:', e);
            }
        }

        subscribeTypingIndicator(roomId);

        if (unsubscribeLatestVoice) {
            unsubscribeLatestVoice();
            unsubscribeLatestVoice = null;
        }
        if (unsubscribeLatestText) {
            unsubscribeLatestText();
            unsubscribeLatestText = null;
        }

        const latestQuery = query(
            collection(db, 'chatrooms', roomId, 'messages'),
            orderBy('created_at', 'desc'),
            limit(PAGE_SIZE)
        );

        unsubscribeLatestText = onSnapshot(latestQuery, (snapshot) => {
            latestTextDocs = snapshot.docs.reverse();
            oldestTextCursor = snapshot.docs.length ? snapshot.docs[snapshot.docs.length - 1] : null;
            hasMoreOldText = snapshot.docs.length === PAGE_SIZE;
            renderCombinedTextMessages(roomId);

            if (!olderTextDocs.length && currentUser) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }, (error) => {
            console.error('Latest text messages load error:', error);
            chatMessages.innerHTML = `<div class="text-center text-danger mt-5">Failed to load messages.</div>`;
            updateAuthEntryVisibility();
        });
    }

    async function loadSelectedVoiceRoom(roomId, urlMode = 'auto') {
        updateMobileRoomUrl(roomId, urlMode);
        if (currentLoadedVoiceRoomId === roomId && activeMode === 'voice') return;

        currentLoadedVoiceRoomId = roomId;
        currentLoadedTextRoomId = null;
        selectedVoiceRoomId = roomId;
        selectedTextRoomId = null;
        clearMessageState();

        const roomData = voiceRoomsCache.find(r => r.room_id === roomId) || { room_id: roomId, display_name: roomId };
        switchToVoiceMode(roomData);
        updateActiveComposerAccess();

        if (currentUser) {
            try {
                await ensureParticipantInRoom(roomId, 'voice');
            } catch (e) {
                console.error('Voice participant add error:', e);
            }
        }

        if (unsubscribeTyping) {
            unsubscribeTyping();
            unsubscribeTyping = null;
        }
        if (unsubscribeLatestText) {
            unsubscribeLatestText();
            unsubscribeLatestText = null;
        }
        if (unsubscribeLatestVoice) {
            unsubscribeLatestVoice();
            unsubscribeLatestVoice = null;
        }

        const latestQuery = query(
            collection(db, 'voice_chatrooms', roomId, 'messages'),
            orderBy('created_at', 'desc'),
            limit(PAGE_SIZE)
        );

        unsubscribeLatestVoice = onSnapshot(latestQuery, (snapshot) => {
            latestVoiceDocs = snapshot.docs.reverse();
            oldestVoiceCursor = snapshot.docs.length ? snapshot.docs[snapshot.docs.length - 1] : null;
            hasMoreOldVoice = snapshot.docs.length === PAGE_SIZE;
            renderCombinedVoiceMessages(roomId);

            if (!olderVoiceDocs.length && currentUser) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }, (error) => {
            console.error('Latest voice messages load error:', error);
            chatMessages.innerHTML = `<div class="text-center text-danger mt-5">Failed to load voice messages.</div>`;
            updateAuthEntryVisibility();
        });
    }

    async function joinAsGuest() {
        try {
            clearAuthAlert();
            const result = await signInAnonymously(auth);
            const user = result.user;

            let guestName = user.displayName;
            if (!guestName) {
                guestName = randomGuestName();
                await updateProfile(user, { displayName: guestName });
            }

            currentAvatarUrl = '';
            await saveUserProfile(user, guestName, 'guest', '');

            if (activeMode === 'text' && selectedTextRoomId) {
                await ensureParticipantInRoom(selectedTextRoomId, 'text');
                renderCombinedTextMessages(selectedTextRoomId);
            } else if (activeMode === 'voice' && selectedVoiceRoomId) {
                await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');
                renderCombinedVoiceMessages(selectedVoiceRoomId);
            }
        } catch (error) {
            console.error('Guest login error:', error);
            alert(error.message || 'Failed to join as guest.');
        }
    }

    async function loginUser() {
        const email = authEmail.value.trim();
        const password = authPassword.value.trim();

        if (!email || !password) {
            showAuthAlert('Email and password are required.');
            return;
        }

        try {
            authActionBtn.disabled = true;
            clearAuthAlert();

            const result = await signInWithEmailAndPassword(auth, email, password);
            const user = result.user;
            const existingProfile = await getUserProfileDoc(user.uid);

            if (isUserBannedFromProfile(existingProfile)) {
                await handleBannedUser(user);
                return;
            }

            await loadCurrentUserAvatar();
            const preferredUsername = existingProfile?.username || existingProfile?.sender_name || user.displayName || user.email || 'Registered User';
            await saveUserProfile(user, preferredUsername, 'registered', currentAvatarUrl || existingProfile?.avatar_url || '', existingProfile?.full_name || '');

            if (activeMode === 'text' && selectedTextRoomId) {
                await ensureParticipantInRoom(selectedTextRoomId, 'text');
            } else if (activeMode === 'voice' && selectedVoiceRoomId) {
                await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');
            }

            authModal.hide();
            clearAuthForm();

            if (activeMode === 'text' && selectedTextRoomId) {
                renderCombinedTextMessages(selectedTextRoomId);
            } else if (activeMode === 'voice' && selectedVoiceRoomId) {
                renderCombinedVoiceMessages(selectedVoiceRoomId);
            }
        } catch (error) {
            console.error('Login error:', error);
            showAuthAlert(getFriendlyLoginErrorMessage(error));
        } finally {
            authActionBtn.disabled = false;
        }
    }

    async function registerUser() {
        const fullName = authName.value.trim();
        const username = authUsername ? authUsername.value.trim() : '';
        const name = username;
        const email = authEmail.value.trim();
        const password = authPassword.value.trim();
        const avatarFile = authAvatarFile.files[0] || null;

        if (!fullName || !username || !email || !password) {
            showAuthAlert('Full name, username, email and password are required.');
            return;
        }

        try {
            authActionBtn.disabled = true;
            clearAuthAlert();

            let avatarUrl = '';
            if (avatarFile) {
                avatarUrl = await uploadImageToCloudinary(avatarFile, 'avatars');
            }

            const result = await createUserWithEmailAndPassword(auth, email, password);
            const user = result.user;
            const loginToken = generateLoginToken();

            await updateProfile(user, { displayName: name });
            currentUser = user;
            currentAvatarUrl = avatarUrl || '';
            currentUsername = username;
            currentFullName = fullName;

            await saveUserProfile(user, username, 'registered', currentAvatarUrl, fullName);

            await setDoc(doc(db, 'users', user.uid), {
                uid: user.uid,
                email: email,
                full_name: fullName,
                username: username,
                sender_name: username,
                sender_type: 'registered',
                avatar_url: currentAvatarUrl || '',
                login_token: loginToken,
                last_seen: serverTimestamp()
            }, { merge: true });

            try {
                await sendQuickLoginLink(email, username);
            } catch (quickLoginError) {
                console.error('Quick login link error:', quickLoginError);
            }

            if (activeMode === 'text' && selectedTextRoomId) {
                await ensureParticipantInRoom(selectedTextRoomId, 'text');
            } else if (activeMode === 'voice' && selectedVoiceRoomId) {
                await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');
            }

            renderCurrentUser();
            updateAuthEntryVisibility();
            updateActiveComposerAccess();

            authModal.hide();
            clearAuthForm();

            if (activeMode === 'text' && selectedTextRoomId) {
                renderCombinedTextMessages(selectedTextRoomId);
            } else if (activeMode === 'voice' && selectedVoiceRoomId) {
                renderCombinedVoiceMessages(selectedVoiceRoomId);
            }
        } catch (error) {
            console.error('Register error:', error);
            showAuthAlert(error.message || 'Registration failed.');
        } finally {
            authActionBtn.disabled = false;
        }
    }

    async function saveProfileSettings() {
        if (!currentUser || currentUser.isAnonymous) {
            showProfileAlert('Guest users cannot update profile settings. Please register/login with email.', 'warning');
            return;
        }

        const newUsername = profileUsername ? profileUsername.value.trim() : '';
        const newFullName = profileName.value.trim();
        const newPassword = profilePassword.value.trim();
        const newAvatarFile = profileAvatarFile.files[0] || null;

        if (!newUsername || !newFullName) {
            showProfileAlert('Username and full name are required.', 'warning');
            return;
        }

        try {
            saveProfileBtn.disabled = true;
            clearProfileAlert();

            let updatedAvatarUrl = currentAvatarUrl;

            if (newAvatarFile) {
                updatedAvatarUrl = await uploadImageToCloudinary(newAvatarFile, 'avatars');
            }

            if (newUsername && newUsername !== (currentUser.displayName || '')) {
                await updateProfile(currentUser, { displayName: newUsername });
            }

            if (newPassword) {
                await updatePassword(currentUser, newPassword);
            }

            currentUsername = newUsername;
            currentFullName = newFullName;

            await saveUserProfile(
                currentUser,
                newUsername,
                'registered',
                updatedAvatarUrl,
                newFullName
            );

            renderCurrentUser();
            showProfileAlert('Profile updated successfully.', 'success');

            if (activeMode === 'text' && selectedTextRoomId) {
                await ensureParticipantInRoom(selectedTextRoomId, 'text');
            } else if (activeMode === 'voice' && selectedVoiceRoomId) {
                await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');
            }

            if (activeMode === 'text' && selectedTextRoomId) {
                renderCombinedTextMessages(selectedTextRoomId);
            } else if (activeMode === 'voice' && selectedVoiceRoomId) {
                renderCombinedVoiceMessages(selectedVoiceRoomId);
            }
        } catch (error) {
            console.error('Profile update error:', error);
            showProfileAlert(error.message || 'Failed to update profile.');
        } finally {
            saveProfileBtn.disabled = false;
        }
    }

    async function logoutUser() {
        try {
            await signOut(auth);
            currentAvatarUrl = '';
            currentUsername = '';
            currentFullName = '';
            currentUserProfileUrl = '';
            currentUserLinkName = '';
        } catch (error) {
            console.error('Logout error:', error);
            alert('Failed to logout.');
        }
    }

    async function sendTextMessage() {
        const text = messageInput.value.trim();
        const attachmentFile = selectedTextAttachmentFile;

        if (activeMode === 'text' && !selectedTextRoomId) {
            alert('Please select a text chatroom first.');
            return;
        }

        if (activeMode === 'voice' && !selectedVoiceRoomId) {
            alert('Please select a voice chatroom first.');
            return;
        }

        if (!currentUser) {
            authModal.show();
            return;
        }

        if (!text && !attachmentFile) return;

        try {
            sendBtn.disabled = true;
            if (textAttachmentBtn) textAttachmentBtn.disabled = true;

            let attachmentData = null;
            if (attachmentFile) {
                attachmentData = await uploadAttachmentToCloudinary(attachmentFile, 'chatroom_uploads');
            }

            if (activeMode === 'voice') {
                await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');

                const roomRef = doc(db, 'voice_chatrooms', selectedVoiceRoomId);

                const messagePayload = {
                    uid: currentUser.uid,
                    ...getCurrentMessageProfilePayload(),
                    sender_type: getCurrentSenderType(),
                    avatar_url: getCurrentAvatarUrl(),
                    message: text,
                    message_type: attachmentData ? (text ? 'text_attachment' : 'attachment') : 'text',
                    created_at: serverTimestamp()
                };

                if (attachmentData) {
                    Object.assign(messagePayload, {
                        attachment_url: attachmentData.url,
                        attachment_public_id: attachmentData.public_id,
                        attachment_name: attachmentData.name,
                        attachment_type: attachmentData.mime_type,
                        attachment_resource_type: attachmentData.resource_type,
                        attachment_bytes: attachmentData.bytes,
                        attachment_format: attachmentData.format
                    });
                }

                await addDoc(collection(db, 'voice_chatrooms', selectedVoiceRoomId, 'messages'), messagePayload);

                const lastMessageText = text || (attachmentData ? `📎 ${attachmentData.name}` : '');

                await updateDoc(roomRef, {
                    last_message: lastMessageText,
                    last_message_by: getCurrentSenderName(),
                    last_message_at: serverTimestamp(),
                    voice_message_seq: increment(1)
                });
            } else {
                await ensureParticipantInRoom(selectedTextRoomId, 'text');

                const roomRef = doc(db, 'chatrooms', selectedTextRoomId);

                const messagePayload = {
                    uid: currentUser.uid,
                    ...getCurrentMessageProfilePayload(),
                    sender_type: getCurrentSenderType(),
                    avatar_url: getCurrentAvatarUrl(),
                    message: text,
                    message_type: attachmentData ? (text ? 'text_attachment' : 'attachment') : 'text',
                    created_at: serverTimestamp()
                };

                if (attachmentData) {
                    Object.assign(messagePayload, {
                        attachment_url: attachmentData.url,
                        attachment_public_id: attachmentData.public_id,
                        attachment_name: attachmentData.name,
                        attachment_type: attachmentData.mime_type,
                        attachment_resource_type: attachmentData.resource_type,
                        attachment_bytes: attachmentData.bytes,
                        attachment_format: attachmentData.format
                    });
                }

                await addDoc(collection(db, 'chatrooms', selectedTextRoomId, 'messages'), messagePayload);

                const lastMessageText = text || (attachmentData ? `📎 ${attachmentData.name}` : '');

                await updateDoc(roomRef, {
                    last_message: lastMessageText,
                    last_message_by: getCurrentSenderName(),
                    last_message_at: serverTimestamp(),
                    message_seq: increment(1)
                });

                await setDoc(doc(db, 'chatrooms', selectedTextRoomId, 'participants', currentUser.uid), {
                    is_typing: false,
                    typing_updated_at: serverTimestamp()
                }, { merge: true });
            }

            messageInput.value = '';
            clearSelectedTextAttachment();
            emojiPickerWrap.classList.add('d-none');
        } catch (error) {
            console.error('Send message error:', error);
            alert(error.message || 'Failed to send message.');
        } finally {
            updateActiveComposerAccess();
        }
    }

    function getSupportedMimeType() {
        const mimeTypes = [
            'audio/webm;codecs=opus',
            'audio/webm',
            'audio/ogg;codecs=opus',
            'audio/mp4'
        ];
        for (const type of mimeTypes) {
            if (window.MediaRecorder && MediaRecorder.isTypeSupported(type)) return type;
        }
        return '';
    }

    function getFileExtensionFromMime(mimeType) {
        if (!mimeType) return 'webm';
        if (mimeType.includes('webm')) return 'webm';
        if (mimeType.includes('ogg')) return 'ogg';
        if (mimeType.includes('mp4')) return 'mp4';
        return 'webm';
    }

    async function startRecording() {
        if (activeMode === 'text' && !selectedTextRoomId) {
            alert('Please select a text chatroom first.');
            return;
        }

        if (activeMode === 'voice' && !selectedVoiceRoomId) {
            alert('Please select a voice chatroom first.');
            return;
        }

        if (!currentUser) {
            authModal.show();
            return;
        }

        const selectedRoom = getSelectedRoomData();
        if (roomRequiresPayment(selectedRoom) && !canCurrentUserUsePrivateRoom()) {
            alert('Please complete payment to use this private chatroom.');
            return;
        }

        try {
            discardRecordingRequested = false;
            recordedChunks = [];
            recordedBlob = null;
            voicePreview.pause();
            voicePreview.src = '';
            voicePreview.classList.add('d-none');
            voiceWaveBars.classList.remove('d-none');

            mediaStream = await navigator.mediaDevices.getUserMedia({
                audio: {
                    echoCancellation: true,
                    noiseSuppression: true,
                    autoGainControl: true
                }
            });

            const mimeType = getSupportedMimeType();
            mediaRecorder = mimeType ? new MediaRecorder(mediaStream, { mimeType }) : new MediaRecorder(mediaStream);

            mediaRecorder.ondataavailable = (event) => {
                if (!discardRecordingRequested && event.data && event.data.size > 0) recordedChunks.push(event.data);
            };

            mediaRecorder.onstop = () => {
                if (discardRecordingRequested) {
                    recordedChunks = [];
                    recordedBlob = null;
                    discardRecordingRequested = false;
                    return;
                }

                const finalMime = mediaRecorder.mimeType || mimeType || 'audio/webm';
                recordedBlob = new Blob(recordedChunks, { type: finalMime });

                if (recordedBlob.size === 0) {
                    recordingStatus.textContent = 'Recording failed';
                    alert('Recording produced an empty file. Please try again.');
                    resetVoiceRecorderUI();
                    return;
                }

                const previewUrl = URL.createObjectURL(recordedBlob);
                voicePreview.src = previewUrl;
                voicePreview.classList.remove('d-none');
                voiceWaveBars.classList.add('d-none');

                recordingStatus.textContent = 'Ready to send';
                recordToggleIcon.className = 'fas fa-paper-plane';
                if (textRecordToggleIcon) textRecordToggleIcon.className = 'fas fa-paper-plane';

                recordToggleBtn.classList.remove('recording');
                recordToggleBtn.classList.add('ready-send');
                if (textRecordToggleBtn) {
                    textRecordToggleBtn.classList.remove('recording');
                    textRecordToggleBtn.classList.add('ready-send');
                }

                pauseRecordingBtn.disabled = true;
                if (textPauseRecordingBtn) textPauseRecordingBtn.disabled = true;
                discardVoiceBtn.disabled = false;
                if (textDiscardVoiceBtn) textDiscardVoiceBtn.disabled = false;

                isRecording = false;
                isPaused = false;
                updateTextInlineVoicePanel('ready');
            };

            mediaRecorder.start(1000);
            recordingStartedAt = Date.now();

            isRecording = true;
            isPaused = false;

            recordToggleIcon.className = 'fas fa-stop';
            if (textRecordToggleIcon) textRecordToggleIcon.className = 'fas fa-stop';

            recordToggleBtn.classList.add('recording');
            recordToggleBtn.classList.remove('ready-send');
            if (textRecordToggleBtn) {
                textRecordToggleBtn.classList.add('recording');
                textRecordToggleBtn.classList.remove('ready-send');
            }

            pauseRecordingBtn.disabled = activeMode !== 'voice';
            discardVoiceBtn.disabled = activeMode !== 'voice';
            if (textPauseRecordingBtn) textPauseRecordingBtn.disabled = activeMode !== 'text';
            if (textDiscardVoiceBtn) textDiscardVoiceBtn.disabled = activeMode !== 'text';

            recordingStatus.textContent = 'Recording...';
            pauseRecordingBtn.innerHTML = '<i class="fas fa-pause"></i>';
            if (textPauseRecordingBtn) textPauseRecordingBtn.innerHTML = '<i class="fas fa-pause"></i>';
            voiceWaveBars.classList.remove('d-none');
            updateTextInlineVoicePanel('recording');
        } catch (error) {
            console.error('Recording start error:', error);
            alert('Could not access microphone.');
            resetVoiceRecorderUI();
        }
    }

    function stopRecording() {
        if (!mediaRecorder) return;

        try {
            if (mediaRecorder.state === 'recording' || mediaRecorder.state === 'paused') {
                mediaRecorder.requestData();
                mediaRecorder.stop();
            }
        } catch (error) {
            console.error('Recording stop error:', error);
        }

        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
            mediaStream = null;
        }
    }

    function togglePauseRecording(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        if (!mediaRecorder) return;

        try {
            if (mediaRecorder.state === 'recording') {
                mediaRecorder.pause();
                isPaused = true;
                recordingStatus.textContent = 'Paused';
                pauseRecordingBtn.innerHTML = '<i class="fas fa-play"></i>';
                if (textPauseRecordingBtn) textPauseRecordingBtn.innerHTML = '<i class="fas fa-play"></i>';
                voiceWaveBars.classList.add('d-none');
                updateTextInlineVoicePanel('paused');
            } else if (mediaRecorder.state === 'paused') {
                mediaRecorder.resume();
                isPaused = false;
                recordingStatus.textContent = 'Recording...';
                pauseRecordingBtn.innerHTML = '<i class="fas fa-pause"></i>';
                if (textPauseRecordingBtn) textPauseRecordingBtn.innerHTML = '<i class="fas fa-pause"></i>';
                voiceWaveBars.classList.remove('d-none');
                updateTextInlineVoicePanel('recording');
            }
        } catch (error) {
            console.error('Pause/resume recording error:', error);
        }
    }

    function discardRecording(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }

        discardRecordingRequested = true;

        try {
            if (mediaRecorder && (mediaRecorder.state === 'recording' || mediaRecorder.state === 'paused')) {
                mediaRecorder.stop();
            }
        } catch (error) {
            console.error(error);
        }

        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
            mediaStream = null;
        }

        recordedChunks = [];
        recordedBlob = null;
        mediaRecorder = null;
        resetVoiceRecorderUI();
    }

    async function uploadVoiceToCloudinary(blob) {
        const extension = getFileExtensionFromMime(blob.type);
        const fileName = `voice-message-${Date.now()}.${extension}`;
        const file = new File([blob], fileName, { type: blob.type || 'audio/webm' });

        const formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);
        formData.append('folder', 'voice-messages');

        const response = await fetch(CLOUDINARY_VIDEO_UPLOAD_URL, {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data?.error?.message || 'Cloudinary upload failed');
        return data;
    }

    async function sendVoiceAttachmentMessage() {
        const attachmentFile = selectedVoiceAttachmentFile;

        if (!selectedVoiceRoomId) {
            alert('Please select a voice chatroom first.');
            return;
        }

        if (!currentUser) {
            authModal.show();
            return;
        }

        if (!attachmentFile) return;

        try {
            if (sendVoiceAttachmentBtn) sendVoiceAttachmentBtn.disabled = true;
            if (voiceAttachmentBtn) voiceAttachmentBtn.disabled = true;
            recordingStatus.textContent = 'Uploading attachment...';

            await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');

            const attachmentData = await uploadAttachmentToCloudinary(attachmentFile, 'chatroom_uploads');

            await addDoc(collection(db, 'voice_chatrooms', selectedVoiceRoomId, 'messages'), {
                uid: currentUser.uid,
                ...getCurrentMessageProfilePayload(),
                sender_type: getCurrentSenderType(),
                avatar_url: getCurrentAvatarUrl(),
                message_type: 'attachment',
                attachment_url: attachmentData.url,
                attachment_public_id: attachmentData.public_id,
                attachment_name: attachmentData.name,
                attachment_type: attachmentData.mime_type,
                attachment_resource_type: attachmentData.resource_type,
                attachment_bytes: attachmentData.bytes,
                attachment_format: attachmentData.format,
                created_at: serverTimestamp()
            });

            await updateDoc(doc(db, 'voice_chatrooms', selectedVoiceRoomId), {
                last_voice_message_at: serverTimestamp(),
                last_voice_message_by: getCurrentSenderName(),
                voice_message_seq: increment(1)
            });

            clearSelectedVoiceAttachment();
            recordingStatus.textContent = 'Tap mic to record';
        } catch (error) {
            console.error('Send voice attachment error:', error);
            alert(error.message || 'Failed to send attachment.');
        } finally {
            updateActiveComposerAccess();
        }
    }

    async function sendVoiceMessage() {
        if (activeMode === 'text' && !selectedTextRoomId) {
            alert('Please select a text chatroom first.');
            return;
        }

        if (activeMode === 'voice' && !selectedVoiceRoomId) {
            alert('Please select a voice chatroom first.');
            return;
        }

        if (!currentUser) {
            authModal.show();
            return;
        }

        const selectedRoom = getSelectedRoomData();
        if (roomRequiresPayment(selectedRoom) && !canCurrentUserUsePrivateRoom()) {
            alert('Please complete payment to send voice messages in this private chatroom.');
            return;
        }

        if (!recordedBlob || recordedBlob.size === 0) {
            alert('No valid voice recording found. Please record again.');
            return;
        }

        try {
            recordToggleBtn.disabled = true;
            if (textRecordToggleBtn) textRecordToggleBtn.disabled = true;
            pauseRecordingBtn.disabled = true;
            discardVoiceBtn.disabled = true;
            recordingStatus.textContent = 'Uploading voice message...';

            const uploadResult = await uploadVoiceToCloudinary(recordedBlob);
            const duration = recordingStartedAt ? Math.max(1, Math.round((Date.now() - recordingStartedAt) / 1000)) : null;

            if (activeMode === 'text') {
                await ensureParticipantInRoom(selectedTextRoomId, 'text');

                const roomRef = doc(db, 'chatrooms', selectedTextRoomId);

                await addDoc(collection(db, 'chatrooms', selectedTextRoomId, 'messages'), {
                    uid: currentUser.uid,
                    ...getCurrentMessageProfilePayload(),
                    sender_type: getCurrentSenderType(),
                    avatar_url: getCurrentAvatarUrl(),
                    message: '',
                    message_type: 'voice',
                    audio_url: uploadResult.secure_url,
                    public_id: uploadResult.public_id,
                    duration: duration,
                    mime_type: recordedBlob.type || 'audio/webm',
                    created_at: serverTimestamp()
                });

                await updateDoc(roomRef, {
                    last_message: '🎙️ Voice message',
                    last_message_by: getCurrentSenderName(),
                    last_message_at: serverTimestamp(),
                    message_seq: increment(1)
                });
            } else {
                await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');

                const roomRef = doc(db, 'voice_chatrooms', selectedVoiceRoomId);

                await addDoc(collection(db, 'voice_chatrooms', selectedVoiceRoomId, 'messages'), {
                    uid: currentUser.uid,
                    ...getCurrentMessageProfilePayload(),
                    sender_type: getCurrentSenderType(),
                    avatar_url: getCurrentAvatarUrl(),
                    message_type: 'voice',
                    audio_url: uploadResult.secure_url,
                    public_id: uploadResult.public_id,
                    duration: duration,
                    mime_type: recordedBlob.type || 'audio/webm',
                    created_at: serverTimestamp()
                });

                await updateDoc(roomRef, {
                    last_voice_message_at: serverTimestamp(),
                    last_voice_message_by: getCurrentSenderName(),
                    voice_message_seq: increment(1)
                });
            }

            if (mediaStream) {
                mediaStream.getTracks().forEach(track => track.stop());
                mediaStream = null;
            }
            mediaRecorder = null;
            recordedChunks = [];
            recordedBlob = null;
            resetVoiceRecorderUI();
        } catch (error) {
            console.error('Send voice message error:', error);
            alert(error.message || 'Failed to send voice message.');
            recordingStatus.textContent = 'Upload failed';
        } finally {
            updateActiveComposerAccess();
        }
    }

    emojiToggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (emojiToggleBtn.disabled) return;
        emojiPickerWrap.classList.toggle('d-none');
    });

    emojiPicker.addEventListener('emoji-click', (event) => {
        const emoji = event.detail?.unicode || '';
        if (!emoji) return;

        const start = messageInput.selectionStart ?? messageInput.value.length;
        const end = messageInput.selectionEnd ?? messageInput.value.length;
        const value = messageInput.value;

        messageInput.value = value.slice(0, start) + emoji + value.slice(end);
        messageInput.focus();

        const cursorPos = start + emoji.length;
        messageInput.setSelectionRange(cursorPos, cursorPos);
        updateSendButtonState();
    });

    document.addEventListener('click', (e) => {
        if (!emojiPickerWrap.contains(e.target) && !emojiToggleBtn.contains(e.target)) {
            emojiPickerWrap.classList.add('d-none');
        }
    });

    async function handleRecordToggleAction() {
        if (isRecording) stopRecording();
        else if (recordedBlob && recordedBlob.size > 0) await sendVoiceMessage();
        else await startRecording();
    }

    recordToggleBtn.addEventListener('click', handleRecordToggleAction);
    if (textRecordToggleBtn) {
        textRecordToggleBtn.addEventListener('click', handleRecordToggleAction);
    }

    pauseRecordingBtn.addEventListener('click', togglePauseRecording);
    discardVoiceBtn.addEventListener('click', discardRecording);
    if (textPauseRecordingBtn) textPauseRecordingBtn.addEventListener('click', togglePauseRecording);
    if (textDiscardVoiceBtn) textDiscardVoiceBtn.addEventListener('click', discardRecording);

    joinGuestBtn.addEventListener('click', joinAsGuest);

    openAuthModalBtn.addEventListener('click', () => {
        clearAuthForm();
        setAuthMode('login');
        authModal.show();
    });



    listenPaymentPlans();
    listenCallParticipantUserProfiles();
    initCallParticipantAvatarEnhancer();

    if (mobileChatroomsBtn) {
        mobileChatroomsBtn.addEventListener('click', openMobileChatDrawer);
    }

    if (mobileVoiceBtn) {
        mobileVoiceBtn.addEventListener('click', openMobileVoiceDrawer);
    }

    if (mobileDrawerOverlay) {
        mobileDrawerOverlay.addEventListener('click', closeMobileDrawers);
    }

    if (mobileTextDrawerClose) {
        mobileTextDrawerClose.addEventListener('click', closeMobileDrawers);
    }

    if (mobileVoiceDrawerClose) {
        mobileVoiceDrawerClose.addEventListener('click', closeMobileDrawers);
    }

    if (mobilePaymentBtn) {
        mobilePaymentBtn.addEventListener('click', () => {
            closeMobileDrawers();
            setMobileNavActive(mobilePaymentBtn);
            if (!currentUser || currentUser.isAnonymous) {
                clearAuthForm();
                setAuthMode('login');
                authModal.show();
                return;
            }
            resetPaymentModalState();
            if (paymentPlansModal) paymentPlansModal.show();
        });
    }

    if (mobileSettingsBtn) {
        mobileSettingsBtn.addEventListener('click', async () => {
            closeMobileDrawers();
            setMobileNavActive(mobileSettingsBtn);
            if (!currentUser || currentUser.isAnonymous) {
                clearAuthForm();
                setAuthMode('login');
                authModal.show();
                return;
            }
            await fillProfileForm();
            profileSettingsModal.show();
        });
    }

    if (mobileProfileBtn) {
        mobileProfileBtn.addEventListener('click', () => {
            closeMobileDrawers();
            setMobileNavActive(mobileProfileBtn);
            if (!currentUser) {
                clearAuthForm();
                setAuthMode('login');
                authModal.show();
                return;
            }
            const profile = getCurrentUserPopupProfile();
            if (profile) openMessageUserPopup(profile);
        });
    }

    if (mobileLogoutBtn) {
        mobileLogoutBtn.addEventListener('click', async () => {
            closeMobileDrawers();
            setMobileNavActive(mobileLogoutBtn);
            await logoutUser();
            setMobileNavActive(mobileProfileBtn || null);
        });
    }

    if (mobileVoiceRoomSearch) {
        mobileVoiceRoomSearch.addEventListener('input', () => {
            currentVoiceSearch = mobileVoiceRoomSearch.value.trim().toLowerCase();
            if (voiceRoomSearch) voiceRoomSearch.value = mobileVoiceRoomSearch.value;
            renderVoiceRooms(getFilteredVoiceRooms());
        });
    }

    roomList?.addEventListener('click', (event) => {
        if (!event.target.closest('.room-item')) return;
        closeMobileDrawers();
        setMobileNavActive(mobileChatroomsBtn);
        scrollMobileThreadToBottom(420);
    });

    voiceRoomList?.addEventListener('click', (event) => {
        if (!event.target.closest('[data-voice-room-id]')) return;
        closeMobileDrawers();
        setMobileNavActive(mobileVoiceBtn);
        scrollMobileThreadToBottom(420);
    });

    const voicePrevBtn = document.getElementById('voicePrevBtn');
    const voiceNextBtn = document.getElementById('voiceNextBtn');
    if (voicePrevBtn) {
        voicePrevBtn.addEventListener('click', () => {
            voiceRoomList.scrollBy({ left: -260, behavior: 'smooth' });
        });
    }
    if (voiceNextBtn) {
        voiceNextBtn.addEventListener('click', () => {
            voiceRoomList.scrollBy({ left: 260, behavior: 'smooth' });
        });
    }

    if (privateAccessPayBtn) {
        privateAccessPayBtn.addEventListener('click', () => {
            resetPaymentModalState();
            if (paymentPlansModal) paymentPlansModal.show();
        });
    }

    if (privateAccessLoginBtn) {
        privateAccessLoginBtn.addEventListener('click', () => {
            clearAuthForm();
            setAuthMode('login');
            authModal.show();
        });
    }

    paymentPlansBtn.addEventListener('click', () => {
        if (!currentUser || currentUser.isAnonymous) {
            clearAuthForm();
            setAuthMode('login');
            authModal.show();
            return;
        }
        resetPaymentModalState();
        if (paymentPlansModal) paymentPlansModal.show();
    });

    if (paymentPlansModalEl) {
        paymentPlansModalEl.addEventListener('show.bs.modal', updateCurrentPurchasedPlanBox);
        paymentPlansModalEl.addEventListener('hidden.bs.modal', resetPaymentModalState);
    }

    confirmPaymentBtn?.addEventListener('click', processPrivateRoomPayment);

    profileSettingsBtn.addEventListener('click', async () => {
        await fillProfileForm();
        profileSettingsModal.show();
    });

    saveProfileBtn.addEventListener('click', saveProfileSettings);

    showLoginModeBtn.addEventListener('click', () => {
        clearAuthAlert();
        setAuthMode('login');
    });

    showRegisterModeBtn.addEventListener('click', () => {
        clearAuthAlert();
        setAuthMode('register');
    });

    if (showForgotModeBtn) {
        showForgotModeBtn.addEventListener('click', () => {
            clearAuthAlert();
            setAuthMode('forgot');
        });
    }

    authActionBtn.addEventListener('click', async () => {
        if (authMode.value === 'register') await registerUser();
        else if (authMode.value === 'forgot') await sendForgotPasswordEmail();
        else if (authMode.value === 'reset') await resetPasswordFromEmailLink();
        else await loginUser();
    });

    if (currentUserBox) {
        currentUserBox.addEventListener('click', (event) => {
            const chip = event.target.closest('.current-user-chip');
            if (!chip || !currentUser) return;

            const profile = getCurrentUserPopupProfile();
            if (profile) openMessageUserPopup(profile);
        });

        currentUserBox.addEventListener('keydown', (event) => {
            if (event.key !== 'Enter' && event.key !== ' ') return;

            const chip = event.target.closest('.current-user-chip');
            if (!chip || !currentUser) return;

            event.preventDefault();
            const profile = getCurrentUserPopupProfile();
            if (profile) openMessageUserPopup(profile);
        });
    }

    logoutBtn.addEventListener('click', logoutUser);
    if (textAttachmentBtn && textAttachmentInput) {
        textAttachmentBtn.addEventListener('click', () => textAttachmentInput.click());
        textAttachmentInput.addEventListener('change', () => {
            selectedTextAttachmentFile = textAttachmentInput.files[0] || null;
            renderSelectedTextAttachment();
            updateSendButtonState();
        });
    }

    if (voiceAttachmentBtn && voiceAttachmentInput) {
        voiceAttachmentBtn.addEventListener('click', () => voiceAttachmentInput.click());
        voiceAttachmentInput.addEventListener('change', () => {
            selectedVoiceAttachmentFile = voiceAttachmentInput.files[0] || null;
            renderSelectedVoiceAttachment();
        });
    }

    if (sendVoiceAttachmentBtn) {
        sendVoiceAttachmentBtn.addEventListener('click', sendVoiceAttachmentMessage);
    }

    sendBtn.addEventListener('click', sendTextMessage);

    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && messageInput.value.trim().length > 0) sendTextMessage();
    });

    messageInput.addEventListener('input', () => {
        updateSendButtonState();

        if (!currentUser || !selectedTextRoomId || activeMode !== 'text') return;

        const hasText = messageInput.value.trim().length > 0;

        clearTimeout(typingWriteTimeout);
        typingWriteTimeout = setTimeout(async () => {
            if (hasText !== lastTypingState) {
                lastTypingState = hasText;
                await setDoc(doc(db, 'chatrooms', selectedTextRoomId, 'participants', currentUser.uid), {
                    is_typing: hasText,
                    typing_updated_at: serverTimestamp()
                }, { merge: true });
            }
        }, 400);

        clearTimeout(typingStopTimeout);
        typingStopTimeout = setTimeout(async () => {
            lastTypingState = false;
            await setDoc(doc(db, 'chatrooms', selectedTextRoomId, 'participants', currentUser.uid), {
                is_typing: false,
                typing_updated_at: serverTimestamp()
            }, { merge: true });
        }, 1500);
    });

    textRoomSearch.addEventListener('input', () => {
        currentTextSearch = textRoomSearch.value.trim().toLowerCase();
        renderTextRooms(getFilteredTextRooms());
    });

    voiceRoomSearch.addEventListener('input', () => {
        currentVoiceSearch = voiceRoomSearch.value.trim().toLowerCase();
        renderVoiceRooms(getFilteredVoiceRooms());
    });

    chatMessages.addEventListener('play', (event) => {
        const target = event.target;
        if (!(target instanceof HTMLAudioElement) || !target.classList.contains('voice-note-player')) return;

        chatMessages.querySelectorAll('audio.voice-note-player').forEach(audio => {
            if (audio !== target) {
                audio.pause();
                audio.currentTime = 0;
            }
        });
    }, true);

    handlePasswordResetLanding();
    handleLoginTokenSignIn();

    onAuthStateChanged(auth, async (user) => {
        stopCurrentUserStatusListener();
        currentUser = user || null;
        const loadedProfile = await loadCurrentUserAvatar();

        if (currentUser && isUserBannedFromProfile(loadedProfile)) {
            await handleBannedUser(currentUser);
            return;
        }

        await loadCurrentPrivateAccess();
        renderCurrentUser();
        updateAuthEntryVisibility();
        updateActiveComposerAccess();

        if (currentUser) {
            startCurrentUserStatusListener(currentUser);
            try {
                await saveUserProfile(currentUser, getCurrentSenderName(), getCurrentSenderType(), currentAvatarUrl, currentFullName);

                if (selectedTextRoomId) await ensureParticipantInRoom(selectedTextRoomId, 'text');
                if (selectedVoiceRoomId) await ensureParticipantInRoom(selectedVoiceRoomId, 'voice');
            } catch (error) {
                console.error('User profile sync error:', error);
            }
        }

        if (activeMode === 'text' && selectedTextRoomId) {
            loadSelectedTextRoom(selectedTextRoomId);
        } else if (activeMode === 'voice' && selectedVoiceRoomId) {
            loadSelectedVoiceRoom(selectedVoiceRoomId);
        }
    });

    const textRoomsQuery = query(
        collection(db, 'chatrooms'),
        where('is_active', '==', true),
        orderBy('last_message_at', 'desc'),
        limit(10)
    );

    onSnapshot(textRoomsQuery, async (snapshot) => {
        textRoomsLoaded = true;
        textRoomsCache = snapshot.docs.map(docSnap => ({ ...docSnap.data(), room_id: docSnap.data().room_id || docSnap.id }));
        renderTextRooms(getFilteredTextRooms());
        updateActiveComposerAccess();

        if (initialRoomIdFromUrl && !initialUrlRoomHandled) {
            await openInitialRoomFromUrl();
            if (!initialUrlRoomHandled) return;
        }

        if (!activeMode && textRoomsCache.length > 0) {
            loadSelectedTextRoom(textRoomsCache[0].room_id, 'replace');
        } else if (activeMode === 'text' && selectedTextRoomId) {
            const exists = textRoomsCache.find(room => room.room_id === selectedTextRoomId);
            if (!exists && textRoomsCache.length > 0 && !initialRoomIdFromUrl) {
                loadSelectedTextRoom(textRoomsCache[0].room_id, 'replace');
            } else {
                renderTextRooms(getFilteredTextRooms());
            }
        }
    }, (error) => {
        console.error('Rooms load error:', error);
        roomList.innerHTML = `<div class="p-3 text-danger">Failed to load chatrooms.</div>`;
    });

    const voiceRoomsQuery = query(
        collection(db, 'voice_chatrooms'),
        where('is_active', '==', true),
        orderBy('last_voice_message_at', 'desc'),
        limit(10)
    );

    onSnapshot(voiceRoomsQuery, async (snapshot) => {
        voiceRoomsLoaded = true;
        voiceRoomsCache = snapshot.docs.map(docSnap => ({ ...docSnap.data(), room_id: docSnap.data().room_id || docSnap.id }));
        renderVoiceRooms(getFilteredVoiceRooms());
        updateActiveComposerAccess();

        if (initialRoomIdFromUrl && !initialUrlRoomHandled) {
            await openInitialRoomFromUrl();
            if (!initialUrlRoomHandled) return;
        }

        if (activeMode === 'voice' && selectedVoiceRoomId) {
            const exists = voiceRoomsCache.find(room => room.room_id === selectedVoiceRoomId);
            if (!exists && voiceRoomsCache.length > 0 && !initialRoomIdFromUrl) {
                loadSelectedVoiceRoom(voiceRoomsCache[0].room_id, 'replace');
            } else {
                renderVoiceRooms(getFilteredVoiceRooms());
            }
        }
    }, (error) => {
        console.error('Voice rooms load error:', error);
        voiceRoomList.innerHTML = `<div class="text-danger">Failed to load voice chatrooms.</div>`;
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const footer = document.querySelector('footer, .footer, .main-footer, .site-footer, .copyright');
    if (footer && footer.parentElement !== document.body) {
        document.body.appendChild(footer);
    }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const isMobile = () => window.matchMedia('(max-width: 991.98px)').matches;

    function scrollToChatThread() {
        if (!isMobile()) return;

        const chatCard =
            document.querySelector('.col-md-8 .card, .col-lg-9 .card') ||
            document.querySelector('#chatMessages') ||
            document.querySelector('#selectedRoomTitle');

        if (chatCard) {
            setTimeout(function () {
                chatCard.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 260);
        }
    }

    document.addEventListener('click', function (e) {
        if (!isMobile()) return;

        const textRoom = e.target.closest('.room-item');
        const voiceRoom = e.target.closest('[data-voice-room-id]');

        if (textRoom || voiceRoom) {
            scrollToChatThread();
        }
    });

    window.scrollToMobileChatThread = scrollToChatThread;
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    function syncDesktopPaymentButton() {
        const payBtn =
            document.getElementById('paymentPlansBtn') ||
            document.querySelector('[data-mobile-pay]') ||
            document.querySelector('.payment-access-btn');

        const currentUserBox = document.getElementById('currentUserBox');

        if (!payBtn || !currentUserBox) return;

        const txt = currentUserBox.textContent.toLowerCase();
        const isGuest = txt.includes('guest');
        const isLoggedOut = txt.includes('not logged in') || txt.trim() === '';

        payBtn.style.display = (!isGuest && !isLoggedOut) ? '' : 'none';
    }

    const observer = new MutationObserver(syncDesktopPaymentButton);

    const currentUserBox = document.getElementById('currentUserBox');
    if (currentUserBox) {
        observer.observe(currentUserBox, { childList: true, subtree: true, attributes: true });
    }

    syncDesktopPaymentButton();
    document.addEventListener('click', syncDesktopPaymentButton, true);
});
</script>

<?php
include('frontend/includes/footer.php');
?>


