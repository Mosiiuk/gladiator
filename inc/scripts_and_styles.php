<?php

if ( ! defined( 'ABSPATH' ) ){ 
    exit;
}


add_action('wp_enqueue_scripts', 'skripts_and_styles');
function skripts_and_styles(){
    global $template;

    //------------ GLOBAL SCRIPTS -----------



    wp_enqueue_style( 'gbcoin-theme-style', get_template_directory_uri() . '/assets/css/gbcoin.css', array(), "3.0" ); //header
    wp_enqueue_style( 'swiper-style', 'https://unpkg.com/swiper@7/swiper-bundle.min.css', array(), null); //header
    wp_enqueue_style( 'animate-style', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), null); //header



    //------------ /GLOBAL SCRIPTS ----------

    /* NEW DESIGN 2024 */

    wp_enqueue_style( 'nouislider-theme-style', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css', array(), "2.0" );
    wp_enqueue_style( 'all-theme-style', get_template_directory_uri() . '/assets/css/all.min.css', array(), "3.0" );
    wp_enqueue_style( 'main-theme-style', get_template_directory_uri() . '/assets/css/main.min.css', array(), "3.0" );
    wp_enqueue_style( 'dev-theme-style', get_template_directory_uri() . '/assets/css/dev.css', array(), "3.5" ); //header

	wp_enqueue_style(
		'main-theme-style_2024',
		get_template_directory_uri() . '/assets/css/main_2024.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/main_2024.css' ),
		false
	);
	wp_enqueue_style(
		'main-theme-style_25',
		get_template_directory_uri() . '/assets/css/main_25.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/main_25.css' ),
		false
	);

	wp_add_inline_style(
		'main-theme-style_25',
		'.gold_choose_wrap p.gold_custom_amount_hint{margin:0 40px 14px!important;max-width:calc(100% - 80px);font-size:16px!important;line-height:24px!important;color:rgba(255,255,255,.72)!important}.gold_choose_wrap p.gold_custom_amount_hint strong{color:inherit}@media screen and (max-width:1279px){.gold_choose_wrap p.gold_custom_amount_hint{margin-inline:20px!important;max-width:calc(100% - 40px)}}@media screen and (max-width:575px){.gold_choose_wrap p.gold_custom_amount_hint{font-size:14px!important;line-height:20px!important}}'
	);
	wp_add_inline_style(
		'main-theme-style_25',
		'.offer__currency{position:relative;z-index:3;width:fit-content;margin:0 0 12px}.offer__currency select.product-card-currency-select{display:block;min-width:86px;height:34px;padding:0 30px 0 12px;border:1px solid rgba(255,255,255,.22);border-radius:6px;background:rgba(5,2,21,.82);color:#fff;font-family:Outfit-f,sans-serif;font-size:14px;line-height:34px;cursor:pointer}.offer__currency select.product-card-currency-select:focus{outline:none;border-color:#098cec}@media screen and (max-width:575px){.offer__currency select.product-card-currency-select{height:32px;font-size:13px}}'
	);

    wp_enqueue_script('parallax-script', get_template_directory_uri() . '/assets/js/parallax.min.js', array(), '1.0', true );
    wp_enqueue_script('nice-select-script', get_template_directory_uri() . '/assets/js/jquery.nice-select.min.js', array(), '1.0', true );//in footer

    wp_enqueue_script('gbcoin-theme-script', get_template_directory_uri() . '/assets/js/gbcoin.js', array(), '3.0', true );//in footer
    wp_enqueue_script('games-theme-script', get_template_directory_uri() . '/assets/js/games.js', array(), '3.0', true ); //in footer

    wp_enqueue_script('slick-script', get_template_directory_uri() . '/assets/js/slick.min.js', array(), '1.0', true ); //in footer
    wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js', array(), null, true ); //in footer
    wp_enqueue_script('bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js', array(), null, true );//in footer
//in footer
    wp_enqueue_script('wow-script', 'https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js', array(),null, true ); //in footer


    wp_enqueue_script('noUiSlider-script', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js', array(), '1.0', true );
    wp_enqueue_script('main-theme-script_2024', get_template_directory_uri().'/assets/js/main_2024.js', array(),null, true ); //in footer
    wp_enqueue_script('swiper-bundle-script', get_template_directory_uri().'/assets/js/swiper-bundle.min.js', array(),null, true );


    wp_enqueue_script(
        'dev-theme-script',
        get_template_directory_uri() . '/assets/js/dev.js',
        array(),
        filemtime( get_template_directory() . '/assets/js/dev.js' ),
        true
    );//in footer

	    wp_enqueue_script('spincrement-script', get_template_directory_uri() . '/assets/js/jquery.spincrement.min.js', array(), '1.0', true );
	    wp_enqueue_script(
	        'main-theme-script',
	        get_template_directory_uri() . '/assets/js/main_new.js',
	        array(),
	        filemtime( get_template_directory() . '/assets/js/main_new.js' ),
	        true
	    );
	    wp_add_inline_script(
	        'main-theme-script',
	        <<<'JS'
(function($){
function changeCurrency(select){var currency=$(select).val();var l=woocs_remove_link_param('currency',window.location.href);l=l.replace('#','');if(woocs_special_ajax_mode){$.post(woocs_ajaxurl,{action:'woocs_set_currency_ajax',currency:currency},function(){window.location=l;});return;}if(Object.keys(woocs_array_of_get).length===0){window.location=l+'?currency='+currency;}else{woocs_redirect(currency);}}
$(function(){if($.fn.niceSelect){$('.product-card-currency-select').niceSelect('destroy');}});
$(document).off('change','.product-card-currency-select').on('change.productCardCurrency','.product-card-currency-select',function(){changeCurrency(this);});
$(document).off('click mousedown touchstart','.offer__currency, .offer__currency select').on('click.productCardCurrency mousedown.productCardCurrency touchstart.productCardCurrency','.offer__currency, .offer__currency select',function(e){e.stopPropagation();});
})(jQuery);
JS
	    );


	    //-------- reCAPTCHA -----
    wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js', array(), null, true );//in footer


    wp_localize_script( 'jquery', 'ajaxurl', array(
        'url' => admin_url('admin-ajax.php'),
        'site_url' => get_site_url(),
    ) );

    wp_localize_script( 'jquery', 'GladiatorInfo', array(
        'is_login'=>is_user_logged_in(),
        'theme_url'=>get_template_directory_uri(),
        'template_name'=>basename($template),
        'is_front_page'=>is_front_page(),
        'user_gbcoin'=>GBCoin::get_instance()->get_gbcoin_in_currency_raw(),
        'recaptcha'=>[
            'google_recaptcha_v2'=>get_field('google_recaptcha_v2','option'),
            'enable_on_sign_ups'=>get_field('enable_on_sign_ups','option'),
        ],
    ));
}
