<div class="error">
    <?php echo $this->session->flashdata('error') ?>
</div>
<?php echo form_open_multipart('cms/admin/edit_video/'.$videos->id) ?>
	<div class="form-group">
		<label>Nazwa filmu</label>
		<input type="text" name="description" class="form-control input" value='<?php echo $videos->description ?>' required>
	</div>
	<div class="form-group">
		<label>Link</label>
		<input type="text" name="link" class="form-control input" value='<?php echo $videos->link ?>' required>
	</div>
	<div class="form-group">
		<label>Zdjęcie (zostaw puste jeśli nie zmieniasz)</label>
		<input type="file" name='img'>
	</div>
	<?php if($videos->big_player != 1): ?>
	<div class="form-group">
		<div class="checkbox">
			<label>
				<input name='big_player' type="checkbox" value='1'>Film główny
			</label>
		</div>
	</div>
<?php endif ?>
	<button type="submit" class="btn btn-warning">Dodaj</button>
</form>