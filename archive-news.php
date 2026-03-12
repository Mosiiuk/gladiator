<?php
    get_header();
    $header_text= get_field('header_text','options');
    $header_image= get_field('header_image','options');
    $latest_news_title= get_field('latest_news_title','options');
    $term_id = get_queried_object()->term_id;
?>
<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->

<script>
    var blog_term_id='<?php echo (int)$term_id;?>';
</script>
<!-- blog header -->
<section class="section__intro__mini section__intro__job ">
    <div class="background__img" data-parallax="scroll" ></div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="blog-hero-wrap">
                    <?php if ($header_image){ ?>
                        <img src="<?php echo $header_image;?>" alt="alt">
                    <?php } ?>
                    <h1>
                        <?php
                            echo $header_text;
                        ?>
                    </h1>
                </div>
            </div>
            <div class='col-12'>
                <div class="blog-categories-wrap">
                    <?php
                        get_template_part('tmpl/blog_news/blog_category', 'tmpl');
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /blog header -->

<!-- blog last-news  -->
<section class='blog-last-news_section section'>
    <div class='container'>
        <div class='row'>
            <div class="col-12">
                <h2>
                    <?php echo $latest_news_title;?>
                </h2>
            </div>
            <div class="col-12">
                <div class="last-news-wrap">
                    <?php
                        get_template_part('tmpl/blog_news/latest_news', 'tmpl');
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /blog last-news  -->


<section class='all-news_section section'>
    <div class='container'>
        <div class='row'>
            <div class="col-12">
                <div class="tabs-swither-wrap">

                    <div class="tab_title_wrap">
                        <div class="tab_title_blog active" data-gamename="all">
                            All
                        </div>
                        <div class="tab_title_blog" data-gamename="week">
                            Last Week
                        </div>
                        <div class="tab_title_blog" data-gamename="month">
                            Last Month
                        </div>
                    </div>

                    <div class="sort-wrap">
                        <span>Sort by</span>
                        <div class="select">
                            <select class="blog_news_select" style="display: none;" id="sort_news">
                                <option value="date_desc" selected>date desc</option>
                                <option value="date_asc"  >date asc</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 p-0">

                <div class="js-tabs_wrap tabs_items_wrap blog_list_news_content">
                    <!-- list news -->
                    <?php
                        $list = get_blog_news();
                        echo $list['list_news_html'];
                    ?>
                    <!-- /list news -->
                </div>

                <ul class="page-numbers w-100 blog_news_pagination" >
                    <?php
                        echo $list['pagination_html'];
                    ?>
                </ul>

            </div>
        </div>

    </div>


</section>


<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->
<?php
    get_footer();
?>