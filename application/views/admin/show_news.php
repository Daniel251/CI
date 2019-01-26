<div class="confirm">
    <div class="confirm"><?php echo $this->session->flashdata('ok'); ?></div>
</div>
<a href="<?php echo base_url() ?>cms/admin/add_news"><button class="btn btn-warning btn-lg btn-add">Dodaj Newsa</button></a>
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
        <td ><div class='img-news'><img src='<?php echo base_url() ?>images/posts/<?php echo $row->img_name; ?>'></div></td>
        <td><?php echo $row->title; ?></td>
        <td ><?php echo $row->date; ?></td>
        <td >
            <a href = '<?php echo base_url() ?>cms/admin/edit_news/<?php echo $row->id; ?>'><span class='glyphicon glyphicon-pencil'></span></a>
            <a href = '<?php echo base_url() ?>cms/admin/remove_news/<?php echo $row->id; ?>'><span class='glyphicon glyphicon-remove'></span></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </div>