<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
<?php
    $arg_blog=[
        'post_type'=>'news',
        'post_status'=>'publish',
        'posts_per_page'  => 3,
        'meta_query' => [
            [
                'key' => 'is_featured',
                'value'   => '1',
                'compare' => '=='
            ],
        ],
        'orderby' => ['date' => 'DESC', 'menu_order' => 'DESC'],
    ];
    $query = new WP_Query( $arg_blog );
    $posts = $query->get_posts();

    $html='';
    if ($posts)
    {
        foreach ($posts as $post)
        {
            $image = get_field('image',$post->ID);
            set_query_var( 'data', [
                'post'=>$post,
                'image'=>$image,
            ] );
            get_template_part('tmpl/blog_news/latest_news_item', 'tmpl');
        }
    }
?>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->