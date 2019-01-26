<div class="confirm">
    <?php echo $this->session->flashdata('ok'); ?>
</div>
<div class="error">
    <?php echo $this->session->flashdata('error'); ?>
</div>
    <a href="<?php echo base_url() ?>cms/admin/add_concert"><button class="btn btn-warning btn-lg btn-add">Dodaj Koncert</button></a>
    <table class="table">
        <thead>
            <th>Data</th>
            <th>Klub</th>
            <th>Miasto</th>
        </thead>
        <tbody>
        <?php foreach($concerts as $row): ?>
        <tr>
	        <td><?php echo $row->date; ?></td>
	        <td><?php echo $row->club; ?></td>
	        <td><?php echo $row->city; ?></td>
        	<td>
        		<a href = '<?php echo base_url() ?>cms/admin/edit_concert/<?php echo $row->id; ?>'><span class='glyphicon glyphicon-pencil'></span></a>
            	<a href = '<?php echo base_url() ?>cms/admin/remove_concert/<?php echo $row->id; ?>'><span class='glyphicon glyphicon-remove'></span></a>
            </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
    </div>
