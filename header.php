<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta <?php bloginfo('charset'); ?>>
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="renderer" content="webkit">
    <!--Bootstrap-->
    <!--link(href="../public/bootstrap/css/bootstrap.min.css" rel="stylesheet")-->
    <link href="<?php echo get_template_directory_uri(); ?>/static/css/base.css" rel="stylesheet">
    <!--HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries-->
    <!-- if lt IE 9
    script(src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js")
    script(src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js")
    -->
  </head>
  <body>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
          </button><a href="#" class="navbar-brand"><img src="<?php echo get_template_directory_uri(); ?>/static/images/logo_03.jpg" class="img-responsive"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        	<?php
        	  /**
        		* Displays a navigation menu
        		* @param array $args Arguments
        		*/
        		$args = array(
        			'theme_location' => 'primary',
        			// 'menu' => '',
        			'container' => false,
        			// 'container_class' => 'menu-{menu-slug}-container',
        			// 'container_id' => '',
        			'menu_class' => 'nav navbar-nav navbar-right',
        			// 'menu_id' => '',
        			// 'echo' => true,
        			// 'fallback_cb' => 'wp_page_menu',
        			// 'before' => '',
        			// 'after' => '',
        			// 'link_before' => '',
        			// 'link_after' => '',
        			// 'items_wrap' => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
        			// 'depth' => 0,
        			'walker' => new fcye_Nav_Walker,
        		);
        	
        		wp_nav_menu( $args ); ?>
          <!-- <ul class="nav navbar-nav navbar-right">
            <li><a href="#">首页</a></li>
            <li><a href="#">新闻公告</a></li>
            <li><a href="#">活动剪影</a></li>
            <li><a href="#">公益慈善</a></li>
            <li><a href="#">青创会简介</a></li>
            <li class="dropdown"><a data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle">服务介绍<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">政务代理服务</a></li>
                <li><a href="#">创业孵化服务</a></li>
                <li><a href="#">管理咨询服务</a></li>
                <li><a href="#">城市会所服务</a></li>
                <li><a href="#">金融服务</a></li>
                <li><a href="#">会展会务服务</a></li>
                <li><a href="#">商机服务</a></li>
                <li><a href="#">人脉圈层服务</a></li>
                <li><a href="#">公关服务</a></li>
                <li><a href="#">国际商务服务</a></li>
                <li><a href="#">学习修炼服务</a></li>
                <li><a href="#">品牌战略服务</a></li>
                <li><a href="#">健康管理服务</a></li>
                <li><a href="#">夫人服务</a></li>
                <li><a href="#">子女服务</a></li>
                <li><a href="#">慈善公益服务</a></li>
              </ul>
            </li>
            <li><a href="#">服务介绍</a></li>
            <li><a href="#">会员之声</a></li>
            <li><a href="#">入会申请</a></li>
          </ul> -->
        </div>
      </div>
    </nav>