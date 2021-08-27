<?php
/**
 * Plugin name: My Snow Monkey
 * Description: このプラグインに、あなたの Snow Monkey 用カスタマイズコードを書いてください。
 * Version: 0.2.1
 *
 * @package my-snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Snow Monkey 以外のテーマを利用している場合は有効化してもカスタマイズが反映されないようにする
 */
$theme = wp_get_theme( get_template() );
if ( 'snow-monkey' !== $theme->template && 'snow-monkey/resources' !== $theme->template ) {
	return;
}

/**
 * Directory url of this plugin
 *
 * @var string
 */
define( 'MY_SNOW_MONKEY_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Directory path of this plugin
 *
 * @var string
 */
define( 'MY_SNOW_MONKEY_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
/**
 * @param array $items パンくずの配列
 * @return array パンくずの配列
 */

// 実際のページ用の CSS 読み込み
add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_style(
			'my-snow-monkey',
			untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/css/style.css',
			[ Framework\Helper::get_main_style_handle() ],
			filemtime( plugin_dir_path( __FILE__ ) )
		);
		wp_enqueue_style(
			'font-awesome',
			'https://use.fontawesome.com/releases/v5.6.1/css/all.css',
		);
	}
);
// js
add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_script(
			'effect-fade',
			'/wp-content/plugins/my-snow-monkey/js/script.js',
			[],
			false
		);
	}
);
//固定ページにカテゴリー、タグを追加
add_action('init','add_categories_for_pages'); 
function add_categories_for_pages(){ 
   register_taxonomy_for_object_type('category', 'page'); 
} 
add_action( 'pre_get_posts', 'nobita_merge_page_categories_at_category_archive' ); 
function nobita_merge_page_categories_at_category_archive( $query ) { 
 
if ( $query->is_category== true && $query->is_main_query() ) { 
$query->set('post_type', array( 'post', 'page', 'nav_menu_item')); 
} 
} 
//svgデータを有効か
function custom_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'custom_mime_types' );