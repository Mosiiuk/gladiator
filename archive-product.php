<?php 
    wp_redirect( home_url() );
    get_header(); 
?>

    <section class="section__intro__mini section__intro__job">
        <?php if(get_field('header_backgroud_image', 8)){ ?>
            <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('header_backgroud_image', 8)['url']; ?>"></div>
        <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h1>shop</h1>

                </div>
            </div>
        </div>
    </section>


<!-- PRODUCTS -->
    <section class="section__shop__btns">
        <div class="container">
            <div class="row">
                <?php
                    $query = new WP_Query([
                        'post_status' => ['publish'],
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'orderby'        => 'menu_order',
                        'order' => 'ASC'
                    ]);
                    if ( $query->have_posts() ) {
                        while($query->have_posts()){
                            $query->the_post();
                            global $product;
                            $product_corner = get_field('product_corner',$product->get_id());
                            set_query_var('product',$product);
                            set_query_var('product_corner',$product_corner);
                            get_template_part('tmpl/arhive_product', 'tmpl');
                            ?>
<!--                                <div class="col-lg-3 col-md-6">
                                    <a class="offer__item" href="<?php /*echo $product->get_permalink() */?>">
                                        <?php /*echo $product->get_image() */?>
                                        <h3><?php /*echo $product->get_name() */?></h3>
                                        <div class="offer__price">
                                            from <?php /*echo wc_price($product->get_price()); */?>
                                        </div>
                                        <p>
                                            <?php /*the_field('description') */?>
                                        </p>
                                    </a>
                                </div>-->
                            <?php
                        }
                        wp_reset_postdata();
                    }
                ?>
            </div>
        </div>
    </section>

<!-- /PRODUCTS -->

    <section class="section__bottom__text">
        <?php if (get_field('bottom_background_image', 'footer')) { ?>
            <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('bottom_background_image', 'footer')['url']; ?>"></div>
        <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="have__questions__text">
                        <?php the_field('have_question', 'footer'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php get_footer(); ?>