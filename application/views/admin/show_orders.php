<div class="confirm">
    <?= $this->session->flashdata('ok') ?>
</div>
<div class="error">
    <?= $this->session->flashdata('error') ?>
</div>
    <div class="row title">
        Zamówienia niezrealizowane
    </div>
    <a href="<?= base_url() ?>cms/admin/orders_done"><button class="btn btn-warning btn-sm btn-add">Wyświetl zamówienia zrealizowane</button></a>
    <table class="table">
        <thead>
            <th>Data zamówienia</th>
            <th>Nr. Zamówienia</th>
            <th>Email zamawiającego</th>
            <th>Szczegóły</th>
        </thead>
        <tbody>
        <?php foreach($orders as $row): ?>
        <tr>
	        <td><?= $row->date ?></td>
	        <td><?= $row->id ?></td>
            <td><?= $row->email ?></td>
            <td><a href='<?= base_url() ?>cms/admin/order_details/<?= $row->id ?>'>Wyświetl szczegóły</a></td>
        </tr>
	<?php endforeach ?>
    </tbody>
    </div>
