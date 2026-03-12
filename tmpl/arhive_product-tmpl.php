<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
<div class="col-lg-3 col-md-6">
    <a class="offer__item" href="<?php echo $product->get_permalink() ?>">
        <?php if ($product_corner) {
            set_query_var('product_corner',$product_corner);
            get_template_part('tmpl/product_item_corner', 'tmpl');
        } ?>
        <?php echo $product->get_image() ?>
        <h3><?php echo $product->get_name() ?></h3>
        <div class="offer__price">
            from <?php echo ' '.wc_price($product->get_price()); ?>
        </div>
        <p>
            <?php the_field('description') ?>
        </p>
    </a>
</div>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ]-->