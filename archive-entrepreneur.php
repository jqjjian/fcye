<?php get_header(); ?>
<section class="banner">
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div style="background:url(<?php echo get_template_directory_uri(); ?>/static/images/banner_03.jpg) center 0 no-repeat;" class="banner-bg"></div>
    </div>
  </div>
</div>
</section>
<section>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php if(function_exists('bcn_display')) : ?>
          <ol class="breadcrumb">
            <?php bcn_display(); ?>
          </ol>
        <?php endif ; ?>
      </div>
    </div>
  </div>
</section>
<section class="entrepreneur-list list">
  <div class="container pr">
    <div class="row text-center">
    	<?php $entrepreneurqueryargs = array(
        'post_type'      => 'entrepreneur',
        'posts_per_page' => 30,
        'orderby'        => 'date'
      ); ?>
      <?php $myentrepreneur =  new WP_Query($entrepreneurqueryargs); ?>
      <?php if($myentrepreneur -> have_posts()) : ?>
        <?php while ($myentrepreneur -> have_posts()) : $myentrepreneur -> the_post(); ?>
        	<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 img-box">
            <a href="<?php the_permalink(); ?>" class="pr thumbnail img-link">
            	<img src="<?php echo wp_get_attachment_image_src(get_field('entrepreneur-avatar'), '创业者头像')[0]; ?>" class="img-responsive">
              <div class="pa info">
                <p class="name"><?php the_title(); ?></p>
                <p class="company"><?php echo get_field('company-name'); ?></p>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<section class="text-center page">
  <nav>
     <?php wp_pagenavi(array('query' => $myentrepreneur)); ?>
  </nav>
</section>
<?php get_footer(); ?>
<!--jQuery (necessary for Bootstrap's JavaScript plugins)-->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!--Include all compiled plugins (below), or include individual files as needed-->
    <script src="<?php echo get_template_directory_uri(); ?>/public/bootstrap/js/bootstrap.min.js"></script>
    <!--base-->
    <!--script(src="static/js/base.js")-->
    <!--script(src="static/js/baseAjax.js")-->
  </body>
</html>