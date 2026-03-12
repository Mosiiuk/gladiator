<?php get_header(); ?>
<?php if( !is_order_received_page() ) { ?>
<!--
<?php } ?>
<section class="section__intro__mini">
<div class='container'>

<div class='row'>

<div class='col-12'> <?php if( !is_order_received_page() ) { ?> --><?php } ?>

  <?php the_content(); ?>
<?php if( !is_order_received_page() ) { ?><!-- <?php } ?>
</div>

</div>

</div>

</section> <?php if( !is_order_received_page() ) { ?> --><?php } ?>
<?php get_footer(); ?>