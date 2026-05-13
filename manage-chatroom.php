<?php
include('includes/header.php');
?>

<div class="container-fluid">
    <div class="shadow p-4 bg-white rounded mt-3">
        <div class="eyebrow">Rooms</div>
        <h2>Manage Chatrooms</h2>

        <form id="addChatroomForm" class="mt-4 form-styling" onsubmit="return false;">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="display_name" class="form-label">Display Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-comments"></i></span>
                        <input type="text" id="display_name" class="form-control" placeholder="Enter Display Name" required>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="room_id" class="form-label">Room ID</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-comment-dots"></i></span>
                        <input type="text" id="room_id" class="form-control" placeholder="Enter Room ID" required>
                    </div>
                    <small class="text-muted">Example: general-chat / night-voice-room</small>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="room_type" class="form-label">Room Type</label>
                    <select id="room_type" class="form-select" required>
                        <option value="text" selected>Text Chatroom</option>
                        <option value="voice">Voice Chatroom</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="room_access" class="form-label">Room Access</label>
                    <select id="room_access" class="form-select" required>
                        <option value="public" selected>Public</option>
                        <option value="private">Private</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="room_logo_file" class="form-label">Room Logo Upload</label>
                    <input type="file" id="room_logo_file" class="form-control" accept="image/*">
                    <small class="text-muted">Optional. Uploaded to Cloudinary folder: logos</small>
                </div>
            </div>

            <div class="form-group mt-3">
                <button type="button" id="addChatRoom" class="btn btn-primary">Add Room</button>
            </div>
        </form>

        <div id="formMessage" class="mt-3"></div>
    </div>

    <div class="shadow mt-4 p-4 bg-white rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Text Chatrooms</h2>
            <a href="frontend/chat-dashboard.php" target="_blank" class="btn btn-sm btn-info">Open Chat Dashboard</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Logo</th>
                        <th>Display Name</th>
                        <th>Room ID</th>
                        <th>Type</th>
                        <th>Access</th>
                        <th>Last Message</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="textChatroomTable">
                    <tr>
                        <td colspan="8" class="text-center">Loading text chatrooms...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="shadow mt-4 p-4 bg-white rounded mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Voice Chatrooms</h2>
            <a href="frontend/chat-dashboard.php" target="_blank" class="btn btn-sm btn-warning">Open Voice Dashboard</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Logo</th>
                        <th>Display Name</th>
                        <th>Room ID</th>
                        <th>Type</th>
                        <th>Access</th>
                        <th>Last Voice By</th>
                        <th>Created At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="voiceChatroomTable">
                    <tr>
                        <td colspan="8" class="text-center">Loading voice chatrooms...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Chatroom Modal -->
<div class="modal fade" id="editChatroomModal" tabindex="-1" aria-labelledby="editChatroomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content admin-edit-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="editChatroomModalLabel">Edit Chatroom</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_original_room_id">
                <input type="hidden" id="edit_original_room_type">

                <div id="editFormMessage" class="mb-3"></div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_display_name" class="form-label">Display Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-comments"></i></span>
                            <input type="text" id="edit_display_name" class="form-control" placeholder="Enter Display Name" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="edit_room_id" class="form-label">Room ID</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="far fa-comment-dots"></i></span>
                            <input type="text" id="edit_room_id" class="form-control" disabled>
                        </div>
                        <small class="text-muted">Room ID is locked to avoid breaking existing messages and links.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="edit_room_access" class="form-label">Room Access</label>
                        <select id="edit_room_access" class="form-select" required>
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                        </select>
                    </div>

                    <div class="col-md-8 mb-3">
                        <label for="edit_room_logo_file" class="form-label">Replace Room Logo</label>
                        <input type="file" id="edit_room_logo_file" class="form-control" accept="image/*">
                        <small class="text-muted">Leave empty to keep the current logo.</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Current Logo</label>
                        <div id="editCurrentLogoPreview" class="edit-logo-preview"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="updateChatRoom" class="btn btn-sm btn-primary">Update Room</button>
            </div>
        </div>
    </div>
</div>


<style>
    .admin-room-logo {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #ddd;
    }
    .admin-room-logo-placeholder {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        border: 1px solid #ddd;
    }
    .admin-edit-modal {
        background: rgba(10,24,58,.96);
        color: #fff;
        border: 1px solid rgba(0,217,255,.38);
        border-radius: 22px;
        box-shadow: 0 28px 80px rgba(0,0,0,.55);
        backdrop-filter: blur(18px);
    }
    .admin-edit-modal .modal-header,
    .admin-edit-modal .modal-footer {
        border-color: rgba(0,217,255,.25);
    }
    .edit-logo-preview img,
    .edit-logo-preview .admin-room-logo-placeholder {
        width: 64px;
        height: 64px;
    }
</style>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
    import {
        getFirestore,
        collection,
        doc,
        setDoc,
        getDoc,
        updateDoc,
        deleteDoc,
        query,
        orderBy,
        onSnapshot,
        serverTimestamp
    } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";

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
    const CLOUDINARY_UPLOAD_URL = `https://api.cloudinary.com/v1_1/${CLOUDINARY_CLOUD_NAME}/image/upload`;

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    const addChatRoomBtn = document.getElementById('addChatRoom');
    const formMessage = document.getElementById('formMessage');
    const textChatroomTable = document.getElementById('textChatroomTable');
    const voiceChatroomTable = document.getElementById('voiceChatroomTable');

    const displayNameInput = document.getElementById('display_name');
    const roomIdInput = document.getElementById('room_id');
    const roomTypeInput = document.getElementById('room_type');
    const roomAccessInput = document.getElementById('room_access');
    const roomLogoFileInput = document.getElementById('room_logo_file');

    const editOriginalRoomIdInput = document.getElementById('edit_original_room_id');
    const editOriginalRoomTypeInput = document.getElementById('edit_original_room_type');
    const editRoomIdInput = document.getElementById('edit_room_id');
    const editDisplayNameInput = document.getElementById('edit_display_name');
    const editRoomAccessInput = document.getElementById('edit_room_access');
    const editRoomLogoFileInput = document.getElementById('edit_room_logo_file');
    const editCurrentLogoPreview = document.getElementById('editCurrentLogoPreview');
    const editFormMessage = document.getElementById('editFormMessage');
    const updateChatRoomBtn = document.getElementById('updateChatRoom');

    let roomsCache = { text: {}, voice: {} };
    let editChatroomModal = null;

    function sanitizeRoomId(value) {
        return value
            .trim()
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^a-z0-9_-]/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function showMessage(message, type = 'success') {
        formMessage.innerHTML = `<div class="alert alert-${type}">${escapeHtml(message)}</div>`;
    }

    function showEditMessage(message, type = 'success') {
        editFormMessage.innerHTML = `<div class="alert alert-${type}">${escapeHtml(message)}</div>`;
    }

    function formatDateTime(timestamp) {
        if (!timestamp || !timestamp.toDate) return '-';
        return timestamp.toDate().toLocaleString();
    }

    function roomLogoHtml(logo, type) {
        if (logo) {
            return `<img src="${escapeHtml(logo)}" class="admin-room-logo" alt="logo">`;
        }
        return `<div class="admin-room-logo-placeholder"><i class="fas ${type === 'voice' ? 'fa-microphone' : 'fa-comments'}"></i></div>`;
    }

    async function uploadImageToCloudinary(file, folderName = 'logos') {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);
        formData.append('folder', folderName);

        const response = await fetch(CLOUDINARY_UPLOAD_URL, {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data?.error?.message || 'Cloudinary upload failed');
        }

        return data.secure_url;
    }

    async function createRoom() {
        let displayName = displayNameInput.value.trim();
        let roomId = sanitizeRoomId(roomIdInput.value);
        const roomType = roomTypeInput.value;
        const roomAccess = roomAccessInput.value;
        const roomLogoFile = roomLogoFileInput.files[0] || null;

        roomIdInput.value = roomId;

        if (!displayName || !roomId || !roomType || !roomAccess) {
            showMessage('Display Name, Room ID, Room Type and Room Access are required.', 'danger');
            return;
        }

        try {
            addChatRoomBtn.disabled = true;
            addChatRoomBtn.textContent = 'Saving...';

            let roomLogoUrl = '';
            if (roomLogoFile) {
                roomLogoUrl = await uploadImageToCloudinary(roomLogoFile, 'logos');
            }

            if (roomType === 'text') {
                const roomRef = doc(db, 'chatrooms', roomId);
                const roomSnap = await getDoc(roomRef);

                if (roomSnap.exists()) {
                    showMessage('This text room ID already exists.', 'danger');
                    return;
                }

                await setDoc(roomRef, {
                    display_name: displayName,
                    room_id: roomId,
                    room_type: 'text',
                    room_access: roomAccess,
                    room_logo: roomLogoUrl || '',
                    is_active: true,
                    created_by: 'admin',
                    created_at: serverTimestamp(),
                    message_seq: 0,
                    last_message: '',
                    last_message_by: '',
                    last_message_at: serverTimestamp()
                });

                showMessage('Text chatroom created successfully.', 'success');
            }

            if (roomType === 'voice') {
                const roomRef = doc(db, 'voice_chatrooms', roomId);
                const roomSnap = await getDoc(roomRef);

                if (roomSnap.exists()) {
                    showMessage('This voice room ID already exists.', 'danger');
                    return;
                }

                await setDoc(roomRef, {
                    display_name: displayName,
                    room_id: roomId,
                    room_type: 'voice',
                    room_access: roomAccess,
                    room_logo: roomLogoUrl || '',
                    is_active: true,
                    created_by: 'admin',
                    created_at: serverTimestamp(),
                    voice_message_seq: 0,
                    last_voice_message_at: serverTimestamp(),
                    last_voice_message_by: ''
                });

                showMessage('Voice chatroom created successfully.', 'success');
            }

            document.getElementById('addChatroomForm').reset();
            roomTypeInput.value = 'text';
            roomAccessInput.value = 'public';
        } catch (error) {
            console.error(error);
            showMessage(error.message || 'Failed to create room.', 'danger');
        } finally {
            addChatRoomBtn.disabled = false;
            addChatRoomBtn.textContent = 'Add Room';
        }
    }

    function getCollectionName(type) {
        return type === 'voice' ? 'voice_chatrooms' : 'chatrooms';
    }

    function openEditModal(roomId, type) {
        const room = roomsCache[type]?.[roomId];
        if (!room) {
            showMessage('Room data not found. Please refresh and try again.', 'danger');
            return;
        }

        editOriginalRoomIdInput.value = roomId;
        editOriginalRoomTypeInput.value = type;
        editRoomIdInput.value = room.room_id || roomId;
        editDisplayNameInput.value = room.display_name || '';
        editRoomAccessInput.value = room.room_access || 'public';
        editRoomLogoFileInput.value = '';
        editFormMessage.innerHTML = '';
        editCurrentLogoPreview.innerHTML = roomLogoHtml(room.room_logo || '', room.room_type || type);

        if (!editChatroomModal) {
            editChatroomModal = new bootstrap.Modal(document.getElementById('editChatroomModal'));
        }
        editChatroomModal.show();
    }

    async function updateRoom() {
        const originalRoomId = editOriginalRoomIdInput.value;
        const originalType = editOriginalRoomTypeInput.value;
        const newType = originalType;
        const displayName = editDisplayNameInput.value.trim();
        const roomAccess = editRoomAccessInput.value;
        const logoFile = editRoomLogoFileInput.files[0] || null;

        if (!originalRoomId || !originalType || !displayName || !roomAccess) {
            showEditMessage('Display Name and Room Access are required.', 'danger');
            return;
        }

        try {
            updateChatRoomBtn.disabled = true;
            updateChatRoomBtn.textContent = 'Updating...';

            const oldCollection = getCollectionName(originalType);
            const newCollection = getCollectionName(newType);
            const oldRef = doc(db, oldCollection, originalRoomId);
            const oldSnap = await getDoc(oldRef);

            if (!oldSnap.exists()) {
                showEditMessage('Room no longer exists.', 'danger');
                return;
            }

            const oldData = oldSnap.data();
            let roomLogoUrl = oldData.room_logo || '';

            if (logoFile) {
                roomLogoUrl = await uploadImageToCloudinary(logoFile, 'logos');
            }

            const updatedData = {
                ...oldData,
                display_name: displayName,
                room_type: newType,
                room_access: roomAccess,
                room_logo: roomLogoUrl,
                updated_at: serverTimestamp()
            };

            if (originalType === newType) {
                await updateDoc(oldRef, updatedData);
            } else {
                const newRef = doc(db, newCollection, originalRoomId);
                const newSnap = await getDoc(newRef);

                if (newSnap.exists()) {
                    showEditMessage(`A ${newType} room with this Room ID already exists.`, 'danger');
                    return;
                }

                if (newType === 'text') {
                    updatedData.message_seq = updatedData.message_seq || 0;
                    updatedData.last_message = updatedData.last_message || '';
                    updatedData.last_message_by = updatedData.last_message_by || '';
                    updatedData.last_message_at = updatedData.last_message_at || serverTimestamp();
                    delete updatedData.voice_message_seq;
                    delete updatedData.last_voice_message_at;
                    delete updatedData.last_voice_message_by;
                }

                if (newType === 'voice') {
                    updatedData.voice_message_seq = updatedData.voice_message_seq || 0;
                    updatedData.last_voice_message_at = updatedData.last_voice_message_at || serverTimestamp();
                    updatedData.last_voice_message_by = updatedData.last_voice_message_by || '';
                    delete updatedData.message_seq;
                    delete updatedData.last_message;
                    delete updatedData.last_message_by;
                    delete updatedData.last_message_at;
                }

                await setDoc(newRef, updatedData);
                await deleteDoc(oldRef);
            }

            showMessage('Chatroom updated successfully.', 'success');
            if (editChatroomModal) editChatroomModal.hide();
        } catch (error) {
            console.error(error);
            showEditMessage(error.message || 'Failed to update room.', 'danger');
        } finally {
            updateChatRoomBtn.disabled = false;
            updateChatRoomBtn.textContent = 'Update Room';
        }
    }

    async function deleteRoom(roomId, type) {
        const confirmDelete = confirm(`Are you sure you want to delete this ${type} room: ${roomId}?`);
        if (!confirmDelete) return;

        try {
            const collectionName = type === 'voice' ? 'voice_chatrooms' : 'chatrooms';
            await deleteDoc(doc(db, collectionName, roomId));
            showMessage(`${type.charAt(0).toUpperCase() + type.slice(1)} room deleted successfully.`, 'success');
        } catch (error) {
            console.error(error);
            showMessage('Failed to delete room.', 'danger');
        }
    }

    roomIdInput.addEventListener('input', function() {
        this.value = sanitizeRoomId(this.value);
    });

    addChatRoomBtn.addEventListener('click', createRoom);
    updateChatRoomBtn.addEventListener('click', updateRoom);

    const textRoomsQuery = query(collection(db, 'chatrooms'), orderBy('created_at', 'desc'));

    onSnapshot(textRoomsQuery, (snapshot) => {
        let rows = '';
        roomsCache.text = {};

        if (snapshot.empty) {
            rows = `<tr><td colspan="8" class="text-center">No text chatrooms found</td></tr>`;
        } else {
            snapshot.forEach((docSnap) => {
                const room = docSnap.data();
                roomsCache.text[room.room_id || docSnap.id] = { ...room, room_id: room.room_id || docSnap.id, room_type: 'text' };

                rows += `
                    <tr>
                        <td>${roomLogoHtml(room.room_logo, 'text')}</td>
                        <td>${escapeHtml(room.display_name)}</td>
                        <td>${escapeHtml(room.room_id)}</td>
                        <td><span class="badge bg-primary">Text</span></td>
                        <td><span class="badge ${room.room_access === 'private' ? 'bg-danger' : 'bg-success'}">${escapeHtml((room.room_access || 'public').charAt(0).toUpperCase() + (room.room_access || 'public').slice(1))}</span></td>
                        <td>${escapeHtml(room.last_message || '-')}</td>
                        <td>${escapeHtml(formatDateTime(room.created_at))}</td>
                        <td class="text-center">
                            <a href="frontend/chat-dashboard.php" target="_blank" class="btn btn-sm btn-info">Open</a>
                            <button class="btn btn-sm btn-primary edit-room-btn" data-room-type="text" data-room-id="${escapeHtml(room.room_id)}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-text-room-btn" data-room-id="${escapeHtml(room.room_id)}">Delete</button>
                        </td>
                    </tr>
                `;
            });
        }

        textChatroomTable.innerHTML = rows;

        textChatroomTable.querySelectorAll('.edit-room-btn').forEach(button => {
            button.addEventListener('click', function() {
                openEditModal(this.getAttribute('data-room-id'), this.getAttribute('data-room-type'));
            });
        });

        document.querySelectorAll('.delete-text-room-btn').forEach(button => {
            button.addEventListener('click', function() {
                deleteRoom(this.getAttribute('data-room-id'), 'text');
            });
        });
    }, (error) => {
        console.error(error);
        textChatroomTable.innerHTML = `<tr><td colspan="8" class="text-center text-danger">Failed to load text chatrooms</td></tr>`;
    });

    const voiceRoomsQuery = query(collection(db, 'voice_chatrooms'), orderBy('created_at', 'desc'));

    onSnapshot(voiceRoomsQuery, (snapshot) => {
        let rows = '';
        roomsCache.voice = {};

        if (snapshot.empty) {
            rows = `<tr><td colspan="8" class="text-center">No voice chatrooms found</td></tr>`;
        } else {
            snapshot.forEach((docSnap) => {
                const room = docSnap.data();
                roomsCache.voice[room.room_id || docSnap.id] = { ...room, room_id: room.room_id || docSnap.id, room_type: 'voice' };

                rows += `
                    <tr>
                        <td>${roomLogoHtml(room.room_logo, 'voice')}</td>
                        <td>${escapeHtml(room.display_name)}</td>
                        <td>${escapeHtml(room.room_id)}</td>
                        <td><span class="badge bg-warning text-dark">Voice</span></td>
                        <td><span class="badge ${room.room_access === 'private' ? 'bg-danger' : 'bg-success'}">${escapeHtml((room.room_access || 'public').charAt(0).toUpperCase() + (room.room_access || 'public').slice(1))}</span></td>
                        <td>${escapeHtml(room.last_voice_message_by || '-')}</td>
                        <td>${escapeHtml(formatDateTime(room.created_at))}</td>
                        <td class="text-center">
                            <a href="frontend/chat-dashboard.php" target="_blank" class="btn btn-sm btn-warning">Open</a>
                            <button class="btn btn-sm btn-primary edit-room-btn" data-room-type="voice" data-room-id="${escapeHtml(room.room_id)}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-voice-room-btn" data-room-id="${escapeHtml(room.room_id)}">Delete</button>
                        </td>
                    </tr>
                `;
            });
        }

        voiceChatroomTable.innerHTML = rows;

        voiceChatroomTable.querySelectorAll('.edit-room-btn').forEach(button => {
            button.addEventListener('click', function() {
                openEditModal(this.getAttribute('data-room-id'), this.getAttribute('data-room-type'));
            });
        });

        document.querySelectorAll('.delete-voice-room-btn').forEach(button => {
            button.addEventListener('click', function() {
                deleteRoom(this.getAttribute('data-room-id'), 'voice');
            });
        });
    }, (error) => {
        console.error(error);
        voiceChatroomTable.innerHTML = `<tr><td colspan="8" class="text-center text-danger">Failed to load voice chatrooms</td></tr>`;
    });
</script>

<?php
include('includes/footer.php');
?>