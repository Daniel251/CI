<div class='row'>
    <div class='error center'>
        <?php echo $this->session->flashdata('errors') ?>
    </div>
</div>
<div class="edit-profile">
    <div class='header'>
        Edycja danych:
    </div>
    <?php echo form_open('shop/user/edit_profile') ?>
        <div class="row">
            <div class="label ">
                Imię:
            </div> 
            <div class="value">
                <input type="text" name="name" value='<?php echo $this->session->userdata('name') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label ">
                Nazwisko: 
            </div> 
            <div class="value">
                <input type="text"  name="surname" value='<?php echo $this->session->userdata('surname') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label ">
                Miasto: 
            </div> 
            <div class="value">
                <input type="text" name="city" value='<?php echo $this->session->userdata('city') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label ">
                Ulica: 
            </div> 
            <div class="value">
                <input type="text" name="street" value='<?php echo $this->session->userdata('street') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label ">
                Kod pocztowy: 
            </div> 
            <div class="value">
                <input type="text" title='Format: xx-xxx' pattern="[0-9]{2}\-[0-9]{3}" name="post_code" value='<?php echo $this->session->userdata('post_code') ?>'>
            </div>
        </div>
        <div class="row">
            <div class="label col-xs-6">
                <a href="<?php echo base_url() ?>shop/user/edit_email">
                    Zmień email
                </a>
            </div>
            <div class="label col-xs-6 left">
                <a  href="<?php echo base_url() ?>shop/user/edit_password">
                    Zmień hasło
                </a>
            </div>
        </div>
        <div class="button">
            <button type='submit' class='submit-btn'>Potwierdź</button>
        </div>
    <?php echo form_close() ?>
</div>