$(document).ready(function(){
    if($('#btn-cart').attr('disabled') == 'disabled')
    {
        $('#btn-cart').html('Wybierz sposób wysyłki')
    }
    $( "input[type=radio]" ).on( "click", function() {
        $('#btn-cart').removeAttr('disabled');
        $('#btn-cart').html('Przejdź do podsumowania');
        aa();
        
    });
    function aa() {
        $total=parseFloat($('#total-cart').html());

        if($('#package-kurier').is(':checked')) {
            $('#sum').html(($total+15).toFixed(2));
            $('#package-type').html('Kurier');
            $('.package-price').html((15).toFixed(2));
            $('#form-package-type').val('Kurier');
        }
        else if($('#package-poczta').is(':checked')) {
            $('#sum').html(($total+10).toFixed(2));
            $('#package-type').html('Paczka priorytetowa');
            $('.package-price').html((10).toFixed(2));
            $('#form-package-type').val('Paczka Priorytetowa');
        }
        else{
            $('#sum').html($total.toFixed(2));
        }
    }
   /* $("#btn-order").click(function(e) {

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                $('#form-order').submit();
                $('#form-paylane').submit();
            }
        });
        e.preventDefault();
    });*/
    $('.add-to-cart').click(function(){
        $id=$(this).attr('id');
        $size=$(".product-size").val();
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin+'/ci/shop/cart/add/'+$id+'/'+$size,
            data: "",
            dataType: "html",

            success: function( msg ){
                console.debug(msg);
                if(msg == 1){
                    $.notify.defaults({ className: "success" });
                    $("#"+$id).notify(
                        "Dodano do koszyka",
                        { position:"top",
                        autoHideDelay: 2000}
                    );
                }
                else{
                    $.notify.defaults({ className: "warn" });
                    $("#"+$id).notify(
                        "Błąd",
                        { position:"top",
                        autoHideDelay: 2000}
                    );
                }
            }
        });
    });

        $('.remove-from-cart').click(function(){
        $size=$(this).parent().prev().children().html();
        $price=parseFloat($(this).parent().next().html());
        $quantity=parseInt($(this).next().html())-1;
        $sumProduct=$price*$quantity;
        $sumAll=parseFloat($('#total-cart').html());
        $sumContent=$(this).parent().next().next();
        $quantityContent=$(this).next(".qty");
        $rowid=$(this).attr('id');
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin+"/ci/shop/cart/remove/"+$rowid,
            data: "",
            dataType: "html",

            success: function( msg ){
                if(msg==1){
                    if($quantity<1){
                        $quantityContent.parent().parent().remove();
                    }
                    $quantityContent.html($quantity);
                    $sumContent.html($sumProduct.toFixed(2));
                    $('#total-cart').html(($sumAll-$price).toFixed(2));
                    aa();

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
        $size=$(this).parent().prev().children().html();
        $price=parseFloat($(this).parent().next().html());
        $quantity=parseInt($(this).prev().html())+1;
        $sumProduct=$price*$quantity;
        $sumAll=parseFloat($('#total-cart').html());
        $sumContent=$(this).parent().next().next();
        $quantityContent=$(this).prev(".qty");
        $id=$(this).attr('id');
        $.ajax({
            type: "POST",
            async: false,
            url: document.location.origin+"/ci/shop/cart/add/"+$id+"/"+$size,
            data: "",
            dataType: "html",

            success: function( msg ){
                if(msg==1){
                    $quantityContent.html($quantity);
                    $sumContent.html($sumProduct.toFixed(2));
                    $('#total-cart').html(($sumAll+$price).toFixed(2));
                    aa();
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