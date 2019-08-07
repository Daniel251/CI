<div id='cart'>
    <div class="row">
        <div class='col-sm-12 error center'>
            <h2><?= $this->session->flashdata('error') ?></h2>
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
                            <?= $row['name'] . "  " . $size ?>
                            <span id="size" class='product-size <?= $hide ?>'>
                            <?= $size ?>
                        </span>
                        </td>
                        <td class="text-center">
                            <span class='qty'><?= $row['qty'] ?></span>
                        <td class='price'>
                            <?= number_format($row['price'], 2) ?>
                        </td>
                        <td class='price'>
                            <?= number_format($row['subtotal'], 2) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <td>
                        Przesyłka: <span id="package-type"><?= $package ?></span>
                    </td>
                    <td class="text-center">
                        <span class='qty'>1</span>
                    <td class='price'>
                        <span class="package-price"><?= number_format($price, 2) ?></span>
                    </td>
                    <td class='price'>
                        <span class="package-price"><?= number_format($price, 2) ?></span>
                    </td>
                </tr>
                </tbody>
            </table>
            <h2>
            <span id='span-sum'>
                Suma: 
                <span id='sum'>
                    <?= $this->cart->format_number($total) ?>
                </span> zł
            </span>
            </h2>
            <div class='clear'></div>
        <?php endif ?>
    </div>

    <br/>
    <br/>
    <div class='row'>
        <div class='col-sm-5 error center'>
            <?= $this->session->flashdata('errors') ?>
        </div>
    </div>
    <div class="row">


        <div class="col-sm-12 text-center">
            <div class='header'>Wprowadź dane do wysyłki:</div>
            <?= form_open('shop/cart/finalize', ' id="form-order"') ?>

            <div class="label ">
                Imię:
            </div>
            <div class="value ">
                <input type="text" name="name" value='<?= $this->session->userdata('name') ?>' maxlength="40"
                       required>
            </div>

            <div class="label ">
                Nazwisko:
            </div>
            <div class="value ">
                <input type="text" name="surname" value='<?= $this->session->userdata('surname') ?>'
                       maxlength="50" required>
            </div>

            <div class="label ">
                Email:
            </div>
            <div class="value ">
                <input type="text" name="email" value='<?= $this->session->userdata('email') ?>'
                       maxlength="50" required>
            </div>

            <div class="label ">
                Miasto:
            </div>
            <div class="value ">
                <input type="text" name="city" value='<?= $this->session->userdata('city') ?>' maxlength="40"
                       required>
            </div>

            <div class="label ">
                Ulica:
            </div>
            <div class="value ">
                <input type="text" name="street" value='<?= $this->session->userdata('street') ?>'
                       maxlength="50">
            </div>

            <div class="label ">
                Kod pocztowy:
            </div>
            <div class="value ">
                <input type="text" title='Format: XX-XXX' placeholder="00-000" pattern="[0-9]{2}\-[0-9]{3}"
                       name="post_code" value='<?= $this->session->userdata('post_code') ?>' required>
            </div>
            <input type="hidden" name="package_type" value="<?= $package_type ?>">
            <input type="hidden" name="package_price" value="<?= $price ?>">
            <input type="hidden" name="total" value="<?= $total ?>">
            <input type="hidden" name="hash" value="<?= $hash ?>">
            <input type="hidden" name="payment_description" value="<?= $description ?>">
            <br/>
            <div class="center">
                <button class="submit-btn" id='btn-order'>Złóż zamówienie</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>