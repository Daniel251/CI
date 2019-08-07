<div class="error">
    <?php echo $this->session->flashdata('error') ?>
</div>
<?php echo form_open_multipart('cms/admin/add_video') ?>
	<div class="form-group">
		<label>Nazwa filmu</label>
		<input type="text" name="description" class="form-control input" value='<?php echo $this->session->flashdata('description') ?>' required>
	</div>
	<div class="form-group">
		<label>Link</label>
		<input type="text" name="link" class="form-control input" value='<?php echo $this->session->flashdata('link') ?>' required>
	</div>
	<div class="form-group">
		<label>Zdjęcie</label>
		<input type="file" name='img' required>
	</div>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input name='big_player' type="checkbox" value='1'>Film główny
			</label>
		</div>
	</div>
	<button type="submit" class="btn btn-warning">Dodaj</button>
</form>