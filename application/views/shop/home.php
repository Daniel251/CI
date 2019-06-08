<div class="ok col-sm-12 text-center">
    <h2><?= $this->session->flashdata('ok') ?></h2>
</div>
<div class='header'>
   <?= $category ?>
</div>

<?php foreach ($products as $row): ?>
    <div class='col-md-2 col-sm-3 col-xs-5 product'>
        <div class='img-thumb'>
            <a href='<?= base_url() ?>images/products/<?= $row->nr ?>-0.jpg' data-lightbox='$nr'>
                <img src='<?= base_url() ?>images/products/thumbs/<?= $row->nr ?>-0.jpg'><br />
            </a>
        </div>
    <div class='product-name'>
        <a href='<?= base_url() ?>shop/home/product/<?= $row->id ?>'>
            <?= $row->name ?>
        </a>
    </div>
    <div class='price'>
        <?= number_format($row->price, 2) ?> zł
    </div>
    <?php if($row->category_id !=2 ): ?>
        <input type='text' class='product-size' disabled hidden value='0'>
        <button type='button' id='<?= $row->id ?>' class='btn btn-warning btn-xs add-to-cart'>
            Do koszyka <span class='glyphicon glyphicon-plus'></span>
        </button>
<?php endif ?>
</div>
<?php endforeach ?>
<div class='clear'></div>