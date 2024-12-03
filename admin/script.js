document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('editModal');
    const resetModal = document.getElementById('resetModal');
    const closeModal = document.querySelector('.close');
    const closeResetModal = document.querySelector('.close-reset');
    const editButtons = document.querySelectorAll('.edit-btn');
    const resetPasswordButton = document.getElementById('resetPassword');
    const statusField = document.getElementById('status');
    const activeButton = document.getElementById('activeButton');
    const lockButton = document.getElementById('lockButton');
    const resetUserId = document.getElementById('reset_user_id');
    const cancelResetButton = document.querySelector('.cancel-reset');

    // Open edit modal and populate fields
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('user_id').value = button.dataset.id;
            document.getElementById('name').value = button.dataset.name;
            document.getElementById('email').value = button.dataset.email;
            statusField.value = button.dataset.status;

            modal.style.display = 'flex';
        });
    });

    // Close edit modal
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Open reset modal
    resetPasswordButton.addEventListener('click', () => {
        resetUserId.value = document.getElementById('user_id').value;
        modal.style.display = 'none';
        resetModal.style.display = 'flex';
    });

    // Close reset modal
    closeResetModal.addEventListener('click', () => {
        resetModal.style.display = 'none';
    });

    cancelResetButton.addEventListener('click', () => {
        resetModal.style.display = 'none';
    });

    // Update status
    activeButton.addEventListener('click', () => {
        const userId = document.getElementById('user_id').value;
        updateStatus(userId, 1); // Set status to active
    });

    lockButton.addEventListener('click', () => {
        const userId = document.getElementById('user_id').value;
        updateStatus(userId, 0); // Set status to locked
    });

    // Function to update status via AJAX
    function updateStatus(userId, status) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // If successful, show an alert and update the status field
                alert(xhr.responseText); // Success message from PHP
                statusField.value = status;
            }
        };
        xhr.send('user_id=' + userId + '&status=' + status);
    }

    // Close modal on outside click
    window.addEventListener('click', event => {
        if (event.target == modal) {
            modal.style.display = 'none';
        } else if (event.target == resetModal) {
            resetModal.style.display = 'none';
        }
    });
});
