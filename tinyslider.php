<?php
/**
 * Plugin Name:       Tiny Slider
 * Plugin URI:        http://saberhr.com/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Saber Hossen Rabbani
 * Author URI:        http://saberhr.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tiny
 * Domain Path:       /languages
 */


function tiny_load_textdomain () {
    load_plugin_textdomain('tiny', false, dirname(__FILE__), '/languages');
}
add_action('plugins_loaded', 'tiny_load_textdomain');

function tiny_init () {
    add_image_size('tiny-slider', 800, 600, true);
}
add_action('init', 'tiny_init');

function tiny_assets () {
    wp_enqueue_style('tinly-slider', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/tiny-slider.css', null, '1.0');
    wp_enqueue_script('tiny-slider-js', '//cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js', false, '1.0', true);
    wp_enqueue_script('tiny-slider-main-js', plugin_dir_url(__FILE__) . '/assets/js/main.js', array('jquery'), '1.0', true);

}
add_action('wp_enqueue_scripts', 'tiny_assets');


function tiny_shortcode_tslider ($arguments, $content) {
    $defaults = array (
        'width' => 600,
        'height'    => 800,
        'id'    => ''
    );

    $attributes = shortcode_atts($defaults, $arguments);
    $content = do_shortcode($content);
    $shortcode_output = <<<EOD
<div id="{$attributes['id']}" style="height:{$attributes['height']}px;width:{$attributes['width']}px;">
    <div class="slider">
        {$content}
    </div>
</div>
EOD;

    return $shortcode_output;
}
add_shortcode('tslider', 'tiny_shortcode_tslider');



function tiny_shortcode_tslide ($arguments) {
    $defaults = array (
        'caption'   => '',
        'id'        => '',
        'size'      => 'large'
    );

    $attributes = shortcode_atts($defaults, $arguments);
    $image_src = wp_get_attachment_image_src($attributes['id'], $attributes['size']);
    $shortcode_output = <<<EOD
<div class="slide">
    <img src="{$image_src[0]}" alt="{$attributes['caption']}">
    <p>{$attributes['caption']}</p>
</div>
EOD;

    return $shortcode_output;

}
add_shortcode('tslide', 'tiny_shortcode_tslide');





