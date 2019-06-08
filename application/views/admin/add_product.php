<div class="error"><?= $this->session->flashdata('error') ?></div>
<?= form_open_multipart('cms/admin/add_product') ?>
<div class='form-group'>
    <label>Kategoria</label> 
    <select class='form-control input' id="new-category" name='category' required>
		<?php foreach ($categories as $category): ?>
		     <option value='<?= $category->id ?>'><?= $category->name ?></option>
         <?php endforeach ?>
    </select>
</div>
<div class='form-group'>
    <label>Nazwa</label>
    <input type='text' name='name' class='form-control input' value='<?= $this->session->flashdata('name') ?>' required>
</div>
<div class='form-group'>
    <label>Nr kat.</label>
    <input type='text' name='nr' class='form-control input' maxlength="6" value='<?= $this->session->flashdata('nr') ?>' required>
</div>
<div id='form-sizes' class='radio hide'>
<div>
    Rozmiary:
</div>
<?php foreach($product_sizes as $key => $value): ?>
    <label class='checkbox-inline'> 
        <input type='checkbox' <?= $value ?> value='1' name='<?= $key ?>'> <?= $key ?>
    </label>
<?php endforeach ?>
</div>
<div class='form-group'>
    <label>Cena</label>
    <input type='number' name='price' step='0.01' class='form-control number' value='<?= number_format($this->session->flashdata('price'), 2) ?>' required>
</div>
<div class='form-group'>
    <label>Opis</label>
    <textarea name='description' class='form-control input' rows='3'><?= $this->session->flashdata('description') ?></textarea>
</div>
<div class='form-group'>
    <label>Zdjęcie nr 1</label>
    <input type='file' name='img1'>
</div>
<div class='form-group'>
    <label>Zdjęcie nr 2 - niewymagane</label>
    <input type='file' name='img2'>
</div>
<button type='submit' class='btn btn-warning'>Zatwierdź Produkt</button>
</form>