$(document).ready(function () {
    $('.add-to-cart').click(function () {
        var id = $(this).attr('id');
        var size = $(".product-size").val();
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin + '/shop/cart/add/' + id + '/' + size,
            data: "",
            dataType: "html",

            success: function () {
                $.notify.defaults({className: "success"});
                $("#" + id).notify(
                    "Dodano do koszyka",
                    {
                        position: "top",
                        autoHideDelay: 1000
                    }
                );
            },
            error: function () {
                $.notify.defaults({className: "warn"});
                $("#" + id).notify(
                    "Błąd",
                    {
                        position: "top",
                        autoHideDelay: 1000
                    }
                );
            }
        });
    });

    $('.remove-from-cart').click(function () {
        var price = parseFloat($(this).parent().next().html());
        var quantity = parseInt($(this).next().html()) - 1;
        var sumProduct = price * quantity;
        var sumAll = parseFloat($('#total-cart').html());
        var sumContent = $(this).parent().next().next();
        var quantityContent = $(this).next(".qty");
        var rowid = $(this).attr('id');
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin + "/shop/cart/remove/" + rowid,
            data: "",
            dataType: "html",

            success: function (msg) {
                if (msg == 1) {
                    if (quantity < 1) {
                        quantityContent.parent().parent().remove();
                    }
                    quantityContent.html(quantity);
                    sumContent.html(sumProduct.toFixed(2));
                    $('#total-cart').html((sumAll - price).toFixed(2));
                    if ($('#total-cart').html() == 0.00) {
                        $('#order-btn').hide();
                        $('.price-total').hide();
                        $('table').hide();
                        $('#cart-package-type').hide();
                        $('.title').html("Koszyk jest pusty");
                    }
                } else {
                    $.notify.defaults({className: "warn"});
                    $("#logo").notify(
                        "Błąd",
                        {
                            position: "top",
                            autoHideDelay: 1000
                        }
                    );
                }
            }
        });
    });

    $('.add-to-cart-plus').click(function () {
        var size = $(this).parent().prev().children().html();
        var price = parseFloat($(this).parent().next().html());
        var quantity = parseInt($(this).prev().html()) + 1;
        var sumProduct = price * quantity;
        var sumAll = parseFloat($('#total-cart').html());
        var sumContent = $(this).parent().next().next();
        var quantityContent = $(this).prev(".qty");
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin + "/shop/cart/add/" + id + "/" + size,
            data: "",
            dataType: "html",

            success: function () {
                quantityContent.html(quantity);
                sumContent.html(sumProduct.toFixed(2));
                $('#total-cart').html((sumAll + price).toFixed(2));
                updateCart();
            },
            error: function () {
                $.notify.defaults({className: "warn"});
                $("#logo").notify(
                    "Błąd",
                    {
                        position: "top",
                        autoHideDelay: 1000
                    }
                );
            },
        });
    });
});