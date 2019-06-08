<div class="edit-profile">
<?php if($this->session->flashdata('errors')): ?>
    <div class='row'>
        <div class='error center'>
            <?= $this->session->flashdata('errors') ?>
        </div>
    </div>
<?php endif ?>
<div class='header'>Zarejestruj się:</div>
    <?= form_open('shop/user/register') ?>
        <div class="label">
            Email: </div> 
        <div class="value ">
            <input type="email" name="email" required>
        </div>
        <div class="label">
            Hasło: 
        </div> 
        <div class="value ">
            <input type="password" name="password" required>
        </div>
        <div class="label">
            Powtórz hasło: 
        </div> 
        <div class="value ">
            <input type="password" name="password2" required>
        </div>
        <div class="label">
            Imię: 
        </div> 
        <div class="value ">
            <input type="text" name="name" required>
        </div>
        <div class="label">
            Nazwisko: 
        </div> 
        <div class="value ">
            <input type="text" name="surname" required>
        </div>
        <div class="label">
            Miasto: 
        </div> 
        <div class="value ">
            <input type="text" name="city" required>
        </div>

        <div class="label">
            Ulica: 
        </div> 
        <div class="value ">
            <input type="text" name="street">
        </div>

        <div class="label">
            Kod pocztowy: 
        </div> 
        <div class="value ">
            <input type="text" title='Format: XX-XXX' placeholder="00-000" pattern="[0-9]{2}\-[0-9]{3}" name="post_code" required>
        </div>
        <div class="center">
            <button type='submit' class='submit-btn'>Zarejestruj się</button>
        </div>
    <?= form_close() ?>
</div>