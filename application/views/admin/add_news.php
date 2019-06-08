<div class="error">
    <?= $this->session->flashdata('error') ?>
</div>
<?= form_open_multipart('cms/admin/add_news') ?>
    <div class="form-group">
        <label>Tytuł posta</label>
        <input type="text" name="title" class="form-control input" value='<?= $this->session->flashdata('title') ?>
' required>
    </div>
    <div  id='news-date' class="form-group">
        <label>Data posta</label>
        <input type="date" name="date" value='<?= $this->session->flashdata('date') ?>
' class="form-control input">
        <label>Godzina posta</label>
        <input type="time" name="time" value='<?= $this->session->flashdata('time') ?>
' class="form-control input">
    </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input class='checkbox' id='date-checkbox' name="checkbox" value='1' type="checkbox">Ustaw aktualną date i czas
            </label>
        </div>
    </div>
    <div class="form-group">
        <label>Treść posta</label>
        <textarea name='post' class="form-control input" rows="5"><?= $this->session->flashdata('post') ?></textarea>
    </div>
    <div class="form-group">
        <label>Zdjęcie</label>
        <input type="file" name='img'>
    </div>
    <button type="submit" class="btn btn-warning">Dodaj news</button>
<?= form_close() ?>