<?php echo form_open_multipart('cms/admin/edit_news/'.$news->id) ?>
    <div class="form-group">
        <label>Tytuł posta</label>
        <input type="text" name="title" class="form-control input" value='<?php echo $news->title; ?>' required>
    </div>
    <div id='news-date' class="form-group">
                <label>Data i godzina posta</label>
                <input type="datetime" name="date" class="form-control input" value='<?php echo $news->date; ?>' required>
            </div>
    <div class="form-group">
        <div class="checkbox">
            <label>
                <input class='checkbox' id='date-checkbox' name="checkbox" value='1' type="checkbox">Ustaw aktualną datę i czas
            </label>
        </div>
    </div>
    <div class="form-group">
        <label>Treść posta</label>
        <textarea name='post' class="form-control input" rows="5"><?php echo $news->post; ?></textarea>
    </div>
    <div class="form-group">
        <label>Zdjęcie - zostaw puste jeśli nie zmieniasz</label>
        <input type="file" name='img'>
    </div>
    <button type="submit" class="btn btn-warning">Aktualizuj</button>
<?php echo form_close(); ?>