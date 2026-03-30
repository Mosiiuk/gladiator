<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
if (class_exists('WooCommerce')) {
    $woocommerce = WC();
    $cart_items = $woocommerce->cart->get_cart();
    $cart_count = $woocommerce->cart->get_cart_contents_count();
    $subtotal = $woocommerce->cart->get_subtotal();
    $total = $woocommerce->cart->get_total();
    $currency = get_woocommerce_currency();
    $applied_coupons = $woocommerce->cart->get_applied_coupons();
}
?>

<div class="wrap">
    <div class="checkout__quantity">
        <h3> <?php echo esc_html__('Shopping Cart','gladiator-theme');?></h3>
        <div class="product-name">
                        <span class="product-quantity">
                            <?php echo $cart_count;?>
                        </span>
            <?php echo esc_html__('Items','gladiator-theme');?>
        </div>
    </div>
    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
        <tbody>
        <?php
        if (!empty($cart_items))
        {
            foreach ($cart_items as $cart_item_key => $cart_item)
            {
                $product_id = $cart_item['product_id'];
                $product = wc_get_product($product_id);
                $url = get_permalink($product_id);

                /*echo '<pre>';
                print_r($cart_item);
                echo '</pre>';*/

                echo "
                <tr class=\"js-product-cart woocommerce-cart-form__cart-item cart_item\">
                    <td class=\"product-thumbnail\">
                        <a href=\"$url\">".$product->get_image()."</a>
                    </td>
                    <td class=\"product-name\" data-title=\"Product\">
                        <div class=\"product__title js-product-title\">
                            ".$product->get_name()."                                                                                                        </div>
                    </td>
                    <td class=\"product__price\">
                        <div>".wc_price($cart_item['line_subtotal'])." </div>
                    </td>
                    <td class=\"product-remove\">
                        <a href=\"".esc_url(wc_get_cart_remove_url($cart_item_key))."\"  class=\"close__product mini_cart_remove_prod\" data-item_key='$cart_item_key' ><span class=\"close\">✕</span>Remove</a>
                    </td>
                </tr>
            ";
            }
        }
        ?>
        </tbody>
    </table>
</div>
<!-- CART-BOOTTOM -->
<div class="cart_totals">
    <table class="shop_table shop_table_responsive">
        <tbody>
        <tr class="cart-subtotal">
            <th><?php echo esc_html__('Items','gladiator-theme');?></th>
            <td data-title="Subtotal"><?php echo wc_price($subtotal);?></td>
        </tr>
        <tr class="woocommerce-form-coupon-toggle">
            <th><?php echo esc_html__('Apply Promo code','gladiator-theme');?></th>
            <td class="showcoupon"><div class="coupon-plus">+</div></td>
        </tr>
        <tr class="checkout_coupon woocommerce-form-coupon <?php echo count($applied_coupons)?'open':'';?>">
            <th>
                <p class="form-row form-row-first">
                    <input type="text" name="coupon_code"  class="input-text" placeholder="<?php echo esc_html__('Coupon code','gladiator-theme');?>" id="coupon_code" value="<?php echo count($applied_coupons)?$applied_coupons[0]:'';?>">
                </p>
            </th>
            <td>
                <p class="form-row form-row-last">
                    <?php if (!count($applied_coupons)) { ?>
                    <button type="submit" class="btn-main button wp-element-button" id="apply_coupon" name="apply_coupon" value="Apply coupon"><?php echo esc_html__('Apply','gladiator-theme');?></button>
                    <?php } else { ?>
                        <button type="submit" class="btn-main button wp-element-button" id="cancel_coupon" name="cancel_coupon" ><?php echo                   esc_html__('Cancel','gladiator-theme');?></button>
                    <?php } ?>

                </p>
            </td>
        </tr>
        <tr class="order-total">
            <th><?php echo esc_html__('Subtotal','gladiator-theme');?></th>
            <td data-title="Total">
                <?php echo $total;?>
            </td>
        </tr>

        </tbody>
    </table>

  <div class="site_balance_checkout_wrap">
    <p>
      Use your site balance to pay
    </p>



    <input type="number" id="pay_gbcoin" name="pay_gbcoin" value="" placeholder="Amount">
    <input type="hidden" id="cart_total_gbcoin" name="cart_total_gbcoin" value="<?php echo $woocommerce->cart->get_total('');?>" >

  </div>
    <div>
        <?php echo $err_msg;?>
    </div>
    <div class="wc-proceed-to-checkout">
        <a href="<?php echo wc_get_checkout_url();?>" class="btn-main checkout-button button alt wc-forward wp-element-button pay_cart_btn">
            <?php echo esc_html__('Secure checkout','gladiator-theme');?>
        </a>
    </div>
</div>
<!-- /CART-BOOTTOM -->

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->