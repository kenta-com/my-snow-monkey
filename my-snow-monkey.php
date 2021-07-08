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

//ローディング画面アニメーション
add_action(
	'snow_monkey_prepend_body',
	function() {
		?>
		<div class="c-page-effect" data-page-effect="fadein" aria-hidden="false">
			<div class="c-page-effect__item">
				<div class="c-circle-spinner"></div>
			</div>
		</div>
		<?php
	}
);

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
	}
);
/**
 * FontAwesome ショートコード
 */
function hsm_add_fontawesome_icon( $atts ) {
	extract( shortcode_atts( array(
			'icon' => 'fab fa-wordpress',
	), $atts ) );
	$output = '<i class="' . $icon . '"></i>';
	return $output;
}
add_shortcode( 'hsm-fa', 'hsm_add_fontawesome_icon' );
// カスタム投稿タイプ(呼び出し)
add_action('init', 'create_post_type');

