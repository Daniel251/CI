<?php

var_dump($this->cart->contents());
?>
<table cellpadding="6" cellspacing="1" style="width:100%" border="0">

<tr>
    <th style="text-align:left">Item Name</th>
    <th style="text-align:left">QTY</th>
    <th style="text-align:right">Item Price</th>
    <th style="text-align:right">Sub-Total</th>
</tr>
<?php

foreach ($this->cart->contents() as $items):
    $size = null;
     if ($this->cart->has_options($items['rowid']) == TRUE):
        $size = '  rozmiar '.$items['options']['Size'];
     endif;
     ?>
    <tr>
    <td><?= $items['name'].$size ?>
    <td><?= $items['qty'] ?></td>
    <td style="text-align:right"><?= $this->cart->format_number($items['price']) ?></td>
    <td style="text-align:right">$<?= $this->cart->format_number($items['subtotal']) ?></td>
    </tr>


<?php endforeach ?>

<tr>
        <td colspan="2"> </td>
        <td class="right"><strong>Total</strong></td>
        <td class="right">$<?= $this->cart->format_number($this->cart->total()) ?></td>
</tr>

</table>
