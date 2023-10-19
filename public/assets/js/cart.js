document.addEventListener("DOMContentLoaded", function () {
    const cartButtons = document.querySelectorAll('.cart-button');

    cartButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const cartUrl = this.getAttribute('href');
            const productId = this.getAttribute('data-id'); // Récupérez l'ID du produit

            const modal = new bootstrap.Modal(document.getElementById('cartModal'));
            modal.show();

            const confirmButton = document.getElementById('confirmCart');
            const cancelCartButton = document.getElementById('cancelCart');

            confirmButton.addEventListener('click', function () {
                window.location.href = cartUrl;
            });

            cancelCartButton.addEventListener('click', function () {
                fetch(cartUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ productId: productId }), // Envoyez l'ID du produit
                }).then(response => {
                    if (response.status === 200) {
                        const flashMessages = document.getElementById('flash-messages');
                        flashMessages.innerHTML = '<div class="alert alert-success" role="alert">Le produit a été ajouté au panier avec succès</div>';
                    }
                });
                modal.hide();
            });
        });
    });
});