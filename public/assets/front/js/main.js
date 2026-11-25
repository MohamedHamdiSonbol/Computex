window.addEventListener('pageshow', function (event) {
    // Check if the page was loaded from the browser's back/forward cache
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
        // Option A: Just reload the page automatically to get fresh server data
        const cartCountSpan = document.getElementById('cart-count');
        const cartCountSpan2 = document.getElementById('cart-count2');
        // console.log(cartCountSpan);
        fetch('/cart/refresh', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                // console.log(data.cartCount)
                if (data.status === 'success') {
                    cartCountSpan.innerText =  data.cartCount;
                    cartCountSpan2.innerText =  data.cartCount;
                }
            }).catch(error => console.error('Error:', error));

        // window.location.reload();

        // Option B: If you prefer an API approach, you could trigger an AJAX
        // request here to fetch the actual cart count and update the HTML element.
    }
});

(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 300);
    };
    spinner(0);


    // Initiate the wowjs
    window.wow = new WOW();
    window.wow.init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.nav-bar').addClass('sticky-top shadow-sm');
        } else {
            $('.nav-bar').removeClass('sticky-top shadow-sm');
        }
    });

/*
    // Hero Header carousel
    $(".header-carousel").owlCarousel({
        items: 1,
        autoplay: true,
        smartSpeed: 2000,
        center: false,
        dots: false,
        loop: true,
        margin: 0,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],

        // This line dynamically turns on RTL if the HTML tag has dir="rtl"
        rtl: $('html').attr('dir') === 'rtl',
    });*/


    // Hero Header carousel
    $(".header-carousel").owlCarousel({
        items: 1,
        autoplay: true,
        smartSpeed: 500, // Reduced speed for a smoother, quicker fade transition
        center: false,
        dots: false,
        loop: true,
        margin: 0,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        rtl: $('html').attr('dir') === 'rtl',

        // --- ADD THESE TWO LINES FOR THE FADE EFFECT ---
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
    });

    // ProductList carousel
    $(".productList-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        dots: false,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="fas fa-chevron-left"></i>',
            '<i class="fas fa-chevron-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:2
            },
            1200:{
                items:3
            }
        }
    });

    // ProductList categories carousel
    $(".productImg-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        dots: false,
        loop: true,
        items: 1,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });


    // Single Products carousel
    $(".single-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        dots: true,
        dotsData: true,
        loop: true,
        items: 1,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });


    // ProductList carousel
    $(".related-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        dots: false,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="fas fa-chevron-left"></i>',
            '<i class="fas fa-chevron-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });



    // Product Quantity
    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });



   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 0, 'swing');
        return false;
    });

    // Listen for Bootstrap tab shown event
    $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
        // When any tab is shown, tell WOW to refresh
        if (window.wow) {
            window.wow.sync();
            window.dispatchEvent(new Event('scroll'));
        }
    });

})(jQuery);


///////////////////////////////////////////////////////////////////////////////////////
//                                     JavaScript                                    //
//////////////////////////////////////////////////////////////////////////////////////
let cache = {};
    document.addEventListener("click", function (event) {
        // event.preventDefault();
        let newArrivalsBtn = event.target.closest("#newArrivalsBtn");
        if(newArrivalsBtn){
            let newArrivalsContainer = document.getElementById("newArrivalsContainer");
            let url = newArrivalsBtn.getAttribute('data-url');
            getNewArrivalProducts(url, newArrivalsContainer);
        }
    })

function getNewArrivalProducts(url, selectElement) {
    if (cache[url]) {
        showData(cache[url], selectElement);
        return;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            cache[url] = data; // Save to cache
            showData(data, selectElement);
        });
}

function showData(data, selectInput) {
    let fullHtml ="";
    let width = selectInput.offsetWidth;
    // console.log(selectInput.offsetWidth);
    selectInput.innerHTML = "";
    data.forEach(item => {
        // console.log(item);
        fullHtml += `
                            <div class="col-md-6 col-lg-4  ${width >= 1300? 'col-xl-3' : ''} " >
                                <div class="product-item rounded wow fadeInUp" data-wow-delay="0.1s" style="visibility: hidden;">

                                    <div class="product-item-inner border rounded">
                                        <div class="product-item-inner-item">
                                            <img src="${item.image_url}" class="img-fluid w-100 rounded-top" alt="" >
                                            ${item.discount_amount ? `<div class="product-sale text-center">${item.discount_percentage} OFF</div>` : ''}
                                            ${item.new ? `<div class="product-new">${item.new}</div>` : ''}
                                            <div class="product-details ">
                                                <a href="http://computex.test/products/${item.slug}" class="stretched-link"><i class="fa fa-eye fa-1x"></i></a>
                                            </div>
                                        </div>


                                         <div class="row m-0 rounded-bottom p-0 ">

                                            <div class="row m-0 mt-1 p-0 justify-content-between">
                                                <a href="http://computex.test/categories/${item.category}" class="col-md-7 small">${item.category}</a>
                                                <a href="http://computex.test/brands/${item.brand}" class="col-md-4 small text-end">${item.brand}</a>
                                            </div>

                                            <div class="row m-0 mt-1 p-0 ">
                                                <a href="http://computex.test/products/${item.slug}" class="col-md-12 h5">${item.name}</a>
                                            </div>

                                            <div class="row m-0 mt-1 p-0 justify-content-start">
                                                <strong class="col-md-5 pe-1 text-primary ">${item.final_price} L.e</strong>
                                                ${item.discount_amount ? `<del class="col-md-4 p-0 small">${item.price} L.e</del>` : ''}
                                            </div>

                                             <div class="row  mt-2 mb-2 ms-0 align-items-center">
                                                ${item.colors.length > 0 ?
                                                `  <p class="col-md-3 p-0 m-0">Colors: </p>
                                                   <div class="col-md-9 row color-container">
                                                   ${item.colors.map(color =>
                                                    ` <div class="rounded-circle color_btn col-md-2 me-2"
                                                             style="background-color: ${color.name}; width: 20px; height: 20px; cursor: pointer;"
                                                             data-colorId="${color.id}">
                                                        </div>
                                                    `).join('')}
                                                   </div> `
                                               : ''}
                                             </div>

                                             <div class="row col-md-12 mt-2 mb-2 ms-0 align-items-center">
                                               <small class="p-0">Available: <strong class="${item.quantity < 5 ? 'text-danger' : 'text-success'}">${item.quantity} items in stock</strong></small>
                                             </div>

                                         </div>

                                    </div>

                                    <div
                                        class="product-item-add border border-top-0 rounded-bottom text-center p-4 pt-0">
                                       <a href="#" class=" btn btn-primary border-secondary rounded-pill py-2 px-4 mb-4 position-relative z-1 js-add-to-cart"
                                               data-url="/cart/add/${item.product_id}">
                                               <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                                       </a>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex">
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star text-primary"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <div class="d-flex">
                                                <a href="#"
                                                   class="text-primary d-flex align-items-center justify-content-center me-3"><span
                                                        class="rounded-circle btn-sm-square border"><i
                                                            class="fas fa-random"></i></i></a>
                                                <a href="#"
                                                   class="text-primary d-flex align-items-center justify-content-center me-0"><span
                                                        class="rounded-circle btn-sm-square border"><i
                                                            class="fas fa-heart"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        `;
    });

    selectInput.innerHTML = fullHtml;
    if (window.wow) {
        window.wow.sync();
    }
    window.dispatchEvent(new Event('scroll'));
    // if (typeof WOW !== 'undefined') {
    //     window.wow.sync();
    // }

}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
const searchBtn = document.getElementById("search-btn");
const searchContainer = document.getElementById("search-container");


if(searchBtn){
    searchBtn.addEventListener("click", function (event) {
        event.preventDefault();
        let url = event.target.getAttribute('href');
        let inputVal = searchBtn.closest('div').querySelector('#search-field').value;
        let categoryId = searchBtn.closest('div').querySelector('#category-id').value ?? null;
        console.log(inputVal);
        console.log(categoryId);
        if(inputVal && inputVal.trim().length !== 0){
            // console.log(url)
            getSearchedProducts(url, inputVal, categoryId, searchContainer);
        }
        // console.log(url);
    })
}
function getSearchedProducts(url, inputVal, categoryId, selectElement) {

    const params = new URLSearchParams({
        searchTerm: inputVal,
        categoryId: categoryId
    });

    // Append params to the base URL
    const finalUrl = `${url}?${params.toString()}`;

    fetch(finalUrl, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log(data)
            showData(data, selectElement);
        });
}////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// document.addEventListener("change", function (event) {
//     const option = event.target.closest('#brand-products, #category-products, #searched-products');
//     if(!option) return;
//     if(option){
//         event.preventDefault();
//
//         // if (event.target.classList.contains('attribute-checkbox')) {
//             // 1. Find all checkboxes that are currently checked
//             const checkedBoxes = document.querySelectorAll('.attribute-checkbox:checked');
//             // 2. Map their values into an array, e.g., [1, 8]
//             const selectedIds = Array.from(checkedBoxes).map(box => box.value);
//             // 3. Get your filter submission endpoint URL
//             // const url = e.target.dataset.url;
//            console.log(checkedBoxes);
//            console.log(selectedIds);
//         // }
//
//         const productContainer = document.getElementById("search-container");
//             getSortedProducts(option.dataset.url, option.value, productContainer)
//     }
// })
//
// function getSortedProducts(url, selectedVal, selectElement) {
//     const params = new URLSearchParams({
//         sortType: selectedVal
//     });
//
//     // Append params to the base URL
//     const finalUrl = `${url}?${params.toString()}`;
//
//     fetch(finalUrl, {
//         method: 'GET',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//             'X-Requested-With': 'XMLHttpRequest'
//         }
//     })
//         .then(response => response.json())
//         .then(data => {
//             console.log(data.products)
//             if(data.status === 'success' && data.products) {
//                 showData(data.products, selectElement);
//             }
//         });
// }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

let cache2 = {};
    document.addEventListener("click", function (event) {
        // event.preventDefault();
        let topSellingBtn = event.target.closest("#topSellingBtn");
        if(topSellingBtn){
            let topSellingContainer = document.getElementById("topSellingContainer");
            let url = topSellingBtn.getAttribute('data-url');
            getTopSellingProducts(url, topSellingContainer);
        }
        // console.log(topSellingBtn);
        // console.log(topSellingContainer);
        // console.log(url);
    })
function getTopSellingProducts(url, selectElement) {
    if (cache2[url]) {
        showData(cache2[url], selectElement);
        return;
    }
    // console.log(url);
    fetch(url)
        .then(response => response.json())
        .then(data => {
            cache2[url] = data; // Save to cache
            console.log(data)
            showData(data, selectElement);
        })
        .catch(error => alert(error.message));
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.addEventListener('click', function (event) {
    const colorBtn = event.target.closest('.color_btn');
    if(colorBtn){
        const btn = colorBtn.closest('div.product-data-container').querySelector('a.js-add-to-cart');
        btn.dataset.colorid = colorBtn.dataset.colorid;

        const allColors = colorBtn.parentElement.querySelectorAll('.color_btn');
        allColors.forEach(item =>{
            item.classList.remove('border', 'border-3', 'border-dark', 'shadow-lg', 'btn-lg');
        })
        colorBtn.classList.add('border', 'border-3', 'border-dark', 'shadow-lg', 'btn-lg', );
        // console.log(colorContainer);
    }
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.addEventListener('click', function (event) {
    const btn = event.target.closest('.js-add-to-cart');
    if (btn) {
        const btnColorId = btn.dataset.colorid;
        // let shit = btn.closest('div.product-data-container');
        const itemsQuantity = btn.closest('div.product-data-container').querySelector('input.items-quantity')?.value?? 1;
        // console.log(itemsQuantity);
        const cartCountSpan = document.getElementById('cart-count');
        const cartCountSpan2 = document.getElementById('cart-count2');
        console.log(cartCountSpan);
        // console.log(itemsQuantity);
// return;

        event.preventDefault(); // Stop the link from jumping
        const url = btn.dataset.url;
        // 2. Perform the AJAX call
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({quantity: itemsQuantity?? 1,
                                        color_id: btnColorId})
        })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                if(data.status === 'success'){
                    console.log(cartCountSpan)
                    cartCountSpan.innerHTML = data.cartCount;
                    cartCountSpan2.innerHTML = data.cartCount;
                }

                alert(data.message);
            })
            .catch(error => alert(error.message));
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.addEventListener('click', function (event) {
    const couponBtn = event.target.closest('#coupon-btn');
    if(!couponBtn){return;}
    event.preventDefault();
    const couponInput = couponBtn.closest('div#coupon-container').querySelector('#coupon-input').value;
    const couponParent = document.getElementById('coupon-parent');
    couponParent.innerHTML = '';
    console.log(couponParent);
// return;
    if (couponInput) {
        const url = couponBtn.href;

        // 2. Perform the AJAX call
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({couponVal: couponInput })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log(data);
                    const finalTotal = document.getElementById("cart-final-total");
                    const subTotalContainer = document.getElementById("subTotal");
                    const container = document.createElement("div");
                    container.classList.add("coupon", 'd-flex', 'justify-content-between');
                    const coupon = document.createElement("div");
                    coupon.classList.add('mb-0', 'me-4');
                    coupon.textContent = `Coupon:`;

                    const couponName = document.createElement("small");
                    // couponName.classList.add('mb-0', 'me-4');
                    couponName.classList.add('mb-0');
                    couponName.textContent = `( ${data.couponName} )`;

                    const discount = document.createElement("h6");
                    discount.classList.add('mb-0');
                    discount.textContent = `${data.discount}`;

                    coupon.appendChild(couponName);
                    container.appendChild(coupon);
                    container.appendChild(discount);
                    couponParent.appendChild(container);

                    // subTotalContainer.after(container);

                    console.log(data.discount);
                    console.log(data.finalTotal);
                    finalTotal.innerHTML = data.finalTotal;
                } else{
                    // alert('Something went wrong');
                }
                // cartCountSpan.innerHTML = data.cartCount;
                // alert(data.message);
            })
            .catch(error => console.error('Error:', error));
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

document.addEventListener('click', function (event) {
    const btn = event.target.closest('.increase-items, .decrease-items');
    if (!btn) return; // Exit early if we didn't click a quantity button

    event.preventDefault();

// 1. Find elements relative to the clicked button
    const container = btn.closest('.cart-btn-container');
    const row = btn.closest('tr');
    const colorId =  row.querySelector('.color-id').dataset.color;
    const quantityInput = container.querySelector('.items-quantity');
    const productTotalPrice = row.querySelector('.total');
    const cartSubTotal = document.getElementById('cart-sub-total');
    const cartFinalTotal = document.getElementById('cart-final-total');
    const cartCountSpan = document.getElementById('cart-count');
    const cartCountSpan2 = document.getElementById('cart-count2');


// 2. Disable button to prevent double-clicks
    btn.disabled = true;

    fetch(btn.dataset.url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: quantityInput.value,
                                    color_id: colorId })
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            if (data.status === 'success') {
// 3. Update UI with the Server's "Source of Truth"
                console.log(data.quant, data.subTotal, data.cartTotal)
                quantityInput.value = data.quant;
                productTotalPrice.innerHTML = `${data.subTotal} $`;
                cartSubTotal.innerHTML = data.cartTotal;
                cartFinalTotal.innerHTML = data.cartTotal;
                cartCountSpan.innerHTML = `${data.cartCount}`;
                cartCountSpan2.innerHTML = `${data.cartCount}`;
            } else {
                alert(data.message || 'Something went wrong');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Could not update cart. Please try again.');
        })
        .finally(() => {
            btn.disabled = false; // Always re-enable the button
        });
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
document.addEventListener('click', function (event) {
    const removeBtn = event.target.closest('.remove-product');
    // console.log(removeBtn);
    if (removeBtn) {
        event.preventDefault(); // Stop the link from jumping
        const cartCountSpan = document.getElementById('cart-count');
        const cartCountSpan2 = document.getElementById('cart-count2');
        const cartSubTotal = document.getElementById('cart-sub-total');
        const cartFinalTotal = document.getElementById('cart-final-total');
        const row = removeBtn.closest('tr');
        const colorId =  row.querySelector('.color-id').dataset.color;
        // console.log(row);
        // return;
        const url = removeBtn.dataset.url;
        // 2. Perform the AJAX call
        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ color_id: colorId })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data)
                if (data.isCartEmpty) {window.location.reload();}
                else {
                    cartCountSpan.innerHTML = data.cartCount;
                    cartCountSpan2.innerHTML = data.cartCount;
                    cartSubTotal.innerHTML = data.cartTotal;
                    cartFinalTotal.innerHTML = data.cartTotal;
                    // alert(data.message);
                    row.remove();
                }
            })
            .catch(error => console.error('Error:', error));
    }
});

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// document.addEventListener('click', function (event) {
//     const btn = event.target.closest('.increase-items, .decrease-items');
//     if (!btn) return; // Exit early if we didn't click a quantity button
//
//     event.preventDefault();
//
// // 1. Find elements relative to the clicked button
//     const container = btn.closest('.cart-btn-container');
//     const row = btn.closest('tr');
//     const colorId =  row.querySelector('.color-id').dataset.color;
//     const quantityInput = container.querySelector('.items-quantity');
//     const productTotalPrice = row.querySelector('.total');
//     const cartTotalPrice = document.getElementById('cart-total-price');
//     const cartCountSpan = document.getElementById('cart-count');
//
//
// // 2. Disable button to prevent double-clicks
//     btn.disabled = true;
//
//     fetch(btn.dataset.url, {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
//         },
//         body: JSON.stringify({ quantity: quantityInput.value,
//             color_id: colorId })
//     })
//         .then(response => response.json())
//         .then(data => {
//             console.log(data);
//
//             if (data.status === 'success') {
// // 3. Update UI with the Server's "Source of Truth"
//                 console.log(data.quant, data.subTotal, data.cartTotal)
//                 quantityInput.value = data.quant;
//                 productTotalPrice.innerHTML = `${data.subTotal} $`;
//                 cartTotalPrice.innerHTML = `${data.cartTotal} $`;
//                 cartCountSpan.innerHTML = `${data.cartCount}`;
//             } else {
//                 alert(data.message || 'Something went wrong');
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             alert('Could not update cart. Please try again.');
//         })
//         .finally(() => {
//             btn.disabled = false; // Always re-enable the button
//         });
// });


document.querySelectorAll('input[name="Shipping"]').forEach((radio) => {
    radio.addEventListener('change', (event) => {
        // console.log("Selected status:", event.target);
        const shippingBtn   = event.target;
        const subtotalVal  = document.getElementById('subtotal-val')
        const couponName   = document.getElementById('coupon-name')
        const couponVal    = document.getElementById('coupon-val')
        const shippingName = document.getElementById('shipping-name')
        const shippingVal  = document.getElementById('shipping-val')
        // const feesName     = document.getElementById('fees-name')
        // const feeVal       = document.getElementById('fees-val')

        fetch(shippingBtn.dataset.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({shippingValue: shippingBtn.value?? 1})
        }).then(response => response.json())
          .then(data => {
            console.log(data);
            if(data.status === 'success') {
                if(data.coupon){
                    subtotalVal.querySelector('strong').innerHTML = `${data.coupon.finalTotal} L.e`;
                    couponName.querySelector('small').innerHTML = `( ${data.coupon.couponName} )`;
                    couponVal.querySelector('small').innerHTML = `- ${data.coupon.discount} L.e`;

                    // shippingName.querySelector('small').innerHTML = '';
                    (data.shipping === 50)? shippingName.querySelector('small').innerHTML = "( Fast SHIP. )" : shippingName.querySelector('small').innerHTML = "( Free SHIP. )";
                    shippingVal.querySelector('small').innerHTML = `${data.shipping} L.e`;
                } else{
                    (data.shipping === 50)? shippingName.querySelector('strong').innerHTML = "( Fast SHIP. )" : "( Free SHIP. )";
                    shippingVal.querySelector('small').innerHTML = `${data.shipping} L.e`;
                    subtotalVal.querySelector('strong').innerHTML = `${data.cartTotal} L.e`;
                }
            }
        })
          .catch(error => console.error('Error:', error));
    });
});
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// document.addEventListener('change', (e) => {
//     // Listen for any attribute checkbox changes
//     if (e.target.classList.contains('attribute-checkbox')) {
//         // 1. Find all checkboxes that are currently checked
//         const checkedBoxes = document.querySelectorAll('.attribute-checkbox:checked');
//         // 2. Map their values into an array, e.g., [1, 8]
//         const selectedIds = Array.from(checkedBoxes).map(box => box.value);
//         // 3. Get your filter submission endpoint URL
//         const url = e.target.dataset.url;
//         const productContainer = document.getElementById("search-container");
//         getFilteredProducts(url, selectedIds, productContainer)
//     }
// });
//
//
// function getFilteredProducts(url, selectedVals, selectElement) {
//     // 4. Send the whole array to your Laravel backend via AJAX
//     const params = new URLSearchParams();
//     selectedVals.forEach(id => params.append('attrValIds[]', id));
//     // Append params to the base URL
//     const finalUrl = `${url}?${params.toString()}`;
//
//     fetch(finalUrl, {
//         method: 'GET',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
//             'X-Requested-With': 'XMLHttpRequest'
//         }
//     })
//         .then(response => response.json())
//         .then(data => {
//             // console.log(data);
//             if(data.status === 'success' && data.products) {
//                 updateFilterCounts(data.valuesCounts)
//                 showData(data.products, selectElement);
//             }
//         });
// }


document.addEventListener('change', (e) => {
    // Trigger filter update if a checkbox OR the sort dropdown changes
    if (e.target.classList.contains('attribute-checkbox') || e.target.classList.contains('price-input') || e.target.id === 'sort-products') {

        // 1. Grab the endpoint URL from any of your elements
        const checkbox = document.querySelector('.attribute-checkbox');
        if (!checkbox) return;
        const url = checkbox.dataset.url;

        // 2. Fire the unified processing function
        applyFiltersAndSort(url);
    }
});

function applyFiltersAndSort(url) {
    const params = new URLSearchParams();

    // 1. Collect all checked attributes
    const checkedBoxes = document.querySelectorAll('.attribute-checkbox:checked');
    checkedBoxes.forEach(box => params.append('attrValIds[]', box.value));

    // 2. Collect the active sort type (e.g., 'low', 'high')
    const sortDropdown = document.getElementById('sort-products');
    if (sortDropdown && sortDropdown.value) {
        params.append('sortType', sortDropdown.value);
    }

    // 3. Gather Price Boundaries
    let minPrice = document.getElementById('price-min').value;
    let maxPrice = document.getElementById('price-max').value;
    let minPriceLabel = document.getElementById('min-label');
    let maxPriceLabel = document.getElementById('max-label');
    if (minPrice) params.append('priceMin', minPrice);
    if (maxPrice) params.append('priceMax', maxPrice);

    // 4. Compile the final unified URL
    const finalUrl = `${url}?${params.toString()}`;
    const productContainer = document.getElementById("search-container");

    // 5. Send the complete state to your backend
    fetch(finalUrl, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log(data)
            if (data.status === 'success' && data.products && data.valuesCounts) {
                updateFilterCounts(data.valuesCounts);
                showData(data.products, productContainer);
                minPrice =  data.minPrice;
                maxPrice =  data.maxPrice;
                minPriceLabel.innerText =  `${data.priceMin} L.e`;
                maxPriceLabel.innerText =  `${data.priceMax} L.e`;
            }
        }).catch(error => console.error('Error:', error));
}



function updateFilterCounts(valuesCounts) {
    // 1. Grab all the little counter elements present on the page
    const counterElements = document.querySelectorAll('.product-counter');
    // 2. Map your dynamic array payload into a clean object/Map for fast key lookup
    const countsMap = {};
    valuesCounts.forEach(item => {
        countsMap[item.attribute_value_id] = item.product_count;
    });
    // 3. Loop over the DOM elements directly instead of writing HTML blocks
    counterElements.forEach(el => {
        const valueId = el.getAttribute('data-val-id');
        // Check if our active payload contains this ID
        if (countsMap[valueId] !== undefined) {
            // It matches! Update it with the dynamic count
            el.textContent = ` (${countsMap[valueId]})`;
            // Re-enable the input element just in case it was disabled
            el.closest('.form-check').querySelector('input').disabled = false;
        } else {
            // No match found across selected items -> Turn to 0
            el.textContent = ' (0)';
            // Optional: Disable the radio button so users can't click zero-result pathways
            el.closest('.form-check').querySelector('input').disabled = true;
        }
    });
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
