document.addEventListener("DOMContentLoaded", function () { // Get all the delete buttons
    const deleteButtons = document.querySelectorAll('.delete-button');

    // Add a click event listener to each delete button
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const deleteUrl = this.getAttribute('href');
            const categoryId = this.getAttribute('data-id');

            // Use Bootstrap modal for confirmation
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();

            // Handle confirmation
            const confirmButton = document.getElementById('confirmDelete');
            confirmButton.addEventListener('click', function () {
                window.location.href = deleteUrl;
            });

            // Handle cancellation (close the modal)
            const cancelButton = document.getElementById('cancelDelete');
            cancelButton.addEventListener('click', function () {
                modal.hide();
            });
        });
    });
});