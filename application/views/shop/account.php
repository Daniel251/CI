<div id="account">
<div class='row'>
    <div class='center ok'>
        <?= $this->session->flashdata('ok') ?>
    </div>
</div>
    <div class='header'>
            Dane użytkownika:
    </div>
    <table>
        <tr>
            <td class='heading'>Email: </td>
            <td><?= $this->session->userdata('email') ?></td>
        </tr>
        <tr>
            <td class='heading'>Imię:  </td>
            <td><?= $this->session->userdata('name') ?></td>
        </tr>
        <tr>
            <td class='heading'>Nazwisko:</td>
            <td><?= $this->session->userdata('surname') ?></td>
        </tr>
        <tr>
            <td class='heading'>Miasto:</td>
            <td><?= $this->session->userdata('city') ?></td>
        </tr>
        <tr>
            <td class='heading'>Ulica:</td>
            <td><?= $this->session->userdata('street') ?></td>
        </tr>
        <tr>
            <td class='heading'>Kod pocztowy:</td>
            <td><?= $this->session->userdata('post_code') ?></td>
        </tr>
    </table>
    <div class='row button'>
         <a href='<?= base_url() ?>shop/user/edit_profile'><button class='submit-btn'>Edycja danych profilu</button></a>
    </div>
</div>
