<form id="form-paylane" name="form-paylane" action="https://secure.paylane.com/order/cart.html" method="POST">
    <input type="hidden" name="amount" value="<?php echo $total ?>">
    <input type="hidden" name="currency" value="PLN">
    <input type="hidden" name="merchant_id" value="daniel252">
    <input type="hidden" name="description" value="<?php echo $payment_description ?>"/>
    <input type="hidden" name="transaction_description" value="Zakup w sklepie Nocny Kochanek"/>
    <input type="hidden" name="transaction_type" value="S">
    <input type="hidden" name="back_url" value="<?php echo base_url() ?>shop/cart/finish_payment">
    <input type="hidden" name="language" value="en">
    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
    <button type="submit"></button>
</form>
<script>
    window.onload = function () {
        document.getElementById("form-paylane").submit();
    }
</script>