<table class="table">
    <thead>
    <tr>
        <th>Data zamówienia</th>
        <th>Nr zamówienia</th>
        <th>Kwota zamówienia</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders as $order): ?>
    <tr>
        <td><?php echo $order->date ?></td>
        <td><?php echo $order->id ?></td>
        <td><?php echo number_format($order->total, 2) ?></td>
        <td><a href='<?php echo base_url() . 'shop/user/order_details/' . $order->id  ?>'>Wyświetl szczegóły</a>
    </tr>
    <?php endforeach ?>
    </tbody>
</table>