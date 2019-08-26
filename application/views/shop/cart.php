<div id='cart'>
    <div class="row">
        <div class='col-sm-12 error center'>
            <?php echo $this->session->flashdata('errors') ?>
        </div>
    </div>
    <?php if (!$this->cart->contents()): ?>
        <div class='title'>Koszyk jest pusty</div>
    <?php else: ?>
        <div class='title'>Koszyk</div>
        <table class='table table-condensed'>
            <thead>
            <tr>
                <th class='col-md-7 name'>Nazwa</th>
                <th class='col-md-1'>Ilość</th>
                <th class='col-md-2'>Cena za szt.</th>
                <th class='col-md-2'>Suma</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->cart->contents() as $row):
                $hide = '';
                $size = null;
                if ($this->cart->has_options($row['rowid']) == TRUE):
                    $size = $row['options']['size'];
                    $hide = 'hide';
                endif;
                ?>
                <tr>
                    <td>
                        <?php echo $row['name'] . "  " . $size ?>
                        <span id="size" class='product-size <?php echo $hide ?>'>
							<?php echo $size ?>
						</span>
                    </td>
                    <td class="text-center">
                        <a class='remove-from-cart' id='<?php echo $row['rowid'] ?>'>
                            <span class='glyphicon glyphicon-minus'></span>
                        </a>
                        <span class='qty'><?php echo $row['qty'] ?></span>
                        <a class='add-to-cart-plus' id='<?php echo $row['id'] ?>'>
                            <span class='glyphicon glyphicon-plus'></span>
                        </a>
                    </td>
                    <td class='price'>
                        <?php echo number_format($row['price'], 2) ?>
                    </td>
                    <td class='price'>
                        <?php echo number_format($row['subtotal'], 2) ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
        <div class="price-total">
            Suma:
            <span id='total-cart'>
                <?php echo $this->cart->format_number($this->cart->total()) ?>
            </span> zł
        </div>
        <div class='clear'></div>
        <div class="row">
            <?php echo form_open('shop/cart/order') ?>
            <div id='order-btn'>
                <button type="submit" id='btn-cart' class='submit-btn'>Przejdz do podsumowania zamówienia</button>
            </div>
            </form>
        </div>
    <?php endif ?>
</div>