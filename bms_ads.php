<?php
/**
 * @author Mike Lathrop
 * @version 0.0.1
 */
/*
Plugin Name: BMS Ads
Plugin URI: http://bigmikestudios.com
Depends: bms-smart-meta-box/bms_smart_meta_box.php, attachments/index.php
Description: Adds an Ad post type
Version: 0.0.1
Author URI: http://bigmikestudios.com
*/

$cr = "\r\n";

// =============================================================================

//////////////////////////
//
// CUSTOM POST TYPES
//
//////////////////////////

add_action( 'init', 'register_cpt_ad' );

function register_cpt_ad() {

    $labels = array( 
        'name' => _x( 'Ads', 'ad' ),
        'singular_name' => _x( 'Ad', 'ad' ),
        'add_new' => _x( 'Add New', 'ad' ),
        'add_new_item' => _x( 'Add New Ad', 'ad' ),
        'edit_item' => _x( 'Edit Ad', 'ad' ),
        'new_item' => _x( 'New Ad', 'ad' ),
        'view_item' => _x( 'View Ad', 'ad' ),
        'search_items' => _x( 'Search Ads', 'ad' ),
        'not_found' => _x( 'No ads found', 'ad' ),
        'not_found_in_trash' => _x( 'No ads found in Trash', 'ad' ),
        'parent_item_colon' => _x( 'Parent Ad:', 'ad' ),
        'menu_name' => _x( 'Ads', 'ad' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title' ),
        
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'ad', $args );
}

// =============================================================================

//////////////////////////
//
// ADD ATTACHMENTS PLUGIN STUFF
//
//////////////////////////

// Integrate with Attachments plugin

function ads( $attachments )
{
  
  $fields=array(
	array(
	  'name'      => 'url',                         // unique field name
	  'type'      => 'text',                          // registered field type
	  'label'     => __( 'URL', 'ads' ),    // label to display
	  // 'default'   => 'title',                         // default value upon selection
	),
  );

  $args = array(

	// title of the meta box (string)
	'label'         => 'Banner Ad Photos',

	// all post types to utilize (string|array)
	'post_type'     => array( 'ad' ),

	// meta box position (string) (normal, side or advanced)
	'position'      => 'normal',

	// meta box priority (string) (high, default, low, core)
	'priority'      => 'low',

	// allowed file type(s) (array) (image|video|text|audio|application)
	'filetype'      => null,  // no filetype limit

	// include a note within the meta box (string)
	'note'          => 'Attach images here!',

	// by default new Attachments will be appended to the list
	// but you can have then prepend if you set this to false
	'append'        => true,

	// text for 'Attach' button in meta box (string)
	'button_text'   => __( 'Attach Images', 'ads' ),

	// text for modal 'Attach' button (string)
	'modal_text'    => __( 'Images', 'ads' ),

	// which tab should be the default in the modal (string) (browse|upload)
	'router'        => 'browse',

	// fields array
	'fields'        => $fields,

  );

  $attachments->register( 'ads', $args ); // unique instance name
}

add_action( 'attachments_register', 'ads' );

// =============================================================================

//////////////////////////
//
// ADD META BOX
//
//////////////////////////

if (is_admin()) {
	if (!class_exists('SmartMetaBox')) {
		require_once(ABSPATH . "wp-content/plugins/bms-smart-meta-box/SmartMetaBox.php");
	}
			
	new SmartMetaBox('bms_ad', array(
		'title'     => 'Ad URL',
		'pages'     => array('ad'),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
				'name' => 'URL',
				'id' => 'bmsad_url',
				'type' => 'text',
				'desc' => 'Be sure to include http:// . This field will be overridden by the URL field on images below.',
			),
			array(
				'name' => 'Open in a new window',
				'id' => 'bmsad_window',
				'default' => 'false',
				'type' => 'checkbox',
			),
			array(
				'name' => 'Image Dimensions:',
				'id' => 'bmsad_image_dimensions',
				'content' => 'Images should be uploaded at 1170px x 165px',
				'type' => 'display',
			),
		)
	));
}

// =============================================================================

//////////////////////////
//
// ADD IMAGE SIZES
//
//////////////////////////

add_image_size( '780x110px', 780 , 110, true );
