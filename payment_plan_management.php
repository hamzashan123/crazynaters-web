<?php
include('includes/header.php');
?>

<div class="container-fluid py-3 payment-plan-admin-page">
    <div class="shadow p-4 bg-white rounded payment-plan-admin-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div>
                <div class="eyebrow">Payment Plans</div>
                <h2 class="mb-1">Payment Plan Management</h2>
                <div class="text-muted">Manage private chatroom access plan amounts used in the chat dashboard payment modal.</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="manage-users.php" class="btn btn-sm btn-primary">Manage Users</a>
                <a href="manage-chatroom.php" class="btn btn-sm btn-outline-primary">Manage Chatrooms</a>
            </div>
        </div>

        <div id="planActionMessage" class="mb-3"></div>

        <div class="plan-form-shell mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-lg-3 col-md-6">
                    <label for="planAmountInput" class="form-label">Plan Amount</label>
                    <input type="number" step="0.01" min="0.01" id="planAmountInput" class="form-control" placeholder="Example: 5">
                </div>
                <div class="col-lg-3 col-md-6">
                    <label for="planLabelInput" class="form-label">Plan Label</label>
                    <input type="text" id="planLabelInput" class="form-control" placeholder="Example: $5 Plan">
                    <small class="text-muted">Leave blank to auto-create label from amount.</small>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label for="planSortOrderInput" class="form-label">Sort Order</label>
                    <input type="number" step="1" id="planSortOrderInput" class="form-control" placeholder="1">
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="form-check plan-active-check">
                        <input class="form-check-input" type="checkbox" id="planActiveInput" checked>
                        <label class="form-check-label" for="planActiveInput">Active</label>
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 d-flex gap-2 flex-wrap">
                    <button type="button" id="addPlanBtn" class="btn btn-primary flex-fill">Add Plan</button>
                    <button type="button" id="seedDefaultPlansBtn" class="btn btn-outline-primary flex-fill">Seed $5/$10</button>
                </div>
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" id="planSearchInput" class="form-control" placeholder="Search by amount, label or status">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Plan Label</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="plansTableBody">
                    <tr>
                        <td colspan="7" class="text-center">Loading payment plans...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <small class="text-muted d-block mt-2">
            Active plans are displayed dynamically in the chat dashboard private-room payment modal. Stripe handling remains unchanged.
        </small>
    </div>
</div>

<!-- Edit Payment Plan Modal -->
<div class="modal fade" id="editPaymentPlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content payment-plan-edit-modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Payment Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editPlanId">

                <div class="mb-3">
                    <label for="editPlanAmount" class="form-label">Plan Amount</label>
                    <input type="number" step="0.01" min="0.01" class="form-control" id="editPlanAmount" placeholder="Example: 10">
                </div>

                <div class="mb-3">
                    <label for="editPlanLabel" class="form-label">Plan Label</label>
                    <input type="text" class="form-control" id="editPlanLabel" placeholder="Example: $10 Plan">
                    <small class="text-muted">This label appears under the amount in the payment modal and is saved on purchase.</small>
                </div>

                <div class="mb-3">
                    <label for="editPlanSortOrder" class="form-label">Sort Order</label>
                    <input type="number" step="1" class="form-control" id="editPlanSortOrder" placeholder="1">
                </div>

                <div class="form-check plan-active-check modal-plan-check">
                    <input class="form-check-input" type="checkbox" id="editPlanActive">
                    <label class="form-check-label" for="editPlanActive">Active</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="savePlanBtn" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-plan-admin-card {
        background: linear-gradient(135deg, rgba(10,24,58,.92), rgba(15,31,76,.72)) !important;
        border: 1px solid rgba(0, 207, 255, .26);
        border-radius: 22px !important;
        color: #f4fbff;
        box-shadow: 0 24px 80px rgba(0, 0, 0, .38), 0 0 34px rgba(0, 191, 255, .10);
        backdrop-filter: blur(18px);
    }
    .payment-plan-admin-card h2,
    .payment-plan-admin-card .table,
    .payment-plan-admin-card .form-label {
        color: #ffffff;
    }
    .payment-plan-admin-card .text-muted,
    .payment-plan-admin-card small.text-muted {
        color: rgba(185, 207, 255, .82) !important;
    }
    .plan-form-shell {
        padding: 18px;
        border-radius: 18px;
        border: 1px solid rgba(0, 207, 255, .22);
        background: rgba(2, 14, 52, .52);
        box-shadow: inset 0 0 28px rgba(0, 207, 255, .05);
    }
    .payment-plan-admin-card .form-control {
        min-height: 46px;
        border-radius: 13px;
        background: rgba(8, 21, 62, .92);
        border: 1px solid rgba(0, 207, 255, .34);
        color: #ffffff;
        box-shadow: inset 0 0 18px rgba(0, 0, 0, .14);
    }
    .payment-plan-admin-card .form-control::placeholder {
        color: rgba(215, 231, 255, .58);
    }
    .payment-plan-admin-card .form-control:focus {
        border-color: rgba(0, 234, 255, .78);
        box-shadow: 0 0 0 .18rem rgba(0, 207, 255, .16), 0 0 24px rgba(0, 207, 255, .16);
    }
    .plan-active-check {
        min-height: 46px;
        padding: 11px 14px 11px 42px;
        border-radius: 13px;
        border: 1px solid rgba(0, 207, 255, .24);
        background: rgba(8, 21, 62, .72);
        color: #eaf7ff;
        font-weight: 800;
    }
    .plan-active-check .form-check-input {
        width: 20px;
        height: 20px;
        margin-left: -28px;
        margin-top: 2px;
        cursor: pointer;
    }
    .payment-plan-admin-card .btn-primary,
    #editPaymentPlanModal .btn-primary {
        border-radius: 13px;
        font-weight: 900;
        color: #ffffff;
        background: linear-gradient(135deg, #00cfff, #6e12ff) !important;
        border: 1px solid rgba(255, 255, 255, .30);
        box-shadow: 0 0 24px rgba(0, 207, 255, .34);
    }
    .payment-plan-admin-card .btn-outline-primary {
        border-radius: 13px;
        font-weight: 800;
        color: #dff5ff;
        border-color: rgba(0, 207, 255, .42);
        background: rgba(8, 21, 62, .55);
    }
    .payment-plan-admin-card .table {
        --bs-table-bg: rgba(4, 15, 52, .66);
        --bs-table-striped-bg: rgba(8, 25, 73, .72);
        --bs-table-hover-bg: rgba(0, 207, 255, .08);
        --bs-table-border-color: rgba(0, 207, 255, .18);
        color: #f4fbff;
        border-color: rgba(0, 207, 255, .18);
    }
    .payment-plan-admin-card .table-dark {
        --bs-table-bg: rgba(1, 9, 34, .95);
        --bs-table-border-color: rgba(0, 207, 255, .22);
    }
    .plan-amount-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 76px;
        padding: 7px 12px;
        border-radius: 999px;
        color: #06122d;
        background: linear-gradient(135deg, #00c897, #00ffc8);
        font-weight: 900;
        box-shadow: 0 0 20px rgba(0, 255, 200, .20);
    }
    .plan-label-text {
        font-weight: 900;
        color: #ffffff;
    }
    .plan-id-text {
        max-width: 220px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .payment-plan-edit-modal-content {
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
    #editPaymentPlanModal .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid rgba(0, 207, 255, .26);
        background: linear-gradient(90deg, rgba(0, 188, 255, .16), rgba(122, 40, 255, .14));
    }
    #editPaymentPlanModal .modal-title {
        color: #ffffff;
        font-weight: 900;
        letter-spacing: -.02em;
    }
    #editPaymentPlanModal .modal-body {
        padding: 22px 24px;
    }
    #editPaymentPlanModal .modal-footer {
        padding: 16px 22px;
        border-top: 1px solid rgba(0, 207, 255, .22);
        background: rgba(1, 10, 38, .60);
    }
    #editPaymentPlanModal .form-label {
        color: #dff5ff;
        font-weight: 800;
        font-size: 13px;
        margin-bottom: 7px;
    }
    #editPaymentPlanModal .form-control {
        min-height: 48px;
        border-radius: 14px;
        background: rgba(8, 21, 62, .92);
        border: 1px solid rgba(0, 207, 255, .34);
        color: #ffffff;
        box-shadow: inset 0 0 20px rgba(0, 0, 0, .16), 0 0 16px rgba(0, 194, 255, .06);
    }
    #editPaymentPlanModal .form-control::placeholder {
        color: rgba(215, 231, 255, .58);
    }
    #editPaymentPlanModal .form-control:focus {
        border-color: rgba(0, 234, 255, .78);
        box-shadow: 0 0 0 .18rem rgba(0, 207, 255, .16), 0 0 26px rgba(0, 207, 255, .18);
    }
    #editPaymentPlanModal small.text-muted {
        color: rgba(175, 205, 255, .82) !important;
        font-weight: 600;
    }
    #editPaymentPlanModal .btn-close {
        filter: invert(1) brightness(1.8);
        opacity: .9;
    }
    #editPaymentPlanModal .btn-secondary {
        border-radius: 14px;
        padding: 10px 20px;
        font-weight: 800;
        color: #ffffff;
        border: 1px solid rgba(220, 232, 255, .22);
        background: rgba(91, 103, 126, .72);
    }
</style>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.14.1/firebase-app.js";
    import {
        getFirestore,
        collection,
        doc,
        addDoc,
        updateDoc,
        deleteDoc,
        onSnapshot,
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

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    const planActionMessage = document.getElementById('planActionMessage');
    const plansTableBody = document.getElementById('plansTableBody');
    const planSearchInput = document.getElementById('planSearchInput');
    const planAmountInput = document.getElementById('planAmountInput');
    const planLabelInput = document.getElementById('planLabelInput');
    const planSortOrderInput = document.getElementById('planSortOrderInput');
    const planActiveInput = document.getElementById('planActiveInput');
    const addPlanBtn = document.getElementById('addPlanBtn');
    const seedDefaultPlansBtn = document.getElementById('seedDefaultPlansBtn');

    const editPaymentPlanModalEl = document.getElementById('editPaymentPlanModal');
    const editPaymentPlanModal = editPaymentPlanModalEl ? new bootstrap.Modal(editPaymentPlanModalEl) : null;
    const editPlanId = document.getElementById('editPlanId');
    const editPlanAmount = document.getElementById('editPlanAmount');
    const editPlanLabel = document.getElementById('editPlanLabel');
    const editPlanSortOrder = document.getElementById('editPlanSortOrder');
    const editPlanActive = document.getElementById('editPlanActive');
    const savePlanBtn = document.getElementById('savePlanBtn');

    let plansCache = [];
    let currentSearch = '';

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function showMessage(message, type = 'success') {
        planActionMessage.innerHTML = `<div class="alert alert-${type} mb-0">${escapeHtml(message)}</div>`;
    }

    function formatDateTime(timestamp) {
        if (!timestamp || !timestamp.toDate) return '-';
        return timestamp.toDate().toLocaleString();
    }

    function normalizeAmount(value) {
        const amount = Number(value);
        if (!Number.isFinite(amount) || amount <= 0) {
            throw new Error('Please enter a valid plan amount greater than 0.');
        }
        return Number(amount.toFixed(2));
    }

    function normalizeSortOrder(value, fallback = 999) {
        const parsed = Number.parseInt(value, 10);
        return Number.isFinite(parsed) ? parsed : fallback;
    }

    function formatAmount(amount) {
        const value = Number(amount || 0);
        if (!Number.isFinite(value)) return '$0';
        return `$${Number.isInteger(value) ? value.toFixed(0) : value.toFixed(2)}`;
    }

    function buildPlanLabel(amount, label) {
        const cleanLabel = (label || '').trim();
        return cleanLabel || `${formatAmount(amount)} Plan`;
    }

    function getPlanAmount(plan) {
        return Number(plan.amount ?? plan.plan_amount ?? 0);
    }

    function getPlanLabel(plan) {
        return plan.plan_label || plan.label || buildPlanLabel(getPlanAmount(plan), '');
    }

    function getSortedPlans(plans) {
        return [...plans].sort((a, b) => {
            const sortA = Number(a.sort_order ?? 9999);
            const sortB = Number(b.sort_order ?? 9999);
            if (sortA !== sortB) return sortA - sortB;
            return getPlanAmount(a) - getPlanAmount(b);
        });
    }

    function getFilteredPlans() {
        const sorted = getSortedPlans(plansCache);
        if (!currentSearch) return sorted;

        return sorted.filter(plan => {
            const haystack = [
                getPlanLabel(plan),
                getPlanAmount(plan),
                plan.is_active === false ? 'inactive' : 'active',
                plan.id || ''
            ].join(' ').toLowerCase();

            return haystack.includes(currentSearch);
        });
    }

    function clearCreateForm() {
        planAmountInput.value = '';
        planLabelInput.value = '';
        planSortOrderInput.value = '';
        planActiveInput.checked = true;
    }

    function openEditPlanModal(plan) {
        if (!editPaymentPlanModal) return;

        editPlanId.value = plan.id || '';
        editPlanAmount.value = getPlanAmount(plan) || '';
        editPlanLabel.value = getPlanLabel(plan) || '';
        editPlanSortOrder.value = Number(plan.sort_order ?? '') || '';
        editPlanActive.checked = plan.is_active !== false;

        editPaymentPlanModal.show();
    }

    async function addPlan() {
        try {
            addPlanBtn.disabled = true;
            addPlanBtn.textContent = 'Saving...';

            const amount = normalizeAmount(planAmountInput.value);
            const label = buildPlanLabel(amount, planLabelInput.value);
            const sortOrder = normalizeSortOrder(planSortOrderInput.value, plansCache.length + 1);
            const isActive = planActiveInput.checked;

            await addDoc(collection(db, 'payment_plans'), {
                amount: amount,
                plan_amount: amount,
                plan_label: label,
                label: label,
                is_active: isActive,
                sort_order: sortOrder,
                created_at: serverTimestamp(),
                updated_at: serverTimestamp()
            });

            clearCreateForm();
            showMessage('Payment plan added successfully.', 'success');
        } catch (error) {
            console.error(error);
            showMessage(error.message || 'Failed to add payment plan.', 'danger');
        } finally {
            addPlanBtn.disabled = false;
            addPlanBtn.textContent = 'Add Plan';
        }
    }

    async function saveEditedPlan() {
        const id = editPlanId.value.trim();
        if (!id) {
            showMessage('Missing payment plan ID. Refresh and try again.', 'danger');
            return;
        }

        try {
            savePlanBtn.disabled = true;
            savePlanBtn.textContent = 'Saving...';

            const amount = normalizeAmount(editPlanAmount.value);
            const label = buildPlanLabel(amount, editPlanLabel.value);
            const sortOrder = normalizeSortOrder(editPlanSortOrder.value, 999);
            const isActive = editPlanActive.checked;

            await updateDoc(doc(db, 'payment_plans', id), {
                amount: amount,
                plan_amount: amount,
                plan_label: label,
                label: label,
                is_active: isActive,
                sort_order: sortOrder,
                updated_at: serverTimestamp()
            });

            showMessage('Payment plan updated successfully.', 'success');
            editPaymentPlanModal.hide();
        } catch (error) {
            console.error(error);
            showMessage(error.message || 'Failed to update payment plan.', 'danger');
        } finally {
            savePlanBtn.disabled = false;
            savePlanBtn.textContent = 'Save Changes';
        }
    }

    async function togglePlanStatus(id, shouldActivate) {
        try {
            await updateDoc(doc(db, 'payment_plans', id), {
                is_active: shouldActivate,
                updated_at: serverTimestamp()
            });
            showMessage(`Payment plan ${shouldActivate ? 'activated' : 'deactivated'} successfully.`, 'success');
        } catch (error) {
            console.error(error);
            showMessage(error.message || 'Failed to update payment plan status.', 'danger');
        }
    }

    async function deletePlan(id, label) {
        if (!confirm(`Are you sure you want to delete this payment plan: ${label}?`)) return;

        try {
            await deleteDoc(doc(db, 'payment_plans', id));
            showMessage('Payment plan deleted successfully.', 'success');
        } catch (error) {
            console.error(error);
            showMessage(error.message || 'Failed to delete payment plan.', 'danger');
        }
    }

    async function seedDefaultPlans() {
        try {
            seedDefaultPlansBtn.disabled = true;
            seedDefaultPlansBtn.textContent = 'Seeding...';

            const defaults = [
                { amount: 5, label: '$5 Plan', sort_order: 1 },
                { amount: 10, label: '$10 Plan', sort_order: 2 }
            ];

            let createdCount = 0;
            for (const plan of defaults) {
                const exists = plansCache.some(item => getPlanAmount(item) === plan.amount);
                if (exists) continue;

                await addDoc(collection(db, 'payment_plans'), {
                    amount: plan.amount,
                    plan_amount: plan.amount,
                    plan_label: plan.label,
                    label: plan.label,
                    is_active: true,
                    sort_order: plan.sort_order,
                    created_at: serverTimestamp(),
                    updated_at: serverTimestamp()
                });
                createdCount++;
            }

            showMessage(createdCount ? `Seeded ${createdCount} default payment plan(s).` : 'Default $5 and $10 plans already exist.', 'success');
        } catch (error) {
            console.error(error);
            showMessage(error.message || 'Failed to seed default payment plans.', 'danger');
        } finally {
            seedDefaultPlansBtn.disabled = false;
            seedDefaultPlansBtn.textContent = 'Seed $5/$10';
        }
    }

    function renderPlans(plans) {
        if (!plans.length) {
            plansTableBody.innerHTML = `<tr><td colspan="7" class="text-center">No payment plans found.</td></tr>`;
            return;
        }

        let rows = '';
        plans.forEach(plan => {
            const amount = getPlanAmount(plan);
            const label = getPlanLabel(plan);
            const isActive = plan.is_active !== false;
            const statusHtml = isActive
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-secondary">Inactive</span>';

            rows += `
                <tr>
                    <td>
                        <div class="plan-label-text">${escapeHtml(label)}</div>
                        <div class="small text-muted plan-id-text">${escapeHtml(plan.id || '-')}</div>
                    </td>
                    <td><span class="plan-amount-pill">${escapeHtml(formatAmount(amount))}</span></td>
                    <td>${statusHtml}</td>
                    <td>${escapeHtml(plan.sort_order ?? '-')}</td>
                    <td>${escapeHtml(formatDateTime(plan.created_at))}</td>
                    <td>${escapeHtml(formatDateTime(plan.updated_at))}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary edit-plan-btn mb-1" data-id="${escapeHtml(plan.id)}">Edit</button>
                        <button class="btn btn-sm ${isActive ? 'btn-warning' : 'btn-success'} toggle-plan-btn mb-1" data-id="${escapeHtml(plan.id)}" data-active="${isActive ? '1' : '0'}">
                            ${isActive ? 'Deactivate' : 'Activate'}
                        </button>
                        <button class="btn btn-sm btn-danger delete-plan-btn mb-1" data-id="${escapeHtml(plan.id)}" data-label="${escapeHtml(label)}">Delete</button>
                    </td>
                </tr>
            `;
        });

        plansTableBody.innerHTML = rows;

        document.querySelectorAll('.edit-plan-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const plan = plansCache.find(item => item.id === id);
                if (!plan) {
                    showMessage('Payment plan not found in the current list. Refresh and try again.', 'warning');
                    return;
                }
                openEditPlanModal(plan);
            });
        });

        document.querySelectorAll('.toggle-plan-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const isActive = this.getAttribute('data-active') === '1';
                togglePlanStatus(id, !isActive);
            });
        });

        document.querySelectorAll('.delete-plan-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const label = this.getAttribute('data-label') || 'Payment Plan';
                deletePlan(id, label);
            });
        });
    }

    planSearchInput.addEventListener('input', () => {
        currentSearch = planSearchInput.value.trim().toLowerCase();
        renderPlans(getFilteredPlans());
    });

    addPlanBtn.addEventListener('click', addPlan);
    savePlanBtn.addEventListener('click', saveEditedPlan);
    seedDefaultPlansBtn.addEventListener('click', seedDefaultPlans);

    onSnapshot(collection(db, 'payment_plans'), (snapshot) => {
        plansCache = snapshot.docs.map(docSnap => ({ id: docSnap.id, ...docSnap.data() }));
        renderPlans(getFilteredPlans());
    }, (error) => {
        console.error(error);
        plansTableBody.innerHTML = `<tr><td colspan="7" class="text-center text-danger">Failed to load payment plans.</td></tr>`;
        showMessage(error.message || 'Failed to load payment plans.', 'danger');
    });
</script>

<?php
include('includes/footer.php');
?>
