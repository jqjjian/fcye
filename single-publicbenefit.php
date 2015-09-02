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
                    'post_parent'     =>$post -> post_parent,
                    'post_type'       => 'attachment',
                    'post_mime_types' => 'video',
                    'order'           => 'ASC',
                    'orderby'         => 'menu_order ID',
                ) ));
                ?>
            <div class="pic-box">
                <div id="player-<?php the_id();?>"></div>
                <script>
                        jwplayer("player-<?php the_id();?>").setup({
                            file : "<?php the_field('video');?>",
                            image: "<?php echo wp_get_attachment_image_src(get_field('video-cover'),'medium')[0];?>",
                            width: 932,
                            height: 600
                        });
                    </script>
            </div>
            <?php endwhile; ?>
            <?php endif; ?></div>
        <div class="col-md-2 pl5">
            <div class="img-list-head">
                <p> <b><?php echo get_post($post_id) ->post_title; ?></b>
                </p>
            </div>
            <div class="img-list-box">
                <div class="img-row">
                <?php $myqueryargs = array(
                  'post_type'      =>'publicbenefit',
                  'posts_per_page' => 10,
                  'orderby'        => 'date',
                  'category__in'   => 12,
                );
                $attachment_size = apply_filters('fcye_attachment', array(70,70) );
                ?>
                    <?php $myquery =  new WP_Query($myqueryargs); ?>
                    <?php if($myquery ->
                    have_posts()) : ?>
                    <?php while ($myquery ->
                    have_posts()) : $myquery -> the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="img-ltem <?php if(is_single($post->ID)){echo 'active';}?>">
                        <img src="<?php echo wp_get_attachment_image_src(get_field('video-cover'))[0]; ?>" width="70" height="70">
                    </a>
                    <?php endwhile; ?>
                    <?php endif;?></div>
            </div>
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