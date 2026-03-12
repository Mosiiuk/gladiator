<?php
/*
Template Name: Work with us
*/
get_header();
?>
    <section class="section__intro__mini section__intro__job ">
        <?php if(get_field('header_backgroud_image')){ ?>
            <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('header_backgroud_image')['url']; ?>"></div>
        <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </section>


    <section class="section__job__bodyes">
        <div class="container">
            <div class="row job__body js-tab-body" style="display: block" id="body-1">
                <div class="col-lg-10 offset-lg-1">
                    <?php
                        the_field('text_editor');
                    ?>
                </div>

                <div class="col-lg-8 offset-lg-2">
                    <?php
                        the_content();
                    ?>
                </div>
            </div>

        </div>
    </section>


    <section class="section__bottom__text ">
        <?php if(get_field('bottom_background_image', 'footer')){ ?>
            <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('bottom_background_image', 'footer')['url']; ?>"></div>
        <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="have__questions__text">
                        <?php
                            the_field('have_question', 'footer');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>

<?php
get_footer();
?>