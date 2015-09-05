<?php get_header(); ?>
<section class="banner">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div style="background:url(<?php echo get_template_directory_uri(); ?>/static/images/banner_04.jpg) center 0 no-repeat;" class="banner-bg"></div>
      </div>
    </div>
  </div>
</section>
<section id="introduction" class="introduction">
  <div class="container">
    <div class="row">
      <div class="col-md-2 introduction-menu">
      <?php $myqueryargs = array(
        'post_type'        =>'introduction',
        'posts_per_page'   => 20,
        'orderby'          => 'date',
        );
      ?>
      <?php $myquery =  new WP_Query($myqueryargs); ?>
      <?php if($myquery -> have_posts()) : ?>
      	<?php while ($myquery -> have_posts()) : $myquery -> the_post(); ?>
		      <a href="<?php the_permalink();?>" <?php if(is_single($post->ID)){echo 'class="active"';}?>><?php the_title();?></a>
				<?php endwhile; ?>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      </div>
      <div class="col-md-10">
        <?php if(function_exists('bcn_display')) : ?>
	        <ol class="breadcrumb">
	          <?php bcn_display(); ?>
	        </ol>
	      <?php endif ; ?>
        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : the_post(); ?>
		        <h3 class="text-center"><?php the_title();?></h3>
		        <hr>
		        <p class="text-center"><small><?php the_time('Y年m月d日'); ?></small></p>
		        <p><?php the_content(); ?></p>
        	<?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
		<!--jQuery (necessary for Bootstrap's JavaScript plugins)-->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!--Include all compiled plugins (below), or include individual files as needed-->
    <script src="<?php echo get_template_directory_uri(); ?>/public/bootstrap/js/bootstrap.min.js"></script>
    <!--base-->
    <!--script(src="static/js/base.js")-->
    <!--script(src="static/js/baseAjax.js")-->
    <script>
      (function(window,undefined){
        var topHeight = $('.navbar').height(),
            bannerHeight = $('.banner').height(),
            footerHeight = $('footer').height(),
            reelHeight = $(window).height() - (topHeight+bannerHeight+footerHeight+9)
        $('#introduction').css('min-height',reelHeight)
      })(window)
    </script>
  </body>
</html>