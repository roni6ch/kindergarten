<?php
/**
 * Plugin Name: Frontend Gallery Slider For Advanced Custom Field
 * Plugin URI: http://www.wponlinesupport.com/
 * Description: Display Advanced Custom Field Gallery on frontend of your website with shorcode.
 * Author: WP Online Support 
 * Text Domain: frontend-gallery-slider-for-advanced-custom-field
 * Domain Path: /languages/
 * Version: 1.1.1
 * Author URI: http://www.wponlinesupport.com/
 *
 * @package WordPress
 * @author SP Technolab
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !defined( 'FAGSFACF_VERSION' ) ) {
	define( 'FAGSFACF_VERSION', '1.1.1' ); // Version of plugin
}
if( !defined( 'FAGSFACF_VERSION_DIR' ) ) {
    define( 'FAGSFACF_VERSION_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if( !defined( 'FAGSFACF_VERSION_URL' ) ) {
    define( 'FAGSFACF_VERSION_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}
if( !defined( 'FAGSFACF_POST_TYPE' ) ) {
    define( 'FAGSFACF_POST_TYPE', 'acf' ); // plugin post type
}

add_action('plugins_loaded', 'fagsfacf_load_textdomain');
function fagsfacf_load_textdomain() {
	load_plugin_textdomain( 'frontend-gallery-slider-for-advanced-custom-field', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @package Frontend Gallery Slider For Advanced Custom Field
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'fagsfacf_install' );

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup,
 * set default values for the plugin options.
 * 
 * @package Frontend Gallery Slider For Advanced Custom Field
 * @since 1.0.0
 */
function fagsfacf_install() {

    if( is_plugin_active('frontend-gallery-slider-for-advanced-custom-field/frontend-gallery-slider.php') ) {
        add_action('update_option_active_plugins', 'fagsfacf_deactivate_pro_version');
    }
}

/**
 * Deactivate free plugin
 * 
 * @package Frontend Gallery Slider For Advanced Custom Field
 * @since 1.0.0
 */
function fagsfacf_deactivate_pro_version() {
    deactivate_plugins('frontend-gallery-slider-for-acf-pro/frontend-gallery-slider-for-acf-pro.php', true);
}

/**
 * Check ACF plugin is active
 *
 * @package Frontend Gallery Slider For Advanced Custom Field
 * @since 1.0.0
 */
function fagsfacf_check_activation() {

    if ( !class_exists('acf') ) {
        // is this plugin active?
        if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
            // deactivate the plugin
            deactivate_plugins( plugin_basename( __FILE__ ) );
            // unset activation notice
            unset( $_GET[ 'activate' ] );
            // display notice
            add_action( 'admin_notices', 'fagsfacf_admin_notices' );
        }
    }
}

// Check required plugin is activated or not
add_action( 'admin_init', 'fagsfacf_check_activation' );

/**
 * Admin notices
 * 
 * @package Frontend Gallery Slider For Advanced Custom Field Pro
 * @since 1.0.0
 */
function fagsfacf_admin_notices() {

    if ( !class_exists('acf') ) {
        echo '<div class="error notice is-dismissible">';
        echo sprintf( __('<p><strong>%s</strong> recommends the following plugin to use.</p>', 'frontend-gallery-slider-for-advanced-custom-field'), 'Frontend Gallery Slider For Advanced Custom Field' );
        echo sprintf( __('<p><strong><a href="%s" target="_blank">%s</a>, %s</strong></p>', 'frontend-gallery-slider-for-advanced-custom-field'), 'https://wordpress.org/plugins/advanced-custom-fields', 'Advanced Custom Fields', 'Advanced Custom Fields: Gallery Field' );
        echo '</div>';
    }
}

/**
 * Function to display admin notice of activated plugin.
 * 
 * @package Frontend Gallery Slider For Advanced Custom Field Pro
 * @since 1.0.0
 */
function fagsfacf_front_gallery_admin_notice() {

    $dir = WP_PLUGIN_DIR . '/frontend-gallery-slider-for-acf-pro/frontend-gallery-slider-for-acf-pro.php';
    
    // If free plugin exist
    if( file_exists($dir) ) {
        
        global $pagenow;
        
        if ( $pagenow == 'plugins.php' && current_user_can( 'install_plugins' ) ) {
            echo '<div id="message" class="updated notice is-dismissible"><p><strong>Thank you for activating Frontend Gallery Slider For Advanced Custom Field</strong>.<br /> It looks like you had PRO version <strong>(<em>Frontend Gallery Slider For Advanced Custom Field Pro</em>)</strong> of this plugin activated. To avoid conflicts the extra version has been deactivated and we recommend you delete it. </p></div>';
        }
    }
}

// Action to display notice
add_action( 'admin_notices', 'fagsfacf_front_gallery_admin_notice');

add_action( 'wp_enqueue_scripts','fagsfacf_style_css' );
function fagsfacf_style_css() {	
	wp_enqueue_style( 'fagsfacf_style',  plugin_dir_url( __FILE__ ) . 'assets/css/slick.css', array(), FAGSFACF_VERSION);
	
	// Registring slick slider script
	if( !wp_script_is( 'wpos-slick-jquery', 'registered' ) ) {
		wp_register_script( 'wpos-slick-jquery', FAGSFACF_VERSION_URL.'assets/js/slick.min.js', array('jquery'), FAGSFACF_VERSION, true );
		wp_enqueue_script( 'wpos-slick-jquery' );
	}	
	wp_register_script( 'fagsfacf-public-jquery', FAGSFACF_VERSION_URL.'assets/js/public.js', array('jquery'), FAGSFACF_VERSION, true );
	wp_enqueue_script( 'fagsfacf-public-jquery' );
}
/**
 * Function to unique number value
 * 
 */
function fagsfacf_get_unique() {
    static $unique = 0;
    $unique++;

    return $unique;
}

// How it work file, Load admin files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    require_once( FAGSFACF_VERSION_DIR . '/admin/fagsfacf-how-it-work.php' );
}

/**
 * shortcode [acf_gallery_slider]
 * 
 */

add_shortcode( 'acf_gallery_slider', 'fagsfacf_products_slider' );
function fagsfacf_products_slider($atts){	
 
	extract(shortcode_atts(array(
		'acf_field' => '',		
		'slide_to_show' => '1',
		'slide_to_scroll' => '1',
		'autoplay' => 'true',
		'autoplay_speed' => '3000',
		'speed' => '300',
		'arrows' => 'true',
		'dots' => 'true',
		'show_caption' => 'true',	
	), $atts));
	
		
	if( $show_caption ) { 
		$show_caption_value = $show_caption; 
	} else {
		$show_caption_value = 'false';
	}
	
	if( $acf_field ) { 
		$acf_field_value = $acf_field; 
	} else {
		$acf_field_value = '';
	}
	
	$unique = fagsfacf_get_unique();	
	
	// Slider configuration
	$slider_conf = compact('slide_to_show', 'slide_to_scroll', 'autoplay', 'autoplay_speed', 'speed', 'arrows','dots','rtl');	
		ob_start();	 
				$images = get_field($acf_field_value);

				if( $images ): ?>
				<div class="fagsfacf-slider-wrap">
					<div id="fagsfacf-slider-<?php echo $unique; ?>" class="fagsfacf-slider">
						<div class="fagsfacf-gallery-slider">
							<?php foreach( $images as $image ): ?>
								<div class="fagsfacf-gallery-slide">
									<div class="fagsfacf-gallery-slide-inner">
										<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
										<?php if($show_caption_value == 'true' ) { ?>
											<div class="fagsfacf-gallery-caption"><?php echo $image['caption']; ?></div>
										<?php } ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="fagsfacf-slider-conf"><?php echo json_encode( $slider_conf ); ?></div><!-- end of-slider-conf -->
					</div>	
				</div>		
				<?php endif;
				return ob_get_clean(); 
		}	
		
/**
 * shortcode [acf_gallery_carousel]
 * 
 */

add_shortcode( 'acf_gallery_carousel', 'fagsfacf_products_carousel' );
function fagsfacf_products_carousel($atts){	
 
	extract(shortcode_atts(array(
		'acf_field' => '',		
		'slide_to_show' => '2',
		'slide_to_scroll' => '1',
		'autoplay' => 'true',
		'autoplay_speed' => '3000',
		'speed' => '300',
		'arrows' => 'true',
		'dots' => 'true',
		'show_caption' => 'true',	
	), $atts));	
	
		
	if( $show_caption ) { 
		$show_caption_value = $show_caption; 
	} else {
		$show_caption_value = 'false';
	}
	
	if( $acf_field ) { 
		$acf_field_value = $acf_field; 
	} else {
		$acf_field_value = '';
	}
	
	$unique = fagsfacf_get_unique();	
	
	// carousel configuration
	$slider_conf = compact('slide_to_show', 'slide_to_scroll', 'autoplay', 'autoplay_speed', 'speed', 'arrows','dots','rtl');	
		ob_start();	 
				$images = get_field($acf_field_value);

				if( $images ): ?>
				<div class="fagsfacf-carousel-wrap">
					<div id="fagsfacf-carousel-<?php echo $unique; ?>" class="fagsfacf-carousel">
						<div class="fagsfacf-gallery-carousel">
							<?php foreach( $images as $image ): ?>
								<div class="fagsfacf-gallery-slide">
									<div class="fagsfacf-gallery-slide-inner">
										<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
										<?php if($show_caption_value == 'true' ) { ?>
											<div class="fagsfacf-gallery-caption"><?php echo $image['caption']; ?></div>
										<?php } ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="fagsfacf-carousel-conf"><?php echo json_encode( $slider_conf ); ?></div><!-- end of-slider-conf -->
					</div>	
				</div>		
				<?php endif;
				return ob_get_clean(); 
	}