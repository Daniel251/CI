<div id='product-page'>
    <div class='row'>
        <div class='col-xs-2 img'>
            <div id='item-id'>
                Nr kat. #<?php echo $product->nr;  ?> 
            </div>
            <?php foreach($images as $img): ?>
               <a href='<?php echo base_url(); ?>images/products/<?php echo $img; ?>' data-lightbox='<?php echo $product->nr; ?>'>
                <img src='<?php echo base_url(); ?>images/products/thumbs/<?php echo $img; ?>'><br />
            </a><br />
            <?php endforeach; ?>
        </div>
        <div class='col-xs-10'>
            <div class='row'>
                <div id='item-name' class='col-sm-8'>
                    <?php echo $product->name; ?>
                </div>
                <div id='item-price' class='col-sm-4 gold'>
                    Cena: <?php echo number_format($product->price, 2); ?> zł
                </div>
            </div>
            <div class='row'>
                <div id='item-description' class='col-sm-8'>

    <?php if($product->category_id == 2): ?>
        <div class='form-group'>
            <label>Rozmiar</label> 
            <select class='form-control product-size' name='category' required>

            <?php foreach ($sizes as $key => $val): ?>
                <?php if($val==1): ?>
                    <option value='<?php echo $key; ?>'><?php echo strtoupper($key) ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
            </select>
        </div>
    <?php else: ?>
        <input type='text' class='product-size' disabled hidden value='0'>
    <?php endif; ?>

        <?php echo nl2br($product->description); ?>
    </div>
    <div class='col-sm-4'>
        <div class='button'>
            <button type='button' id='<?php echo $product->id; ?>' class='btn btn-warning btn-xs add-to-cart'>Do koszyka <span class='glyphicon glyphicon-plus'></span></button>
        </div>
    </div>
</div>