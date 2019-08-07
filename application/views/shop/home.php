<div class="ok col-sm-12 text-center">
    <h2><?php echo $this->session->flashdata('ok') ?></h2>
</div>
<div class='header'>
   <?php echo $category ?>
</div>

<?php foreach ($products as $row): ?>
    <div class='col-md-2 col-sm-3 col-xs-5 product'>
        <div class='img-thumb'>
            <a href='<?php echo base_url() ?>images/products/<?php echo $row->nr ?>-0.jpg' data-lightbox='$nr'>
                <img src='<?php echo base_url() ?>images/products/thumbs/<?php echo $row->nr ?>-0.jpg'><br />
            </a>
        </div>
    <div class='product-name'>
        <a href='<?php echo base_url() ?>shop/home/product/<?php echo $row->id ?>'>
            <?php echo $row->name ?>
        </a>
    </div>
    <div class='price'>
        <?php echo number_format($row->price, 2) ?> zł
    </div>
    <?php if($row->category_id !=2 ): ?>
        <input type='text' class='product-size' disabled hidden value='0'>
        <button type='button' id='<?php echo $row->id ?>' class='btn btn-warning btn-xs add-to-cart'>
            Do koszyka <span class='glyphicon glyphicon-plus'></span>
        </button>
<?php endif ?>
</div>
<?php endforeach ?>
<div class='clear'></div>