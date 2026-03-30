<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
<?php
    $args=[
        'taxonomy' => 'news_category',
        'hide_empty' => true,
    ];

    $terms = get_terms( $args );

    if ($terms)
    {
        $curr_cat = get_queried_object()->term_id;
        foreach ($terms as $term)
        {
            $class='';
            if ( $curr_cat && $curr_cat==$term->term_id )
                $class=' class="cat_active" ';

            echo "<a href='".get_term_link($term)."' $class >$term->name</a>\n";
        }
    }
?>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->