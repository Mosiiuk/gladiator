<?php
get_header();

// Cache get_field call
$show_per_page = wp_cache_get( 'show_per_page' );
if ( false === $show_per_page ) {
	$show_per_page = get_field( 'show_per_page', 'option' );
	wp_cache_set( 'show_per_page', $show_per_page );
}

$term = get_queried_object();
?>
  <!-- [<?php echo str_replace( $_SERVER['DOCUMENT_ROOT'], '', __FILE__ ); ?> -->


  <!--  data-image-src="--><?php //the_image_url('heading_image', $term) ?><!--"-->


  <section class="section__intro__mini section__intro__arena">
    <div class="background__img" data-parallax="scroll">
      <img src="<?php the_image_url( 'heading_image', $term ) ?>" alt="">
    </div>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
					<?php
					if ( function_exists( 'bcn_display' ) ) {
						?>
            <ul class="navbar"><?php
						echo str_replace( '<br>', ' ', (string) bcn_display( true ) );
						?></ul><?php
					}
					?>
        </div>
        <div class="col-lg-8">
          <h1><?php echo $term->name ?></h1>
					<?php echo term_description( $term ) ?>
        </div>

        <div class="col-lg-4">
          <div class="d-flex justify-content-lg-end">
            <div class="hero_overal_rating">
              <div class="product_reviews">
                                    <span>
                                        Overall rating
                                    </span>

                <img src="<?php echo get_template_directory_uri(); ?>/img/reviews1.png" alt="alt">
                  <?php
                  $product_overall_rating = get_field( 'product_overall_rating', 'options' ); // Use the field name of the accordion
                  ?>
                <span class="reviews_count"><?php echo $product_overall_rating; ?>+ reviews</span>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PRODUCTS -->
  <section class="section__advantages">
    <div class="container">
			<?php
			$before_products_shortcode = get_field( 'before_products_shortcode', $term );
			if ( $before_products_shortcode ) {
				echo do_shortcode( $before_products_shortcode );
			}
			?>

			<?php
			// Cache the result of get_terms
			$cached_termchildren = wp_cache_get( 'termchildren_' . $term->term_id );
			if ( false === $cached_termchildren ) {
				$cached_termchildren = get_terms( 'product_cat', array( 'child_of' => $term->term_id ) );
				wp_cache_set( 'termchildren_' . $term->term_id, $cached_termchildren );
			}

			$map_term   = [];
			$map_term[] = $term;

			if ( ! empty( $cached_termchildren ) && is_array( $cached_termchildren ) ) {
				foreach ( $cached_termchildren as $id_term_child ) {
					$ch_term    = get_term( $id_term_child );
					$map_term[] = $ch_term;
				}
			}
			?>
      <div class="row">
        <!-- Remaining code unchanged... -->
        <div class="col-12">

          <div class="tab_title_wrap tab_title_categories ">
            <div class="scrolling-buttons">
              <div class="scrolling-buttons-inner">
                <div class="button-container">
                  <div class="tab_title active" data-gamename="all">
                    All
                  </div>
									<?php
									foreach ( $map_term as $k => $value ) {
										if ( $k > 0 ) {
											echo "
                                                <div class=\"tab_title\" data-gamename=\"$value->slug\">
                                                $value->name
                                                </div>
                                            ";
										}
									}
									?>
                </div>
              </div>
              <button class="scroll-left-button scroll-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20px" height="20px"
                     class="navigation__StyledChevronLeftIcon-sc-v3efrf-1 tbObS">
                  <path fill-rule="evenodd"
                        d="M15.694 18.694a1.043 1.043 0 0 0 0-1.476L10.47 12l5.224-5.218a1.043 1.043 0 0 0 0-1.476 1.046 1.046 0 0 0-1.478 0l-5.91 5.904a1.04 1.04 0 0 0-.305.79 1.04 1.04 0 0 0 .305.79l5.91 5.904c.408.408 1.07.408 1.478 0Z"
                        clip-rule="evenodd"></path>
                </svg>
              </button>
              <button class="scroll-right-button scroll-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20px" height="20px"
                     class="navigation__StyledChevronLeftIcon-sc-v3efrf-1 tbObS">
                  <path fill-rule="evenodd"
                        d="M15.694 18.694a1.043 1.043 0 0 0 0-1.476L10.47 12l5.224-5.218a1.043 1.043 0 0 0 0-1.476 1.046 1.046 0 0 0-1.478 0l-5.91 5.904a1.04 1.04 0 0 0-.305.79 1.04 1.04 0 0 0 .305.79l5.91 5.904c.408.408 1.07.408 1.478 0Z"
                        clip-rule="evenodd"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-12 p-0 if_js-tabs_wrap">
          <!-- tabs_items_wrap -->
          <div class="js-tabs_wrap ">
						<?php
						$alreadyIn       = array();
						$posts_count     = 0;
						$pagination_html = '';

						foreach ( $map_term as $value ) {
							$paged          = ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
							$posts_per_page = $show_per_page;
							$query          = new WP_Query( [
								'post_status'    => [ 'publish' ],
								'post_type'      => 'product',
								'post__not_in'   => $alreadyIn,
								'posts_per_page' => $posts_per_page,
								//'posts_per_page' => -1,
								'tax_query'      => [
									[
										'taxonomy' => 'product_cat',
										'field'    => 'term_id',
										'terms'    => $value->term_id
									]
								],
								'orderby'        => 'menu_order',
								'order'          => 'ASC',
								'paged'          => $paged,
							] );

							$posts = $query->get_posts();


							//---- all count ---

							$query_all = new WP_Query( [
								'post_status'    => [ 'publish' ],
								'post_type'      => 'product',
								'post__not_in'   => $alreadyIn,
								'posts_per_page' => - 1,
								'fields'         => 'ids',
								'tax_query'      => [
									[
										'taxonomy' => 'product_cat',
										'field'    => 'term_id',
										'terms'    => $value->term_id
									]
								],
							] );

							$posts_all = $query_all->get_posts();

							//---- /all count --

							$html = '';
							if ( is_array( $posts ) && count( $posts ) ) {

								foreach ( $posts as $key => $item ) {
									$product_corner = get_field( 'product_corner', $item->ID );
									$product        = new WC_Product( $item->ID );
									$alreadyIn[]    = $item->ID;

									set_query_var( 'post_item', $item );
									set_query_var( 'product', $product );
									set_query_var( 'tab_name', $value->slug );
									set_query_var( 'product_corner', $product_corner );
									set_query_var( 'post_count', ++ $posts_count );
									set_query_var( 'posts_per_page', $posts_per_page );


									ob_start();
									get_template_part( 'tmpl/product_item', 'tmpl' );
									$html .= ob_get_contents();
									ob_end_clean();
								}
							}

							$config     = array( 'indent' => true, 'output-xhtml' => true, 'show-body-only' => 1 );
							$prettyhtml = tidy_parse_string( $html, $config, 'UTF8' );
							$prettyhtml->cleanRepair();
							echo $prettyhtml;

							$total_pages = $query->max_num_pages;
							if ( ! empty( $term->parent ) && $term->parent != 0 ) {
								$gamename = $value->slug;
							} elseif ( $term->slug == $value->slug ) {
								$gamename = 'all';
							} else {
								$gamename = $value->slug;
							}

							if ( $posts_count < 1 ) {
								$class_hidden = 'hidden';
							};
							if ( $total_pages > 1 ) {

								$pagination_html .= '<div class="pagination tab_item ' . $class_hidden . '" data-id="' . $value->term_id . '" data-game="' . $gamename . '" data-per-page="' . $posts_per_page . '" data-offset="' . $posts_per_page . '" data-total_pages="' . $total_pages . '" data-all_count_post="' . count( $posts_all ) . '">

                                                            <p>' . __( 'Load More', 'gladiatorboost' ) . '</p>
                                    
                                                        </div>';
							}


						}


						?>

          </div>

					<?php echo $pagination_html; ?>

          <div class="preloader" style="display: none;">
            <svg width="100px" height="100px" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"
                 style="background: none;">
              <circle cx="75" cy="50" fill="#36b3ff" r="6.39718">
                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" times="0;0.1;0.2;0.3;1" dur="1s"
                         repeatCount="indefinite" begin="-0.875s"></animate>
              </circle>
              <circle cx="67.678" cy="67.678" fill="#36b3ff" r="4.8">
                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" times="0;0.1;0.2;0.3;1" dur="1s"
                         repeatCount="indefinite" begin="-0.75s"></animate>
              </circle>
              <circle cx="50" cy="75" fill="#36b3ff" r="4.8">
                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" times="0;0.1;0.2;0.3;1" dur="1s"
                         repeatCount="indefinite" begin="-0.625s"></animate>
              </circle>
              <circle cx="32.322" cy="67.678" fill="#36b3ff" r="4.8">
                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" times="0;0.1;0.2;0.3;1" dur="1s"
                         repeatCount="indefinite" begin="-0.5s">
                </animate>
              </circle>
              <circle cx="25" cy="50" fill="#36b3ff" r="4.8">
                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" times="0;0.1;0.2;0.3;1" dur="1s"
                         repeatCount="indefinite" begin="-0.375s"></animate>
              </circle>
              <circle cx="32.322" cy="32.322" fill="#36b3ff" r="4.80282">
                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" times="0;0.1;0.2;0.3;1" dur="1s"
                         repeatCount="indefinite" begin="-0.25s"></animate>
              </circle>
              <circle cx="50" cy="25" fill="#36b3ff" r="6.40282">
                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" times="0;0.1;0.2;0.3;1" dur="1s"
                         repeatCount="indefinite" begin="-0.125s"></animate>
              </circle>
              <circle cx="67.678" cy="32.322" fill="#36b3ff" r="7.99718">
                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" times="0;0.1;0.2;0.3;1" dur="1s"
                         repeatCount="indefinite" begin="0s">
                </animate>
              </circle>
            </svg>
          </div>

        </div>
      </div>

    </div>
  </section>

  <!-- /PRODUCTS -->
  <section class="section__boosting_question">

    <div class="container">
      <div class="boosting_question_wrap">
        <div class="boosting_question_bg">
          <img src="<?php echo theme_url; ?>/img/boosting_question_bg.jpeg" alt="">
        </div>

        <div class="boosting_question_text d-flex justify-content-between">

          <h2>Any questions about Boosting?</h2>
          <a href="#" class="btn-main" id="prod_cat_show_chat" >
            Open chat with us
          </a>
        </div>
      </div>
    </div>

  </section>

  <section class="section__advantages_items">

    <div class="container">

      <div class="row">
        <div class="col-lg-4">

          <div class="advantages_item">
            <div class="advantages_item_icon">
              <img src="<?php echo theme_url; ?>/img/advantages_item_icon_1.svg" alt="">
            </div>
            <p>
              We 100% Guarantee the full delivery and result of the order you purchase with nothing less
            </p>


          </div>

        </div>
        <div class="col-lg-4">

          <div class="advantages_item">
            <div class="advantages_item_icon">
              <img src="<?php echo theme_url; ?>/img/advantages_item_icon_2.svg" alt="">
            </div>
            <p>
              You have full safety on purchase, as all payments are fully secured with buyer protection
            </p>


          </div>

        </div>
        <div class="col-lg-4">

          <div class="advantages_item">
            <div class="advantages_item_icon">
              <img src="<?php echo theme_url; ?>/img/advantages_item_icon_3.svg" alt="">

            </div>
            <p>
              Your boost will be performed quickly, safely and professionally by the current top PRO Players in the Game
            </p>

          </div>

        </div>
      </div>

    </div>

  </section>

  <section class="section__howtoorder">
		<?php
		$after_products_shortcode = get_field( 'after_products_shortcode', $term );
		if ( $after_products_shortcode ) {
			echo do_shortcode( $after_products_shortcode );
		}
		?>
  </section>

  <section class="section__bottom__text__arena">
    <div class="container">
      <div class="row">
        <div class="col-12">
			<?php the_field( 'after_products_content', $term ) ?>
        </div>
      </div>
  </section>



<?php
    $boost_services = get_field('boost_services',$term);

    if ($boost_services)
    {
?>
  <section class="boost_services__section">
    <div class="container">
      <div class="col-12">
        <h2>
          <?php echo $boost_services['title'];?>
        </h2>
        <div class="boost_services__wrap">

            <?php
                $repeater= $boost_services['items'];
                if ( is_array($repeater) && count($repeater) )
                {
                    foreach ($repeater as $key => $item)
                    {
                        echo "
                             <div class=\"boost_services__item\">
                                <h6>$item[title]</h6>
                                <p>$item[text]</p>
                              </div>
                        ";
                    }
                }
            ?>
        </div>
      </div>
    </div>
  </section>
<?php } ?>

<!-- FAQ -->
<?php
$faq = get_field('faq',$term);

if ($faq)
{
    ?>

    <section class="faq_section">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <h2> <?php echo $faq['title'];?></h2>


                    <?php if (!empty($faq['items']) && is_array($faq['items'])) : ?>
                        <div class="accordion" id="faq">
                            <?php foreach ($faq['items'] as $key => $item) :
                                $collapseId = "collapse" . ($key + 1);
                                $headingId = "heading" . ($key + 1);
                                $isFirst = ($key === 0) ? 'show' : '';
                                $isExpanded = ($key === 0) ? 'true' : 'false';
                                ?>
                                <div class="card">
                                    <div class="card-header" id="<?= $headingId ?>">
                                        <button class="btn <?= $isFirst ? '' : 'collapsed' ?>" type="button" data-toggle="collapse" data-target="#<?= $collapseId ?>" aria-expanded="<?= $isExpanded ?>" aria-controls="<?= $collapseId ?>">
                                            <?= htmlspecialchars($item['title']) ?>
                                        </button>
                                    </div>
                                    <div id="<?= $collapseId ?>" class="collapse <?= $isFirst ?>" aria-labelledby="<?= $headingId ?>" data-parent="#faq">
                                        <div class="card-body">
                                            <?= nl2br(htmlspecialchars($item['text'])) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

    </section>

<?php } ?>



<!-- /FAQ -->

  <!-- <?php echo str_replace( $_SERVER['DOCUMENT_ROOT'], '', __FILE__ ); ?> ] -->
<?php get_footer(); ?>