<?php if (empty($order_details)): ?>

<?php else: ?>
<div class="title">
    Sczegóły zamówienia nr <?php echo $order_details[0]->id; ?>
</div>
<div class="mb-3 label">
    <h4>
        Data złożenia zamówienia:  <?php echo $order_details[0]->date; ?> | Status płatności: <?php echo $payment_status ?>
    </h4>
</div>
<table class="table">
    <thead>
    <tr>
        <th>Nazwa produktu</th>
        <th>Numer katalogowy</th>
        <th>Ilość</th>
        <th>Cena za szt.</th>
        <th>Suma</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($order_details as $product): ?>
    <tr>
        <td><a href='<?php echo base_url() . 'shop/home/product/' . $product->product_id  ?>'>
                <?php echo $product->name . ($product->size ? " ($product->size)" : '') ?>
            </a>
        </td>
        <td><?php echo $product->nr ?></td>
        <td><?php echo $product->quantity ?></td>
        <td class="price"><?php echo number_format($product->price, 2) ?></td>
        <td class="price"><?php echo number_format($product->price * $product->quantity, 2) ?></td>
    </tr>
    <?php endforeach ?>
    </tbody>
</table>


<div class="price-total">
    Suma: <?php echo number_format($order_details[0]->total, 2); ?> zł
</div>
<?php endif; ?>