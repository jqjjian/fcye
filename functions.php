<?php
function fcye_setup(){
	//注册菜单
	register_nav_menu('primary', __('Primary Menu', 'fcye') );
	// 主题为特色图像使用自定义图像尺寸，显示在 '标签' 形式的文章上。
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'fcye_setup' );
/**
 * 网站的页面标题
 */
function fcye_wp_title($title, $sep){
	global $paged, $page;
	if (is_feed())
		return $title;
	//添加网站名称
	$title .= get_bloginfo('name');

	//为首页添加网站描述
	$site_description = get_bloginfo('description', 'display');
	if ($site_description && (is_home() || is_front_page()))
		$title = "$title $sep $site_description";

	// 在页面标题中添加页码
	if ($paged >= 2 || spage>= 2)
		$title = "$title $sep " . sprintf(__('page %s', 'fcye'), max($paged, $page));
	return $title;
}
add_filter('wp_title', 'fcye_wp_title', 10, 2);
/*
 * Bootstrap 导航菜单
 */

class fcye_Nav_Walker extends Walker_Nav_Menu {

     /*
      * @see Walker_Nav_Menu::start_lvl()
      */
     function start_lvl( &$output, $depth ) {
          $output .= "\n<ul class=\"dropdown-menu\">\n";
     }

     /*
      * @see Walker_Nav_Menu::start_el()
      */
     function start_el( &$output, $item, $depth, $args ) {
          global $wp_query;
          $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
          $li_attributes = $class_names = $value = '';
          $classes = empty( $item->classes ) ? array() : (array) $item->classes;
          $classes[] = 'menu-item-' . $item->ID;

          if ( $args->has_children ) {
               $classes[] = ( 1 > $depth) ? 'dropdown': 'dropdown-submenu';
               $li_attributes .= ' data-dropdown="dropdown"';
          }

          $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
          $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

          $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
          $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

          $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

					$attributes  =     $item->attr_title     ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
					$attributes  .=     $item->target          ? ' target="' . esc_attr( $item->target     ) .'"' : '';
					$attributes  .=     $item->xfn               ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
					$attributes  .=     $item->url               ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
					$attributes  .=     $args->has_children     ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
					
					$item_output =     $args->before . '<a' . $attributes . '>';
					$item_output .=     $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
					$item_output .=     ( $args->has_children AND 1 > $depth ) ? ' <b class="caret"></b>' : '';
					$item_output .=     '</a>' . $args->after;

          $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
     }

     /*
      * @see Walker::display_element()
      */
     function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
          if ( ! $element )
               return;
          $id_field = $this->db_fields['id'];
          //display this element
          if ( is_array( $args[0] ) )
               $args[0]['has_children'] = (bool) ( ! empty( $children_elements[$element->$id_field] ) AND $depth != $max_depth - 1 );
          elseif ( is_object(  $args[0] ) )
               $args[0]->has_children = (bool) ( ! empty( $children_elements[$element->$id_field] ) AND $depth != $max_depth - 1 );

          $cb_args = array_merge( array( &$output, $element, $depth ), $args );
          call_user_func_array( array( &$this, 'start_el' ), $cb_args );

          $id = $element->$id_field;

          // descend only when the depth is right and there are childrens for this element
          if ( ( $max_depth == 0 OR $max_depth > $depth+1 ) AND isset( $children_elements[$id] ) ) {

               foreach ( $children_elements[ $id ] as $child ) {

                    if ( ! isset( $newlevel ) ) {
                         $newlevel = true;
                         //start the child delimiter
                         $cb_args = array_merge( array( &$output, $depth ), $args );
                         call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
                    }
                    $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
               }
               unset( $children_elements[ $id ] );
          }

          if ( isset( $newlevel ) AND $newlevel ) {
               //end the child delimiter
               $cb_args = array_merge( array( &$output, $depth ), $args );
               call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
          }

          //end this element
          $cb_args = array_merge( array( &$output, $element, $depth ), $args );
          call_user_func_array( array( &$this, 'end_el' ), $cb_args );
     }
}

/*
 * 给激活的导航菜单添加 .active
 */
function fcye_nav_menu_css_class( $classes ) {
     if ( in_array('current-menu-item', $classes ) OR in_array( 'current-menu-ancestor', $classes ) )
          $classes[]     =     'active';

     return $classes;
}
add_filter( 'nav_menu_css_class', 'fcye_nav_menu_css_class' );
/**
 * 自定义内容类型 - 创业者
 */
function entrepreneur_custom_post_entrepreneur(){
  $labels = array(
    'name'               => '创业者',
    'singular_name'      => '创业者',
    'add_new'            => '添加创业者',
    'add_new_item'       => '添加创业者信息',
    'edit_item'          => '编辑创业者信息',
    'new_item'           => '新的创业者',
    'all_items'          => '所有创业者',
    'view_item'          => '查看创业者',
    'search_item'        => '搜索创业者',
    'not_found'          => '未找到创业者信息',
    'not_found_in_trash' => '回收站里没找到创业者信息',
    'menu_name'          => '创业者'
  );
  $args = array(
    'public'        => true,
    'labels'        => $labels,
    'menu_position' => 4,
    'supports'      => array('title', 'editor'),
    'has_archive'   => true,//使用归档页面模板
    'rewrite'       => array('slug' => 'entrepreneur-page', 'with_front' => false),//重写归档地址,去掉archives
  );
  register_post_type('entrepreneur', $args );
}
add_action('init', 'entrepreneur_custom_post_entrepreneur' );
/*
 * 自定义内容类型的内容更新信息 - 创业者
 */
function entrepreneur_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['entrepreneur'] = array(
    0 => '', // 没有用，信息从索引 1 开始。
    1 => sprintf( __('信息已更新，<a href="%s">点击查看</a>', 'entrepreneur'), esc_url( get_permalink($post_ID) ) ),
    2 => __('自定义字段已更新。', 'entrepreneur'),
    3 => __('自定义字段已删除。', 'entrepreneur'),
    4 => __('信息已更新。', 'entrepreneur'),
    // translators: %s: 修订版本的日期与时间
    5 => isset($_GET['revision']) ? sprintf( __('新闻恢复到了 %s 这个修订版本。', 'entrepreneur'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('创业者已添加，<a href="%s">点击查看</a>', 'entrepreneur'), esc_url( get_permalink($post_ID) ) ),
    7 => __('信息已保存', 'entrepreneur'),
    8 => sprintf( __('信息已提交， <a target="_blank" href="%s">点击预览</a>', 'entrepreneur'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('创业者添加于：<strong>%1$s</strong>， <a target="_blank" href="%2$s">点击预览</a>', 'entrepreneur'),
      // translators: 发布选项日期格式，查看 http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('创业者草稿已更新，<a target="_blank" href="%s">点击预览</a>', 'entrepreneur'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'entrepreneur_updated_messages' );
/**
 * 自定义内容类型 - 新闻
 */
function news_custom_post_news(){
	$labels = array(
		'name'               =>	'新闻',
		'singular_name'      =>	'新闻',
		'add_new'            =>	'添加新闻',
		'add_new_item'       =>	'添加新闻信息',
		'edit_item'          =>	'编辑新闻信息',
		'new_item'           =>	'新的新闻',
		'all_items'          =>	'所有新闻',
		'view_item'          =>	'查看新闻',
		'search_item'        =>	'搜索新闻',
		'not_found'          =>	'未找到新闻信息',
		'not_found_in_trash' =>	'回收站里没找到新闻信息',
		'menu_name'          =>	'新闻'
	);
	$args = array(
		'public'        => true,
		'labels'        => $labels,
		'menu_position' => 5,
		'supports'      => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions'),
		'has_archive'   => true,//使用归档页面模板
		'rewrite'				=> array('slug' => 'news-page', 'with_front' => false),//重写归档地址,去掉archives
		'taxonomies'		=> array('category'),
	);
	register_post_type('news', $args );
}
add_action('init', 'news_custom_post_news' );
/*
 * 自定义内容类型的内容更新信息 - 新闻
 */
function news_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['news'] = array(
    0 => '', // 没有用，信息从索引 1 开始。
    1 => sprintf( __('新闻已更新，<a href="%s">点击查看</a>', 'news'), esc_url( get_permalink($post_ID) ) ),
    2 => __('自定义字段已更新。', 'news'),
    3 => __('自定义字段已删除。', 'news'),
    4 => __('新闻已更新。', 'news'),
    // translators: %s: 修订版本的日期与时间
    5 => isset($_GET['revision']) ? sprintf( __('新闻恢复到了 %s 这个修订版本。', 'news'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('新闻已发布，<a href="%s">点击查看</a>', 'news'), esc_url( get_permalink($post_ID) ) ),
    7 => __('新闻已保存', 'news'),
    8 => sprintf( __('新闻已提交， <a target="_blank" href="%s">点击预览</a>', 'news'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('新闻发布于：<strong>%1$s</strong>， <a target="_blank" href="%2$s">点击预览</a>', 'news'),
      // translators: 发布选项日期格式，查看 http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('新闻草稿已更新，<a target="_blank" href="%s">点击预览</a>', 'news'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'news_updated_messages' );
/**
 * 自定义分类法 - 新闻类型
 */
function news_custom_taxonomy_genre(){
		$labels = array(
			'name'                         => '新闻类型',
	    'singular_name'                => '新闻类型',
	    'search_items'                 => '搜索新闻类型',
	    'popular_items'                => '热门新闻类型',
	    'all_items'                    => '所有新闻类型',
	    'parent_item'                  => null,
	    'parent_item_colon'            => null,
	    'edit_item'                    => '编辑新闻类型',
	    'update_item'                  => '更新新闻类型',
	    'add_new_item'                 => '添加新闻类型',
	    'new_item_name'                => '新的新闻类型',
	    'separate_items_with_commas'   => '使用逗号分隔不同的新闻类型',
	    'add_or_remove_items'          => '添加或移除新闻类型',
	    'choose_from_most_used'        => '从使用最多的新闻类型里选择',
	    'menu_name'                    => '新闻类型'
		);
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			// 'show_in_nav_menus' => true,
			// 'show_admin_column' => false,
			// 	'hierarchical'     => false,
			// 'show_tagcloud'     => true,
			// 'show_ui'           => true,
			// 'query_var'         => true,
			// 'rewrite'           => true,
			// 'query_var'         => true,
			// 'capabilities'      => array(),
		);
		register_taxonomy( 'genre', 'news', $args );
}
add_action('init', 'news_custom_taxonomy_genre' );

/**
 * 自定义内容类型 - 活动
 */
function activity_custom_post_activity(){
  $labels = array(
    'name'               => '活动',
    'singular_name'      => '活动',
    'add_new'            => '添加活动信息',
    'add_new_item'       => '添加活动信息',
    'edit_item'          => '编辑活动信息',
    'new_item'           => '新的活动信息',
    'all_items'          => '所有活动信息',
    'view_item'          => '查看活动信息',
    'search_item'        => '搜索活动信息',
    'not_found'          => '未找到活动信息',
    'not_found_in_trash' => '回收站里没找到活动信息',
    'menu_name'          => '活动'
  );
  $args = array(
    'public'        => true,
    'labels'        => $labels,
    'menu_position' => 5,
    'supports'      => array('title', 'editor', 'thumbnail'),
    'has_archive'   => true,//使用归档页面模板
    'rewrite'       => array('slug' => 'activity-page', 'with_front' => false),//重写归档地址,去掉archives
    'taxonomies'    => array('category'),
  );
  register_post_type('activity', $args );
}
add_action('init', 'activity_custom_post_activity' );
/*
 * 自定义内容类型的内容更新信息 - 新闻
 */
function activity_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['activity'] = array(
    0 => '', // 没有用，信息从索引 1 开始。
    1 => sprintf( __('活动已更新，<a href="%s">点击查看</a>', 'activity'), esc_url( get_permalink($post_ID) ) ),
    2 => __('自定义字段已更新。', 'activity'),
    3 => __('自定义字段已删除。', 'activity'),
    4 => __('活动已更新。', 'activity'),
    // translators: %s: 修订版本的日期与时间
    5 => isset($_GET['revision']) ? sprintf( __('活动恢复到了 %s 这个修订版本。', 'activity'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('活动已发布，<a href="%s">点击查看</a>', 'activity'), esc_url( get_permalink($post_ID) ) ),
    7 => __('活动已保存', 'activity'),
    8 => sprintf( __('活动已提交， <a target="_blank" href="%s">点击预览</a>', 'activity'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('活动发布于：<strong>%1$s</strong>， <a target="_blank" href="%2$s">点击预览</a>', 'activity'),
      // translators: 发布选项日期格式，查看 http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('活动草稿已更新，<a target="_blank" href="%s">点击预览</a>', 'activity'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'activity_updated_messages' );
/**
 * 自定义内容类型 - 公益慈善
 */
function publicbenefit_custom_post_publicbenefit(){
  $labels = array(
    'name'               => '公益慈善',
    'singular_name'      => '公益慈善',
    'add_new'            => '添加公益慈善信息',
    'add_new_item'       => '添加公益慈善信息',
    'edit_item'          => '编辑公益慈善信息',
    'new_item'           => '新的公益慈善信息',
    'all_items'          => '所有公益慈善信息',
    'view_item'          => '查看公益慈善信息',
    'search_item'        => '搜索公益慈善信息',
    'not_found'          => '未找到公益慈善信息',
    'not_found_in_trash' => '回收站里没找到公益慈善信息',
    'menu_name'          => '公益慈善'
  );
  $args = array(
    'public'        => true,
    'labels'        => $labels,
    'menu_position' => 5,
    'supports'      => array('title', 'editor', 'thumbnail'),
    'has_archive'   => true,//使用归档页面模板
    'rewrite'       => array('slug' => 'publicbenefit-page', 'with_front' => false),//重写归档地址,去掉archives
    'taxonomies'    => array('category'),
  );
  register_post_type('publicbenefit', $args );
}
add_action('init', 'publicbenefit_custom_post_publicbenefit' );
/*
 * 自定义内容类型的内容更新信息 - 新闻
 */
function publicbenefit_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['publicbenefit'] = array(
    0 => '', // 没有用，信息从索引 1 开始。
    1 => sprintf( __('公益慈善信息已更新，<a href="%s">点击查看</a>', 'publicbenefit'), esc_url( get_permalink($post_ID) ) ),
    2 => __('自定义字段已更新。', 'publicbenefit'),
    3 => __('自定义字段已删除。', 'publicbenefit'),
    4 => __('公益慈善信息已更新。', 'publicbenefit'),
    // translators: %s: 修订版本的日期与时间
    5 => isset($_GET['revision']) ? sprintf( __('公益慈善信息恢复到了 %s 这个修订版本。', 'publicbenefit'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('公益慈善信息已发布，<a href="%s">点击查看</a>', 'publicbenefit'), esc_url( get_permalink($post_ID) ) ),
    7 => __('公益慈善信息已保存', 'publicbenefit'),
    8 => sprintf( __('公益慈善信息已提交， <a target="_blank" href="%s">点击预览</a>', 'publicbenefit'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('公益慈善信息发布于：<strong>%1$s</strong>， <a target="_blank" href="%2$s">点击预览</a>', 'publicbenefit'),
      // translators: 发布选项日期格式，查看 http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('公益慈善信息草稿已更新，<a target="_blank" href="%s">点击预览</a>', 'publicbenefit'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'publicbenefit_updated_messages' );
// /**
//  * 自定义分类法 - 新闻类型
//  */
// function activity_custom_taxonomy_genre(){
//     $labels = array(
//       'name'                         => '活动',
//       'singular_name'                => '活动',
//       'search_items'                 => '搜索活动',
//       'popular_items'                => '热门活动',
//       'all_items'                    => '所有活动',
//       'parent_item'                  => null,
//       'parent_item_colon'            => null,
//       'edit_item'                    => '编辑活动',
//       'update_item'                  => '更新活动',
//       'add_new_item'                 => '添加活动',
//       'new_item_name'                => '新的活动',
//       'separate_items_with_commas'   => '使用逗号分隔不同的活动',
//       'add_or_remove_items'          => '添加或移除活动',
//       'choose_from_most_used'        => '从使用最多的活动里选择',
//       'menu_name'                    => '活动'
//     );
//     $args = array(
//       'labels'            => $labels,
//       'public'            => true,
//       // 'show_in_nav_menus' => true,
//       // 'show_admin_column' => false,
//       //  'hierarchical'     => false,
//       // 'show_tagcloud'     => true,
//       // 'show_ui'           => true,
//       // 'query_var'         => true,
//       // 'rewrite'           => true,
//       // 'query_var'         => true,
//       // 'capabilities'      => array(),
//     );
//     register_taxonomy( 'genre', 'activity', $args );
// }
// add_action('init', 'activity_custom_taxonomy_genre' );


/**
 * 自定义内容类型 - 合作伙伴
 */
function partner_custom_post_partner(){
	$labels = array(
		'name'               =>	'合作伙伴',
		'singular_name'      =>	'合作伙伴',
		'add_new'            =>	'添加合作伙伴',
		'add_new_item'       =>	'添加合作伙伴信息',
		'edit_item'          =>	'编辑合作伙伴信息',
		'new_item'           =>	'新的合作伙伴',
		'all_items'          =>	'所有合作伙伴',
		'view_item'          =>	'查看合作伙伴',
		'search_item'        =>	'搜索合作伙伴',
		'not_found'          =>	'未找到合作伙伴信息',
		'not_found_in_trash' =>	'回收站里没找到合作伙伴信息',
		'menu_name'          =>	'合作伙伴'
	);
	$args = array(
		'public'        => true,
		'labels'        => $labels,
		'menu_position' => 6,
		'supports'      => array('title', 'excerpt'),
		'has_archive'   => true,//使用归档页面模板
		'rewrite'				=> array('slug' => 'partner-page', 'with_front' => false),//重写归档地址,去掉archives
	);
	register_post_type('partner', $args );
}
add_action('init', 'partner_custom_post_partner' );
/*
 * 自定义内容类型的内容更新信息 - 合作伙伴
 */
function partner_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['partner'] = array(
    0 => '', // 没有用，信息从索引 1 开始。
    1 => sprintf( __('合作伙伴已更新，<a href="%s">点击查看</a>', 'partner'), esc_url( get_permalink($post_ID) ) ),
    2 => __('自定义字段已更新。', 'partner'),
    3 => __('自定义字段已删除。', 'partner'),
    4 => __('合作伙伴已更新。', 'partner'),
    // translators: %s: 修订版本的日期与时间
    5 => isset($_GET['revision']) ? sprintf( __('合作伙伴恢复到了 %s 这个修订版本。', 'partner'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('合作伙伴已发布，<a href="%s">点击查看</a>', 'partner'), esc_url( get_permalink($post_ID) ) ),
    7 => __('合作伙伴已保存', 'partner'),
    8 => sprintf( __('合作伙伴已提交， <a target="_blank" href="%s">点击预览</a>', 'partner'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('合作伙伴发布于：<strong>%1$s</strong>， <a target="_blank" href="%2$s">点击预览</a>', 'partner'),
      // translators: 发布选项日期格式，查看 http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('合作伙伴草稿已更新，<a target="_blank" href="%s">点击预览</a>', 'partner'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
add_filter( 'post_updated_messages', 'partner_updated_messages' );

/**
 * 添加缩略图尺寸http://localhost:8000/fcye/static/images/u=1977945241,1806250151&fm=21&gp=0.jpg
 */
add_image_size('新闻配图小' , 320, 150, true);
add_image_size('新闻配图大' , 750, 316, true);
add_image_size('创业者头像' , 210, 250, true);
add_image_size('企业logo' , 124, 124);

/**
 * 设置文章摘要默认显示字数
 */
function emtx_excerpt_length( $length ) {
	return 120; //把92改为你需要的字数，具体就看你的模板怎么显示了。
}
add_filter( 'excerpt_length', 'emtx_excerpt_length' );

function news_query_vars($vars){
  $vars[] = 'category_id';
  return $vars;
}
add_filter( 'query_vars', 'news_query_vars' );

/**
 * 重写规则
 */
function news_rewrite_rules($rules){
  $rules['newsquery/([0-9]{1,})'] = 'index.php?pagename=newsquery&category_id=$matches[0]';
  return $rules;
}
//add_filter('rewrite_rules_array', 'news_rewrite_rules' );

/**
 * 自定义翻页器样式
 */
function news_pagination($html) {
  $out = '';

  //wrap a's and span's in li's
  $out = str_replace("<div","",$html);
  $out = str_replace("class='wp-pagenavi'>","",$out);
  $out = str_replace("<a","<li><a",$out);
  $out = str_replace("</a>","</a></li>",$out);
  //$out = str_replace("<span",'<li><span',$out);
  $out = str_replace("</span>","</span></li>",$out);
  $out = str_replace("</div>","",$out);
  $out = str_replace('<li><a class="previouspostslink"','<li class="page-prev"><a',$out);
  $out = str_replace('<</a>','</a>',$out);
  $out = str_replace('<li><a class="nextpostslink"','<li class="page-next"><a',$out);
  $out = str_replace('></a>','</a>',$out);
  $out = str_replace('<li><a class="first"','<li class="page-first"><a',$out);
  $out = str_replace('《','',$out);
  $out = str_replace('<li><a class="last"','<li class="page-last"><a',$out);
  $out = str_replace('》','',$out);
  return '<ul class="pagination">'.$out.'</ul>';
}
add_filter( 'wp_pagenavi', 'news_pagination', 10, 2 );

/**
 * 更改标题输入框提示文字
 * http://www.wpdaxue.com/change-title-prompt-text.html
 */
function change_default_title( $title ){
	$screen = get_current_screen();

	if( 'post' == $screen->post_type ) {
		$title = '输入文章标题';
	} elseif ('news' == $screen->post_type) {
		$title = '输入新闻标题';
	} elseif ('entrepreneur' == $screen->post_type) {
		$title = '输入创业者姓名';
	}	elseif ('partner' == $screen->post_type) {
		$title = '输入合作伙伴名称';
	}

	return $title;
}
add_filter( 'enter_title_here', 'change_default_title' );


//获取相册数量
function post_img_number(){
  global $post, $posts;
  ob_start();
  ob_end_clean();

  //使用do_shortcode($post->post_content) 是为了处理在相册的情况下统计图片张数
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',do_shortcode($post->post_content), $matches);
  $cnt = count( $matches[1] );
  return $cnt;
}
//隐藏版本号
function wpbeginner_remove_version() {
return '';
}
add_filter('the_generator', 'wpbeginner_remove_version');