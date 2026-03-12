<?php
/**
 * Template Name: Search
 *
 */

get_header();
?>

<section class="section__intro__mini section__intro__arena">

    <?php if(get_field('header_backgroud_image', 8)){ ?>
        <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('header_backgroud_image', 8)['url']; ?>"></div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h1><?php _e('Search by: ', 'gladiator'); ?><?php echo $_GET['search']; ?></h1>
                <br>
                <br>
            </div>
        </div>
    </div>
</section>

<section class="section__advantages search_results">
    <div class="container">
        <div class="row">
            <div class="col-12">
            
            <?php
            $search_value = $_GET['search'];

            $query_args = array(
                'post_type' => 'product',
                'posts_per_page' => 50,
                'post_status' => array('publish'),
                'fields' => array('ids', 'post_title'),
                'cache_results' => false,
                's' => $search_value,

            );

            $query = new WP_Query($query_args);
            $totalCount = $query->found_posts;

            if ($query->have_posts() && $search_value) {

                echo '<ul>';

                foreach ($query->posts as $game) {

                    $descr   = get_field('description_text', $game->ID);

                ?>

                                            
                    <li>
                        <a href="<?php the_permalink($game->ID); ?>"><?php echo $game->post_title; ?></a>
                        <p>
                            <?php echo mb_strimwidth($descr, 0, 150, '...'); ?>
                        </p>
                    </li>

                <?php

                }

                echo '</ul>';

            } else {

            ?>

                <div class="result_item">
                    <span class="not_found"><?php _e('No Games Found.');?></span>
                </div>

            <?php
            }
            ?>

            </div>

        </div>
    </div>
</section>

<?php
get_footer();