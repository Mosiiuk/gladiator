<?php
$tab_names = '';
$sub_cats = get_the_terms( $product->get_id(), 'product_cat' );
    if($sub_cats) {
        $total_cats = count($sub_cats);
        $sub_cats_count = 0;
        foreach($sub_cats as $sub_category) {
            $sub_cats_count++;
            if($sub_cats_count == $total_cats){
                $tab_names .= $sub_category->slug;
            } else {
                $tab_names .= $sub_category->slug.',';
            }
        }

    }


?>

<a class="offer__item  tab_item <?php if($post_count > $posts_per_page){echo 'hidden';}; ?>" href="<?php echo get_permalink($product->get_id());?>" data-game="<?php echo $tab_names;?>" data-prodid="<?php echo $product->get_id();?>">

    <?php if ($product_corner) {

        set_query_var('product_corner',$product_corner);

        get_template_part('tmpl/product_item_corner', 'tmpl');

    } ?>

    <?php echo $product->get_image(); ?>

    <h3><?php echo $product->get_name(); ?></h3>

    <div class="offer__price">

        from <?php echo ' '.$product->get_price_html();?>

    </div>

    <p>

        <?php

            echo get_field('description', $product->get_id());

        ?>

    </p>

</a>