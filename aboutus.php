<?php
/*
Template Name: About
*/

get_header();
?>

    <section class="section__intro__mini section__intro__aboutus">
<!--        --><?php //if(get_field('header_section_background_image')){ ?>
<!--            <div class="background__img" data-parallax="scroll" data-image-src="--><?php //echo get_field('header_section_background_image')['url']; ?><!--"></div>-->
<!--        --><?php //} ?>
	    <?php if(get_field('section_our_mision_background_image')){ ?>
        <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('section_our_mision_background_image')['url']; ?>">
        </div>
	    <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h1><?php the_title(); ?></h1>
                    <?php the_field('header_section_text_editor'); ?>
                </div>
            </div>
        </div>
    </section>


    <section class="section__advantages">
        <div class="container">
            <div class="row">
                <?php 
                    $advantages = get_field('advantages');
                    if($advantages){
                        foreach($advantages as $advantage){
                            ?>
                            <div class="col-lg-4">
                                <div class="advantage__item">
                                    <div class="advantage__icon">
                                        <?php 
                                        if(isset($advantage['image']['url'])){
                                            ?>
                                                <img src="<?php echo $advantage['image']['url'] ?>" alt="<?php echo $advantage['image']['alt'] ?>">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <h3><?php echo $advantage['title']; ?></h3>
                                    <p>
                                        <?php echo $advantage['description']; ?>
                                    </p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
    </section>


    <section class="section__mission" >
        <?php if(get_field('section_our_mision_background_image')){ ?>
            <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('section_our_mision_background_image')['url']; ?>">
            </div>
        <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-7 order-lg-2">
                    <?php the_field('section_our_mision_text_editor'); ?>
                </div>
                <div class="col-lg-5 order-lg-1">
                    <?php if(get_field('section_our_mision_image')){
                        ?> 
                            <img src="<?php echo get_field('section_our_mision_image')['url'] ?>" alt="<?php echo get_field('section_our_mision_image')['alt'] ?>">
                        <?php
                    } ?>
                </div>
            </div>
        </div>
    </section>


    <section class="section__stat js-section-stat">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <h2 class="js-stat-title"><?php the_field('section_key_figures_title'); ?></h2>
                </div>
                
                <?php 
                    $figures = get_field('section_key_figures_figures');
                    if($figures){
                        foreach($figures as $figure){
                            ?>
                                <div class="col-md-4">
                                    <div class="stat__value">
                                        <span class="js-stat-value"><?php echo $figure['count']; ?></span>
                                        <?php echo $figure['text_after_count']; ?>
                                    </div>
                                    <div class="stat__name"><?php echo $figure['title']; ?></div>
                                    <div class="stat__text"><?php echo $figure['description']; ?></div>
                                </div>  
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
    </section>



    <section class="section__principles">
        <?php if(get_field('sectio_our_principles_background_image')){ ?>
            <div class="background__img" data-parallax="scroll" data-image-src="<?php echo get_field('sectio_our_principles_background_image')['url']; ?>"></div>
        <?php } ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <?php
                        the_field('sectio_our_principles_text_editor');
                    ?>
                </div>

                <?php
                    $boxes = get_field('sectio_our_principles_boxes');
                    if($boxes){
                        ?><div class="col-12">
                            <ul class="princeples__inner"><?php
                            foreach($boxes as $box){
                                ?>
                                    <li>
                                        <div class="princeples__icon">
                                            <span class="<?php echo $box['icon'] ?>"></span>
                                        </div>
                                        <h3><?php echo $box['title'] ?></h3>
                                    </li>
                                <?php
                            }
                        ?></ul>
                    </div><?php
                    }
                ?>
            </div>
        </div>
    </section>


    <section class="section__bottom__text">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <?php the_field('section_questions_text_editor') ?>


                    <div class="have__questions__text">
                        <?php the_field('have_question', 'footer'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>



<?php get_footer(); ?>