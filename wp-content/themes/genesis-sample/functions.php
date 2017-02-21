<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
function genesis_sample_localization_setup(){
	load_child_theme_textdomain( 'genesis-sample', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Genesis Sample' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.3.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

}

// Define our responsive menu settings.
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 600,
	'height'          => 160,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'genesis-sample' ), 'secondary' => __( 'Footer Menu', 'genesis-sample' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'genesis_sample_secondary_menu_args' );
function genesis_sample_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar' );
function genesis_sample_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'genesis_sample_comments_gravatar' );
function genesis_sample_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}


// メニューを非表示にする
function remove_menus(){
 if(!current_user_can('administrator')){ //管理者以外のユーザーの場合メニューをunsetする
 global $menu;
 unset($menu[2]); // ダッシュボード
 unset($menu[4]); // メニューの線1
 unset($menu[5]); // 投稿
 unset($menu[10]); // メディア
 unset($menu[15]); // リンク
 unset($menu[20]); // ページ
 unset($menu[25]); // コメント
 unset($menu[26]); // item
 unset($menu[59]); // メニューの線2
 unset($menu[60]); // テーマ
 unset($menu[65]); // プラグイン
 unset($menu[70]); // プロフィール
 unset($menu[75]); // ツール
 unset($menu[80]); // 設定
 unset($menu[90]); // メニューの線3
 unset($menu[100]); // テンプレート
 }
 }
add_action('admin_menu', 'remove_menus');

function remove_bar_menus( $wp_admin_bar ) {
if(!current_user_can('administrator')){
    //$wp_admin_bar->remove_menu( 'wp-logo' );      // ロゴ
    //$wp_admin_bar->remove_menu( 'site-name' );    // サイト名
    $wp_admin_bar->remove_menu( 'view-site' );    // サイト名 -> サイトを表示
    $wp_admin_bar->remove_menu( 'dashboard' );    // サイト名 -> ダッシュボード (公開側)
    $wp_admin_bar->remove_menu( 'themes' );       // サイト名 -> テーマ (公開側)
    $wp_admin_bar->remove_menu( 'customize' );    // サイト名 -> カスタマイズ (公開側)
    $wp_admin_bar->remove_menu( 'comments' );     // コメント
    $wp_admin_bar->remove_menu( 'updates' );      // 更新
    $wp_admin_bar->remove_menu( 'view' );         // 投稿を表示
    $wp_admin_bar->remove_menu( 'new-content' );  // 新規
    $wp_admin_bar->remove_menu( 'new-post' );     // 新規 -> 投稿
    $wp_admin_bar->remove_menu( 'new-media' );    // 新規 -> メディア
    $wp_admin_bar->remove_menu( 'new-link' );     // 新規 -> リンク
    $wp_admin_bar->remove_menu( 'new-page' );     // 新規 -> 固定ページ
    $wp_admin_bar->remove_menu( 'new-user' );     // 新規 -> ユーザー
    $wp_admin_bar->remove_menu( 'my-account' );   // マイアカウント
    $wp_admin_bar->remove_menu( 'user-info' );    // マイアカウント -> プロフィール
    $wp_admin_bar->remove_menu( 'edit-profile' ); // マイアカウント -> プロフィール編集
    $wp_admin_bar->remove_menu( 'logout' );       // マイアカウント -> ログアウト
    $wp_admin_bar->remove_menu( 'search' );       // 検索 (公開側)
}
}
add_action('admin_bar_menu', 'remove_bar_menus', 201);

function remove_dashboard_widget() {
	if ( ! current_user_can( 'administrator' ) ) {
	 	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // 概要
	 	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // アクティビティ
	 	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // クイックドラフト
	 	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // WordPressニュース
	}
}
add_action('wp_dashboard_setup', 'remove_dashboard_widget' );

// 編集画面にボタンを追加
function register_button($buttons) {
	$buttons[] = 'blockquote_link';
	$buttons[] = 'blockquote_val';
	return $buttons;
}
add_filter('mce_buttons', 'register_button');

function mce_plugin($plugin_array) {
	$plugin_array['custom_button_script'] = get_stylesheet_directory_uri() . '/myeditor_plugin/myeditor_plugin.js';
	return $plugin_array;
}
add_filter('mce_external_plugins', 'mce_plugin');


//js追加
add_action( 'admin_enqueue_scripts', 'admin_enqueue_label_sctipt');

function admin_enqueue_label_sctipt( $hook_suffix ){

	if ( 'post-new.php' === $hook_suffix || 'post.php' === $hook_suffix ){
		wp_enqueue_script(
			'insert-labels',
			get_stylesheet_directory_uri() . '/myeditor_plugin/insert-labels.js',
			array('jquery'),
			filemtime( dirname( __FILE__ ) . '/myeditor_plugin/insert-labels.js' ),
			true
		);

		wp_enqueue_style(
			'insert-labels',
			get_stylesheet_directory_uri() . '/myeditor_plugin/insert-labels.css',
			array(),
			filemtime( dirname( __FILE__ ) . '/myeditor_plugin/insert-labels.css' )
		);

	}
}


add_action('admin_footer-post.php', 'affi_footer');
add_action('admin_footer-post-new.php', 'affi_footer');

function affi_footer(){
	?>

	<div id="insert-labels-backdrop" style="desplay: none;"></div>
	<div id="insert-labels-wrap" class="wp-core-ui search-panel-visible" style="desplay: none;">
		<div class="modal">
			<div class="header">
				<h1><span class="dashicons dashicons-format-image"></span>ラベルの挿入</h1>
				<a href="#" class="close"><span class="dashicons dashicons-no-alt"></span></a>
			</div>
			<div class="container">
				<div id="left-option">
					<p>商材名：<br><select id="insert-labels-list"></select></p>
					<p>パターン：<br><select id="label-type-list">
						<option value="detail">詳細</option>
						<option value="button">ボタン</option>
						<option value="text">テキスト</option>
					</select></p>
				</div>
				<div id="right-option">
					<p>タイトル：<br><input type="text" id="label-title"></p>
					<p>ラベリング：<br><input type="text" id="label-text" value="公式サイトへ"></p>
					<!-- <iframe id="insert-labels-preview"></iframe> -->
				</div>
			</div>
			<div class="footer">
				<a href="#" id="insert-labels-insert" class="button button-primary button-large template-button-insert" disabled>ラベルを挿入する</a>
			</div>
		</div>
	</div>

	<?php

	$url   = admin_url( 'admin-ajax.php' );
	$nonce = wp_create_nonce( 'insert_labels' );
	$args = array(
		'action' => 'insert_labels',
		'nonce' => $nonce,
	);

	$post_id = get_the_ID();
	add_post_meta($post_id, '_label_count', 0, true);

	?>
	<script type="text/javascript">
		var insert_labels_list_uri = '<?php echo esc_url( $url ); ?>';
		var insert_labels_list_args = <?php echo json_encode($args); ?>;
		var insert_labels_post_id = <?php echo $post_id; ?>;
	</script>
	<?php
}

//アフィボタン追加
function affi_buttons( $editor_id = 'content' )
{
	//$editors = apply_filters( 'tinymce_templates_editors', array( 'content' ), $editor_id );
	//if ( apply_filters( 'tinymce_templates_enable_media_buttons', in_array( $editor_id, $editors ), $editor_id ) ) {
		$button_html = '<a id="%s" class="%s" href="#" data-editor="%s" title="%s">';
		$button_html .= '<span class="%s" style="%s"></span> %s';
		$button_html .= '</a>';
		printf(
			$button_html,
			'button-insert-labels',
			'button button-insert-labels',
			esc_attr( $editor_id ),
			'ラベルを挿入',
			'dashicons dashicons-format-image',
			'margin-top: 3px;',
			'ラベルを挿入'
		);
	//}
}

add_action( 'media_buttons', 'affi_buttons', 12 );


//output
add_action( 'wp_ajax_insert_labels', 'wp_ajax_insert_labels' );

function wp_ajax_insert_labels(){
	nocache_headers();

	if( !isset( $_GET['nonce'] ) || ! wp_verify_nonce( $_GET['nonce'], 'insert_labels')) {
		return;
	}

	header( 'Content-Type: application/javascript; charset=UTF-8' );

	if(isset($_GET['count_label']) && $_GET['count_label']){

		$mes = $_GET['count_label'];
		$adfd = update_post_meta($_GET['post_id'], '_label_count', $mes);

		exit;
	}

		$labels = get_labels();
		echo json_encode( $labels );

	exit;
}

//アフィラベルの情報を取得
function get_labels() {

	$p = array(
		'post_status' => 'publish',
		'post_type'   => 'label',
		'orderby'     => 'date',
		'order'       => 'DESC',
		'numberposts' => -1,
	);

	$posts = get_posts($p);
	$labels = array();

	foreach($posts as $p) {
		$ID = intval( $p->ID );
		$name = $p->post_title;
		$thumb = get_the_post_thumbnail($ID);
		$pattern= "/(?<=src=['|\"])[^'|\"]*?(?=['|\"])/i";
			preg_match($pattern, $thumb, $thePath);
		$theSrc = $thePath[0];
		$image = '<img src="' . $theSrc . '">';
		$labels[ $ID ] = array(
			'title' => $name,
			'url' => get_permalink($ID),
			'image' => $image,
		);
	}

	if(isset($_GET['label_id']) && $_GET['label_id']){
		if(isset( $labels[ $_GET['label_id'] ] ) && $labels[ $_GET['label_id'] ] ){
			$p = $labels[ $_GET['label_id'] ];
			$url = $p['url'];
			$preview = $p['image'];
			$label_count = intval(get_post_meta($_GET['post_id'], '_label_count', true));

			return array(
				'url' => $url,
				'preview' => $preview,
				'label_count' => $label_count,
			);
		}
	}

	return $labels;

}

add_editor_style("visual-style.css");
