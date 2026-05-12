<?php
include('includes/header.php');
?>

<div class="container-fluid py-3">
    <div class="shadow p-4 bg-white rounded">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div>
                <div class="eyebrow">Users</div>
                <h2 class="mb-1">Manage Users</h2>
                <div class="text-muted">Ban / unban users, update profile details, and keep chat display names synced with username.</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="manage-chatroom.php" class="btn btn-sm btn-primary">Manage Chatrooms</a>
            </div>
        </div>

        <div id="userActionMessage" class="mb-3"></div>

        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" id="userSearchInput" class="form-control" placeholder="Search by name, username, email, UID, type or link">
            </div>
        </div>
         
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Avatar</th>
                        <th>Name / UID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>User Link</th>
                        <th>Private Plan</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Last Seen</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <tr>
                        <td colspan="11" class="text-center">Loading users...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <small class="text-muted d-block mt-2">
            Delete removes the profile document from Firestore users collection. A full Firebase Authentication account deletion would require a secure server-side admin setup.
        </small>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content manage-user-edit-modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editUserUid">
                <input type="hidden" id="editExistingAvatarUrl">

                <div class="text-center mb-3">
                    <div id="editCurrentAvatarPreview"></div>
                    <small class="text-muted d-block mt-2">Upload a new avatar only if you want to replace the existing one.</small>
                </div>

                <div class="mb-3">
                    <label for="editFullName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="editFullName" placeholder="Enter full name">
                </div>

                <div class="mb-3">
                    <label for="editUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" id="editUsername" placeholder="Enter username">
                    <small class="text-muted">This username will be shown in chat and in the message-meta popup.</small>
                </div>

                <div class="mb-3">
                    <label for="editAvatarFile" class="form-label">Avatar Upload</label>
                    <input type="file" class="form-control" id="editAvatarFile" accept="image/*">
                </div>

                <div class="mb-3">
                    <label for="editLinkName" class="form-label">Link Name</label>
                    <input type="text" class="form-control" id="editLinkName" placeholder="Example: Portfolio, Website, LinkedIn">
                </div>

                <div class="mb-3">
                    <label for="editUserUrl" class="form-label">User URL</label>
                    <input type="url" class="form-control" id="editUserUrl" placeholder="https://example.com/profile">
                    <small class="text-muted">Shown as a badge button in the message-meta popup. Leave blank to hide the badge.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="saveUserProfileBtn" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-user-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #00b7ff;
        box-shadow: 0 0 12px rgba(0, 183, 255, .25);
    }
    .admin-user-avatar-placeholder {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #06265e, #641bd6);
        color: #ffffff;
        border: 1px solid #00b7ff;
        box-shadow: 0 0 12px rgba(0, 183, 255, .22);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
    }
    .admin-user-link-badge {
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        border-radius: 999px;
    }
    .admin-edit-avatar-preview {
        width: 86px;
        height: 86px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(0, 207, 255, .84);
        box-shadow: 0 0 28px rgba(0, 207, 255, .32);
    }
    .admin-edit-avatar-placeholder {
        width: 86px;
        height: 86px;
        border-radius: 50%;
        background: linear-gradient(135deg, #06356f, #7b2cff);
        color: #ffffff;
        border: 2px solid rgba(0, 207, 255, .84);
        box-shadow: 0 0 28px rgba(0, 207, 255, .30);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 900;
        text-transform: uppercase;
    }

    #editUserModal .modal-dialog {
        max-width: 560px;
    }
    #editUserModal .manage-user-edit-modal-content {
        border-radius: 22px;
        overflow: hidden;
        color: #f4fbff;
        border: 1px solid rgba(0, 207, 255, .42);
        background:
            radial-gradient(circle at 18% 0%, rgba(0, 216, 255, .20), transparent 34%),
            radial-gradient(circle at 88% 14%, rgba(126, 0, 255, .24), transparent 38%),
            linear-gradient(145deg, rgba(2, 14, 52, .98), rgba(7, 6, 45, .98));
        box-shadow: 0 0 44px rgba(0, 191, 255, .24), 0 24px 80px rgba(0, 0, 0, .52);
    }
    #editUserModal .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid rgba(0, 207, 255, .26);
        background: linear-gradient(90deg, rgba(0, 188, 255, .16), rgba(122, 40, 255, .14));
    }
    #editUserModal .modal-title {
        color: #ffffff;
        font-weight: 900;
        letter-spacing: -.02em;
    }
    #editUserModal .modal-body {
        padding: 22px 24px;
    }
    #editUserModal .modal-footer {
        padding: 16px 22px;
        border-top: 1px solid rgba(0, 207, 255, .22);
        background: rgba(1, 10, 38, .60);
    }
    #editUserModal .form-label {
        color: #dff5ff;
        font-weight: 800;
        font-size: 13px;
        margin-bottom: 7px;
    }
    #editUserModal .form-control {
        min-height: 48px;
        border-radius: 14px;
        background: rgba(8, 21, 62, .92);
        border: 1px solid rgba(0, 207, 255, .34);
        color: #ffffff;
        box-shadow: inset 0 0 20px rgba(0, 0, 0, .16), 0 0 16px rgba(0, 194, 255, .06);
    }
    #editUserModal .form-control::placeholder {
        color: rgba(215, 231, 255, .58);
    }
    #editUserModal .form-control:focus {
        border-color: rgba(0, 234, 255, .78);
        box-shadow: 0 0 0 .18rem rgba(0, 207, 255, .16), 0 0 26px rgba(0, 207, 255, .18);
    }
    #editUserModal input[type="file"].form-control::file-selector-button {
        border: 0;
        border-radius: 10px;
        margin-right: 12px;
        padding: 9px 14px;
        color: #052149;
        font-weight: 800;
        background: linear-gradient(135deg, #9befff, #ffffff);
    }
    #editUserModal small.text-muted {
        color: rgba(175, 205, 255, .82) !important;
        font-weight: 600;
    }
    #editUserModal .btn-close {
        filter: invert(1) brightness(1.8);
        opacity: .9;
    }
    #editUserModal .btn-secondary {
        border-radius: 14px;
        padding: 10px 20px;
        font-weight: 800;
        color: #ffffff;
        border: 1px solid rgba(220, 232, 255, .22);
        background: rgba(91, 103, 126, .72);
    }
    #editUserModal #saveUserProfileBtn {
        border-radius: 14px;
        padding: 10px 22px;
        font-weight: 900;
        color: #ffffff;
        background: linear-gradient(135deg, #00cfff, #6e12ff);
        border: 1px solid rgba(255, 255, 255, .30);
        box-shadow: 0 0 28px rgba(0, 207, 255, .42);
    }
</style>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
    import {
        getFirestore,
        collection,
        collectionGroup,
        doc,
        query,
        where,
        getDocs,
        orderBy,
        onSnapshot,
        updateDoc,
        deleteDoc,
        serverTimestamp
    } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-firestore.js";

    const firebaseConfig = {
        apiKey: "AIzaSyD_X8hJzryCHrlC8BgO4wExzHzmnIJCBOI",
        authDomain: "chatroom-4ecf4.firebaseapp.com",
        projectId: "chatroom-4ecf4",
        storageBucket: "chatroom-4ecf4.firebasestorage.app",
        messagingSenderId: "19724728120",
        appId: "1:19724728120:web:a61bc3d3986b15d58a73cd"
    };

    const CLOUDINARY_CLOUD_NAME = "dyqeg4xdu";
    const CLOUDINARY_UPLOAD_PRESET = "crazynaters";
    const CLOUDINARY_IMAGE_UPLOAD_URL = `https://api.cloudinary.com/v1_1/${CLOUDINARY_CLOUD_NAME}/image/upload`;

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    const userActionMessage = document.getElementById('userActionMessage');
    const usersTableBody = document.getElementById('usersTableBody');
    const userSearchInput = document.getElementById('userSearchInput');

    const editUserModalEl = document.getElementById('editUserModal');
    const editUserModal = editUserModalEl ? new bootstrap.Modal(editUserModalEl) : null;
    const editUserUid = document.getElementById('editUserUid');
    const editExistingAvatarUrl = document.getElementById('editExistingAvatarUrl');
    const editCurrentAvatarPreview = document.getElementById('editCurrentAvatarPreview');
    const editFullName = document.getElementById('editFullName');
    const editUsername = document.getElementById('editUsername');
    const editAvatarFile = document.getElementById('editAvatarFile');
    const editLinkName = document.getElementById('editLinkName');
    const editUserUrl = document.getElementById('editUserUrl');
    const saveUserProfileBtn = document.getElementById('saveUserProfileBtn');

    let usersCache = [];
    let currentSearch = '';

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function showMessage(message, type = 'success') {
        userActionMessage.innerHTML = `<div class="alert alert-${type} mb-0">${escapeHtml(message)}</div>`;
    }

    function formatDateTime(timestamp) {
        if (!timestamp || !timestamp.toDate) return '-';
        return timestamp.toDate().toLocaleString();
    }

    function getInitials(name) {
        const cleaned = (name || 'US').trim().split(/\s+/).slice(0, 2).map(part => part[0] || '').join('');
        return (cleaned || 'US').substring(0, 2).toUpperCase();
    }

    function avatarHtml(url, name, preview = false) {
        if (url) {
            return `<img src="${escapeHtml(url)}" class="${preview ? 'admin-edit-avatar-preview' : 'admin-user-avatar'}" alt="avatar">`;
        }
        return `<div class="${preview ? 'admin-edit-avatar-placeholder' : 'admin-user-avatar-placeholder'}">${escapeHtml(getInitials(name))}</div>`;
    }

    function normalizeHttpUrl(url) {
        const trimmed = (url || '').trim();
        if (!trimmed) return '';

        const normalized = /^[a-zA-Z][a-zA-Z\d+\-.]*:/.test(trimmed) ? trimmed : `https://${trimmed}`;
        const parsed = new URL(normalized);

        if (parsed.protocol !== 'http:' && parsed.protocol !== 'https:') {
            throw new Error('Only http:// or https:// links are allowed.');
        }

        return parsed.href;
    }

    function userLinkHtml(user) {
        const userUrl = user.user_url || '';
        if (!userUrl) return '-';

        let safeUrl = '';
        try {
            safeUrl = normalizeHttpUrl(userUrl);
        } catch (error) {
            return '<span class="badge bg-warning text-dark">Invalid URL</span>';
        }

        const label = user.link_name || user.linkName || 'Open Link';
        return `<a href="${escapeHtml(safeUrl)}" target="_blank" rel="noopener noreferrer" class="badge bg-info text-dark text-decoration-none admin-user-link-badge">${escapeHtml(label)}</a>`;
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

    async function deleteDocsFromQuery(snapshot) {
        for (const docSnap of snapshot.docs) {
            await deleteDoc(docSnap.ref);
        }
    }

    async function deleteUserFirestoreData(uid) {
        const textMessagesSnap = await getDocs(query(collectionGroup(db, 'messages'), where('uid', '==', uid)));
        await deleteDocsFromQuery(textMessagesSnap);

        const participantsSnap = await getDocs(query(collectionGroup(db, 'participants'), where('uid', '==', uid)));
        await deleteDocsFromQuery(participantsSnap);

        await deleteDoc(doc(db, 'users', uid));
    }

    async function updateUserReferences(uid, profilePayload) {
        const referencesPayload = {
            username: profilePayload.username || '',
            sender_name: profilePayload.username || '',
            full_name: profilePayload.full_name || '',
            avatar_url: profilePayload.avatar_url || '',
            user_url: profilePayload.user_url || '',
            link_name: profilePayload.link_name || ''
        };

        const textMessagesSnap = await getDocs(query(collectionGroup(db, 'messages'), where('uid', '==', uid)));
        for (const docSnap of textMessagesSnap.docs) {
            await updateDoc(docSnap.ref, referencesPayload);
        }

        const participantsSnap = await getDocs(query(collectionGroup(db, 'participants'), where('uid', '==', uid)));
        for (const docSnap of participantsSnap.docs) {
            await updateDoc(docSnap.ref, referencesPayload);
        }
    }

    function getFilteredUsers() {
        if (!currentSearch) return usersCache;
        return usersCache.filter(user => {
            const haystack = [
                user.full_name || '',
                user.username || '',
                user.sender_name || '',
                user.email || '',
                user.uid || '',
                user.sender_type || '',
                user.user_url || '',
                user.link_name || '',
                user.linkName || ''
            ].join(' ').toLowerCase();
            return haystack.includes(currentSearch);
        });
    }

    function openEditUserModal(user) {
        if (!editUserModal) return;

        const fullName = user.full_name || user.sender_name || '';
        const username = user.username || user.sender_name || '';
        const avatarUrl = user.avatar_url || '';

        editUserUid.value = user.uid || '';
        editExistingAvatarUrl.value = avatarUrl;
        editFullName.value = fullName;
        editUsername.value = username;
        editAvatarFile.value = '';
        editLinkName.value = user.link_name || user.linkName || '';
        editUserUrl.value = user.user_url || '';
        editCurrentAvatarPreview.innerHTML = avatarHtml(avatarUrl, username || fullName || user.email || 'User', true);

        editUserModal.show();
    }

    async function saveEditedUserProfile() {
        const uid = editUserUid.value.trim();
        const fullName = editFullName.value.trim();
        const username = editUsername.value.trim();
        const linkName = editLinkName.value.trim();
        const rawUserUrl = editUserUrl.value.trim();
        const avatarFile = editAvatarFile.files[0] || null;

        if (!uid) {
            showMessage('Missing user ID. Refresh the page and try again.', 'danger');
            return;
        }

        if (!fullName || !username) {
            showMessage('Full name and username are required.', 'warning');
            return;
        }

        let normalizedUserUrl = '';
        try {
            normalizedUserUrl = normalizeHttpUrl(rawUserUrl);
        } catch (error) {
            showMessage(error.message || 'Invalid user URL.', 'warning');
            return;
        }

        try {
            saveUserProfileBtn.disabled = true;
            saveUserProfileBtn.textContent = avatarFile ? 'Uploading...' : 'Saving...';

            let avatarUrl = editExistingAvatarUrl.value.trim();
            if (avatarFile) {
                avatarUrl = await uploadImageToCloudinary(avatarFile, 'avatars');
            }

            const profilePayload = {
                full_name: fullName,
                username: username,
                sender_name: username,
                avatar_url: avatarUrl,
                user_url: normalizedUserUrl,
                link_name: linkName,
                updated_at: serverTimestamp()
            };

            await updateDoc(doc(db, 'users', uid), profilePayload);

            // Do not bulk-update old room messages/participants here.
            // Firestore commonly blocks collectionGroup updates from this browser admin page,
            // which causes: Missing or insufficient permissions.
            // The chat dashboard now reads the latest username/avatar/link from users/{uid},
            // so the main user profile update is enough and does not break save.
            showMessage('User profile updated successfully.', 'success');
            editUserModal.hide();
        } catch (error) {
            console.error(error);
            showMessage(error.message || 'Failed to update user profile.', 'danger');
        } finally {
            saveUserProfileBtn.disabled = false;
            saveUserProfileBtn.textContent = 'Save Changes';
        }
    }

    function renderUsers(users) {
        if (!users.length) {
            usersTableBody.innerHTML = `<tr><td colspan="11" class="text-center">No users found.</td></tr>`;
            return;
        }

        let rows = '';
        users.forEach(user => {
            const isBanned = user.is_banned === true;
            const planText = user.private_plan_label || (user.purchased_plan_amount ? `$${user.purchased_plan_amount}` : '-');
            const fullName = user.full_name || user.sender_name || 'Unnamed User';
            const username = user.username || user.sender_name || '-';

            rows += `
                <tr>
                    <td>${avatarHtml(user.avatar_url || '', username || fullName || user.email || 'User')}</td>
                    <td>
                        <div class="fw-semibold">${escapeHtml(fullName)}</div>
                        <div class="small text-muted">${escapeHtml(user.uid || '-')}</div>
                    </td>
                    <td>${escapeHtml(username)}</td>
                    <td>${escapeHtml(user.email || '-')}</td>
                    <td><span class="badge bg-secondary">${escapeHtml((user.sender_type || 'unknown').toUpperCase())}</span></td>
                    <td>${userLinkHtml(user)}</td>
                    <td>${escapeHtml(planText)}</td>
                    <td>${isBanned ? '<span class="badge bg-danger">Banned</span>' : '<span class="badge bg-success">Active</span>'}</td>
                    <td>${escapeHtml(formatDateTime(user.created_at))}</td>
                    <td>${escapeHtml(formatDateTime(user.last_seen))}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary edit-user-btn mb-1" data-uid="${escapeHtml(user.uid)}">Edit</button>
                        <button class="btn btn-sm ${isBanned ? 'btn-success' : 'btn-warning'} ban-user-btn mb-1" data-uid="${escapeHtml(user.uid)}" data-banned="${isBanned ? '1' : '0'}">
                            ${isBanned ? 'Unban' : 'Ban'}
                        </button>
                        <!--<button class="btn btn-sm btn-danger delete-user-btn" data-uid="${escapeHtml(user.uid)}">Delete</button> -->
                    </td>
                </tr>
            `;
        });

        usersTableBody.innerHTML = rows;

        document.querySelectorAll('.edit-user-btn').forEach(button => {
            button.addEventListener('click', function() {
                const uid = this.getAttribute('data-uid');
                const user = usersCache.find(item => item.uid === uid);
                if (!user) {
                    showMessage('User not found in the current list. Refresh and try again.', 'warning');
                    return;
                }
                openEditUserModal(user);
            });
        });

        document.querySelectorAll('.ban-user-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const uid = this.getAttribute('data-uid');
                const isCurrentlyBanned = this.getAttribute('data-banned') === '1';

                try {
                    const shouldBan = !isCurrentlyBanned;
                    await updateDoc(doc(db, 'users', uid), {
                        is_banned: shouldBan,
                        banned: shouldBan,
                        status: shouldBan ? 'banned' : 'active',
                        banned_at: shouldBan ? serverTimestamp() : null,
                        ban_updated_at: serverTimestamp()
                    });
                    showMessage(`User ${shouldBan ? 'banned and kicked out immediately' : 'unbanned'} successfully.`, 'success');
                } catch (error) {
                    console.error(error);
                    showMessage('Failed to update user status.', 'danger');
                }
            });
        });

        document.querySelectorAll('.delete-user-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const uid = this.getAttribute('data-uid');
                if (!confirm(`Are you sure you want to delete this user profile: ${uid}?`)) return;

                try {
                    await deleteUserFirestoreData(uid);
                    showMessage('User Firestore data deleted successfully.', 'success');
                } catch (error) {
                    console.error(error);
                    showMessage('Failed to delete user Firestore data.', 'danger');
                }
            });
        });
    }

    userSearchInput.addEventListener('input', () => {
        currentSearch = userSearchInput.value.trim().toLowerCase();
        renderUsers(getFilteredUsers());
    });

    saveUserProfileBtn.addEventListener('click', saveEditedUserProfile);

    const usersQuery = query(collection(db, 'users'), orderBy('created_at', 'desc'));
    onSnapshot(usersQuery, (snapshot) => {
        usersCache = snapshot.docs.map(docSnap => ({ uid: docSnap.id, ...docSnap.data() }));
        renderUsers(getFilteredUsers());
    }, (error) => {
        console.error(error);
        usersTableBody.innerHTML = `<tr><td colspan="11" class="text-center text-danger">Failed to load users.</td></tr>`;
    });
</script>

<?php
include('includes/footer.php');
?>
