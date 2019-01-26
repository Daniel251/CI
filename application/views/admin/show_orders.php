<div class="confirm">
    <?php echo $this->session->flashdata('ok'); ?>
</div>
<div class="error">
    <?php echo $this->session->flashdata('error'); ?>
</div>
    <div class="row title">
        Zamówienia niezrealizowane
    </div>
    <a href="<?php echo base_url() ?>cms/admin/orders_done"><button class="btn btn-warning btn-sm btn-add">Wyświetl zamówienia zrealizowane</button></a>
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
	        <td><?php echo $row->date; ?></td>
	        <td><?php echo $row->id; ?></td>
            <td><?php echo $row->email; ?></td>
            <td><a href='<?php echo base_url() ?>cms/admin/order_details/<?php echo $row->id; ?>'>Wyświetl szczegóły</a></td>
        </tr>
	<?php endforeach; ?>
    </tbody>
    </div>
