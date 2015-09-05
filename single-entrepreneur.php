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
<section class="estp-details">
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <div class="introduce-bx">
          <div class="title-bar etur"></div>
          <div class="cont-bos">
          <?php while (have_posts()) : the_post(); ?>
          	<img src="<?php echo wp_get_attachment_image_src(get_field('entrepreneur-avatar'), '创业者头像')[0]; ?>" class="pull-left">
            <div class="info-cont">
              <h3><?php the_title(); ?>
                <p><small><?php echo get_field('company-name'); ?></small></p>
              </h3>
              <hr>
              <p class="indent"><?php the_content(); ?></p>
            </div>
          
          </div>
        </div>
        <div class="info-bx">
          <div class="title-bar info"></div>
          <ul class="list-unstyled info-list">
            <li><a href="#">
                <h4><strong>单身股民：股市震荡震丢了恋爱的心思</strong></h4></a>
              <p>“最近股市振幅太大，幸亏年轻，心理承受能力强，不然要震出毛病。这几天震荡又这么大，连对象都不想找了！”</p>
            </li>
          </ul>
        </div>
        <hr>
        <section class="text-center page">
	        <nav>
	          <ul class="pager">
	          	<li class="previous">
	          		<?php previous_post_link('%link', '&larr;'. ' %title' ); ?>
	            <li class="next">
	            	<?php next_post_link('%link', '%title'. ' &rarr;' ); ?>
	            </li>
	          <?php endwhile; ?>
	          </ul>
	        </nav>
        </section>
      </div>
      <div class="col-md-2">
        <div class="sidebar top-icon">
        <?php $entrepreneurqueryargs = array(
	        'post_type'      => 'entrepreneur',
	        'posts_per_page' => 5,
	        'orderby'        => 'date'
	      ); ?>
	      <?php $myentrepreneur =  new WP_Query($entrepreneurqueryargs); ?>
	      <?php if($myentrepreneur -> have_posts()) : ?>
	        <?php while ($myentrepreneur -> have_posts()) : $myentrepreneur -> the_post(); ?>
	        	<div class="img-box text-center">
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
          <div class="text-right"><a href="<?php echo get_post_type_archive_link( 'entrepreneur' ); ?>">更多>>></a></div>
        </div>
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
  </body>
</html>