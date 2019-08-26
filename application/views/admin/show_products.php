<div class="confirm">
    <div class="confirm"><?php echo $this->session->flashdata('ok') ?></div>
</div>
<a href="<?php echo base_url() ?>cms/admin/add_product">
    <button class="btn btn-warning btn-lg btn-add">Dodaj Produkt</button>
</a>
<table class="table">
    <thead>
    <tr>
        <th></th>
        <th>Nr kat.</th>
        <th>Kategoria</th>
        <th>Nazwa</th>
        <th>Cena</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($products as $row): ?>
        <?php
        $category = $row->category_id;
        $image = $row->nr . '-0.jpg';
        switch ($category) {
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
            <td><img src='<?php echo base_url() ?>images/products/thumbs/<?php echo $image ?>'></td>
            <td><?php echo $row->nr ?></td>
            <td><?php echo $category ?></td>
            <td><?php echo $row->name ?></td>
            <td><?php echo $row->price ?></td>
            <td>
                <a href='<?php echo base_url() ?>cms/admin/edit_product/<?php echo $row->id ?>'><span class='glyphicon glyphicon-pencil'></span></a>
                <a href='<?php echo base_url() ?>cms/admin/remove_product/<?php echo $row->id ?>'><span class='glyphicon glyphicon-remove'></span></a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>