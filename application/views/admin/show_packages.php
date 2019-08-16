<div class="confirm">
    <?php echo $this->session->flashdata('ok') ?>
</div>
<div class="error">
    <?php echo $this->session->flashdata('error') ?>
</div>
<table class="table">
    <thead>
    <th>Nazwa</th>
    <th>Cena</th>
    <th>Aktywna</th>
    <th></th>
    </thead>
    <tbody>
    <?php foreach ($packageTypes as $type): ?>
        <tr>
            <td><input id="package-name-<?php echo $type->id ?>" type="text" value="<?php echo $type->name ?>"></td>
            <td><input id="package-price-<?php echo $type->id ?>" type="number" value="<?php echo $type->price ?>"></td>
            <td><input id="package-is-active-<?php echo $type->id ?>" type="checkbox" <?php echo $type->is_active ? 'checked' : '' ?>></td>
            <td>
                <a id="edit-package-<?php echo $type->id ?>" href="javascript:void(0)" onclick="editPackage(<?php echo $type->id ?>)">
                    <span class='glyphicon glyphicon-ok'></span>
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    <tr id="add-package"><td></td><td></td><td></td><td><span id="save-error"></span></td></tr>
    </tbody>
</table>
<a id="add-package-type-btn" href="javascript:void(0)" onclick="addPackageRow()">
    <button class="btn btn-warning btn-add">Dodaj typ paczki</button>
</a>