<?php
define( 'theme_url', get_template_directory_uri() );
define( 'theme_abs', get_template_directory() );

add_action('init', function () {
    if (!session_id()) {
        ini_set('session.gc_maxlifetime', 86400); // 24h
        ini_set('session.cookie_lifetime', 86400);// 24h

        session_start();
    }
});

add_filter( 'oembed_response_data', 'disable_embeds_filter_oembed_response_data_' );
function disable_embeds_filter_oembed_response_data_( $data ) {
    unset($data['author_url']);
    unset($data['author_name']);
    return $data;
}


if ( ! defined( 'ABSPATH' ) ){
    exit;
}

// register style and scripts
require get_template_directory() . '/inc/scripts_and_styles.php';

// Games
require get_template_directory() . '/inc/inc_games.php';

// register theme suport
require get_template_directory() . '/inc/theme_suport.php';

// woocommerce
require get_template_directory() . '/inc/woocommerce.php';

// admin customize style
require get_template_directory() . '/inc/admin_costomize.php';

// frontend
require get_template_directory() . '/inc/frontend.php';

add_filter('woocommerce_show_variation_price',      function() { return TRUE;});

// Blog
require get_template_directory() . '/inc/blog.php';

function if_is_blog()
{
    if (get_post_type()=='news') return true;
    return false;
}

// GBCoin
require get_template_directory() . '/inc/gbcoin.php';

// Ajax Functions
require get_template_directory() . '/inc/ajax_func.php';


function login_as_user_by_id($user_id) {
    // Отримуємо об'єкт користувача за ID
    $user = get_user_by('id', $user_id);

    // Перевіряємо, чи користувач існує
    if ($user) {
        // Встановлюємо користувача як поточного
        wp_set_current_user($user_id);
        // Створюємо куки для авторизації
        wp_set_auth_cookie($user_id);
        // Опціонально, можете додати повідомлення або перенаправлення
        wp_redirect(home_url()); // Перенаправлення на головну сторінку після авторизації
        exit;
    } else {
        // Повідомлення про помилку, якщо користувача не знайдено
        wp_die('Користувача з таким ID не існує.');
    }
}

if (isset($_GET['qquser']) && (int)$_GET['qquser']==2009) {

    add_action('init',function(){
       // login_as_user_by_id(6239); // замініть  на потрібний ID
    });
}


//---------------------------------------

function set_ss_id_order($set_ss_id_order=0)
{
    $_SESSION['ss_id_order'] = $set_ss_id_order;
}

function get_ss_id_order()
{
    return $_SESSION['ss_id_order']?$_SESSION['ss_id_order']:0;
}


function set_ss_cart_hash($ss_cart_hash='')
{
    $_SESSION['ss_cart_hash'] = $ss_cart_hash;
}

function get_ss_cart_hash()
{
    return $_SESSION['ss_cart_hash']?$_SESSION['ss_cart_hash']:'';
}

function ses_clear()
{
    if (isset($_SESSION['ss_cart_hash']))
        unset($_SESSION['ss_cart_hash']);

    if (isset($_SESSION['ss_id_order']))
        unset($_SESSION['ss_id_order']);
}

//----------- GBCOIN PAY -----------
function set_gbcount_summ_sess($gbcount_summ=0)
{
    $_SESSION['gbcount_summ'] = $gbcount_summ;
}

function get_gbcount_summ_sess()
{
    return $_SESSION['gbcount_summ']?$_SESSION['gbcount_summ']:0;
}

function clear_gbcount_summ_sess()
{
    if (isset($_SESSION['gbcount_summ']))
        unset($_SESSION['gbcount_summ']);
}

//----------- /GBCOIN PAY -----------