// ============================================================
// ACCOUNT
// ============================================================

// -----
// Navigation entre les sections du compte
// -----

async function readAccount(event) {

    const link = event.target.closest('a');

    if (!link) {
        return;
    }

    event.preventDefault();

    const currentActive =
        document.querySelector('.account-menu a.active');

    if (currentActive) {
        currentActive.classList.remove('active');
    }

    link.classList.add('active');

    try {

        const response = await fetch(link.href);

        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }

        const accountText = await response.text();

        const accountContent =
            document.getElementById('account-content');

        if (accountContent) {
            accountContent.innerHTML = accountText;
        }

    } catch (error) {

        console.error('Erreur navigation account :',error);
    }
}


// ============================================================
// PANIER
// ============================================================

// -----
// Modification de la quantité
// -----

async function updateCart(form, quantity) {

    const productIdInput =
        form.querySelector('input[name="product_id"]');

    if (!productIdInput) {
        return;
    }

    const data = new URLSearchParams();

    data.append('product_id', productIdInput.value);
    data.append('quantity', quantity);

    const response = await fetch(form.action, {
        method: 'POST',
        body: data
    });

    if (!response.ok) {
        throw new Error(`HTTP error: ${response.status}`);
    }

    const result = await response.json();

    console.log('Réponse updateCart :', result);

    const productRow =document.querySelector(`tr[data-product-id="${productIdInput.value}"]`);

    if (productRow) {

        const product =result.cart.products.find( product => Number(product.id) === Number(productIdInput.value));

        if (product) {

            const productTotal = productRow.querySelector('.product-total');

            if (productTotal) {

                productTotal.textContent =`${Number(product.total_by_product).toFixed(2)} €`;
            }
        }
    }

    const accountTableCount = document.getElementById('account_table_count');

    if (accountTableCount) {

        accountTableCount.textContent =`${result.cart_count} article(s)`;
    }

    const cartTotal = document.getElementById('cart_total');

    if (cartTotal) {

        cartTotal.textContent = `${Number(result.cart.total).toFixed(2)} €`;
    }

    return result;
}


// -----
// Gestion des boutons + / -
// et du champ quantité
// -----

async function changeQuantity(event) {

    if (event.type === 'click') {

        const button =
            event.target.closest('.quantity-plus, .quantity-minus');

        if (!button) {
            return;
        }

        const form = button.closest('form');

        if (!form) {
            return;
        }

        const input = form.querySelector('.quantity-input');

        if (!input) {
            return;
        }

        let quantity = Number(input.value);

        if (button.classList.contains('quantity-plus')) {

            quantity++;

        } else {

            if (quantity <= 1) {
                return;
            }

            quantity--;
        }

        input.value = quantity;

        try {

            await updateCart(form, quantity);

        } catch (error) {

            console.error('Erreur modification quantité :', error);
        }

        return;
    }


    if (event.type === 'change') {

        const input =
            event.target.closest('.quantity-input');

        if (!input) {
            return;
        }

        const form =
            input.closest('form');

        if (!form) {
            return;
        }

        let quantity =
            Number(input.value);

        if (quantity < 1) {
            quantity = 1;
            input.value = 1;
        }

        try {

            await updateCart(
                form,
                quantity
            );

        } catch (error) {

            console.error(
                'Erreur modification quantité :',
                error
            );
        }
    }
}


// -----
// Suppression d'un produit du panier
// -----

async function removeProductFromCart(event) {

    event.preventDefault();

    const form = event.target.closest('.cart-remove-form');

    if (!form) {
        return;
    }

    const productIdInput = form.querySelector('input[name="product_id"]');

    if (!productIdInput) {
        return;
    }

    const productId = productIdInput.value;

    const data =  new URLSearchParams();

    data.append('product_id', productId);

    try {

        const response =
            await fetch(form.action, {
                method: 'POST',
                body: data
            });

        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }

        const result =await response.json();

        console.log('Réponse removeProductFromCart :', result);

        if (!result.success) {
            return;
        }

        const productRow = document.querySelector(`tr[data-product-id="${productId}"]`);

        if (productRow) {
            productRow.remove();
        }

        const accountTableCount =document.getElementById('account_table_count');

        if (accountTableCount) {

            accountTableCount.textContent = `${result.cart_count} article(s)`;
        }

        const cartTotal = document.getElementById('cart_total');

        if (cartTotal) {

            cartTotal.textContent = `${Number(result.cart.total).toFixed(2)} €`;
        }

    } catch (error) {

        console.error('Erreur suppression produit panier :', error);
    }
}


// ============================================================
// FAVORIS
// ============================================================

// -----
// Suppression d'un favori
// -----

async function removeFavorite(event) {

    event.preventDefault();

    const form = event.target.closest('.favorite-remove-form');

    if (!form) {
        return;
    }

    const productIdInput = form.querySelector('input[name="product_id"]');

    if (!productIdInput) {
        return;
    }

    const productId =productIdInput.value;

    const data =new URLSearchParams();

    data.append('product_id',productId);

    try {

        const response =
            await fetch(form.action, {
                method: 'POST',
                body: data
            });

        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }

        const result = await response.json();
 
        console.log('Réponse removeFavorite :', result);

        if (!result.success) {
            return;
        }

        const productRow =document.querySelector(`tr[data-product-id="${productId}"]`);

        if (productRow) {
            productRow.remove();
        }

    } catch (error) {

        console.error('Erreur suppression favori :', error);
    }
}


// ============================================================
// LISTES
// ============================================================

// -----
// Suppression d'une liste
// -----

async function deleteList(event) {

    event.preventDefault();

    const form = event.target.closest('.list-delete-form');

    if (!form) {
        return;
    }

    const listIdInput =
        form.querySelector('input[name="list_id"]');

    if (!listIdInput) {
        return;
    }

    const listId = listIdInput.value;

    const data = new URLSearchParams();

    data.append('list_id', listId);

    try {

        const response =
            await fetch(form.action, {
                method: 'POST',
                body: data
            });

        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }

        const result = await response.json();

        console.log('Réponse deleteList :', result);

        if (!result.success) {
            return;
        }

        const listBox = form.closest('.list-box');

        if (listBox) {
            listBox.remove();
        }

    } catch (error) {

        console.error('Erreur suppression liste :', error);
    }
}


// -----
// Création d'une liste
// -----

async function createList(event) {

    event.preventDefault();

    const form = event.target.closest('.list-create-form');

    if (!form) {
        return;
    }

    const nameInput = form.querySelector('input[name="name"]');

    if (!nameInput) {
        return;
    }

    const name = nameInput.value.trim();

    if (name === '') {
        return;
    }

    const data =
        new URLSearchParams();

    data.append('name', name);

    try {

        const response =
            await fetch(form.action, {
                method: 'POST',
                body: data
            });

        if (!response.ok) {
            throw new Error(`HTTP error: ${response.status}`);
        }

        const result = await response.json();

        console.log('Réponse createList :', result);

        if (!result.success) {
            return;
        }

        const listsUrl = form.dataset.listsUrl;

        if (!listsUrl) {
            return;
        }

        const listsResponse = await fetch(listsUrl);

        if (!listsResponse.ok) {
            throw new Error(`HTTP error: ${listsResponse.status}`);
        }

        const listsText =await listsResponse.text();

        const accountContent = document.getElementById('account-content');

        if (accountContent) {
            accountContent.innerHTML = listsText;
        }

    } catch (error) {

        console.error('Erreur création liste :', error);
    }
}


// ============================================================
// EVENTS AJAX
// ============================================================

// -----
// Navigation account
// -----

const accountMenu =document.querySelector('.account-menu');

if (accountMenu) {

    accountMenu.addEventListener('click', readAccount);
}


// -----
// Panier
// -----

document.addEventListener('click', changeQuantity);

document.addEventListener('change', changeQuantity);


// ============================================================
// FORMULAIRES AJAX
// ============================================================

document.addEventListener(
    'submit',
    function (event) {

        const form = event.target;

        // Suppression favori
        if (
            form.matches('.favorite-remove-form')
        ) {

            removeFavorite(event);
            return;
        }

        // Suppression d'une liste
        if (
            form.matches('.list-delete-form')
        ) {

            deleteList(event);
            return;
        }

        // Création d'une liste
        if (
            form.matches('.list-create-form')
        ) {

            createList(event);
            return;
        }

        // Suppression produit panier
        if (
            form.matches('.cart-remove-form')
        ) {

            removeProductFromCart(event);
            return;
        }
    }
);

