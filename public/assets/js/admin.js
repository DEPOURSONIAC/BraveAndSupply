document.addEventListener('DOMContentLoaded', function () {
    // Toggle sidebar mobile
    var trigger = document.querySelector('.admin-menu-trigger');
    if (trigger) {
        trigger.addEventListener('click', function () {
            document.body.classList.toggle('admin-sidebar-open');
        });
    }

    // Confirm the removing
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            var message = el.getAttribute('data-confirm');
            if (!window.confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Open the modals (append/edit product)
    document.querySelectorAll('[data-modal-open]').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            var modal = document.getElementById(trigger.getAttribute('data-modal-open'));
            if (!modal) return;

            // Pre append the data on the forms for editing data
            if (modal.id === 'modal-edit-product') {
                modal.querySelector('#edit-id').value = trigger.dataset.productId || '';
                modal.querySelector('#edit-name').value = trigger.dataset.productName || '';
                modal.querySelector('#edit-description').value = trigger.dataset.productDescription || '';
                modal.querySelector('#edit-price').value = trigger.dataset.productPrice || '';
                modal.querySelector('#edit-quantity').value = trigger.dataset.productStock || '';
            }

            modal.classList.add('active');
        });
    });

    // Close the modals
    document.querySelectorAll('[data-modal-close]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            btn.closest('.admin-modal').classList.remove('active');
        });
    });

    document.querySelectorAll('.admin-modal').forEach(function (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) modal.classList.remove('active');
        });
    });
});
