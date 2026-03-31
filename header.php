<!DOCTYPE html>
<html <?php language_attributes();?>  >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

	
    <script>
        var url_sound = "<?php echo plugins_url().'/gladiator_dashboard/sound/sound.mp3';?>";
        var chatNotificationSound;
        function initChatSound() {
            chatNotificationSound = new Audio(url_sound);
        }
        function playChatSound() {
            if (chatNotificationSound) {
                chatNotificationSound.play().catch(e => console.error('Error playing sound:', e));
            }
        }
        document.addEventListener('click', initChatSound, { once: true });
    </script>

    <?php
        wp_head();
        $custom_logo__url = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
        $game_design = Game_Change::get_instance()->get_game_design();
        $content = get_field('field_645a4a9ec6fef', 'header');
    ?>



</head>

<body <?php body_class(); ?>>

<?php
    $current_user = wp_get_current_user();
    $roles = $current_user->roles[0];
    $link='/';
    if (!isset($gladiator_dashboard_plugin) && class_exists('Gladiator_Dashboard_Plugin') )
    {
        $gladiator_dashboard_plugin = new Gladiator_Dashboard_Plugin();

        $user_dashboard_url = [
            'administrator' => $gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_admin_dashboard_orders]'),
            admin_panel_role_name => $gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_admin_dashboard_orders]'),
            'boosters' => $gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_booster_panel]'),
            'customer' => $gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_panel]'),
            'subscriber' => $gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_panel]'),
        ];

        $user_profile_url = [
            'administrator' => [
                'orders'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_admin_dashboard_orders]')),
                'chats'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_admin_dashboard_view_chats]')),
                'notifications'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_admin_dashboard_orders]')),
                'profile_settings'=>get_dashboard_url($current_user->ID),
            ],
            'boosters' => [
                'orders'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_booster_my_orders]')),
                'chats'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_booster_chats]')),
                'notifications'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_booster_panel]')),
                'profile_settings'=>wc_get_account_endpoint_url( 'edit-account' ),
            ],
            'customer' => [
                'orders'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_booster_my_orders]')),
                'chats'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_chats]')),
                'notifications'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_panel]')),
                'profile_settings'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_profile_setting]')),
            ],
            'subscriber' => [
                'orders'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_booster_my_orders]')),
                'chats'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_chats]')),
                'notifications'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_panel]')),
                'profile_settings'=>get_permalink($gladiator_dashboard_plugin->find_page_id_by_shortcode('[gladiator_dashboard_customer_profile_setting]')),
            ],
        ];

        $link = get_permalink($user_dashboard_url[$roles]);
    }
    else
    {
        $user_dashboard_url = [
            'administrator' => '/',
            admin_panel_role_name => '/',
            'boosters' => '/',
            'customer' => '/',
            'subscriber' => '/',
        ];
    }

    if ( $current_user )
    {
        $balance = get_field('gbcoin', 'user_' . $current_user->ID);
        $balance = (float)$balance ? $balance : 0;

        $custom_profile_image = get_field( 'custom_profile_image', 'user_' . $current_user->ID );
        $profile_image = $custom_profile_image ? $custom_profile_image : plugins_url() . '/gladiator_dashboard/img/no_avatar.png';

        if ( $roles=='customer' || $roles=='subscriber')
        {
            $usermeta = get_user_meta($current_user->ID);

            $usermeta_ = [];
            if (is_array($usermeta) && !empty($usermeta)) {
                $usermeta_ = array_map('reset', $usermeta);
            }

            if ( !array_key_exists('avatar',$usermeta_))
            {
                $profile_image = plugins_url().'/gladiator_dashboard/img/no_avatar.png';
            }
            else
            {
                $profile_image = $usermeta_['avatar'];
            }
        }
    }
?>
<div class="main" style="overflow-x: clip;">
    <!-- NEW DESIGN 2024 -->
    <!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->

    <header class="header">
        <div class="container-fluid">
            <div class="container__header">
                <div class="header_wrap">
                    <div class="header__inner">
                        <div class="header__content-wrap">
                            <div class="header__logo">
                                <a href="<?php echo home_url(); ?>">
                                    <picture>
                                        <source media="(max-width: 991px)" srcset="<?php echo theme_url;?>/img/favicon.svg">
                                        <source media="(min-width: 992px)" srcset="<?php echo theme_url;?>/img/logo.svg">
                                        <img src="<?php echo theme_url;?>/img/favicon.svg" alt="logo">
                                    </picture>
                                </a>
                            </div>
                            <div class="header_games_menu">
                                <div class="menu-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <span class="btn-text-games"><?php echo __('games','gladiator-theme');?></span>

                            </div>
                            <div class="header_search">
                                <form autocomplete="off" role="search" method="get" id="searchform" action="#" class="search_form">
                                    <button type="button" id="searchButton">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="11" cy="11" r="6" stroke="white"></circle>
                                            <path d="M20 20L17 17" stroke="white" stroke-linecap="round"></path>
                                        </svg>
                                    </button>
                                    <input type="search" value="" name="s" class="search-input" id="s" placeholder="<?php echo $content['search_placeholder']; ?>">
                                </form>
                                <div class="result-search" id="resultSearch">
                                    <div class="preloader">
                                        <svg width="100px" height="100px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="background: none;">
                                            <circle cx="75" cy="50" fill="#36b3ff" r="6.39718">
                                                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" dur="1s" repeatCount="indefinite" begin="-0.875s"></animate>
                                            </circle>
                                            <circle cx="67.678" cy="67.678" fill="#36b3ff" r="4.8">
                                                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" dur="1s" repeatCount="indefinite" begin="-0.75s"></animate>
                                            </circle>
                                            <circle cx="50" cy="75" fill="#36b3ff" r="4.8">
                                                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" dur="1s" repeatCount="indefinite" begin="-0.625s"></animate>
                                            </circle>
                                            <circle cx="32.322" cy="67.678" fill="#36b3ff" r="4.8">
                                                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" dur="1s" repeatCount="indefinite" begin="-0.5s">
                                                </animate>
                                            </circle>
                                            <circle cx="25" cy="50" fill="#36b3ff" r="4.8">
                                                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" dur="1s" repeatCount="indefinite" begin="-0.375s"></animate>
                                            </circle>
                                            <circle cx="32.322" cy="32.322" fill="#36b3ff" r="4.80282">
                                                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" dur="1s" repeatCount="indefinite" begin="-0.25s"></animate>
                                            </circle>
                                            <circle cx="50" cy="25" fill="#36b3ff" r="6.40282">
                                                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" dur="1s" repeatCount="indefinite" begin="-0.125s"></animate>
                                            </circle>
                                            <circle cx="67.678" cy="32.322" fill="#36b3ff" r="7.99718">
                                                <animate attributeName="r" values="4.8;4.8;8;4.8;4.8" dur="1s" repeatCount="indefinite" begin="0s">
                                                </animate>
                                            </circle>
                                        </svg>
                                    </div>
                                    <div class="result-search-list">
                                        <ul>
                                            <li>
                                                <a href="#"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="header_acc ">
                                <?php if (!is_user_logged_in()){ ?>
                                <div class="user" data-toggle="modal" data-target="#signInModal">
                                    <img src="<?php echo theme_url;?>/img/my-account-mobile.svg" alt="icon">
                                    <div class="my_account">
                                        <?php echo __('My account','gladiator-theme');?>
                                    </div>
                                </div>
                                <?php } else { ?>

                                    <?php if ($roles==admin_panel_role_name) { ?>
                                        <div class="user" id="go_to_my_acc" data-url="<?php echo wp_logout_url(); ?>">
                                            <img src="<?php echo theme_url;?>/img/my-account-mobile.svg" alt="icon">
                                            <div class="my_account">
                                                    <?php echo __('Logout','gladiator-theme');?>
                                            </div>
                                        </div>
                                    <?php } else { ?>

                                        <div class="user_coins">
                                            <img src="<?php echo theme_url;?>/img/coins_colour.svg" alt="">
                                            <p>
                                                <?php
                                                    echo GBCoin::get_instance()->get_gbcoin_in_currency();
                                                ?>
                                            </p>
                                          </div>

                                        <div class="user" id="go_to_my_acc" data-url="<?php echo $link;?>">
                                            <img src="<?php echo theme_url;?>/img/my-account-mobile.svg" alt="icon">
                                            <div class="my_account">
                                                <?php echo __('My account','gladiator-theme');?>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <script>
                                        function isMobileDevice() {
                                            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                                        }
                                        jQuery(document).ready(function($){
                                            console.log(isMobileDevice());
                                            $('#go_to_my_acc').click(function(){
                                                if (!isMobileDevice()) {
                                                    document.location.href = $(this).data('url');
                                                }
                                                else
                                                {
                                                    if ( !$('#mobile_acc').hasClass('open'))
                                                        $('#mobile_acc').addClass('open');
                                                    else
                                                        $('#mobile_acc').removeClass('open');
                                                }
                                            });
                                        });
                                    </script>
                                <?php } ?>

                                <div class="header_currency currency__select">
                                    <?php header_currency(); ?>
                                </div>
                                <div class="btn__cart icon-shopping-cart">
                                    <img src="<?php echo theme_url;?>/img/checkout.svg" alt="checkout">
                                    <span class="b-count">
                                        <?php echo WC()->cart->get_cart_contents_count(); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MEGA-MENU__WRAP -->
        <div class="mega-menu__wrap">
            <div class="mega_menu__container">
                <div class="mega-menu__title-row">
                    <div class="mega-menu__title-games"><?php echo __('Choose the game','gladiator-theme');?>
                      <div class="mega-menu__search">

                         <form autocomplete="off" role="search" method="get"  action="#" class="search_form">
                          <button type="button" id="btn_header_search_game" >
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <circle cx="11" cy="11" r="6" stroke="white"></circle>
                              <path d="M20 20L17 17" stroke="white" stroke-linecap="round"></path>
                            </svg>
                          </button>

                          <input type="search" value="" name="header_search_game" id="header_search_game" class="search-input" placeholder="Search" >

                        </form>

                      </div>
                    </div>
                    <div class="mega-menu__title-categories"><?php echo __('Categories','gladiator-theme');?>
                      <div class="mega-menu__search">
                        <form autocomplete="off" role="search" method="get" action="#" class="search_form">
                          <button type="button" id="btn_header_search_game_cat"  >
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <circle cx="11" cy="11" r="6" stroke="white"></circle>
                              <path d="M20 20L17 17" stroke="white" stroke-linecap="round"></path>
                            </svg>
                          </button>
                          <input type="search" value="" name="header_search_game_cat" id="header_search_game_cat"  class="search-input" placeholder="Search">
                        </form>
                      </div>
                    </div>
                </div>
                <div class="mega-menu__menu-row">
                    <div class="mega-menu__tabs scroll-block__styles">


                      <?php
                            $games = GGame::get_instance()->get_list_game();
                        ?>
                        <ul class="nav nav-pills justify-content-left" id="pills-tab-game" role="tablist">
                            <?php
                                $game_tab=[];
                                if (is_array($games) && count($games))
                                {
                                    $active='active';
                                    $aria_selected='true';
                                    foreach ($games as $key => $item)
                                    {
                                        $gimtem = $item['game'];
                                        $uid = 'game_'.$gimtem->ID;


                                        echo "
                                            <li class=\"nav-item\" role=\"presentation\">
                                <div class=\"nav-link $active\" id=\"item-$uid\" data-toggle=\"pill\" data-target=\"#$uid\" role=\"tab\" aria-controls=\"$uid\" aria-selected=\"$aria_selected\">$gimtem->post_title</div>
                            </li>
                                        ";
                                        $active='';
                                        $aria_selected='false';

                                        $game_tab[]=[
                                            'ID'=>$gimtem->ID,
                                            'uid'=>$uid,
                                        ];
                                    }
                                }

                            ?>
                         </ul>
                    </div>
                    <div class="mega-menu__content scroll-block__styles">


                      <div class="tab-content games__tab-content" id="pills-tabContent-games">
                            <?php
                                if (is_array($game_tab) && count($game_tab))
                                {
                                    $active='show active';
                                    foreach ($game_tab as $key => $item)
                                    {
                                        $uid = $item['uid'];
                                        $ID = $item['ID'];
                                        $cat = GGame::get_instance()->get_categories($ID);
                                        //----------------- CATEGORY -------------
                                        $cats_html_p='';
                                        $cats_html_c='';
                                        if (is_array($cat) && count($cat))
                                        {
                                            foreach ($cat as $ckey => $citem)
                                            {
                                                if ( count($citem['child'])==0 )
                                                {
                                                    $cterm=$citem['term'];
                                                    $link = get_term_link($cterm->term_id,$cterm->taxonomy);
                                                    $cats_html_p.="
                                                        <li data-child='not' ><a href=\"$link\"><h4>$cterm->name</h4></a></li>
                                                    ";
                                                }
                                                else
                                                {
                                                    $cats_html_c.='<ul class="games__item list_subcat" data-ps="1">';
                                                    $cterm=$citem['term'];
                                                    $link = get_term_link($cterm->term_id,$cterm->taxonomy);
                                                    $cats_html_c.="
                                                        <li data-child='root' ><a href=\"$link\"><h4>$cterm->name</h4></a></li>
                                                    ";

                                                    $uni=[];
                                                    foreach ($citem['child'] as $chkey => $chitem1)
                                                    {
                                                        $cterm=$chitem1;

                                                        if (in_array($cterm->term_id,$uni)) continue;

                                                        $link = get_term_link($cterm->term_id,$cterm->taxonomy);
                                                        $cats_html_c.="
                                                            <li data-child='yes' ><a href=\"$link\"><h5>$cterm->name</h5></a></li>
                                                        ";
                                                        $uni[]=$cterm->term_id;
                                                    }
                                                    $uni=[];

                                                    $cats_html_c.='</ul>';
                                                }
                                            }

                                            if (trim($cats_html_p))
                                            {
                                                $cats_html_p =
                                                    '<ul class="games__item list_subcat" data-ps="2"> >' . $cats_html_p . '</ul>';
                                            }
                                        }
                                        //-----------------/CATEGORY -------------
                                        echo "
                                        <div class=\"tab-pane fade $active\" id=\"$uid\" role=\"tabpanel\" aria-labelledby=\"$uid\">
                                            <div class=\"games__wrapper\">
                                               $cats_html_p
                                               $cats_html_c
                                            </div>
                                        </div>";
                                        $active='';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /MEGA-MENU__WRAP -->

        <!-- OUT IF IS MOBILE -->
        <?php
            $current_user = wp_get_current_user();

            if ( $current_user->first_name && $current_user->last_name ) {
                $full_name = $current_user->first_name . ' ' . $current_user->last_name;
            } else {
                $full_name = $current_user->user_nicename;
            }

        ?>
        <div id="mobile_acc" class="header__profile scroll-block__styles" style="background-image: url('<?php echo theme_url;?>/img/hero-bg.png');">
            <img class="avatar" src="<?php echo $profile_image;?>" alt="avatar">
            <div class="nickname"> <?php echo $full_name; ?></div>
            <div class="role">
                <?php
                    echo $roles;
                ?>
            </div>
            <div class="profile__content-wrapper">
                <div class="profile__blocks-wrapper">
                    <div class="profile__block-item profile__block-item-large">
                        <div class="balance__block">
                            <?php echo __('Store Credit Balance','gladiator-theme');?> 
                            <span class="info-icon info-icon-text" data-info="This is your store credit balance. You automatically gain Store credit by placing any orders on GladiatorBoost. Enjoy!"></span>
                            <span>$<?php echo $balance;?></span>
                        </div>
                        <!--
                        <div class="add-funds__block">
                            <a href="#" class="btn-main btn-add-funds">
                                <img src="<?php echo theme_url;?>/img/add_square.svg" alt="plus">Add funds
                            </a>
                        </div>
                        -->
                    </div>

                    <div class="profile__block-item profile__block-item-small">
                        <img src="<?php echo theme_url;?>/img/profile-orders.svg" alt="icon">
                        <div>
                            <a href="<?php echo $user_profile_url[$roles]['orders'];?>">
                                <?php echo __('My Orders','gladiator-theme');?>
                            </a>
                        </div>
                    </div>
                    <div class="profile__block-item profile__block-item-small">
                        <img src="<?php echo theme_url;?>/img/profile-chat.svg" alt="icon">
                        <div>
                            <a href="<?php echo $user_profile_url[$roles]['chats'];?>">
                                <?php echo __('Chats','gladiator-theme');?>
                            </a>
                        </div>
                    </div>
                    <div class="profile__block-item profile__block-item-small">
                        <img src="<?php echo theme_url;?>/img/profile-notifications.svg" alt="icon">
                        <div>
                            <a href="<?php echo $user_profile_url[$roles]['notifications'];?>">
                                <?php echo __('Notifications','gladiator-theme');?>
                            </a>
                        </div>
                    </div>

                    <div class="profile__block-item profile__block-item-small">
                        <img src="<?php echo theme_url;?>/img/profile-settings.svg" alt="icon">
                        <div>
                            <a href="<?php echo $user_profile_url[$roles]['profile_settings'];?>">
                                <?php echo __('Profile Settings','gladiator-theme');?>
                            </a>
                        </div>
                    </div>


                    <div class="profile__block-item profile__block-item-large is_mobile">
                        <div>Currency</div>
                        <!-- mobile -->
                        <?php header_currency(); ?>
                    </div>

                </div>
                <div class="profile-btn__wrapper">
                    <div class="btn-border">
                        <a href="<?php echo wp_logout_url(); ?>">
                            <?php echo __('Logout','gladiator-theme');?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /OUT IF IS MOBILE -->

        <!-- MINI CART -->
        <div class="checkout__wrapper scroll-block__styles">
            <div class="checkout__close-btn"><img src="<?php echo theme_url;?>/img/close-modal.svg" alt="">
            </div>
            <form class="woocommerce-cart-form" id="form_minicart" action="<?php echo wc_get_checkout_url(); ?>" method="post">
                <?php
                    get_template_part('tmpl/cart/mini_cart');
                ?>
            </form>
        </div>
        <!-- /MINI CART -->


        <div class="body__overlay"></div>
    </header>

    <!-- LEFT BLOCK -->
    <?php
    if (!is_front_page()){
        ?>
        <aside class="header_aside">
            <div class="header_menu_left">

                <a href="<?php echo home_url(); ?>" class="header__logo">
                    <img src="<?php echo $custom_logo__url[0]; ?>" alt="alt">
                </a>

                <div class="header__nav js-header-nav">
                    <?php
                    $show_terms_menu = get_field('show_terms_in_menu', get_queried_object());

                    $game_in_side_panel = get_field('game_in_side_panel','options');
                    $game_in_side_panel_html='';
                    $current_term_id = get_queried_object_id();

                    if ( is_array($game_in_side_panel) && count($game_in_side_panel) )
                    {
                        foreach ($game_in_side_panel as $key => $item)
                        {
                            $gimtem = $item['game'];
                            $show_in_category = $item['show_in_category'];
                            $l=get_permalink($gimtem->ID);

                            if ( !empty($show_in_category) && $show_in_category==$current_term_id )
                            {
                                $game_in_side_panel_html.= "
                                <li class=\"game_side_bar\" >
                                    <a href='$l'>$gimtem->post_title $show_in_category </a>
                                </li>
                            ";
                            }

                            if (!$show_in_category)
                            {
                                $game_in_side_panel_html.= "
                                <li class=\"game_side_bar\" >
                                    <a href='$l'>$gimtem->post_title $show_in_category </a>
                                </li>
                            ";
                            }


                        }
                    }

                    if ($game_design['is_main_game'] && !is_product())
                    {
                        if (is_tax()) {
                            $cat = get_terms([
                                'taxonomy' => 'product_cat',
                                'hide_empty' => 0,
                                'parent' => get_queried_object()->term_id,
                                'exclude' => [15],
                                'hierarchical' => true
                            ]);

                            if (is_array($cat) && count($cat)) {
                                $html = '<ul>';

                                if(empty(get_queried_object()->parent)){
                                    foreach ($cat as $key => $item) {

                                        $child_ids = get_term_children($item->term_id, 'product_cat');
                                        $class = '';
                                        if($child_ids){$class = 'dropdown';};

                                        $html .= "
                                                <li class='$class'>
                                                    <a href='" . get_term_link($item->term_id) . "'>$item->name</a>";

                                        if($child_ids){

                                            $html .= '<span class="after">+</span>
                                                <ul class="list">';

                                            foreach ($child_ids as $id) {

                                                $html .= "
                                                            <li>
                                                                <a href='" . get_term_link($id) . "'>".get_term( $id )->name."</a>
                                                            </li>
                                                        ";
                                            }

                                            $html .= "</ul>";

                                        }

                                        $html .= "</li>";
                                    }
                                } else {

                                    $parent_cat = get_terms([
                                        'taxonomy' => 'product_cat',
                                        'hide_empty' => 0,
                                        'parent' => get_queried_object()->parent,
                                        'hierarchical' => 1,
                                        'exclude' => [15],

                                    ]);

                                    foreach ($parent_cat as $key => $item) {

                                        $child_ids = get_term_children($item->term_id, 'product_cat');
                                        $class = '';
                                        if($child_ids){$class = 'dropdown';};

                                        $html .= "
                                                <li class='parent_menu $class'>
                                                    <a href='" . get_term_link($item->term_id) . "'>$item->name</a>";

                                        if($child_ids){

                                            $html .= '<span class="after">+</span>
                                                <ul class="list">';

                                            foreach ($child_ids as $id) {

                                                $html .= "
                                                            <li>
                                                                <a href='" . get_term_link($id) . "'>".get_term( $id )->name."</a>
                                                            </li>
                                                        ";
                                            }

                                            $html .= "</ul>";

                                        }

                                        $html .= "</li>";
                                    }

                                }

                                $html .= $game_in_side_panel_html.'</ul>';

                                echo $html;
                            } else {

                                $parent_id = wp_get_term_taxonomy_parent_id(get_queried_object()->parent, 'product_cat');

                                if(empty($parent_id)){
                                    $parent_id = get_queried_object()->parent;
                                }

                                $cat = get_terms([
                                    'taxonomy' => 'product_cat',
                                    'hide_empty' => 0,
                                    'parent' => $parent_id,
                                    'exclude' => [15]
                                ]);

                                $html = '<ul>';
                                foreach ($cat as $key => $item) {

                                    $child_ids = get_term_children($item->term_id, 'product_cat');
                                    $class = '';
                                    if($child_ids){$class = 'dropdown';};

                                    $html .= "
                                            <li class='$class'>
                                                <a href='" . get_term_link($item->term_id) . "'>$item->name</a>";

                                    if($child_ids){

                                        $html .= '<span class="after">+</span>
                                            <ul class="list">';

                                        foreach ($child_ids as $id) {

                                            $html .= "
                                                        <li>
                                                            <a href='" . get_term_link($id) . "'>".get_term( $id )->name."</a>
                                                        </li>
                                                    ";
                                        }

                                        $html .= "</ul>";

                                    }

                                    $html .= "</li>";
                                }

                                $html .= $game_in_side_panel_html.'</ul>';

                                echo $html;
                            }
                        } else {
                            $product_categories = get_field('product_categories', 'header');

                            if ($product_categories && is_array($product_categories)) {

                                $html = '<ul>';

                                foreach($product_categories as $category){

                                    $cat = get_terms([
                                        'taxonomy' => 'product_cat',
                                        'hide_empty' => 0,
                                        'parent' => $category->term_id,
                                        'exclude' => [15],
                                        'hierarchical' => true,
                                        'orderby' => 'name',
                                        'order' => 'ASC',
                                    ]);

                                    if(is_array($cat) && count($cat)){

                                        $html .= "<li class='parent_menu dropdown'>
                                                        <a href='" . get_term_link($category->term_id) . "'>$category->name</a>";
                                        $html .= '<span class="after">+</span>
                                                            <ul class="list">';

                                        foreach ($cat as $key => $item) {

                                            $html .= "
                                                        <li>
                                                            <a href='" . get_term_link($item->term_id) . "'>$item->name</a>
                                                        </li>
                                                    ";

                                        }

                                        $html .= "</ul>";
                                        $html .= "</li>";

                                    } else {

                                        $child_ids = get_term_children($category->term_id, 'product_cat');
                                        $class = '';
                                        if($child_ids){$class = 'dropdown';};

                                        $html .= "
                                                <li class='parent_menu $class'>
                                                    <a href='" . get_term_link($category->term_id) . "'>$category->name</a>";

                                        if($child_ids){

                                            $html .= '<span class="after">+</span>
                                                <ul class="list">';

                                            foreach ($child_ids as $id) {

                                                $html .= "
                                                            <li>
                                                                <a href='" . get_term_link($id) . "'>".get_term( $id )->name."</a>
                                                            </li>
                                                        ";
                                            }

                                            $html .= "</ul>";

                                        }

                                        $html .= "</li>";

                                    }

                                }

                                $html .= '</ul>';

                                echo $html;

                            }
                        }

                        wp_nav_menu(array(
                            'theme_location' => 'header_menu',
                            'container' => false,
                            'menu_id' => false,
                            'menu_class' => '',
                            'fallback_cb' => '__return_empty_string',
                            'depth' => 2,
                        ));
                    }
                    else
                    {
                        if (is_tax())
                        {
                            $product_categories    = get_terms(
                                array(
                                    'taxonomy'   => 'product_cat',
                                    'hide_empty' => false,
                                    'parent'     => get_queried_object()->term_id
                                )
                            );
                            if ($product_categories)
                            {
                                get_menu_from_cat($product_categories);
                            }
                        }
                        else
                        {

                            $product_parentCat     = get_the_terms( $theID, 'product_cat' );
                            $product_parentCat_ID  = $product_parentCat[0]->term_id;
                            $product_categories    = get_terms(
                                array(
                                    'taxonomy'   => 'product_cat',
                                    'hide_empty' => false,
                                    'parent'     => $product_parentCat_ID
                                )
                            );

                            if ($product_categories) {
                                get_menu_from_cat($product_categories);
                            }
                        }


                    }




                    ?>
                </div>
            </div>
        </aside>
        <?php
    }
    ?>
    <!-- /LEFT BLOCK -->

    <!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->