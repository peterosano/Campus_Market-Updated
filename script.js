// ==========================
// Browse Products Button
// ==========================

const browseBtn = document.getElementById("browseBtn");

browseBtn.addEventListener("click", function (event) {

    event.preventDefault();

    document.getElementById("products").scrollIntoView({
        behavior: "smooth"
    });

});


// ==========================
// Shopping Cart
// ==========================

let cart = 0;

// Select the cart number
const cartCount = document.getElementById("cartCount");

// Select all Add to Cart buttons
const addCartButtons = document.querySelectorAll(".addCart");


// Add click event to every button
addCartButtons.forEach(function(button){

    button.addEventListener("click", function(){

        cart++;

        cartCount.textContent = cart;

        alert("Item added to cart!");

    });

});
// ==========================
// Product Search
// ==========================

const searchInput = document.getElementById("searchInput");

const products = document.querySelectorAll(".product");


searchInput.addEventListener("keyup", function(){

    let searchValue = searchInput.value.toLowerCase();


    products.forEach(function(product){

        let productName = product
        .querySelector(".productName")
        .textContent
        .toLowerCase();


        if(productName.includes(searchValue)){

            product.style.display = "block";

        } else {

            product.style.display = "none";

        }

    });

});
// ==========================
// Product Details Modal
// ==========================


const detailButtons = document.querySelectorAll(".viewDetails");


detailButtons.forEach(function(button){


button.addEventListener("click", function(){


let name = button.dataset.name;

let description = button.dataset.description;

let price = button.dataset.price;

let image = button.dataset.image;



document.getElementById("modalTitle").textContent = name;

document.getElementById("modalDescription").textContent = description;

document.getElementById("modalPrice").textContent = price;

document.getElementById("modalImage").src = image;



let modal = new bootstrap.Modal(
document.getElementById("productModal")
);


modal.show();


});


});
// ==========================
// Sell Item Form
// ==========================


const sellForm = document.getElementById("sellForm");


if(sellForm){


sellForm.addEventListener("submit", function(event){


event.preventDefault();


let name = document.getElementById("productName").value;


alert(name + " has been submitted successfully!");



});


}
// ==========================
// Register Form
// ==========================

const registerForm = document.getElementById("registerForm");


if(registerForm){

registerForm.addEventListener("submit", function(event){

event.preventDefault();


let name = document.getElementById("fullName").value;


alert("Welcome " + name + "! Your account has been created.");

});


}



// ==========================
// Login Form
// ==========================


const loginForm = document.getElementById("loginForm");


if(loginForm){


loginForm.addEventListener("submit", function(event){


event.preventDefault();


alert("Login successful!");


});


}