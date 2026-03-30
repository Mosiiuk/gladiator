<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
<?php
$arg_blog=[
    'post_type'=>'news',
    'post_status'=>'publish',
    'posts_per_page'  => 4,
    'orderby' => ['date' => 'DESC', 'menu_order' => 'DESC'],
];
$query = new WP_Query( $arg_blog );
$posts = $query->get_posts();

if ($posts)
{
    foreach ($posts as $post)
    {
        $image = get_field('image',$post->ID);
        echo "
            <a class=\"tab_item_blog\" href=\"".get_permalink($post->ID)."\" >
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
}
?>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->