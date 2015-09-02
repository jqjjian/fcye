<?php
/**
 * Template Name: 活动剪影
 */
get_header(); ?>

<div class="container">
  <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
      <div id="carousel-example-generic" data-ride="carousel" class="carousel slide">
        <!--Indicators-->
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <!--Wrapper for slides-->
        <div role="listbox" class="carousel-inner">
          <div class="item active"><img src="<?php echo get_template_directory_uri(); ?>/static/images/564654568.jpg" alt="" width="100%" class="img-responsive">
            <div class="carousel-caption"></div>
          </div>
          <div class="item"><img src="<?php echo get_template_directory_uri(); ?>/static/images/564654568.jpg" alt="" width="100%" class="img-responsive">
            <div class="carousel-caption"></div>
          </div>
          <div class="item"><img src="<?php echo get_template_directory_uri(); ?>/static/images/564654568.jpg" alt="" width="100%" class="img-responsive">
            <div class="carousel-caption"></div>
          </div>
        </div>
        <!--Controls--><a href="#carousel-example-generic" role="button" data-slide="prev" class="left carousel-control"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span><span class="sr-only">Previous</span></a><a href="#carousel-example-generic" role="button" data-slide="next" class="right carousel-control"><span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span><span class="sr-only"></span></a>
      </div>
    </div>
    <div class="col-sm-12">
      <div class="pic-list-line clearfix">
        <h4 class="pull-left">活动摄影</h4>
        <div class="title-line"></div>
      </div>
    </div>
    <div class="col-sm-5ths">
    	<a href="#" class="pic-preview pic-preview-more">
    		<span>图片精选</span>
    		<span class="glyphicon glyphicon-arrow-right"></span>
    		<span class="glyphicon glyphicon-plus-sign"></span>
    	</a>
    </div>
    <?php $myqueryargs = array(
	    'post_type'      => 'activity',
	    'posts_per_page' => 9,
	    'orderby'        => 'date',
	    'category__in' => 9,
	  ); ?>
	  <?php $myquery =  new WP_Query($myqueryargs); ?>
	  <?php if($myquery -> have_posts()) : ?>
      <?php while ($myquery -> have_posts()) : $myquery -> the_post(); ?>
		    <div class="col-sm-5ths">
        <?php
          $args = array(
            'order'        => 'ASC',
            'post_parent'    => get_the_ID(),
            'post_type'      => 'attachment',
            'post_mime_type' => 'image'
          );
          $images = array_values(get_children( $args ));
          $atta = get_attached_media( 'image', $post_id );
        ?>
		    	<a href="<?php echo get_attachment_link($images[0] -> ID);?>" class="pic-preview">
		    		<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail')[0]; ?>" class="img-responsive">
		    		<p class="pic-preview-title"><?php the_title(); ?>（<?php echo count($atta); ?>）</p>
		    		<p class="pic-preview-time"><?php the_time('Y年m月d日'); ?></p>
		    	</a>
		    </div>
			<?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    <div class="col-sm-12">
      <div class="pic-list-line">
        <h4 class="pull-left">活动视频</h4>
        <div class="title-line"></div>
      </div>
    </div>
    <div class="col-sm-5ths">
    	<a href="#" class="pic-preview pic-preview-more">
    		<span>视频精选</span>
    		<span class="glyphicon glyphicon-arrow-right"></span>
    		<span class="glyphicon glyphicon-plus-sign"></span>
    	</a>
    </div>
     <?php $myvedios = array(
      'post_type'      => 'activity',
      'posts_per_page' => 9,
      'orderby'        => 'date',
      'category__in' => 10,
    ); ?>
    <?php $myvedio=  new WP_Query($myvedios); ?>
    <?php if($myvedio -> have_posts()) : ?>
      <?php while ($myvedio -> have_posts()) : $myvedio -> the_post(); ?>
        <?php
          $vedios = array(
            'order'        => 'ASC',
            'post_parent'    => get_the_ID(),
            'post_type'      => 'attachment',
            'post_mime_type' => 'video'
          );
          $video = array_values(get_children( $vedios ));
          $vatta = get_attached_media( 'video', $post_id );
        ?>
        <div class="col-sm-5ths">
        	<a href="<?php the_permalink(); ?>" class="pic-preview">
        		<img src="<?php echo wp_get_attachment_image_src(get_field('video-cover'), 'thumbnail')[0]; ?>" class="img-responsive">
        		<p class="pic-preview-title"><?php the_title(); ?></p>
        		<p class="pic-preview-time"><?php the_time('Y年m月d日'); ?></p>
        	</a>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</div>
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