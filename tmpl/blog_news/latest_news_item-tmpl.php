<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->
    <a href="<?php echo get_permalink($data['post']->ID);?>">
        <?php if ( $data['image']) { ?>
            <img src="<?php echo $data['image'];?>" >
        <?php } ?>
        <center>
            <p>
                <?php echo $data['post']->post_title;?>
            </p>
            <date>
                <?php echo date('F d, Y',strtotime($data['post']->post_date));?>
            </date>
        </center>
    </a>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->