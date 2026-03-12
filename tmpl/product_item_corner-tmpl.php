<!-- [<?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> -->
<?php
    $temp_dir = get_template_directory_uri();
    $mclass='product_corner';
    switch ($product_corner)
    {
        case 1:
            echo "<div class='$mclass product_corner_hot_offer' ><img src='$temp_dir/assets/img/hot.png'/ class'data-skip-lazy'><span>hot offer</span></div>";
            break;
        case 2:
            echo "<div class='$mclass product_corner_new_offer' ><img src='$temp_dir/assets/img/new.png'/ class'data-skip-lazy'><span>new offer</span></div>";
            break;
        case 3:
            echo "<div class='$mclass product_corner_discount' ><img src='$temp_dir/assets/img/disc.png'/ class'data-skip-lazy'><span>Discount</span></div>";
            break;
        default:
            echo "";
    };
   
?>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->