<?php get_header(); ?>
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
<section class="news-details">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">

    		<?php while (have_posts()) : the_post(); ?>
	        <img src="<?php echo wp_get_attachment_image_src(get_field('title-img'), '新闻配图大')[0]; ?>" width="100%" class="img-responsive">
	        <h3><?php the_title(); ?></h3>
	        <div class="border border-bottom"></div><small class="date">发布日期：<?php the_time('Y年m月d日 G:i'); ?></small>
	        <div class="news-details-cont"><?php the_content(); ?></div>
	      </div>
	      <div class="col-sm-12">
	        <nav>
	          <ul class="pager">
	          	<li class="previous">
	          		<?php previous_post_link('%link', '&larr;'. ' %title' ); ?>
	            <li class="next">
	            	<?php next_post_link('%link', '%title'. ' &rarr;' ); ?>
	            </li>
	            <!-- <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span>上一篇</a></li>
	            <li class="next"><a href="#">下一篇<span aria-hidden="true">&rarr;</span></a></li> -->
	          </ul>
	        </nav>
	      </div>
	    	<?php endwhile; ?>

    </div>
  </div>
</section>
<?php get_footer(); ?>
<!--jQuery (necessary for Bootstrap's JavaScript plugins)-->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!--Include all compiled plugins (below), or include individual files as needed-->
    <script src="<?php echo get_template_directory_uri(); ?>/public/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>