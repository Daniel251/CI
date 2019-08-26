<div id="login">
    <div class='row'>
        <div class='error center'>
            <?php echo $this->session->flashdata('errors') ?>
        </div>
    </div>
    <div class='row'>
        <div class='ok center'>
            <?php echo $this->session->flashdata('ok') ?>
        </div>
    </div>
    <div class='header'>
        Logowanie
    </div>
    <?php echo form_open('shop/user/login') ?>
    <div class="row">
        <div class="heading">Email:</div>
        <div class="value">
            <input type="text" name="email">
        </div>
    </div>
    <div class="row">
        <div class="heading">Hasło:</div>
        <div class="value">
            <input type="password" name="password">
        </div>
    </div>
    <div class="row center">
        <button type='submit' class='submit-btn'>Zaloguj</button>
    </div>
    <div class='row forget-pass-link'>
        <a href="<?php echo base_url() ?>shop/user/forget_password">Nie pamiętasz hasła?</a>
    </div>
    <?php echo form_close() ?>
</div>