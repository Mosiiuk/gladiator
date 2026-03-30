<?php

if( function_exists('acf_add_options_page') ) {
    $maine_option = acf_add_options_page( array(
        'page_title' => 'GBCoin Settings',
        'menu_title' => 'GBCoin Settings',
        'redirect'   => 'GBCoin Settings',
    ) );
}

class GBCoin
{
    private static $instance;
    public $ajax_action_list=[];
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public $wc_session_name='gbcoin_session';

    function __construct()
    {
        add_action('show_user_profile', [$this,'add_user_gbcoin_field']);
        add_action('edit_user_profile', [$this,'add_user_gbcoin_field']);

        add_action('personal_options_update', [$this,'save_gbcoin_field']);
        add_action('edit_user_profile_update', [$this,'save_gbcoin_field']);

        add_action('woocommerce_cart_calculate_fees', [$this,'bgcoin_woocommerce_cart_calculate_fees']); // GBCoin in the cart

        add_action( 'woocommerce_order_status_changed', [$this,'woocommerce_order_status_changed'], 10, 3  );
        add_action('woocommerce_thankyou', [$this,'add_gbcoin_user']);
        add_action('woocommerce_payment_complete', [$this,'add_gbcoin_user']);

        $this->ajax_action_list=[
            'gbcoin_set',
            'gbcoin_cancel',
        ];

        $this->register_ajax_action();
    }

    public function init()
    {

    }


    /**
     * Remember order_id and gbcoin plus
     * @param $order_id
     */
    private function gbcoin_remember_order_adds($order_id)
    {
        $user_id = get_current_user_id();
        $gbcoin_order_list_adds = get_user_meta($user_id,'gbcoin_order_list_adds',true);
        if ( $gbcoin_order_list_adds )
        {
            if ( is_array($gbcoin_order_list_adds) && count($gbcoin_order_list_adds) && !in_array($order_id,$gbcoin_order_list_adds))
            {
                $gbcoin_order_list_adds[]=$order_id;
                update_user_meta($user_id, 'gbcoin_order_list_adds',$gbcoin_order_list_adds );
            }
        }
        else
        {
            $how_much_gbcoin_add = [];
            $how_much_gbcoin_add[]=$order_id;
            update_user_meta($user_id, 'gbcoin_order_list_adds',$how_much_gbcoin_add );
        }
    }

    public function woocommerce_order_status_changed($order_id, $old_status, $new_status)
    {
        if( $new_status == "completed" )
        {
            if (is_admin())
            {
                $order = wc_get_order($order_id);
                if ($order && $order->get_user_id())
                {
                    $user_id = $order->get_user_id();
                    $how_much_gbcoin = $this->how_much_gbcoin_order($order_id);
                    if( $how_much_gbcoin!==false )
                    {
                        if ($how_much_gbcoin>0)
                        {
                            $gbcoin_user = get_user_meta($user_id, 'gbcoin', true);
                            $gbcoin_order_list_adds = get_user_meta($user_id,'gbcoin_order_list_adds',true);

                            $add_gbcoin=true;
                            if ( $gbcoin_order_list_adds && in_array($order_id,$gbcoin_order_list_adds))
                            {
                                $add_gbcoin=false;
                            }

                            if ($add_gbcoin)
                            {
                                if ($gbcoin_user) {
                                    $add_new_gbcoin = (float)$gbcoin_user + $how_much_gbcoin;
                                    update_user_meta($user_id, 'gbcoin', $add_new_gbcoin);
                                } else {
                                    update_user_meta($user_id, 'gbcoin', $how_much_gbcoin);
                                }

                                $this->gbcoin_remember_order_adds($order_id);
                            }
                        }
                    }
                }
            }
            else
            {
                $this->add_gbcoin_user($order_id);
            }
        }
    }

    public function add_gbcoin_user($order_id)
    {
        $session_gbcoin_count = WC()->session->get($this->wc_session_name);
        $user_id = get_current_user_id();

        if ( $session_gbcoin_count )
        {
            $count_user_gbcoin = $this->count_user_gbcoin();
            if ( $count_user_gbcoin )
            {
                $count_user_gbcoin_new = $count_user_gbcoin - $session_gbcoin_count;
                if ($count_user_gbcoin_new < 0) $count_user_gbcoin_new = 0;

                update_user_meta($user_id, 'gbcoin', $count_user_gbcoin_new);
            }
            WC()->session->set($this->wc_session_name, null );
        }
        else
        {
            $how_much_gbcoin = $this->how_much_gbcoin_order($order_id);
            if( $how_much_gbcoin!==false )
            {
                if ($how_much_gbcoin>0)
                {
                    $gbcoin_user = get_user_meta($user_id, 'gbcoin', true);
                    $gbcoin_order_list_adds = get_user_meta($user_id,'gbcoin_order_list_adds',true);

                    $add_gbcoin=true;
                    if ( $gbcoin_order_list_adds && in_array($order_id,$gbcoin_order_list_adds))
                    {
                        $add_gbcoin=false;
                    }

                    if ($add_gbcoin)
                    {
                        if ($gbcoin_user) {
                            $add_new_gbcoin = (float)$gbcoin_user + $how_much_gbcoin;
                            update_user_meta($user_id, 'gbcoin', $add_new_gbcoin);
                        } else {
                            update_user_meta($user_id, 'gbcoin', $how_much_gbcoin);
                        }

                        $this->gbcoin_remember_order_adds($order_id);
                    }
                }
            }
        }
    }

    public function count_user_gbcoin()
    {
        $user_id = get_current_user_id();
        $gbcoin = get_user_meta($user_id, 'gbcoin', true);
        return $gbcoin;
    }

    public function get_gbcoin_in_currency_raw()
    {
        global $WOOCS;


        $user_id = get_current_user_id();
        $gbcoin = (float)get_user_meta($user_id, 'gbcoin', true);

        if(is_object($WOOCS) and isset($WOOCS->current_currency))
        {
            $current_currency = strtolower($WOOCS->current_currency);
            $currencies=$WOOCS->get_currencies();
            $current_symbol=$current_currency;

            $convert = $gbcoin;

            if(count($currencies) )
            {
                foreach ($currencies as  $key => $currencie)
                {
                    if (strtolower($key) == $current_currency)
                    {
                        $current_symbol = $currencie['symbol'];
                        break;
                    }
                }
            }

            $gbcoin_convert_currency = get_field('gbcoin_convert_currency','options');


            if (is_array($gbcoin_convert_currency) && count($gbcoin_convert_currency))
            {
                foreach ($gbcoin_convert_currency as $item)
                {
                    if (isset($item['currency']) && strtolower($item['currency'])==$current_currency )
                    {
                        if (isset($item['price']) && (float)$item['price']>0)
                        {
                            $price = (float)$item['price'];

                            $convert = $price*$gbcoin;
                        }

                        break;
                    }
                }

                $convert = round($convert,2);
                $convert = number_format($convert, 2, '.', ',');
            }

            return $convert;
        }
        else
        {
            $gbcoin = round($gbcoin,2);
            return number_format($gbcoin, 2, '.', ',');;
        }


    }

    public function get_gbcoin_in_currency()
    {
        global $WOOCS;


        $user_id = get_current_user_id();
        $gbcoin = (float)get_user_meta($user_id, 'gbcoin', true);

        if(is_object($WOOCS) and isset($WOOCS->current_currency))
        {
            $current_currency = strtolower($WOOCS->current_currency);
            $currencies=$WOOCS->get_currencies();
            $current_symbol=$current_currency;

            $convert = $gbcoin;

            if(count($currencies) )
            {
                foreach ($currencies as  $key => $currencie)
                {
                    if (strtolower($key) == $current_currency)
                    {
                        $current_symbol = $currencie['symbol'];
                        break;
                    }
                }
            }

            $gbcoin_convert_currency = get_field('gbcoin_convert_currency','options');


            if (is_array($gbcoin_convert_currency) && count($gbcoin_convert_currency))
            {
                foreach ($gbcoin_convert_currency as $item)
                {
                    if (isset($item['currency']) && strtolower($item['currency'])==$current_currency )
                    {
                        if (isset($item['price']) && (float)$item['price']>0)
                        {
                            $price = (float)$item['price'];

                            $convert = $price*$gbcoin;
                        }

                        break;
                    }
                }

                $convert = round($convert,2);
                $convert = number_format($convert, 2, '.', ',');
            }

           /* echo '<pre>';
            print_r([
                '$convert'=>$convert,
                '$gbcoin'=>$gbcoin,
                '$gbcoin_convert_currency'=>$gbcoin_convert_currency,
                '$current_currency'=>$current_currency,
            ]);
            echo '</pre>';*/

            return $current_symbol.' '.$convert;
        }
        else
        {
            $gbcoin = round($gbcoin,2);
            return number_format($gbcoin, 2, '.', ',');;
        }


    }

    public function count_set_bgcoin()
    {
        $session_gbcoin_count = WC()->session->get( $this->wc_session_name);
        if ($session_gbcoin_count ) return $session_gbcoin_count; else 0;
    }

    public function is_set_bgcoin()
    {
        $session_gbcoin_count = WC()->session->get( $this->wc_session_name);
        if ($session_gbcoin_count ) return true; else return false;
    }

    public function bgcoin_woocommerce_cart_calculate_fees($cart_object)
    {
        $session_gbcoin_count = WC()->session->get( $this->wc_session_name);
        if ($session_gbcoin_count)
        {
            $cart_object->add_fee('GBCoin',-$session_gbcoin_count, true, '');
        }
       // $cart_object->add_fee('GBCoin',1, true, '');
    }

    public function gbcoin_cancel()
    {
        WC()->session->set($this->wc_session_name, null );
        echo json_encode([
            '$POST'=>$_POST,
        ]);
        wp_die();
    }

    public function gbcoin_set()
    {
        $user_id = get_current_user_id();
        $gbcoin_user = get_user_meta($user_id, 'gbcoin', true);
        $gbcoin = (int)$_POST['gbcoin'];

        $error=0;
        if ( !$gbcoin ) $error=1;
        if ( !$gbcoin_user ) $error=2;
        if ( $gbcoin>$gbcoin_user ) $error=3;

        if ( $gbcoin>0 && !$error )
        {
            WC()->session->set($this->wc_session_name, $gbcoin );
        }

        echo json_encode([
            '$POST'=>$_POST,
            'error'=>$error,
        ]);
        wp_die();
    }

    private function how_much_gbcoin_order($order_id)
    {
        $order = wc_get_order( $order_id );

        $purchase_rule = get_field('purchase', 'option');
        $count_gbcoin_credit=0;

        if (is_array($purchase_rule) && count($purchase_rule))
        {
            $cart_total = $order->get_total();
            $price = array_column($purchase_rule, 'min');
            array_multisort($price, SORT_ASC, $purchase_rule);


            foreach ($purchase_rule as $key => $item)
            {
                $min=$item['min'];
                $max=$item['max'];

                if ( $min==$max )
                {
                    continue;
                }

                if ( $min>$max )
                {
                    $tm=$min;
                    $min=$max;
                    $max=$tm;
                }

                if ( $cart_total>=$min && $cart_total<=$max  )
                {
                    $count_gbcoin_credit = $item['count_gbcoin_credit'];
                    break;
                }
            }
            return $count_gbcoin_credit;
        }
        else
            return false;
    }

    public function how_much_gbcoin()
    {
        global $woocommerce;

        if ($this->is_set_bgcoin()) return false;

        $purchase_rule = get_field('purchase', 'option');

        $cart=[
            '*total'=> $woocommerce->cart->total,
            'get_subtotal'=> $woocommerce->cart->get_subtotal(),
            'get_total_tax'=>$woocommerce->cart->get_total_tax(),
            'get_subtotal_tax'=>$woocommerce->cart->get_subtotal_tax(),
        ];

        $count_gbcoin_credit=0;

        if (is_array($purchase_rule) && count($purchase_rule))
        {
            $cart_total = $woocommerce->cart->total;
            $price = array_column($purchase_rule, 'min');
            array_multisort($price, SORT_ASC, $purchase_rule);

            foreach ($purchase_rule as $key => $item)
            {
                $min=$item['min'];
                $max=$item['max'];

                if ( $min==$max )
                {
                    continue;
                }

                if ( $min>$max )
                {
                    $tm=$min;
                    $min=$max;
                    $max=$tm;
                }

                if ( $cart_total>=$min && $cart_total<=$max  )
                {
                    $count_gbcoin_credit = $item['count_gbcoin_credit'];
                    break;
                }
            }

            return $count_gbcoin_credit;
        }
        else
            return false;
    }

    public function get_coin_display()
    {
        $user_id = get_current_user_id();
        $gbcoin = get_user_meta($user_id, 'gbcoin', true);
        $description_info = get_field('description_info', 'option');

        $html ='';
        set_query_var('gbcoin',$gbcoin);
        set_query_var('description_info',$description_info);

        ob_start();
        get_template_part('tmpl/gbc_coin_popap', 'tmpl');
        $html= ob_get_contents();
        ob_end_clean();

        return $html;
    }

    public function add_user_gbcoin_field($user)
    {
        ?>
        <div style="width: fit-content; border: #2271b1 1px solid; padding: 15px; border-radius: 6px; margin-top:10px; margin-bottom: 10px;">
            <h2>GBCoin
                <input class="regular-text" name="gbcoin" type="text" id="gbcoin" value="<?php echo $user->gbcoin; ?>" >
            </h2>
        </div>
        <?php
    }

    public function save_gbcoin_field($user_id)
    {
        $roles=$this->get_current_user_roles();
        if ( in_array('administrator',$roles)) {
            if (is_admin()) {
                update_user_meta($user_id, 'gbcoin', (float)$_POST['gbcoin']);
            }
        }
    }

    private function get_current_user_roles()
    {
        if( is_user_logged_in() )
        {
            $user = wp_get_current_user();
            return $user->roles; // This will returns an array
        } else {
            return [];
        }
    }

    /**
     * Register ajax action
     */
    function register_ajax_action()
    {
        foreach ($this->ajax_action_list as $action_calback)
        {
            add_action( "wp_ajax_{$action_calback}", array($this, $action_calback) );
            add_action( "wp_ajax_nopriv_{$action_calback}", array($this, $action_calback));
        }
    }
}

add_action( 'init', 'GBCoin__init' );
function GBCoin__init()
{
    GBCoin::get_instance()->init();
}

?>