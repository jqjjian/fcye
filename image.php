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
                    'orderby' => 'menu_order ID',
                    'suppress_filters'=> true
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
    <div class="col-md-2 pl5">
    	<div class="img-list-head">
             <?php
                $post_id = wp_get_post_parent_id(get_the_id());
                $title = get_post($post_id) -> post_title;
                $otp = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',do_shortcode(get_post($post_id) -> post_content), $matches);
                $count = count($matches[1]);
            ?>
    		<span class="img-size">专辑(<?php echo $count; ?>张)</span>
    		<p>
                <b>
                    <?php echo $title; ?>
                </b>
            </p>
    	</div>
    	<div class="img-list-box">
    		<div class="img-row">
                <?php
                  $args = array(
                    'order'        => 'ASC',
                    'post_parent'    => $post_id,
                    'post_type'      => 'attachment',
                    'post_mime_type' => 'image',
                    'suppress_filters' => true
                  );
                  $images = array_values(get_children( $args ));
                  $attachments = get_attached_media( 'image', $post_id );
                ?>
                
    			<a href="<?php echo get_attachment_link(get_the_id()); ?>" class="img-ltem active">
    				<img src="<?php echo wp_get_attachment_thumb_url(get_the_id()); ?>" width="70" height="70"></a>
    		</div>
    	</div>
        <pre><?php echo count($attachments) ;?></pre>
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