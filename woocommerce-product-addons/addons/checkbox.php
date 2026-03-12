<?php
/**
 * The Template for displaying checkbox field.
 *
 * @version 3.0.0
 */

global $WOOCS;

$addon_required = WC_Product_Addons_Helper::is_addon_required( $addon );

if ( $addon_required ) {
	?>
	<div class="wc-pao-addon-checkbox-group-required">
	<?php
}

?> <div class="control__items"> <?php

foreach ( $addon['options'] as $i => $option ) {
	$option_price      = ! empty( $option['price'] ) ? $option['price'] : '';
	$option_price_type = ! empty( $option['price_type'] ) ? $option['price_type'] : '';
	$price_prefix       = 0 < $option_price ? '+' : '';
	$price_type        = $option_price_type;
	$price_raw         = apply_filters( 'woocommerce_product_addons_option_price_raw', $option_price, $option );

    //--------------------------------
    if (isset($_GET['currency']) && trim($_GET['currency'])!='' )
    {
        $prc =  $WOOCS->convert_from_to_currency((float)$price_raw, 'EUR', $_GET['currency']);

        //var_dump($prc);
        $price_raw = $prc;
    }
    //-------------------------------
    
	$field_name         = ! empty( $addon['field_name'] ) ? $addon['field_name'] : '';
	$option_label      = ( '0' === $option['label'] ) || ! empty( $option['label'] ) ? $option['label'] : '';
	$price_display     = WC_Product_Addons_Helper::get_product_addon_price_for_display( $price_raw );
	$required_html     = $addon_required ? 'required' : '';

	if ( 'percentage_based' === $price_type ) {
		$price_display = $price_raw; 
		$price_for_display = apply_filters( 'woocommerce_product_addons_option_price',
			$price_raw ? '(' . $price_prefix . $price_raw . '%)' : '',
			$option,
			$i,
			'checkbox'
		);
	} else {
		$price_for_display = apply_filters( 'woocommerce_product_addons_option_price',
			$price_raw ? '(' . $price_prefix . wc_price( WC_Product_Addons_Helper::get_product_addon_price_for_display( $price_raw ) ) . ')' : '',
			$option,
			$i,
			'checkbox'
		);
	}

	$selected = isset( $_POST[ 'addon-' . sanitize_title( $field_name ) ] ) ? $_POST[ 'addon-' . sanitize_title( $field_name ) ] : array();
	if ( ! is_array( $selected ) ) {
		$selected = array( $selected );
	}

	$current_value     = ( in_array( sanitize_title( $option_label ), $selected ) ) ? 1 : 0;
	?>

		<label class="control__checkbox" >

			<?php echo wptexturize( $option_label . ' ' . $price_for_display ); ?>

			<input 
				type="checkbox" 
				<?php echo $required_html; ?> 
				class="wc-pao-addon-field wc-pao-addon-checkbox" 
				name="addon-<?php echo sanitize_title( $field_name ); ?>[]" 
				data-raw-price="<?php echo esc_attr( $price_raw ); ?>" 
				data-price="<?php echo esc_attr( $price_display ); ?>" 
				data-price-type="<?php echo esc_attr( $price_type ); ?>" 
				value="<?php echo sanitize_title( $option_label ); ?>" 
				data-label="<?php echo esc_attr( wptexturize( $option_label ) ); ?>" 
			/> 
			<div class="control_indicator"></div>
		</label>
	<?php
}

?> </div> <?php

// div wc-pao-addon-checkbox-group-required.
if ( $addon_required ) {
	?>
	</div>
	<?php
}

?>

