<?php
/**
 * Template Name: Admin Panel - Withdrawal requests
 */
get_header();
?>
<!-- [ <?php echo str_replace($_SERVER["DOCUMENT_ROOT"], '', __FILE__); ?> -->
<?php echo do_shortcode(get_the_content()); ?>
<!-- <?php echo str_replace($_SERVER["DOCUMENT_ROOT"], '', __FILE__); ?> ] -->
<?php
get_footer();
?>