<?php
    get_header();
?>
<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
    <article class="post_article" style="background-image: url(<?php echo get_template_directory_uri();?>/img/article_bg.png);">

        <section class="section__intro__mini">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="article_head">
                            <a href="<?php echo get_post_type_archive_link('news');?>" class="back_btn">

                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17px" height="17px" viewBox="0 0 512 512" version="1.1" xml:space="preserve"><style type="text/css">
                                        .st0{fill:rgba(255, 255, 255, 0.2);}
                                    </style><g id="Layer_1"/><g id="Layer_2"><g><path class="st0" d="M217,129.88c-6.25-6.25-16.38-6.25-22.63,0L79.61,244.64c-0.39,0.39-0.76,0.8-1.11,1.23    c-0.11,0.13-0.2,0.27-0.31,0.41c-0.21,0.28-0.42,0.55-0.62,0.84c-0.14,0.21-0.26,0.43-0.39,0.64c-0.14,0.23-0.28,0.46-0.41,0.7    c-0.13,0.24-0.24,0.48-0.35,0.73c-0.11,0.23-0.22,0.45-0.32,0.68c-0.11,0.26-0.19,0.52-0.28,0.78c-0.08,0.23-0.17,0.46-0.24,0.69    c-0.09,0.29-0.15,0.58-0.22,0.86c-0.05,0.22-0.11,0.43-0.16,0.65c-0.08,0.38-0.13,0.76-0.17,1.14c-0.02,0.14-0.04,0.27-0.06,0.41    c-0.11,1.07-0.11,2.15,0,3.22c0.01,0.06,0.02,0.12,0.03,0.18c0.05,0.46,0.12,0.92,0.21,1.37c0.03,0.13,0.07,0.26,0.1,0.39    c0.09,0.38,0.18,0.76,0.29,1.13c0.04,0.13,0.09,0.26,0.14,0.4c0.12,0.36,0.25,0.73,0.4,1.09c0.05,0.11,0.1,0.21,0.15,0.32    c0.17,0.37,0.34,0.74,0.53,1.1c0.04,0.07,0.09,0.14,0.13,0.21c0.21,0.38,0.44,0.76,0.68,1.13c0.02,0.03,0.04,0.06,0.06,0.09    c0.55,0.81,1.18,1.58,1.89,2.29l114.81,114.81c3.12,3.12,7.22,4.69,11.31,4.69s8.19-1.56,11.31-4.69c6.25-6.25,6.25-16.38,0-22.63    l-87.5-87.5h291.62c8.84,0,16-7.16,16-16s-7.16-16-16-16H129.51L217,152.5C223.25,146.26,223.25,136.13,217,129.88z"/></g></g></svg>

                                <span>back to list</span>
                            </a>

                            <h1>
                                <?php echo get_the_title();?>
                            </h1>

                            <date>
                                <?php echo date('F d, Y',strtotime(get_the_date()));?>
                            </date>
                        </div>
                    </div>
                </div>
        </section>

        <section class="article_text">
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-12'>
                        <div class="article_wrap">
                            <?php
                                $image = get_field('image_single',get_the_ID());
                            ?>
                            <?php if ($image){ ?>
                                <img src="<?php echo $image;?>" alt="alt">
                            <?php } ?>

                            <br><br>
                            <?php
                                the_content();
                            ?>
                            <div class="share_block">
                                <span>Share our Guide</span>

                                <!-- Twitter -->

                                <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(get_the_ID());?>&text=<?php echo get_the_title();?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="rgba(255, 255, 255, 0.3)" width="28px" height="28px" viewBox="0 0 24 24"
                                         version="1.2" baseProfile="tiny">
                                        <g>
                                            <path
                                                d="M15.279 10.283c.358-.221.597-.521.713-.904-.349.186-.697.312-1.045.383-.312-.336-.708-.507-1.182-.507-.464 0-.855.163-1.175.479-.317.318-.478.706-.478 1.158 0 .137.017.26.052.364-1.368-.048-2.499-.614-3.391-1.706-.151.267-.227.539-.227.82 0 .578.244 1.036.73 1.373-.277-.023-.521-.094-.73-.209 0 .413.121.758.365 1.062.243.3.557.492.939.573-.139.036-.285.053-.435.053-.14 0-.237-.012-.296-.037.104.337.296.609.574.818.277.21.597.32.957.33-.591.465-1.269.694-2.035.694-.188 0-.32-.002-.4-.017.754.489 1.594.733 2.521.733.951 0 1.792-.241 2.522-.723.73-.479 1.271-1.07 1.617-1.767.348-.695.521-1.419.521-2.174v-.209c.336-.253.609-.538.818-.854-.298.133-.611.222-.935.267zM12 21c-2.49 0-4.635-.89-6.376-2.646-1.741-1.751-2.624-3.889-2.624-6.354 0-2.488.884-4.634 2.627-6.375 1.74-1.741 3.884-2.625 6.373-2.625 2.466 0 4.604.883 6.354 2.624 1.756 1.742 2.646 3.888 2.646 6.376 0 2.465-.889 4.604-2.644 6.357-1.751 1.753-3.889 2.643-6.356 2.643zm0-16c-1.966 0-3.588.667-4.958 2.04-1.375 1.372-2.042 2.994-2.042 4.96 0 1.944.668 3.562 2.043 4.945 1.372 1.383 2.993 2.055 4.957 2.055 1.943 0 3.56-.673 4.942-2.057 1.385-1.384 2.058-3.002 2.058-4.943 0-1.963-.672-3.585-2.055-4.957-1.383-1.375-3-2.043-4.945-2.043z" />
                                        </g>
                                    </svg>
                                </a>
                                <!-- /Twitter -->

                                <!-- facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(get_the_ID());?>&t=<?php echo get_the_title();?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="rgba(255, 255, 255, 0.3)" width="28px" height="28px"
                                         viewBox="-2 -2 24 24" preserveAspectRatio="xMinYMin" class="jam jam-facebook-circle">
                                        <path
                                            d="M8.695 6.937v1.377H7.687v1.683h1.008V15h2.072V9.997h1.39s.131-.807.194-1.69h-1.576v-1.15c0-.173.226-.404.45-.404h1.128V5h-1.535C8.644 5 8.695 6.685 8.695 6.937z" />
                                        <path
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0 2C4.477 20 0 15.523 0 10S4.477 0 10 0s10 4.477 10 10-4.477 10-10 10z" />
                                    </svg>
                                </a>
                                <!-- /facebook -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class='blog-last-news_section article-blog-last-news_section section'>
            <div class='container'>
                <div class='row'>

                    <div class="col-12">
                        <h2>
                            Related Guides
                        </h2>
                    </div>

                    <div class="col-12">
                        <div class="tabs_items_wrap">
                            <?php
                                get_template_part('tmpl/blog_news/related_news', 'tmpl');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->
<?php
    get_footer();
?>
		
