<div id="account">
    <div class='row'>
        <div class='center ok'>
            <?php echo $this->session->flashdata('ok') ?>
        </div>
    </div>
    <div class='header'>
        Dane użytkownika:
    </div>
    <table>
        <tr>
            <td class='heading'>Email:</td>
            <td><?php echo $this->session->userdata('email') ?></td>
        </tr>
        <tr>
            <td class='heading'>Imię:</td>
            <td><?php echo $this->session->userdata('name') ?></td>
        </tr>
        <tr>
            <td class='heading'>Nazwisko:</td>
            <td><?php echo $this->session->userdata('surname') ?></td>
        </tr>
        <tr>
            <td class='heading'>Miasto:</td>
            <td><?php echo $this->session->userdata('city') ?></td>
        </tr>
        <tr>
            <td class='heading'>Ulica:</td>
            <td><?php echo $this->session->userdata('street') ?></td>
        </tr>
        <tr>
            <td class='heading'>Kod pocztowy:</td>
            <td><?php echo $this->session->userdata('post_code') ?></td>
        </tr>
    </table>
    <div class='row button'>
        <a href='<?php echo base_url() ?>shop/user/edit_profile'>
            <button class='submit-btn'>Edycja danych profilu</button>
        </a>
    </div>
</div>
