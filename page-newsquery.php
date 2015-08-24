<?php
/**
 * Template Name: 新闻查询
 */
get_header(); ?>
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
<section class="news-list list">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="main-bx border border-double">
        <?php $myqueryargs = array(
					'post_type'      => 'news',
					'posts_per_page' => 1,
					'orderby'        => 'date',
					'category__not_in' => 1,
        ); ?>
        <?php if($category_id) : ?>
					<?php
						$myqueryargs['category__not_in'] = '';
						$myqueryargs['category__in'] = $category_id;
					?>
				<?php endif; ?>
        <?php $myquery =  new WP_Query($myqueryargs); ?>

        <?php if($myquery -> have_posts()) : ?>
          <?php while ($myquery -> have_posts()) : $myquery -> the_post(); ?>

	        	<div class="focus-img">
	        		<?php echo count($myqueryargs); ?>
	        		<a href="<?php the_permalink(); ?>">
	        			<img src="<?php echo wp_get_attachment_image_src(get_field('title-img'), '新闻配图大')[0]; ?>" alt="" width="100%" class="img-responsive">
	        		</a>

	          </div>
	          <h3>
	          	<a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							<p><small><?php the_time('Y年m月d日 G:i'); ?></small></p>
	          </h3>
	          <p><?php the_excerpt(); ?></p>
	          <p class="text-right">
	          	<a href="<?php the_permalink(); ?>" class="link">+阅读全文</a>
	          </p>
          <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="sidebar border">
        	<?php $announcementargs = array(
						'post_type'      => 'news',
						'posts_per_page' => 10,
						'orderby'        => 'date',
					'category__in' => 1,
	        ); ?>
	        <?php $announcement =  new WP_Query($announcementargs); ?>
	        <?php if($announcement-> have_posts()) : ?>
          <h3 class="text-center border border-bottom">青创公告</h3>
          <ul class="news-hot-list">
          	<?php while ($announcement -> have_posts()) : $announcement -> the_post(); ?>
            	<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; ?>
          </ul>
        	<?php endif; ?>
        	<?php wp_reset_postdata(); ?>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="news-classify">
        	<a href="#" role="button" class="btn btn-default active">全部</a>
        	<a href="#" role="button" class="btn btn-default">青创新闻</a>
        	<a href="#" role="button" class="btn btn-default">行业新闻</a></div>
        <div class="ltem-bx">
				<?php $mynewslist = array(
					'post_type'        => 'news',
					'posts_per_page'   => 10,
					'orderby'          => 'date',
					'category__not_in' => 1,
					'offset'           => 1,
        ); ?>
        <?php if($category_id) : ?>
					<?php
						$mynewslist['category__not_in'] = '';
						$mynewslist['category__in'] = $category_id;
					?>
				<?php endif; ?>
        <?php $mynews =  new WP_Query($mynewslist); ?>
        <?php if($mynews -> have_posts()) : ?>
        	<?php while ($mynews -> have_posts() ) : $mynews -> the_post(); ?>
	          <div class="news-ltem border border-bottom clearfix pr">
	          	<a href="<?php the_permalink(); ?>">
	          		<img src="<?php echo wp_get_attachment_image_src(get_field('delineation-img'), '新闻配图小')[0]; ?>" class="pull-left">
	          	</a>
	            <div class="cont-text">
	              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	                <p><small><?php the_time('Y年m月d日 G:i'); ?></small></p>
	              </h4>
	              <p class="indent"><?php echo get_the_excerpt(); ?></p><a href="<?php the_permalink(); ?>" class="link">+阅读全文</a>
	            </div>
	          </div>
          <?php endwhile; ?>
        <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="text-center page">
  <nav>
    <ul class="pagination">
      <li><a href="#"></a></li>
      <li><a href="#" aria-label="Previous"></a></li>
      <li><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li class="active"><a href="#">3</a></li>
      <li><a href="#">4</a></li>
      <li><a href="#">5</a></li>
      <li><a href="#">…</a></li>
      <li><a href="#" aria-label="Next"></a></li>
      <li><a href="#"></a></li>
    </ul>
  </nav>
</section>
<pre><?php print_r($myquery); ?></pre>
<?php get_footer(); ?>
<!--jQuery (necessary for Bootstrap's JavaScript plugins)-->
    <script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <!--Include all compiled plugins (below), or include individual files as needed-->
    <script src="<?php echo get_template_directory_uri(); ?>/public/bootstrap/js/bootstrap.min.js"></script>
    <script>
      (function(window,undefined){
        function showHeight(){
          var topHeight = $('.main-bx').height(),
          $sidebar = $('.sidebar');
          if($(window).width()>=768){
            $sidebar.height(topHeight);
          }
          else{
            $sidebar.css('height','auto');
          }
        }
        //showHeight();
        $(window).resize(showHeight);
      })(window)
    </script>
    <!--base-->
    <!--script(src="static/js/base.js")-->
    <!--script(src="static/js/baseAjax.js")-->
  </body>
</html>