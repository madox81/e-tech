$(document).ready(() => {
    
    // Load cart data function
    function request(url, payload = "", callback) {
        $.ajax({
            url: url,
            method: "POST",
            data: payload,
            dataType: "json",
            success: function(data) {
                callback(data);
            },
            error: function(xhr, status, error) {
                alert("Error loading cart:", error);
            }
        });
    }

    // Render cart function
    function renderCart(cartData) {
        // Get the current page
        const page = new URL(location.href).searchParams.get("page");
        // Action column in cart table
        const column = "table .action";
        // Cart length
        const cartLength = cartData.length;
        // Check if cart is empty
        if (cartLength === 0) {
            $(".badge").text("");
            $("#cart-content").html(
                `<tr>
                    <td colspan="5" align="center">Your Cart is Empty!</td>
                </tr>`
            );
            $("#cart_btns").hide();
        } else {
            let total = calculateTotal(cartData);
            let totalQ = calculateTotalQ(cartData);
            $(".badge").text(totalQ);
            $("#cart_btns").show();
            let content = cartData.map((item) => {
                const subtotal = item.quantity * item.price;
                return `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.quantity}</td>
                        <td align="right">$ ${item.price}</td>
                        <td align="right">$ ${subtotal}</td>
                        <td class="action"><button name="remove" class="btn btn-danger 
                        btn-sm remove" data-pid="${item.pid}">Remove</button></td>
                    </tr>
                `;
            }).join("");
            content += `<tr>  
                        <td colspan="3" align="right">Total</td>  
                        <td align="right">$${total}</td>  
                        <td class="action"></td>  
                        </tr>`;
            $("tbody").html(content);

            // If the page is checkout page hide acrion column from cart table
            if(page === "checkout"){
                $(column).hide();
                $("#cart_btns").hide();
            }else{
                 $(column).show();
                 $("#cart_btns").show();
            }
        }
    }

    // Calculate total
    function calculateTotal(cartData) {
        return cartData.reduce((acc, item) => 
            acc + (item.quantity * item.price),
        0);
    }

    // Calculate total quantity
    function calculateTotalQ(cartData) {
        return cartData.reduce((acq, item) => 
            acq + parseInt(item.quantity),
        0);
    }

    // Load cart data on page load
    request("api/cart.php?action=show",undefined, function(data){
        renderCart(data);
    });

    // Add item to cart
    $(document).on("click", ".add_to_cart", function(event) {
        event.preventDefault();
        const form = $(this).closest("form");
        const pid = form.find('[name="pid"]').val();
        const product = form.find('[name="product"]').val();
        const price = form.find('[name="price"]').val();
        const quantity = form.find('[name="quantity"]').val();
        const item = {
            pid,
            product,
            price,
            quantity,
        };
        if (quantity <= 0 || isNaN(quantity)) {
            alert("Please enter a valid quantity");
            return;
        }

        request("api/cart.php?action=add", item,function(data){
            renderCart(data);
            form[0].reset();
            alert("Item added to cart successfully!");
        });
    });

    // Remove item from cart
    $(document).on("click", ".remove", function(event) {
        event.preventDefault();
        const pid = $(this).data("pid");
        if (confirm("Are you sure you want to remove this product?")) {
            request("api/cart.php?action=remove", {pid}, function(data){
                renderCart(data);
                $("#cart-popover").popover("hide");
                alert("Item removed from cart successfully!");
            });
        }
    });

    // Clear items from cart
    $(document).on("click", "#clear_cart", function(event) {
        event.preventDefault();
        if (confirm("Are you sure you want to clear your cart?")) {
            request("api/cart.php?action=clear", undefined, function(data){
                renderCart(data);
                $("#cart-popover").popover("hide");
                alert("Cart cleared successfully!");
            });
        }
    });

    // Enable popover for cart
    $("#cart-popover").popover({
        html: true,
        container: "body",
        placement: "bottom",
        title: "Shopping Cart",
        sanitize: false,
        trigger: "focus" ,
        content: function() {
            return $('[data-name="popover-content"]').html();
        }
    });

    // Enable popover for password field
    $('[name="password"]').popover({
        html:true,
        container: "body",
        placement: "top",
        title: "Password Rules",
        trigger: "focus" ,
        customClass: function(){
            form = $('[name="password"]').closest("form");
            formId = $(form).attr("id");
            if(formId === "signupForm"){
                return "ppopover";
            }
        },
        content: function() {
            return "<p><i>Password must be at least 8 characters long and contains at least one uppercase letter and one digit</i></p>" ;
        }
    });

});