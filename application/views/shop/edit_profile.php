<div class='row'>
    <div class='error center'>
        <?= $this->session->flashdata('errors') ?>
    </div>
</div>
<div class="edit-profile">
    <div class='header'>
        Edycja danych:
    </div>
    <?= form_open('shop/user/edit_profile') ?>
        <div class="row">
            <div class="label ">
                Imię:
            </div> 
            <div class="value">
                <input type="text" name="name" value='<?= $this->session->userdata('name') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label ">
                Nazwisko: 
            </div> 
            <div class="value">
                <input type="text"  name="surname" value='<?= $this->session->userdata('surname') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label ">
                Miasto: 
            </div> 
            <div class="value">
                <input type="text" name="city" value='<?= $this->session->userdata('city') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label ">
                Ulica: 
            </div> 
            <div class="value">
                <input type="text" name="street" value='<?= $this->session->userdata('street') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label ">
                Kod pocztowy: 
            </div> 
            <div class="value">
                <input type="text" title='Format: xx-xxx' pattern="[0-9]{2}\-[0-9]{3}" name="post_code" value='<?= $this->session->userdata('post_code') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label col-xs-6">
                <a href="<?= base_url() ?>shop/user/edit_email">
                    Zmień email
                </a>
            </div>
            <div class="label col-xs-6 left">
                <a  href="<?= base_url() ?>shop/user/edit_password">
                    Zmień hasło
                </a>
            </div>
        </div>
        <div class="button">
            <button type='submit' class='submit-btn'>Potwierdź</button>
        </div>
    <?= form_close() ?>
</div>