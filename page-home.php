<?php
/*
Template Name: Home
*/
get_header();

$game_design = Game_Change::get_instance()->get_game_design();

?>
<!--[ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->

        <section class="hero">
            <img class="hero__bg" src="<?php echo theme_url;?>/img/hero-bg.png" alt="background">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero__title ">
                            <img src="<?php echo theme_url;?>/img/favicon.svg" alt="GladiatorBoost - Game Boosting Services Logo">
                            <h1 class="wow animate__animated animate__zoomIn" data-wow-duration="1.5s"><?php echo __('GladiatorBoost:','gladiator-theme');?></h1>
                            <h2 class="wow animate__animated animate__fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.4s"><?php echo __('','gladiator-theme');?> <span class="blue__text"><?php echo __('Trusted & Legit Game Boosting Services','gladiator-theme');?></span></h2>
                            <p><?php echo __('GladiatorBoost offers trusted game boosting and coaching to help gamers succeed.','gladiator-theme');?></p>

                            <div class="search_home_wrap">
                              <form autocomplete="off" role="search" method="get"  action="#" class="search_form search_form_hero">
                                <button type="button" >
                                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="6" stroke="white"></circle>
                                    <path d="M20 20L17 17" stroke="white" stroke-linecap="round"></path>
                                  </svg>
                                </button>

                                <input type="search" value="" name="home_search_ext" id="home_search_ext" class="search-input home_search_ext"  placeholder="Search">

                                  <div class="home_search_ext_result_wrap">
                                          <!--- POPAP RESULT -->
                                          <div id="home_search_ext_result" >

                                          </div>
                                          <!--- /POPAP RESULT -->
                                   </div>
                              </form>

                            </div>

                        </div>


                        <div class="hero__games_wrap popular_games">

                        <h3>
                          Popular Games
                        </h3>
                        <div class="hero__games">

                          <?php

                            $repeater= get_field('popular_game', 'options')['popular_games'];

                            if ( is_array($repeater) && count($repeater) )
                            {
                               foreach ($repeater as $key => $item)
                               {
                                   $icon = $item['icon'];
                                   $link = get_term_link($item['game_category']);

                                   echo "
                                        <div class=\"hero__games-item\">
                                            <img src=\"{$icon['url']}\" alt=\"{$icon['alt']}\">
                                            <div class=\"hero__games-title\">
                                                <h4>{$item['title']}</h4>
                                            </div>
                                            <a href=\"$link\" class=\"hero__games-description\">
                                                <div class=\"hero__games-content\">
                                                    <h4>{$item['title']}</h4>
                                                    <p>{$item['subtitle']}</p>
                                                </div>
                                                <p>Details<img src=\"".theme_url."/img/arrow.svg\" alt=\"arrow\"></p>
                                            </a>
                                        </div>
                                    ";

                               }
                            }


                           /* $tabs = $game_design['tabs'];
                            if (isset($tabs) && is_array($tabs) && count($tabs))
                            {
                                $count = 0;
                                foreach ($tabs as $key => $item)
                                {
                                    if ($count >= 5) break;

                                    $link = get_term_link($item['category']);
                                    $icon = $item['icon'];
                                    echo "
                                        <div class=\"hero__games-item\">
                                            <img src=\"{$icon['url']}\" alt=\"{$icon['alt']}\">
                                            <div class=\"hero__games-title\">
                                                <h4>{$item['title']}</h4>
                                            </div>
                                            <a href=\"$link\" class=\"hero__games-description\">
                                                <div class=\"hero__games-content\">
                                                    <h4>{$item['title']}</h4>
                                                    <p>{$item['subtitle']}</p>
                                                </div>
                                                <p>Details<img src=\"".theme_url."/img/arrow.svg\" alt=\"arrow\"></p>
                                            </a>
                                        </div>
                                    ";
                                    $count++;
                                }
                            }*/
                        ?>

                        </div>
                        </div>
                        <div class="hero__games_wrap">

                        <h3>Browse all Games</h3>

                            <div class="hero__games ">

                                <?php
                                    $tabs = $game_design['tabs'];
                                    if (isset($tabs) && is_array($tabs) && count($tabs))
                                    {
                                        foreach ($tabs as $key => $item)
                                        {
                                            $link = get_term_link($item['category']);
                                            $icon = $item['icon'];
                                            echo "
                                                <div class=\"hero__games-item home_all_list_game\">
                                                    <img src=\"$icon[url]\" alt=\"$icon[alt]\">
                                                    <div class=\"hero__games-title\">
                                                        <h4>$item[title]</h4>
                                                    </div>
                                                    <a href=\"$link\" class=\"hero__games-description\">
                                                        <div class=\"hero__games-content\">
                                                            <h4>$item[title]</h4>
                                                            <p>$item[subtitle]</p>
                                                        </div>
                                                        <p>Details<img src=\"".theme_url."/img/arrow.svg\" alt=\"arrow\"></p>
                                                    </a>
                                                </div>
                                            ";
                                        }
                                    }

                                    $buttons = get_field('buttons',get_the_ID());
                                ?>
                            </div>

                            <a href="#" class="btn-main" id="home_all_list_game_btn" >Show more </a>

        <!--
                            <a href="<?php echo $buttons['get_started_now']['url'];?>" <?php echo $buttons['get_started_now']['target'];?> class="btn-main"><?php echo $buttons['get_started_now']['title'];?>
                            </a>
        -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
            remove_filter('acf_the_content', 'wpautop'); // remove <p> wraiper
            $steps_block = get_field('steps_block',get_the_ID());
        ?>
        <section class="steps" style="background-image: url(<?php echo theme_url;?>/img/step-bg.png);">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="steps__wrapper">
                            <div class="frame"></div>
                            <div class="steps__tabs-wrapper">
                                <h3><?php echo apply_filters('acf_the_content', $steps_block['title']); ?></h3>
                                <p><?php echo $steps_block['sub_title'];?> </p>
                                <ul class="nav nav-pills justify-content-left" id="pills-tab-steps" role="tablist">
                                    <?php
                                        $steps_list =  $steps_block['steps_list'];
                                        if (is_array($steps_list) && count($steps_list))
                                        {
                                            $active='active';
                                            $tb_active='show active';
                                            $html_tab='';
                                            $html_slider='';
                                            foreach ($steps_list as $key => $item)
                                            {
                                                $icon = $item['icon'];
                                                $image = $item['image'];
                                                $id='tab'.$key;

                                                echo "
                                                     <li class=\"nav-item\" role=\"presentation\">
                                                        <div class=\"nav-link $active\" id=\"$id-tab\" data-toggle=\"pill\" data-target=\"#$id\" role=\"tab\" aria-controls=\"pills-choose\" aria-selected=\"true\"><img src=\"$icon[url]\" alt=\"$icon[alt]\"><h5>$item[title]</h5></div>
                                                    </li>
                                                ";


                                                $html_tab.="
                                                    <div class=\"tab-pane fade $tb_active\" id=\"$id\" role=\"tabpanel\" aria-labelledby=\"$id-tab\">
                                                        <div class=\"steps__img-wrapper\">
                                                            <img src=\"$image[url]\" alt=\"$image[alt]\">
                                                        </div>
                                                    </div>
                                                ";
                                                $tb_active='';

                                                $html_slider.="
                                                    <div class=\"swiper-slide\">
                                                        <div class=\"steps__item\">
                                                           <img src=\"$image[url]\" alt=\"$image[alt]\">
                                                            <div class=\"nav-link \">
                                                                <img src=\"$icon[url]\" alt=\"$icon[alt]\">
                                                                <h5>$item[title]</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ";

                                                $active='';
                                            }
                                        }
                                    ?>
                                 </ul>
                            </div>
                            <div class="tab-content steps__tab-content" id="pills-tabContent-steps">
                                <?php
                                    echo $html_tab;
                                ?>
                            </div>
                        </div>
                        <div class="steps__wrapper-mobile">
                            <h3><?php echo apply_filters('acf_the_content', $steps_block['title']); ?></h3>
                            <p><?php echo $steps_block['sub_title'];?> </p>
                            <!-- Slider -->
                            <div class="swiper steps-slider">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    <?php echo $html_slider;?>
                                </div>
                                <div class="swiper-pagination pagination__steps pagination__styles"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
            remove_filter('acf_the_content', 'wpautop');
        ?>

        <?php
            remove_filter('acf_the_content', 'wpautop'); // remove <p> wraiper
            $benefits = get_field('benefits',get_the_ID());
        ?>
        <section class="benefits">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2><?php echo $benefits['title'];?></h2>
                        <div class="benefits__blocks-wrapper">
                            <?php
                                $items = $benefits['items'];

                                if ( is_array($items) && count($items))
                                {
                                    $wow_delay=[
                                        '',
                                        'data-wow-delay="0.2s"',
                                        'data-wow-delay="0.4s"',
                                    ];
                                    foreach ($items as $key => $item)
                                    {
                                        $icon = $item['icon'];
                                        echo "
                                            <div class=\"benefits__item wow animate__animated animate__fadeInUp\" data-wow-duration=\"1s\" $wow_delay[$key] >
                                                <div class=\"benefits__block-title\">
                                                    <img src=\"$icon[url]\" alt=\"$icon[alt]\">
                                                    <h5>$item[title]</h5>
                                                </div>
                                                <p>$item[text]</p>
                                            </div>
                                        ";
                                    }
                                }
                            ?>
                        </div>
                        <a href="<?php echo $benefits['button']['url'];?>" <?php echo $benefits['button']['target'];?> class="btn-main"><?php echo $benefits['button']['title'];?></a>
                    </div>
                </div>
            </div>
        </section>
        <?php
            remove_filter('acf_the_content', 'wpautop');
        ?>


        <section class="testimonials">
            <div class="container-fluid">
                <h3 class="wow animate__animated animate__zoomIn" data-wow-duration="1s">
                    <?php echo $game_design['reviews_title']; ?>
                </h3>
                <!-- Slider -->
                <div class="swiper testimonials-slider">
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php
                            $reviews = $game_design['reviews'];
                            if (is_array($reviews) && count($reviews))
                            {
                                foreach ($reviews as $key => $item)
                                {
                                    $stars = intval($item['stars']);
                                    $hstars = implode('',array_fill(0, $stars, '<img src="'.theme_url.'/img/stars-row.svg" alt="stars" style="width:16px;height:16px" >'));
                                    echo "
                                        <div class=\"swiper-slide\" >
                                            <div class=\"testimonial__item\">
                                                <h5>$item[title]</h5>
                                                <p>$item[text_review]</p>
                                                <div class=\"testimonials__rating\">
                                                    $hstars
                                                </div>
                                                <div class=\"testimonials__user-name\">$item[user_name]</div>
                                            </div>
                                        </div>";
                                }
                            }
                        ?>

                    </div>
                    <div class="swiper-pagination pagination__testimonials pagination__styles"></div>
                </div>
            </div>
        </section>

        <?php
            $choice_block_setting= get_field('choice_block_setting',get_the_ID());
        ?>
        <section class="choose" style="background-image: url(<?php echo theme_url;?>/img/choose-bg.png);">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3><?php echo $choice_block_setting['title'];?></h3>
                        <p><?php echo $choice_block_setting['sub_title'];?></p>
                        <div class="choose__btn-wrapper">
                            <a href="<?php echo $choice_block_setting['choose_game']['url'];?>" <?php echo $choice_block_setting['choose_game']['target'];?> class="btn-main"><?php echo $choice_block_setting['choose_game']['title'];?></a>
                            <div class="btn-border" data-toggle="modal" data-target="#signUpModal">Sign up now</div>
                        </div>
                    </div>
                </div>
            </div>


        </section>

    </main>
</div>
<?php
    if ( 2>5 ){
?>
<!-- Updated Section with H1, Subheading, and Trust Score Icon -->
<section class="section__intro" style='background-image: url(https://stagewq24.wxqw2.gladiatorboost.com/wp-content/uploads/2023/11/BackgroundHome.png);'>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center"> <!-- Added text-center class for center alignment -->
                <h1 class="main-heading">GladiatorBoost: Your One-Stop Gaming Hub</h1>
                <p class="subheading">Unlock your gaming potential with Expert Boosting and Coaching Services.</p>
                <!-- Trust Score Icon with 5.0 Star Rating, Centered Below Subheading -->
                <div class="trust-score">
                    <img src="https://stagewq24.wxqw2.gladiatorboost.com/wp-content/themes/gladiator/img/reviews1.png" alt="Trust Score Icon">
                    <span class="star-rating">Rated Excellent. 750+ Reviews</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="choose_game_section">

    <div class='container-fluide'>

        <div class='row'>

            <div class='col-12'>

                <div class="choose_game_main_wrap">

                    <?php
                        $tabs = $game_design['tabs'];
					
                        if (isset($tabs) && is_array($tabs) && count($tabs))
                        {
                            $sel_def='active_game';
                            foreach ($tabs as $key => $item)
                            {
                                $link = get_term_link($item['category']);
                                $game_rel = $item['game']->post_name;
                                $icon = $item['icon'];
                                $sel = (Game_Change::get_instance()->get_selected_game()==$game_rel)?'active_game':'';
                                if ( Game_Change::get_instance()->get_selected_game() ) $sel_def='';
                                echo "
                                    <a href=\"$link\" data-game_rel='$game_rel' class='game_tab_link $sel $sel_def' >
                                    <img src=\"$icon[url]\" alt=\"$icon[alt]\">
                                        $item[title] <span> $item[subtitle]</span>
                                    </a>
                                ";
                                $sel_def='';
                            }
                        }
                    ?>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Rest of your original code -->
<!-- special offers tabs -->

<section class="section__deals js-section-deals" id="section-deals">


    <?php if($game_design['special_offers_background']){ ?>
    <div class="background__img" data-parallax="scroll"
        data-image-src="<?php echo $game_design['special_offers_background']; ?>"></div>
    <?php } ?>


    <div class="container">
        <h2><?php _e('Special Offers', 'gladiator'); ?></h2>

        <div class="row">

            <div class="col-12">
                <div class="tab_title_wrap">

                    <div class="tab_title tab_get_products active" data-gamename="all"
                        data-terms_slug='<?php echo json_encode(['slug'=>['wotlk-boost','shadowlands'],'tab_name'=>'']);?>'>
                        <?php _e('All', 'gladiator'); ?>
                    </div>

                    <?php
                    
                    $best_deals = $game_design['special_offers'];
                    $tab_names  = [];
                    
                    if (is_array($best_deals) && count($best_deals))
                    {
                        foreach ($best_deals as $key => $item)
                        {
                            
                            $ID = $item['product'];
                            $term_list = wp_get_post_terms($ID, 'product_cat', array( 'fields' => 'all' ) );
                            $tab_name = $term_list[0]->name;
                            $tab_slug = $term_list[0]->slug;

                            if(!in_array($tab_slug, $tab_names)) {

                                $tab_names[$tab_slug] =  $tab_name;

                            }

                        }
                    }

                    foreach($tab_names as $key=>$name) {

                        echo    '<div class="tab_title tab_get_products" data-gamename="'.$key.'"
                                    data-terms_slug="'.$key.'">'
                                    .$name.
                                '</div>';
                    }
                    
                    ?>

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-12 p-0">
                <div class="js-tabs_wrap tabs_items_wrap">
                    <?php

                        $html='';
                        if (is_array($best_deals) && count($best_deals))
                        {
                            foreach ($best_deals as $key => $item)
                            {
                                
                                $ID = $item['product'];
                                $product_corner = get_field('product_corner',$ID);
                                $term_list = wp_get_post_terms($ID, 'product_cat', array( 'fields' => 'all' ) );
                                $product = new WC_Product($ID);
                                $tab_name = $term_list[0]->slug;

                                set_query_var('product',$product);
                                set_query_var('tab_name',$tab_name);
                                set_query_var('term_list',$term_list);
                                set_query_var('product_corner',$product_corner);

                                ob_start();
                                get_template_part('tmpl/product_item', 'tmpl');
                                $html.= ob_get_contents();
                                ob_end_clean();
                            }

                            echo $html;
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- /special offers tabs -->

<section class="section__aboutus">
    <div class="container">
        <div class="aboutus__inner">
            <div class="circle__bg js-circle"></div>
            <?php echo $game_design['about_section_text_editor']; ?>
            <div class="big__btn">
                <a style="background-image: url(<?php echo $game_design['about_section_big_button_image']; ?>)"
                    href="<?php echo $game_design['about_section_big_button_url']; ?>"><?php echo $game_design['about_section_big_button_text']; ?></a>
            </div>
        </div>
    </div>
</section>

<section class="section__advantages">
    <?php if($game_design['section_why_background_image']){ ?>
    <div class="background__img" data-parallax="scroll"
        data-image-src="<?php echo $game_design['section_why_background_image']; ?>"></div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2><?php echo $game_design['section_why_title']; ?></h2>
            </div>
            <?php
                $section_why_boxes = $game_design['section_why_boxes'];
                if($section_why_boxes){
                    foreach($section_why_boxes as $box){
            ?>
            <div class="col-lg-4">
                <div class="advantage__item">
                    <div class="advantage__icon">
                        <?php if($box['image']){
                                        ?>
                        <img src="<?php echo $box['image']['url'] ?>" alt="<?php echo $box['image']['alt'] ?>">
                        <?php
                                    } ?>
                    </div>
                    <h3><?php echo $box['title'] ?></h3>
                    <p>
                        <?php echo $box['text'] ?>
                    </p>
                </div>
            </div>
            <?php
                    }
                }
                ?>
        </div>
    </div>
</section>

<section class="section__howtobuy">
    <div class="container">
        <h2><?php echo $game_design['section_how_title']; ?></h2>
        <?php
            $steps = $game_design['steps'];
            if($steps){
                ?><ul class="howtobuy__wrapper">
            <?php
                        foreach($steps as $step){
                        $icon = $step['icon']
                    ?>
            <li>
                <div class="howtobuy__text">
                    <div class="icon">
                        <img src="<?php echo $icon['url'] ?>" alt="<?php echo $icon['alt'] ?>">
                    </div>
                    <!-- <h3><?php echo $step['title'] ?></h3> -->
                    <p>
                        <?php echo $step['description'] ?>
                    </p>
                </div>
            </li>
            <?php
                }
                ?>
        </ul>
        <?php
            }
            ?>
    </div>
</section>

<section class="section__reviews" <?php
        $reviews_bg = $game_design['reviews_background'];
        if($reviews_bg) { ?> style="background-image: url(<?php echo $reviews_bg ;?>);" <?php }; ?>>
    <div class="container">
        <h2><?php echo $game_design['reviews_title']; ?></h2>
        <?php
            $reviews = $game_design['reviews'];
            if( $reviews){
                ?><div class="review__slider js-review-slider"><?php
                foreach($reviews as $review){
                    ?>
            <div class="review__item">
                <p>
                    <?php echo $review['text_review'] ?>
                </p>
                <div class="b-bottom__review">
                    <ul class="rating__stars">
                        <?php
                                if($review['stars']){
                                    $stars = intval($review['stars']);
                                    for($i=0; $stars > $i; $i++){
                                        ?>
                        <li class="star">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/rating_star.png" alt="alt">
                        </li>
                        <?php
                                    }
                                }
                                ?>
                    </ul>
                    <div class="b-review__info">
                        <span class="user__name"><?php echo $review['user_name'] ?></span>
                        <span class="date">
                            <?php
                                                if($review['data']){
                                                    echo get_ago_time($review['data']);
                                                }
                                                ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php
                }
                ?>
        </div><?php
            }
            ?>
        <?php
            $reviews_link = $game_design['reviews_link'];
            if($reviews_link){
                ?>
        <a href="<?php echo $reviews_link['url']; ?>" class="b-view__all"><?php echo $reviews_link['title']; ?></a>
        <?php
            }
            ?>
    </div>
    </div>
</section>

<div class="dark__overlay js-dark-overlay">
    <form class="popup__window popup__deal js-popup-deal">
        <div class="modal__close js-modal-deal-close"></div>
        <div class="deal__img js-popup-deal-img">
        </div>
        <div class="deal__info js-popup-deal-info">
        </div>
    </form>
</div>

<?php get_footer(); ?>

<!-- CSS Adjustments for Center Alignment -->
<style>
    .text-center {
        text-align: center; /* Ensures text is centered */
    }

    .trust-score {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .trust-score .star-rating {
        margin-left: 8px;
        font-weight: bold;
    }

    .subheading {
        font-size: 1.25em;
        margin-top: 10px;
    }
</style>
<?php } ?>

<!-- <?php   echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->


<?php get_footer(); ?>