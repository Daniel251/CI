<div class='row'>
    <div class='center error'>
        <?= $this->session->flashdata('errors') ?>
    </div>
</div> 
<div class="edit-profile">
<div class='header'>Zmień email:</div>
<?= form_open('shop/user/edit_email') ?>
 <div class='row'>
    <div class='label'>
        Wpisz nowy email: 
    </div> 
    <div class='value'>
        <input type='email' name='email'>
    </div>
</div>         
<div class='row'>
    <div class='label'>
        Wpisz ponownie nowy email: 
    </div> 
    <div class='value'>
        <input type='email' name='email2'>
    </div>
</div>
<div class='center'>
    <button type='submit' class='submit-btn'>Potwierdź</button>
</div>
<?= form_close() ?>