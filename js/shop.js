$(document).ready(function(){
    function updateCart() {
        var total=parseFloat($('#total-cart').html());

        if($('#package-kurier').is(':checked')) {
            $('#sum').html((total+15).toFixed(2));
            $('#package-type').html('Kurier');
            $('.package-price').html((15).toFixed(2));
            $('#form-package-type').val('Kurier');
        }
        else if($('#package-poczta').is(':checked')) {
            $('#sum').html((total+10).toFixed(2));
            $('#package-type').html('Paczka priorytetowa');
            $('.package-price').html((10).toFixed(2));8
            $('#form-package-type').val('Paczka Priorytetowa');
        }
        else{
            $('#sum').html(total.toFixed(2));
        }
    }
    if($('#btn-cart').attr('disabled') == 'disabled')
    {
        $('#btn-cart').html('Wybierz sposób wysyłki')
    }
    $( "input[type=radio]" ).on( "click", function() {
        $('#btn-cart').removeAttr('disabled');
        $('#btn-cart').html('Przejdź do podsumowania');
        updateCart();
        
    });

    $('.add-to-cart').click(function(){
        var id=$(this).attr('id');
        var size=$(".product-size").val();
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin+'/ci/shop/cart/add/'+id+'/'+size,
            data: "",
            dataType: "html",

            success: function( msg ){
                if(msg == 1){
                    $.notify.defaults({ className: "success" });
                    $("#"+id).notify(
                        "Dodano do koszyka",
                        { position:"top",
                        autoHideDelay: 2000}
                    );
                }
                else{
                    $.notify.defaults({ className: "warn" });
                    $("#"+id).notify(
                        "Błąd",
                        { position:"top",
                        autoHideDelay: 2000}
                    );
                }
            }
        });
    });

        $('.remove-from-cart').click(function(){
        var price=parseFloat($(this).parent().next().html());
        var quantity=parseInt($(this).next().html())-1;
        var sumProduct=price*quantity;
        var sumAll=parseFloat($('#total-cart').html());
        var sumContent=$(this).parent().next().next();
        var quantityContent=$(this).next(".qty");
        var rowid=$(this).attr('id');
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin+"/ci/shop/cart/remove/"+rowid,
            data: "",
            dataType: "html",

            success: function( msg ){
                if(msg==1){
                    if(quantity<1){
                        quantityContent.parent().parent().remove();
                    }
                    quantityContent.html(quantity);
                    sumContent.html(sumProduct.toFixed(2));
                    $('#total-cart').html((sumAll-price).toFixed(2));
                    updateCart();

                    if($('#sum').html()==0.00){
                        $('#order-btn').hide();
                        $('#span-sum').hide();
                        $('table').hide();
                        $('#cart-package-type').hide();
                        $('.title').html("Koszyk jest pusty");
                    }
                }
                else{
                    $.notify.defaults({ className: "warn" });
                    $("#logo").notify(
                        "Błąd",
                        { position:"top",
                        autoHideDelay: 2000}
                    );
                }
            }
        });
    });

    $('.add-to-cart-plus').click(function(){
        var size=$(this).parent().prev().children().html();
        var price=parseFloat($(this).parent().next().html());
        var quantity=parseInt($(this).prev().html())+1;
        var sumProduct=price*quantity;
        var sumAll=parseFloat($('#total-cart').html());
        var sumContent=$(this).parent().next().next();
        var quantityContent=$(this).prev(".qty");
        var id=$(this).attr('id');
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin+"/ci/shop/cart/add/"+id+"/"+size,
            data: "",
            dataType: "html",

            success: function( msg ){
                if(msg==1){
                    quantityContent.html(quantity);
                    sumContent.html(sumProduct.toFixed(2));
                    $('#total-cart').html((sumAll+price).toFixed(2));
                    updateCart();
                }
                else{
                    $.notify.defaults({ className: "warn" });
                    $("#logo").notify(
                        "Błąd",
                        { position:"top",
                        autoHideDelay: 2000}
                    );
                }
            }
        });
    });

});