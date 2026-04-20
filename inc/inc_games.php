<?php

if( function_exists('acf_add_options_page') ) {
    $maine_option = acf_add_options_page( array(
        'page_title' => 'Game Settings',
        'menu_title' => 'Game Settings',
        'redirect'   => 'Game Settings',
    ) );
}

if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group(
		array(
			'key'    => 'group_gladiator_guarantees_popup',
			'title'  => 'Guarantees Popup',
			'fields' => array(
				array(
					'key'           => 'field_gladiator_guarantees_popup_title',
					'label'         => 'Popup Title',
					'name'          => 'guarantees_popup_title',
					'type'          => 'text',
					'default_value' => 'Our Guarantees',
				),
				array(
					'key'          => 'field_gladiator_guarantees_popup_steps',
					'label'        => 'Popup Steps',
					'name'         => 'guarantees_popup_steps',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Add Row',
					'sub_fields'   => array(
						array(
							'key'           => 'field_gladiator_guarantees_popup_step_text',
							'label'         => 'Text',
							'name'          => 'text',
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => 'br',
							'default_value' => '',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-game-settings',
					),
				),
			),
			'menu_order'            => 90,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}

if ( function_exists( 'acf_add_local_field_group' ) ) {
	acf_add_local_field_group(
		array(
			'key'    => 'group_gladiator_order_success_page',
			'title'  => 'Order Success Page',
			'fields' => array(
				array(
					'key'           => 'field_gladiator_order_success_title',
					'label'         => 'Success Title',
					'name'          => 'order_success_title',
					'type'          => 'text',
					'default_value' => 'Order Successful!',
				),
				array(
					'key'           => 'field_gladiator_order_success_order_prefix',
					'label'         => 'Order Number Prefix',
					'name'          => 'order_success_order_prefix',
					'type'          => 'text',
					'default_value' => 'Your order number is',
				),
				array(
					'key'           => 'field_gladiator_order_success_intro',
					'label'         => 'Intro Text',
					'name'          => 'order_success_intro_text',
					'type'          => 'textarea',
					'rows'          => 3,
					'new_lines'     => 'br',
					'default_value' => 'Please follow the instructions below to contact us on Discord so we can start your order right away.',
				),
				array(
					'key'           => 'field_gladiator_order_success_video_button',
					'label'         => 'Video Button Text',
					'name'          => 'order_success_video_button_text',
					'type'          => 'text',
					'default_value' => 'Watch Video',
				),
				array(
					'key'           => 'field_gladiator_order_success_video_url',
					'label'         => 'Video URL',
					'name'          => 'order_success_video_url',
					'type'          => 'url',
					'default_value' => 'https://www.youtube.com/embed/nwM_dbpK8w4?autoplay=1',
				),
				array(
					'key'           => 'field_gladiator_order_success_flow_title',
					'label'         => 'Flow Title',
					'name'          => 'order_success_flow_title',
					'type'          => 'text',
					'default_value' => 'How to contact us',
				),
				array(
					'key'          => 'field_gladiator_order_success_steps',
					'label'        => 'Flow Steps',
					'name'         => 'order_success_steps',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Add Step',
					'sub_fields'   => array(
						array(
							'key'           => 'field_gladiator_order_success_step_title',
							'label'         => 'Title',
							'name'          => 'title',
							'type'          => 'text',
							'default_value' => '',
						),
						array(
							'key'           => 'field_gladiator_order_success_step_text',
							'label'         => 'Text',
							'name'          => 'text',
							'type'          => 'textarea',
							'rows'          => 3,
							'new_lines'     => 'br',
							'default_value' => '',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-game-settings',
					),
				),
			),
			'menu_order'            => 91,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
		)
	);
}

class Game_Change
{
    private static $instance;

    public $ajax_action_list = [];

    public static function get_instance()
    {

        if (null === self::$instance) {

            self::$instance = new self();

        }
        return self::$instance;
    }

    function __construct()
    {
        $this->ajax_action_list=[
            'set_game_js'
        ];
        $this->register_ajax_action();
    }

    public function set_game_js()
    {
        $select_game = $_POST['select_game'];
        $_SESSION['select_game'] = $select_game;
        echo json_encode([

            'POST'=>$_POST,

            '$_SESSION'=>$_SESSION,

        ]);
        wp_die();
    }

    public function get_game_design()
    {
        $inf = $this->get_selected_game_info();
        $frontpage_id = get_option('page_on_front');
		$design=[];
        $design['main_class']='';
        if ( $inf )
        {
            $design['is_main_game']=false;

			if ( isset(get_field('background_image',$inf->ID)['url']))
            $design['background_image']=get_field('background_image',$inf->ID)['url'];
			else
			$design['background_image']=get_field('background_image',$inf->ID);
			
            $design['header_section_text_editor']=get_field('header_section_text_editor',$inf->ID);

            $design['about_section_text_editor']=get_field('about_section_text_editor',$inf->ID);

            $design['about_section_big_button_image']=get_field('about_section_big_button_image',$inf->ID)['url'];

            $design['about_section_big_button_url']=get_field('about_section_big_button_url',$inf->ID);

            $design['about_section_big_button_text']=get_field('about_section_big_button_text',$inf->ID);

            $design['section_why_background_image']=get_field('section_why_background_image',$inf->ID)['url'];

            $design['section_why_title']=get_field('section_why_title',$inf->ID);

            $design['section_why_boxes']=get_field('section_why_boxes',$inf->ID);

            $design['section_how_title']=get_field('section_how_title',$inf->ID);

            $design['steps']=get_field('steps',$inf->ID);

            $design['reviews_background']=get_field('reviews_background',$inf->ID);

            $design['reviews_title']=get_field('reviews_title',$inf->ID);

            $design['reviews']=get_field('reviews',$inf->ID);

            $design['reviews_link']=get_field('reviews_link',$inf->ID);



            $design['special_offers_background']=get_field('special_offers_background',$inf->ID)['url'];

            $design['special_offers']=get_field('special_offers',$inf->ID);



            $design['main_class']=' '.get_field('class_page',$inf->ID);



            $design['product_categories']=get_field('categories', $inf->ID);



            $design['tabs']=get_field('tabs', 68);

        }
        else
        {
            $design['is_main_game']=true;

			if ( isset(get_field('background_image',$frontpage_id)['url']))
             $design['background_image']=get_field('background_image',$frontpage_id)['url'];
			else
				  $design['background_image']=get_field('background_image',$frontpage_id);

            $design['about_section_text_editor']=get_field('about_section_text_editor',$frontpage_id);

            $design['about_section_big_button_image']=get_field('about_section_big_button_image',$frontpage_id)['url'];

            $design['about_section_big_button_url']=get_field('about_section_big_button_url',$frontpage_id);

            $design['about_section_big_button_text']=get_field('about_section_big_button_text',$frontpage_id);

            $design['section_why_background_image']=get_field('section_why_background_image',$frontpage_id)['url'];

            $design['section_why_title']=get_field('section_why_title',$frontpage_id);

            $design['section_why_boxes']=get_field('section_why_boxes',$frontpage_id);

            $design['section_how_title']=get_field('section_how_title',$frontpage_id);

            $design['steps']=get_field('steps',$frontpage_id);

            $design['reviews_background']=get_field('reviews_background',$frontpage_id);

            $design['reviews_title']=get_field('reviews_title',$frontpage_id);

            $design['reviews']=get_field('reviews',$frontpage_id);

            $design['reviews_link']=get_field('reviews_link',$frontpage_id);

            $design['product_categories']=get_field('product_categories', 'header');

            $design['special_offers_background']=get_field('special_offers_background',$frontpage_id)['url'];

            $design['special_offers']=get_field('special_offers',$frontpage_id);

            $design['tabs']=get_field('tabs', 68);


        }
        return $design;

    }

    private function get_selected_game_info()
    {
        if ( $this->get_selected_game())

        {

            $list_games = get_field('list_games', 'option');

            if (isset($list_games) && is_array($list_games) && count($list_games)) {

                foreach ($list_games as $key => $item) {

                    $game_post = $item['game'];

                    if ( $this->get_selected_game() && $this->get_selected_game()==$game_post->post_name ) {

                        return $game_post;

                        break;

                    }

                }

            }

        }
        return false;
    }

    private function _game_options($list_games=[])
    {
        $options='';
        if (isset($list_games) && is_array($list_games) && count($list_games))
        {
            foreach ($list_games as $key => $item)
            {
                $game_post = $item['game'];
                if ( $this->get_selected_game() && $this->get_selected_game()==$game_post->post_name ) $sel='selected'; else  $sel='';
                $options.="<option value=\"$game_post->post_name\" $sel >$game_post->post_title</option>\n";
            }
        }
        return $options;
    }

    private function _game_li($list_games=[])

    {

        $options='';

        if (isset($list_games) && is_array($list_games) && count($list_games))

        {

            foreach ($list_games as $key => $item)

            {

                $game_post = $item['game'];

                if ( $this->get_selected_game() && $this->get_selected_game()==$game_post->post_name ) $sel='selected'; else  $sel='';

                $options.="<li data-value=\"$game_post->post_name\" class=\"option\">$game_post->post_title</li>\n";

            }

        }

        return $options;

    }

    public function get_game_list()

    {

        $list_games = get_field('list_games', 'option');

        return [

            'options'=>$this->_game_options($list_games),

            'li'=>$this->_game_li($list_games),

        ];

    }

    public function get_selected_game()
    {
        if ( isset($_SESSION['select_game']))
        {
            return $_SESSION['select_game'];
        }
        else
            return false;
    }

    public function init()
    {
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

class GGame
{
    private static $instance;

    public static function get_instance()
    {

        if (null === self::$instance) {

            self::$instance = new self();

        }
        return self::$instance;
    }

    function __construct()
    {

    }

    public function get_list_game()
    {
        $list_games = get_field('list_games','options');
        return $list_games;
    }

    public function get_categories($game_id=0)
    {
        $categories = get_field('categories',$game_id);
        $result=[];
        if (is_array($categories) && count($categories))
        {
            foreach ($categories as $key => $item)
            {
                if ( $this->has_child_terms($item->term_id,'product_cat'))
                {
                    $result[]=[
                        'term'=>$item,
                        'child'=>$this->get_recursive_term_children($item->term_id,'product_cat'),
                    ];
                }
                else
                {
                    $result[]=[
                        'term'=>$item,
                        'child'=>[],
                    ];
                }
            }
        }

        return $result;
    }

    private function has_child_terms($term_id, $taxonomy) {
        $children = get_term_children($term_id, $taxonomy);
        return !empty($children);
    }

    public function get_recursive_term_children($term_id, $taxonomy)
    {
        $children = get_term_children($term_id, $taxonomy);

        $all_children = [];

        foreach ($children as $child) {
            $all_children[] = get_term($child,$taxonomy);
            $all_children = array_merge($all_children, $this->get_recursive_term_children($child, $taxonomy));
        }

        return $all_children;
    }
}


add_action( 'init', 'Game_Change__init' );
function Game_Change__init()
{
   /* if( !session_id() )
    {
        session_start();
    }*/
    Game_Change::get_instance()->init();
}



?>
