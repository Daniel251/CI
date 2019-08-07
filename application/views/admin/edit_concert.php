<?= form_open('cms/admin/edit_concert/'.$concerts->id ) ?>
  <div class="form-group">
    <label>Data</label>
    <input type="date" name='date' class="form-control input-date" value='<?= $concerts->date ?>' required>
  </div>
  <div class="form-group">
    <label>Klub</label>
    <input type="text" name="club" class="form-control input" placeholder="Klub" value='<?= $concerts->club ?>' required>
  </div>
  <div class="form-group">
    <label>Miasto</label>
      <input type="text" name="city" class="form-control input" placeholder="Miasto" value='<?= $concerts->city ?>' required>
  </div>
  <button type="submit" class="btn btn-warning">Edytuj koncert</button>
<?= form_close() ?>