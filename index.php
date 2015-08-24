<?php get_header(); ?>
<div id="carousel-example-generic" data-ride="carousel" class="carousel slide">
  <!--Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
  </ol>
  <!--Wrapper for slides-->
  <div role="listbox" class="carousel-inner">
    <div class="item active"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/static/images/55861a41b14d7.jpg" alt="" width="100%" height="100%"></a>
      <div class="carousel-caption"></div>
    </div>
    <div class="item"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/static/images/5586178db0366.jpg" alt="" width="100%"></a>
      <div class="carousel-caption"></div>
    </div>
    <div class="item"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/static/images/5586195a8602b.jpg" alt="" width="100%"></a>
      <div class="carousel-caption"></div>
    </div>
  </div>
  <!--Controls--><a href="#carousel-example-generic" role="button" data-slide="prev" class="left carousel-control"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous</span></a><a href="#carousel-example-generic" role="button" data-slide="next" class="right carousel-control"><span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span><span class="sr-only"></span></a>
</div>
<section class="news">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-offset-1 col-lg-3 col-md-offset-1">
          <div class="h3 new-title text-center">新闻公告</div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-md-offset-1 col-lg-5">
          <div class="list-group new-list">
          <?php $myqueryargs = array(
	          'post_type'      => 'news',
	          'posts_per_page' => 5,
	          'orderby'        => 'date'
	        ); ?>
	        <?php $myquery =  new WP_Query($myqueryargs); ?>
	        <?php if($myquery -> have_posts()) : ?>
	        	<?php while ($myquery -> have_posts()) : $myquery -> the_post(); ?>
	          	<a href="<?php the_permalink(); ?>" class="list-group-item"><?php the_title(); ?></a>
		        <?php endwhile; ?>
	        <?php endif; ?>
	        <?php wp_reset_postdata(); ?>
          </div>
        </div>
        <div class="col-sm-2 col-md-3 pull-right text-right" style="padding-bottom:10px;"><a href="<?php echo get_permalink( 24 ); ?>" class="moer">更多>>></a></div>
      </div>
    </div>
  </div><a href="#" class="down-btn text-center"><i class="glyphicon glyphicon-menu-down"></i></a>
</section>
<section class="container partners">
  <h3 class="text-center">青创会伙伴</h3>
<?php $mypartners = array(
  'post_type'      => 'partner',
  'posts_per_page' => 12,
  'orderby'        => 'date'
); ?>
<?php $partnerlogo =  new WP_Query($mypartners); ?>
<?php if($partnerlogo -> have_posts()) : ?>
  <?php while ($partnerlogo -> have_posts()) : $partnerlogo -> the_post(); ?>
    <img src="<?php echo wp_get_attachment_image_src(get_field('partner-logo'), '企业logo')[0]; ?>" class="img-circle" title="<?php the_title(); ?>">
  <?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
</section>
<section class="entrepreneurs">
	<div class="mask text-center">
		<h3>知名创业者</h3>
	</div>
</section>
<section class="entrepreneur-list">
  <div class="container pr">
    <div class="row text-center">
    <?php $entrepreneurqueryargs = array(
      'post_type'      => 'entrepreneur',
      'posts_per_page' => 12,
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
    </div><a href="<?php echo get_post_type_archive_link( 'entrepreneur' ); ?>" class="moer">更多>>></a>
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
        function showHeight(){
          var topHeight = $('.navbar').height(),
            newsHeight = $('.news').height();
            reelHeight = $(window).height() - (topHeight+newsHeight)
          $('#carousel-example-generic .item').height(reelHeight);
        }
        showHeight()
        $(window).resize(showHeight);
      })(window)
    </script>
  </body>
</html>