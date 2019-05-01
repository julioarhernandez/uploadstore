<?php wp_head(); ?>
<?php get_header(); ?>
<?php
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="col-xs-12">
  <div class="bc-main-container pb-5 bg-light" id="bc-mainContainer">
      <ul class="bc-breadcrumb text-center uppercase weight-600">
          <li><span class="active upload-tabs upload-tab-upload">Upload a Photo</span></li>
          <li><span class="upload-tabs upload-tab-size">Select Size</span></li>
      </ul>
        <div class="container">
        <?php wc_print_notices(); ?>
      </div>
        <?php include __DIR__."/../sections/upload.php"; ?>
        <?php include __DIR__."/../sections/size.php"; ?>
  </div>
</div>
<?php 
  endwhile;
  endif;
?>
<?php get_footer(); ?>
<?php wp_footer(); ?>
