<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */
/*do_action( 'woocommerce_account_navigation' );*/

?>

<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->

<section class="profile_section">
    <div class="container-fluid p-md-0">
        <div class="row m-md-0">
            <div class="col-12">
                <div class="woocommerce">
                    <nav class="woocommerce-MyAccount-navigation">
                        <ul>
                            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--edit-account is-active">
                                <a href="#profile">Account details</a>
                            </li>
                            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--orders">
                                <a href="#orders">Orders</a>
                            </li>
                            <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
                                <a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">Logout</a>
                            </li>
                        </ul>
                        <?php /*do_action( 'woocommerce_account_navigation' );*/ ?>
                    </nav>

                    <div class="woocommerce-MyAccount-content">

                        <div class="woocommerce-notices-wrapper"></div>

                        <div id="profile" class="profile_tab">
                            <form class="woocommerce-EditAccountForm edit-account" action="" method="post">
                                <?php
                                /**
                                 * My Account content.
                                 *
                                 * @since 2.6.0
                                 */
                                do_action( 'woocommerce_account_content' );
                                ?>
                            </form>
                            <!-- GBCoin -->
                            <?php
                                echo GBCoin::get_instance()->get_coin_display();
                            ?>
                            <!-- /GBCoin -->
                        </div>

                        <div id="orders" class="hidden profile_tab orders-tab">
                            <?php
                                wc_get_template( 'myaccount/my-orders.php', array(
                                    'current_user'  => get_user_by( 'id', get_current_user_id() ),
                                    'order_count'   => -1
                                ) );
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
