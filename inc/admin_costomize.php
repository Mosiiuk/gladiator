<?php

if ( ! defined( 'ABSPATH' ) ){ 
    exit;
}

add_action( 'login_head', 'my_custom_login_logo' );
function my_custom_login_logo(){
	?>
	<style type="text/css">
        body {
            background: #090616;
        }
		h1 a {  
			background-image:url('<?php echo get_bloginfo('template_directory'); ?>/assets/img/mini-logo.svg') !important;  
			background-size: 100% !important;
			height: 154px !important;
			width: 154px !important;
		}
		.wp-core-ui .button-primary{
			background: #C4C4C4;
			border-color: #C4C4C4;
			color: #000;
		}

        .wp-core-ui .button-primary{
            border-radius: 6px;
            background-color: #098cec;
            border-bottom: 3px solid #36b3ff;
            box-shadow: 0 0 41px 1px rgb(54 179 255 / 20%);
            transition: .2s;
            text-transform: uppercase;
            padding: 10px 20px 10px;
            color: #fff;
            text-transform: uppercase;
            font-weight: 500;
        }
        .wp-core-ui .button-primary:hover{
            border-color: #C4C4C4;
            border-bottom: 3px solid #36b3ff;
            background-color: #36b3ff;
            box-shadow: 0 0 41px 1px rgb(54 179 255 / 40%);
            color: #fff;
            outline: none;
        }

		.dashicons-visibility:before{
			color: #000;
		}
		.dashicons-hidden:before{
			color: #C4C4C4;
		}
		input[type=checkbox]:checked::before{
			content: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE0LjgzIDQuODkwMDFMMTYuMTcgNS44MzAwMUwxMC4zNiAxNC4yMUg5LjAyMDAzTDUuNzgwMDMgOS42NzAwMUw3LjEyMDAzIDguNDIwMDFMOS42OTAwMyAxMC44MkwxNC44MyA0Ljg5MDAxWiIgZmlsbD0iIzA5OENFQyIvPgo8L3N2Zz4K);
		}
		.login #login_error, .login .message, .login .success{
			border-left: 4px solid #098cec;
		}
	</style>
	<?php
}

