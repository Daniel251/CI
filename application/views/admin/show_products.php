<div class="confirm">
    <div class="confirm"><?= $this->session->flashdata('ok') ?></div>
</div>
    <a href="<?= base_url() ?>cms/admin/add_product"><button class="btn btn-warning btn-lg btn-add">Dodaj Produkt</button></a>
    <table class="table">
        <thead>
            <th></th>
            <th>Nr kat.</th>
            <th>Kategoria</th>
            <th>Nazwa</th>
            <th>Cena</th>
        </thead>
        <tbody>

<?php foreach ($products as $row): ?>
        <?php
        $category = $row->category_id;
        $image = $row->nr.'-0.jpg';
        switch($category){
                case '1':
                   $category = "Płyty";
                    break;
                case '2':
                   $category = "Koszulki";
                   break;
                case '3':
                    $category = "Pozostałe";
                    break;
        }
        ?>
            <tr>
                <td><img src='<?= base_url() ?>images/products/thumbs/<?= $image ?>'></td>
                <td><?= $row->nr ?></td>
                <td><?= $category ?></td>
                <td><?= $row->name ?></td>
                <td><?= $row->price ?></td>
                <td>
                    <a href = '<?= base_url() ?>cms/admin/edit_product/<?= $row->id ?>'><span class='glyphicon glyphicon-pencil'></span></a>
                    <a href = '<?= base_url() ?>cms/admin/remove_product/<?= $row->id ?>'><span class='glyphicon glyphicon-remove'></span></a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>