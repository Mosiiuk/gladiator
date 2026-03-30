<?php
defined('ABSPATH') || exit;

global $product;

if ('product_game_money' !== $product->get_type()) {
    return;
}
?>
123
<!-- [ <?php echo str_replace($_SERVER["DOCUMENT_ROOT"], '', __FILE__); ?> -->
<div class="game-money-product ">
    <h1><?php the_title(); ?></h1>
    <p><?php echo $product->get_description(); ?></p>
    <p>
        <strong><?php _e('Game Money Value:', 'custom-woocommerce-product'); ?></strong>
        <?php echo get_post_meta($product->get_id(), '_game_money_value', true); ?>
    </p>
    <?php woocommerce_template_single_add_to_cart(); ?>
</div>
<!-- <?php echo str_replace($_SERVER["DOCUMENT_ROOT"], '', __FILE__); ?> ]-->