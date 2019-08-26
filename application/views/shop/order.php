<div id='cart'>
    <div class="row">
        <div class='col-sm-12 error center'>
            <h2><?php echo $this->session->flashdata('errors') ?></h2>
        </div>
        <?php if ($this->cart->contents()): ?>
            <div class='title'>Twoje zamówienie:</div>
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
                            <span class='qty'><?php echo $row['qty'] ?></span>
                        <td class='price'>
                            <?php echo number_format($row['price'], 2) ?>
                        </td>
                        <td class='price'>
                            <?php echo number_format($row['subtotal'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td>
                        Przesyłka: <span id="package-type">(Wybierz)</span>
                    </td>
                    <td class="text-center">
                        <span class='qty'></span>
                    <td class='price'>
                        <span class="package-price"></span>
                    </td>
                    <td class='price'>
                        <span class="package-price"></span>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="price-total">
                Suma: <?php echo $this->cart->format_number($total, 2) ?> zł
            </div>
            <div class='clear'></div>
        <?php endif ?>
    </div>
    <span class='hidden' id="total-cart">
        <?php echo $this->cart->format_number($this->cart->total()) ?>
    </span>
    <?php echo form_open('shop/cart/finalize', ' id="form-order"') ?>
    <div class="row">
        <div id='cart-package-type' class="col-sm-5">
            <div class='header'>Sposób wysyłki:</div>
            <?php foreach ($packages as $package): ?>
                <div>
                    <label onclick="updateCart('<?php echo $package->name; ?> ', '<?php echo $package->price; ?>')"
                           id="package-label-<?php echo $package->id; ?>" for="package-<?php echo $package->id; ?>">
                        <input id="package-<?php echo $package->id; ?>" type="radio" value="<?php echo $package->id ?>"
                               name="package_id"> <?php echo $package->name; ?> ( <?php echo $package->price; ?> zł )
                    </label>
                </div>

            <?php endforeach; ?>
        </div>
        <br/>
        <br/>
    </div>

    <div class='row'>
        <div class='error center'>
            <?php echo $this->session->flashdata('validationErrors') ?>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12 text-center">
            <div class='header'>Wprowadź dane do wysyłki:</div>

            <div class="label ">
                Imię:
            </div>
            <div class="value ">
                <input type="text" name="name" value='<?php echo $this->session->userdata('name') ?>' maxlength="40"
                       required>
            </div>

            <div class="label ">
                Nazwisko:
            </div>
            <div class="value ">
                <input type="text" name="surname" value='<?php echo $this->session->userdata('surname') ?>'
                       maxlength="50" required>
            </div>

            <div class="label ">
                Email:
            </div>
            <div class="value ">
                <input type="text" name="email" value='<?php echo $this->session->userdata('email') ?>'
                       maxlength="50" required>
            </div>

            <div class="label ">
                Miasto:
            </div>
            <div class="value ">
                <input type="text" name="city" value='<?php echo $this->session->userdata('city') ?>' maxlength="40"
                       required>
            </div>

            <div class="label ">
                Ulica:
            </div>
            <div class="value ">
                <input type="text" name="street" value='<?php echo $this->session->userdata('street') ?>'
                       maxlength="50">
            </div>

            <div class="label ">
                Kod pocztowy:
            </div>
            <div class="value ">
                <input type="text" title='Format: XX-XXX' placeholder="00-000" pattern="[0-9]{2}\-[0-9]{3}"
                       name="post_code" value='<?php echo $this->session->userdata('post_code') ?>' required>
            </div>

            <input type="hidden" name="hash" value="<?php echo $hash ?>">
            <input type="hidden" name="payment_description" value="<?php echo $description ?>">
            <input type="hidden" name="total" value="<?php echo $total ?>">
            <br/>
            <div class="center">
                <button class="submit-btn" id='btn-order' disabled>Wybierz typ przesyłki</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
    <script>
        function updateCart(packageName, packagePrice) {
            const totalWithoutPackage = parseFloat($('#total-cart').html());
            $('#sum').html((parseFloat(totalWithoutPackage) + parseFloat(packagePrice)).toFixed(2));
            $('#package-type').html(packageName);
            $('.package-price').html((parseFloat(packagePrice)).toFixed(2));
            $('#form-package-type').val(packageName);

            $("input[name=package_id]").on("click", function () {
                $('#btn-order').removeAttr('disabled');
                $('#btn-order').html('Złóż zamówienie');
            });
        }
    </script>
