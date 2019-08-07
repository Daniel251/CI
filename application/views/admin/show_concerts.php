<div class="confirm">
    <?= $this->session->flashdata('ok') ?>
</div>
<div class="error">
    <?= $this->session->flashdata('error') ?>
</div>
    <a href="<?= base_url() ?>cms/admin/add_concert"><button class="btn btn-warning btn-lg btn-add">Dodaj Koncert</button></a>
    <table class="table">
        <thead>
            <th>Data</th>
            <th>Klub</th>
            <th>Miasto</th>
        </thead>
        <tbody>
        <?php foreach($concerts as $row): ?>
        <tr>
	        <td><?= $row->date ?></td>
	        <td><?= $row->club ?></td>
	        <td><?= $row->city ?></td>
        	<td>
        		<a href = '<?= base_url() ?>cms/admin/edit_concert/<?= $row->id ?>'><span class='glyphicon glyphicon-pencil'></span></a>
            	<a href = '<?= base_url() ?>cms/admin/remove_concert/<?= $row->id ?>'><span class='glyphicon glyphicon-remove'></span></a>
            </td>
        </tr>
	<?php endforeach ?>
    </tbody>
    </div>
