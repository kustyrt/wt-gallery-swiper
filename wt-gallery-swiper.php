<?php
/*
Plugin Name: WT Gallery Swiper
Plugin URI: http://web-technology.biz/cms-wordpress/plugin-wt-gallery-swiper
Description: Галерея на основе слайдера Swiper
Version: 0.1
Author: Роман Кусты, АИТ "Web-Techology"
Author URI: http://web-technology.biz
*/

class WtGallerySwiper
{
	private $counter; // Счетчик сгенерированных галерей

	function __construct(){

		add_filter('post_gallery', array($this, 'shortcode_gallery_slider'), 10, 2);

	}

	public static function basename() {
        return plugin_basename(__FILE__);
    }

	function shortcode_gallery_slider($output, $attr) {

		$images = array();

		$post_mimes = get_posts(array(
			'include' => $attr['include'],
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'orderby' => $attr['orderby']
		));

		if (isset($attr['size'])) $size = $attr['size'];
		else $size = 'thumbnail';

		foreach ($post_mimes as $item) {
			$title = '';
			if (!empty($item->post_title)) $title = $item->post_title;
			if (!empty($item->post_content)){
				if (!empty($title)) $title .= '. ';
				$title .= $item->post_content;
			}

			$images[] = array(
				'src_miniature' => wp_get_attachment_image_url( $item->ID, $size),
				'src' => $item->guid,
				'alt' => get_post_meta($item->ID, '_wp_attachment_image_alt', true),
				'title' => $title
			);
		}

		//if ($attr['orderby'] == 'rand') shuffle($images);

		if (!empty($images)) {
			$output = $this->gallery_slider_template($images);
			return $output;
		}
	}

	function gallery_slider_template($images) {
		$this->counter++;

		// Подключаем стили
		// Слайдер Swiper
		wp_register_style(
			'swiper',
			plugin_dir_url(__FILE__).'/swiper_3_3_1/css/swiper.min.css',
			array(),
			'3.3.1');

		wp_register_script(
			'swiper',
			plugin_dir_url(__FILE__).'/swiper_3_3_1/js/swiper.min.js',
			array('jquery'),
			'3.3.1');

		wp_enqueue_style( 'swiper');
		wp_enqueue_script('swiper');

		// Magnific Popup
		wp_register_style(
			'magnific-popup',
			plugin_dir_url(__FILE__) . '/magnific_popup_1_1_0/magnific-popup.css',
			array(),
			'1.1.0');

		wp_register_script(
			'magnific-popup',
			plugin_dir_url(__FILE__) . '/magnific_popup_1_1_0/jquery.magnific-popup.min.js',
			array('jquery'),
			'1.1.0');

		wp_enqueue_style( 'magnific-popup');
		wp_enqueue_script('magnific-popup');

		wp_register_style('wt-gallery-swiper', plugin_dir_url(__FILE__).'/css/style.css', array('swiper'));
		wp_enqueue_style('wt-gallery-swiper');

		ob_start();
		include 'template.php';
		$output = ob_get_clean();
		return $output;
	}
}

$wt_gallery_swiper = new WtGallerySwiper();

?>