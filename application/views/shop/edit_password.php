<div class="edit-profile">
<div class='row'>
    <div class='center error'>
        <?php echo $this->session->flashdata('errors') ?>
    </div>
</div> 
    <div class='header'>Zmień hasło:</div>
    <?php echo form_open('shop/user/edit_password/'.$code = isset($code) ? $code : '' ) ?>
     <div class='row'>
        <div class='label'>
            Wpisz nowe hasło: 
        </div> 
        <div class='value'>
            <input type='password' minlength="5" maxlength="15" name='password' required>
        </div>
    </div>         
    <div class='row'>
        <div class='label'>
            Wpisz ponownie nowe hasło: 
        </div> 
        <div class='value'>
            <input type='password' minlength="5" maxlength="15" name='password2' required>
        </div>
    </div>
    <div class='center'>
        <button type='submit' class='submit-btn'>Potwierdź</button>
    </div>
    <?php echo form_close() ?>
</div>