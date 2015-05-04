<?php
/*
  Plugin Name: WP Testimonials Slider
  Plugin URI: http://www.e2soft.com/blog/wp-testimonial-slider/
  Description: WP Testimonials Slider is a wordpress testimonial slider plugin for show client testimonial.
  Version: 1.0
  Author: S M Hasibul Islam
  Author URI: http://www.e2soft.com
  Copyright: 2015 S M Hasibul Islam http:/`/www.e2soft.com
  License URI: license.txt
 */


#######################	WP Testimonials Slider ###############################

if ( ! function_exists('testimonial_post_type') ) {
	// Register Custom Post Type
	function testimonial_post_type() {

	$labels = array(
		'name'                => _x( 'Testimonials', 'Post Type General Name', 'wp_testimonial_slider' ),
		'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'wp_testimonial_slider' ),
		'menu_name'           => __( 'Testimonial', 'wp_testimonial_slider' ),
		'name_admin_bar'      => __( 'Testimonial', 'wp_testimonial_slider' ),
		'parent_item_colon'   => __( 'Parent Testimonial:', 'wp_testimonial_slider' ),
		'all_items'           => __( 'All Testimonials', 'wp_testimonial_slider' ),
		'add_new_item'        => __( 'Add New Testimonial', 'wp_testimonial_slider' ),
		'add_new'             => __( 'Add New', 'wp_testimonial_slider' ),
		'new_item'            => __( 'New Testimonial', 'wp_testimonial_slider' ),
		'edit_item'           => __( 'Edit Testimonial', 'wp_testimonial_slider' ),
		'update_item'         => __( 'Update Testimonial', 'wp_testimonial_slider' ),
		'view_item'           => __( 'View Testimonial', 'wp_testimonial_slider' ),
		'search_items'        => __( 'Search Testimonial', 'wp_testimonial_slider' ),
		'not_found'           => __( 'Not found', 'wp_testimonial_slider' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'wp_testimonial_slider' ),
	);
	$args = array(
		'label'               => __( 'testimonial', 'wp_testimonial_slider' ),
		'description'         => __( 'Testimonial Description', 'wp_testimonial_slider' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'testimonial', $args );
}
// Hook into the 'init' action
add_action( 'init', 'testimonial_post_type', 0 );
}

// Register Script
function wp_testimonial_scripts() {
    wp_enqueue_script('modernizr', plugins_url('/js/modernizr.js', __FILE__), array('jquery'), true);
	wp_enqueue_script('masonry', plugins_url('/js/masonry.js', __FILE__), array('jquery'), true);
	wp_enqueue_script('flexslider', plugins_url('/js/flexslider.js', __FILE__), array('jquery'), true);
	wp_enqueue_script('main', plugins_url('/js/main.js', __FILE__), array('jquery'), true);
	
    wp_enqueue_style('wpts-style', plugins_url('/css/wpts-style.css', __FILE__));
	wp_enqueue_style('wpts-reset', plugins_url('/css/wpts-reset.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'wp_testimonial_scripts');

// Register Admin Script
function wp_testimonial_scripts_admin() {
    wp_enqueue_style('wpts-admin', plugins_url('/css/wpts-admin.css', __FILE__));
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
	wp_enqueue_script( 'cp-active', plugins_url('/js/cp-active.js', __FILE__), array('jquery'), '', true );
}
add_action('admin_enqueue_scripts', 'wp_testimonial_scripts_admin');

function wp_testimonial_content(){ ?>
	<div class="cd-testimonials-wrapper cd-container">
	<ul class="cd-testimonials">
    <?php
	// WP_Query arguments
	$args = array (
		'post_type'              => 'testimonial',
		'post_status'            => 'publish',
	);
	
	// The Query
	$wpts_query = new WP_Query( $args );
	
	// The Loop
	if ( $wpts_query->have_posts() ) {
		while ( $wpts_query->have_posts() ) {
			$wpts_query->the_post(); ?>
            <li>
			<?php the_excerpt(); ?>
			<div class="cd-author">
            <?php $client_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail', true); ?>
				<img src="<?php echo $client_img[0]; ?>" alt="<?php the_title(); ?>">
				<ul class="cd-author-info">
					<li><?php the_title(); ?></li>
					<li><?php echo get_post_meta( get_the_ID(), 'designation', true ); ?>, <a href="<?php echo get_post_meta( get_the_ID(), 'company_url', true ); ?>" target="_blank" rel="nofollow"><?php echo get_post_meta( get_the_ID(), 'company_name', true ); ?></a></li>
				</ul>
			</div>
		</li>
        <?php
		}
	} else {
		echo 'Testimonial Not Found';
	}
	
	// Restore original Post Data
	wp_reset_postdata();
	wp_reset_query();
	?>
		
        
	</ul> <!-- cd-testimonials -->
	<a href="#0" class="cd-see-all">See all</a>
</div> 
<!-- cd-testimonials-wrapper -->

<div class="cd-testimonials-all">
	<div class="cd-testimonials-all-wrapper">
		<ul>
        <?php
	// WP_Query arguments
	$args = array (
		'post_type'              => 'testimonial',
		'post_status'            => 'publish',
	);
	
	// The Query
	$wpts_query = new WP_Query( $args );
	
	// The Loop
	if ( $wpts_query->have_posts() ) {
		while ( $wpts_query->have_posts() ) {
			$wpts_query->the_post(); ?>
            <li class="cd-testimonials-item">
				<?php the_content(); ?>
				<div class="cd-author">
					<?php $client_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail', true); ?>
				<img src="<?php echo $client_img[0]; ?>" alt="Author image">
					<ul class="cd-author-info">
						<li><?php the_title(); ?></li>
						<li><?php echo get_post_meta( get_the_ID(), 'designation', true ); ?>,  <a href="<?php echo get_post_meta( get_the_ID(), 'company_url', true ); ?>" target="_blank" rel="nofollow"><?php echo get_post_meta( get_the_ID(), 'company_name', true ); ?></a></li>
					</ul>
				</div> <!-- cd-author -->
			</li>
        <?php
		}
	} else {
		echo 'Testimonial Not Found';
	}
	
	// Restore original Post Data
	wp_reset_postdata();
	wp_reset_query();
	?>
		</ul>
	</div>	<!-- cd-testimonials-all-wrapper -->

	<a href="#0" class="close-btn">Close</a>
</div> 
<!-- cd-testimonials-all -->

<?php }

//Add Shortcode
function wp_testimonial_content_exist() {
    return wp_testimonial_content();
}
add_shortcode('WPTS-TESTIMONIAL', 'wp_testimonial_content_exist');

//Include PHP files
foreach ( glob( plugin_dir_path( __FILE__ )."lib/*.php" ) as $e_file )
    include_once $e_file;
	
// Page Redirect
register_activation_hook(__FILE__, 'wpts_plugin_activate');
add_action('admin_init', 'wpts_plugin_redirect');

function wpts_plugin_activate() {
    add_option('wpts_plugin_do_activation_redirect', true);
}

function wpts_plugin_redirect() {
    if (get_option('wpts_plugin_do_activation_redirect', false)) {
        delete_option('wpts_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("edit.php?post_type=testimonial&page=testimonial");
        }
    }
}