<div class="confirm">
    <div class="confirm"><?= $this->session->flashdata('ok') ?></div>
</div>
<a href="<?= base_url() ?>cms/admin/add_news"><button class="btn btn-warning btn-lg btn-add">Dodaj Newsa</button></a>
    <table class="table">
        <thead>
            <th></th>
            <th>Tytuł</th>
            <th>Data</th>
            <th></th>
        </thead>
        <tbody>


    <?php foreach($news as $row): ?>

        <tr>
        <td ><div class='img-news'><img src='<?= base_url() ?>images/posts/<?= $row->img_name ?>'></div></td>
        <td><?= $row->title ?></td>
        <td ><?= $row->date ?></td>
        <td >
            <a href = '<?= base_url() ?>cms/admin/edit_news/<?= $row->id ?>'><span class='glyphicon glyphicon-pencil'></span></a>
            <a href = '<?= base_url() ?>cms/admin/remove_news/<?= $row->id ?>'><span class='glyphicon glyphicon-remove'></span></a></td>
        </tr>
    <?php endforeach ?>
    </tbody>
    </div>