<div class="confirm">
    <?= $this->session->flashdata('ok') ?>
</div>
<a href="<?= base_url() ?>cms/admin/add_video">
	<button class="btn btn-warning btn-lg btn-add">Dodaj Film</button>
</a>
<table class="table">
    <thead>
    	<th> </th>
        <th>Nazwa</th>
        <th>Link</th>
        <th>Krótka nazwa</th>
    </thead>
    <tbody>
	<?php foreach($videos as $row): ?>
		<tr>
		    <td><img src='<?= base_url() ?>images/videos/<?= $row->img_name ?>'></td>
		    <td class='col-md-5'><?= $row->description ?></td>
		    <td class='col-md-4 link'><a href='$<?= $row->link ?>'><?= substr($row->link, 0, 40) ?></a></td>
		    <td class='col-md-1'><?= $row->img_name ?></td>
		    <td class='col-md-1'>
		    	<a href = '<?= base_url() ?>cms/admin/edit_video/<?= $row->id ?>'><span class='glyphicon glyphicon-pencil'></span></a>
		        <a href = '<?= base_url() ?>cms/admin/remove_video/<?= $row->id ?>'><span class='glyphicon glyphicon-remove'></span></a>
		    </td>
		</tr>
	<?php endforeach ?>
	</tbody>
</div>