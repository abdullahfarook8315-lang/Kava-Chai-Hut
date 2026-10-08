let cart = {};
let cartTotal = 0;

function addToCart(itemName) {
    if (!cart[itemName]) {
        cart[itemName] = 0;
    }

    cart[itemName]++;
    cartTotal += getPrice(itemName);

    updateCartDisplay();
}

function getPrice(name) {
    if (name === "Kava Chai") return 130;
    if (name === "ThanthooriChai") return 200;
    if (name === "Choclate Milkshak") return 450;
    if (name === "Banana Milkshak") return 450;
    if (name === "vanila Milkshak") return 450;
    if (name === "Oreo Milkshak") return 450;
    if (name === "Browni Milkshak") return 450;
    if (name === "Submarine") return 250;
    if (name === "Burgur") return 250;
    if (name === "Shawarma") return 450;

    return 0;
}

function updateCartDisplay() {
    let cartItems = document.getElementById("cart-items");
    let total = document.getElementById("cart-total");
    let cartCount = document.getElementById("cart-count");

    cartItems.innerHTML = "";

    let itemCount = 0;

    for (let item in cart) {
        itemCount += cart[item];

        let itemDiv = document.createElement("div");

        let itemText = document.createElement("span");
        itemText.innerText = item + " ";

        let minusButton = document.createElement("button");
        minusButton.innerText = "−";

        let quantityText = document.createElement("span");
        quantityText.innerText = " " + cart[item] + " ";

        let plusButton = document.createElement("button");
        plusButton.innerText = "+";

        minusButton.onclick = function () {
            cart[item]--;
            cartTotal -= getPrice(item);

            if (cart[item] <= 0) {
                delete cart[item];
            }

            updateCartDisplay();
        };

        plusButton.onclick = function () {
            cart[item]++;
            cartTotal += getPrice(item);

            updateCartDisplay();
        };

        itemDiv.appendChild(itemText);
        itemDiv.appendChild(minusButton);
        itemDiv.appendChild(quantityText);
        itemDiv.appendChild(plusButton);

        cartItems.appendChild(itemDiv);
    }

    cartCount.innerText = "🛒 Cart: " + itemCount;
    total.innerText = "Total: " + cartTotal + " LKR";

    if (itemCount === 0) {
        cartItems.innerHTML = "<p>Your cart is empty.</p>";
    }
}

function showCheckout() {
    let form = document.getElementById("checkout-form");

    form.style.display = "block";
}

function placeOrder() {
    let name = document.getElementById("customer-name").value;
    let phone = document.getElementById("customer-phone").value;
    let address = document.getElementById("customer-address").value;

    if (Object.keys(cart).length === 0) {
        alert("Your cart is empty. Please add items first.");
        return;
    }

    if (name === "" || phone === "" || address === "") {
        alert("Please fill all details.");
        return;
    }
    let orderId = "KCH" + Math.floor(1000 + Math.random() * 9000);
    alert(
        "🎉 Order Placed Successfully!\n\n" +
        "Order ID: " + orderId + "\n" +
        "Thank you, " + name + "!\n" +
        "Your order has been received.\n\n" +
        "Total: " + cartTotal + " LKR"
    );

    cart = {};
    cartTotal = 0;
    updateCartDisplay();

    document.getElementById("checkout-form").style.display = "none";
}