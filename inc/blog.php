<?php

    add_action('admin_init', 'remove_acf_options_page', 99);

    function remove_acf_options_page() {

        remove_menu_page('acf-options');

    }



    add_action( 'init', 'blog_news_init' );

    function blog_news_init()

    {

        if( function_exists('acf_add_options_page') )

        {

            // Settings Option Page

            $blog_option = acf_add_options_page( array(

                'page_title' => 'Blog Settings',

                'menu_title' => 'Blog Settings',

                'redirect'   => 'Blog Settings',

            ) );

        }

    }





    add_action('wp_enqueue_scripts', 'blog_news_wp_enqueue_scripts');

    function blog_news_wp_enqueue_scripts()

    {

        if (if_is_blog())

        {

            wp_enqueue_style( 'blog-news-style', get_template_directory_uri() . '/assets/css/blog_news.css', array(), "2.0" );



            wp_enqueue_script('blog-news-script', get_template_directory_uri() . '/assets/js/blog_news.js', array(), '1.0', true );

        }

    }





    add_filter( 'body_class','blog_body_class' );

    function blog_body_class( $classes )

    {

        global $template;

        $is_admin = current_user_can( 'manage_options' );

        $classes=[];

        $classes_body=[

            'archive-news.php'=>'blog',

            'single-news.php'=>'blog',

            'taxonomy-news_category.php'=>'blog',

        ];

        foreach ( $classes_body as $tmpl=>$class )

        {

            if( basename($template)==$tmpl )

            {

                $classes[] = $class;

                break;

            }

        }

        if ( is_front_page() ) {

		    $classes[] = 'home'; }

        if ( is_user_logged_in() ) {

            $classes[] = 'logged'; }

        if ( $is_admin ) {

            $classes[] = 'is_admin'; }

            

        if ( is_404() ) {

            $classes[] = 'error404'; }



        return $classes;

    }



    $action='blog_get_news';

    add_action("wp_ajax_nopriv_$action", "$action");

    add_action("wp_ajax_$action","$action" );

    function blog_get_news()

    {

        $game_period = $_POST['game_period'];

        $sort_by= $_POST['sort_by'];

        $paged = (int)$_POST['paged'];

        $term_id = (int)$_POST['term_id'];



        $result=get_blog_news($paged,$sort_by,$game_period,$term_id);



        echo json_encode([

            '$_POST'=>$_POST,

            'result'=>$result,

        ]);

        wp_die();

    }



    function get_blog_news($paged=1,$sort_by='',$game_period='',$term_id_inp=0)

    {

        $count_show_post = get_field('count_show_post','options')?get_field('count_show_post','options'):8;



        $term_id =  $term_id_inp?$term_id_inp:get_queried_object()->term_id;



        $arg_blog=[

            'paged'=>$paged,

            'post_type'=>'news',

            'post_status'=>'publish',

            'posts_per_page'  => $count_show_post,

            'orderby' => ['date' => 'DESC'],

        ];



        if ( $term_id )

        {

            $arg_blog['tax_query']=[

                [

                    'taxonomy' => 'news_category',

                    'field' => 'term_id',

                    'terms' => $term_id

                ]

            ];

        }



        switch ($game_period)

        {

            case 'week':

                $arg_blog['date_query']=[

                    'after' => date('Y-m-d',strtotime('previous week Monday')),

                    'before' => date('Y-m-d',strtotime('previous week Friday')),

                    'column' => 'post_date',

                ];

                break;

            case 'month':

                $arg_blog['date_query']=[

                    'before' => '-30 days',

                    'column' => 'post_date',

                ];

                break;

        }



        switch ($sort_by)

        {

            case 'date_asc':

                $arg_blog['orderby']=['date' => 'ASC'];

                break;

            case 'date_desc':

                $arg_blog['orderby']=['date' => 'DESC'];

                break;

        }



        $query_blog = new WP_Query( $arg_blog );

        $posts = $query_blog->get_posts();



        $html='';

        $links_data=[];

        $pagination_html='';

        $max_num_pages = $query_blog->max_num_pages;



        if ($posts)

        {

            foreach ($posts as $post)

            {

                $image = get_field('image',$post->ID);

                $html.= "

                     <a data-id_news='$post->ID' class=\"tab_item_blog\" href=\"".get_permalink($post->ID)."\" data-game_period=\"$game_period\">

                        <img src=\"$image\">

                        <center>

                            <p>

                              $post->post_title

                            </p>

                            <date>

                                ".date('F d, Y',strtotime($post->post_date))."

                            </date>

                        </center>

                    </a>

                ";

            }



            $links_data = blog_paginate_links_data( [

                'total'    => $max_num_pages,

                'current'  => $paged,

                'url_base' => get_post_type_archive_link('news').'{pagenum}',

                'mid_size' => 2,

            ] );

        }



        if (is_array($links_data) && count($links_data))

        {

            foreach ($links_data as $key => $item)

            {

                if ( $item->is_current)

                {

                    $pagination_html.= "

                    <li>

                        <span aria-current=\"page\" class=\"page-number current blog_paginate_js\" data-page_num='$item->page_num' >$item->page_num</span>

                    </li>\n ";

                }

                else

                {

                    $pagination_html.= "

                    <li>

                        <a class=\"page-number blog_paginate_js\" data-page_num='$item->page_num' >$item->page_num</a>

                    </li>\n ";

                }

            }

        }



        return [

            'list_news_html'=>$html,

            'links_data'=>$links_data,

            'pagination_html'=>$pagination_html,

            '$arg_blog'=>$arg_blog,

            'request'=>$query_blog->request,

            'term_id'=>(int)$term_id,

        ];

    }



    function blog_paginate_links_data( array $args )

    {

        global $wp_query;



        $args += [

            'total'        => 1,

            'current'      => 0,

            'url_base'     => '/{pagenum}',

            'first_url'    => '',

            'mid_size'     => 2,

            'end_size'     => 1,

            'show_all'     => false,

            'a_text_patt'  => '%s',

            'is_prev_next' => false,

            'prev_text'    => '« Previous',

            'next_text'    => 'Next »',

        ];



        $rg = (object) $args;



        $total_pages = max( 1, (int) ( $rg->total ?: $wp_query->max_num_pages ) );



        if( $total_pages === 1 ){

            return [];

        }



        // fix working parameters



        $rg->total = $total_pages;

        $rg->current = max( 1, abs( $rg->current ?: get_query_var( 'paged', 1 ) ) );



        $rg->url_base = $rg->url_base ?: str_replace( PHP_INT_MAX, '{pagenum}', get_pagenum_link( PHP_INT_MAX ) );

        $rg->url_base = wp_normalize_path( $rg->url_base );



        if( ! $rg->first_url ){

            // /foo/page(d)/2 >>> /foo/ /foo?page(d)=2 >>> /foo/

            $rg->first_url = preg_replace( '~/paged?/{pagenum}/?|[?]paged?={pagenum}|/{pagenum}/?~', '', $rg->url_base );

            $rg->first_url = user_trailingslashit( $rg->first_url );

        }



        // core array



        if( $rg->show_all ){

            $active_nums = range( 1, $rg->total );

        }

        else {



            if( $rg->end_size > 1 ){

                $start_nums = range( 1, $rg->end_size );

                $end_nums = range( $rg->total - ($rg->end_size - 1), $rg->total );

            }

            else {

                $start_nums = [ 1 ];

                $end_nums = [ $rg->total ];

            }



            $from = $rg->current - $rg->mid_size;

            $to = $rg->current + $rg->mid_size;



            if( $from < 1 ){

                $to = min( $rg->total, $to + absint( $from ) );

                $from = 1;



            }

            if( $to > $rg->total ){

                $from = max( 1, $from - ($to - $rg->total) );

                $to = $rg->total;

            }



            $active_nums = array_merge( $start_nums, range( $from, $to ), $end_nums );

            $active_nums = array_unique( $active_nums );

            $active_nums = array_values( $active_nums ); // reset keys

        }



        // fill by core array



        $pages = [];



        if( 1 === count( $active_nums ) ){

            return $pages;

        }



        $item_data = static function( $num ) use ( $rg ){



            $data = [

                'is_current'   => false,

                'page_num'     => null,

                'url'          => null,

                'link_text'    => null,

                'is_prev_next' => false,

                'is_dots'      => false,

            ];



            if( 'dots' === $num ){



                return (object) ( [

                        'is_dots' => true,

                        'link_text' => '…',

                    ] + $data );

            }



            $is_prev = 'prev' === $num && ( $num = max( 1, $rg->current - 1 ) );

            $is_next = 'next' === $num && ( $num = min( $rg->total, $rg->current + 1 ) );



            $data = [

                    'is_current'   => ! ( $is_prev || $is_next ) && $num === $rg->current,

                    'page_num'     => $num,

                    'url'          => 1 === $num ? $rg->first_url : str_replace( '{pagenum}', $num, $rg->url_base ),

                    'is_prev_next' => $is_prev || $is_next,

                ] + $data;



            if( $is_prev ){

                $data['link_text'] = $rg->prev_text;

            }

            elseif( $is_next ) {

                $data['link_text'] = $rg->next_text;

            }

            else {

                $data['link_text'] = sprintf( $rg->a_text_patt, $num );

            }



            return (object) $data;

        };



        foreach( $active_nums as $indx => $num ){



            $pages[] = $item_data( $num );



            // set dots

            $next = $active_nums[ $indx + 1 ] ?? null;

            if( $next && ($num + 1) !== $next ){

                $pages[] = $item_data( 'dots' );

            }

        }



        if( $rg->is_prev_next ){

            $rg->current !== 1 && array_unshift( $pages, $item_data( 'prev' ) );

            $rg->current !== $rg->total && $pages[] = $item_data( 'next' );

        }



        return $pages;

    }



/*    function blog_title($title, $sep)

    {

        return $title.' '.var_export(is_post_type_archive(),1);

    }

    add_filter( 'wp_title', 'blog_title', 999999999999, 2 );*/

?>