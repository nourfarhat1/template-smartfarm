// Fonction pour charger les informations du panier depuis le localStorage
function loadCart() {
    const cartContent = document.getElementById('cart-content');
    const cartData = JSON.parse(localStorage.getItem('cart'));

    // ken el panier vide
    if (!cartData || cartData.quantity === 0) {
        cartContent.innerHTML = "<p>Votre panier est vide.</p>";
        return;
    }

    // Affichi les detail mta3 el produi
    const { productName, quantity, pricePerItem } = cartData;
    const total = (pricePerItem * quantity) + 7; // Frais de livraison de 7 dt

    cartContent.innerHTML = `
        <div class="product-details">
            <div class="product-name">${productName}
                        <img src="trash.png" alt="Supprimer" style="width: 30px; height: 30px; class="trash-icon"  onclick="removeFromCart() ">
                    </div>
            <div class="product-quantity">
                <button onclick="decreaseQuantity()">-</button>
                <input type="text" id="quantity" value="${quantity}" readonly>
                <button onclick="increaseQuantity()">+</button>
            </div>
            <div class="product-price">${pricePerItem * quantity} dt</div>
            
        </div>
        
        <div class="billing">
            <h2 class="billing-title">Facturation</h2>
            <div class="billing-item">
                <span>${productName}</span>
                <span id="billing-quantity">${quantity}</span>
            </div>
            <div class="billing-item">
                Frais de livraison ................ 7 dt
            </div>
            <div class="billing-item">
                Total ............................. <span id="total-price">${total}</span> dt
            </div>
            <button class="checkout-button">Acheter maintenant</button>
        </div>
    `;
}

//supprimer le produit mel panier
function removeFromCart() {
    // Retirer l'élément du localStorage
    localStorage.removeItem('cart');
    
    // mettre à jour el contenu
    loadCart();
}

// mettre à jour la section de facturation m3a el quantité
function updateBilling(quantity) {
    const productPrice = 43;
    const shippingFee = 7;
    const totalPrice = (productPrice * quantity) + shippingFee;

    document.getElementById('billing-quantity').textContent = quantity;
    document.getElementById('total-price').textContent = totalPrice;
    
    // Mettre à jour la quantité dans le localStorage
    const cartData = JSON.parse(localStorage.getItem('cart'));
    cartData.quantity = quantity;
    localStorage.setItem('cart', JSON.stringify(cartData));
}

// augmenter la quantité
function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value, 10);
    quantityInput.value = ++quantity;
    updateBilling(quantity);
}

// diminuer la quantité
function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value, 10);
    if (quantity > 1) {
        quantityInput.value = --quantity;
        updateBilling(quantity);
    }
}

window.onload = loadCart;
