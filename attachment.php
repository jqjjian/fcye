<?php
/**
 * Template Name: 活动剪影
 */
get_header(); ?>

<div class="container activity_single">
  <div class="row">
    <div class="col-md-10">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php $attachments = array_values(get_children(array(
                    'post_parent'    => $post -> post_parent,
                    'post_type' => 'attachment',
                    'post_mime_types' => 'image',
                    'order' => 'ASC',
                    'orderby' => 'menu_order ID'
                ) ));
                foreach($attachments as $k => $attachment) :
                    if ($attachment -> ID == $post-> ID)
                        break;
                endforeach;
                $k++;
                if(count($attachments > 1)) :
                    if(isset($attachments[$k])) :
                        $next_attachments_url = get_attachment_link($attachments[$k] -> ID);
                    else :
                        $next_attachments_url = get_attachment_link($attachments[0] -> ID);
                    endif;
                else:
                    $next_attachments_url = wp_get_attachment();
                endif;
                ?>
            	<div class="pic-box">
                    <span><?php previous_image_link(0,'&nbsp;'); ?></span>
            		<img src="<?php echo wp_get_attachment_image_src($post -> ID, 'medium')[0]; ?>" width="100%" class="img-responsive">
            		<span><?php next_image_link(0,'&nbsp;'); ?></span>
            	</div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
     <?php $myqueryargs = array(
        'post_type'      => 'activity',
        'posts_per_page' => 9,
        'orderby'        => 'date',
        'category__in' => 15,
    ); ?>
    <?php $myquery =  new WP_Query($myqueryargs); ?>
    <?php if($myquery -> have_posts()) : ?>
    <div class="col-md-2 pl5">
    	<div class="img-list-head">
    		<span class="img-size">专辑(<?php echo post_img_number(); ?>张)</span>
    		<p><b><?php get_the_title();?></b></p>
    	</div>
    	<div class="img-list-box">
    		<div class="img-row">
                <?php while ($myquery -> have_posts()) : $myquery -> the_post(); ?>
    			<a href="#" class="img-ltem active">
    				<img src="../static/images/adfasdf.jpg" width="70" height="70"></a>
                <?php endwhile; ?>
    		</div>
    	</div>
    <?php endif; ?>
    </div>
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