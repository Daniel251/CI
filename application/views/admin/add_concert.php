<?= form_open('cms/admin/add_concert') ?>
  <div class="form-group">
    <label>Data</label>
    <input type="date" name='date' class="form-control input-date" required>
  </div>
  <div class="form-group">
    <label>Klub</label>
    <input type="text" name="club" class="form-control input" placeholder="Klub" required>
  </div>
  <div class="form-group">
    <label>Miasto</label>
      <input type="text" name="city" class="form-control input" placeholder="Miasto" required>
  </div>
  <button type="submit" class="btn btn-warning">Dodaj koncert</button>
<?= form_close() ?>