<div class="edit-profile">
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
    <div class='header'>Odzyskiwanie hasła</div>
    <div class='center'>
        <?php echo form_open('shop/user/forget_password') ?>
        <div class='heading'>
            Podaj email:
        </div>
        <div class='value'>
            <input type='email' name='email'>
        </div>
    </div>
    <div class='center'>
        <button type='submit' class='submit-btn'>Potwierdź</button>
    </div>
</div>