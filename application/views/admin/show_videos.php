<div class="confirm">
    <?php echo $this->session->flashdata('ok'); ?>
</div>
<a href="<?php echo base_url() ?>cms/admin/add_video">
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
		    <td><img src='<?php echo base_url() ?>images/videos/<?php echo $row->img_name; ?>'></td>
		    <td class='col-md-5'><?php echo $row->description; ?></td>
		    <td class='col-md-4 link'><a href='$<?php echo $row->link ?>'><?php echo substr($row->link, 0, 40); ?></a></td>
		    <td class='col-md-1'><?php echo $row->img_name; ?></td>
		    <td class='col-md-1'>
		    	<a href = '<?php echo base_url() ?>cms/admin/edit_video/<?php echo $row->id; ?>'><span class='glyphicon glyphicon-pencil'></span></a>
		        <a href = '<?php echo base_url() ?>cms/admin/remove_video/<?php echo $row->id; ?>'><span class='glyphicon glyphicon-remove'></span></a>
		    </td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</div>