<?php

/**
 * Plugin Name:       STC FORUM
 * Plugin URI:
 * Description:       Forum for Resource Hub (SaveTheChildren)
 * Version:           1.0
 * Requires PHP:      7.3.8
 * Author:            Save The Children
 * Author URI:        https://www.savethechildren.org.uk
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       stcForum
 * Domain Path:       /languages
 */


 if ( !defined( 'WPINC' ) ) {
   die;
 }


 // plugin cpt inizialization
function stcForum_register_cpt(){

    $labels = array (
        'name'                    => 'Resource Hub Forum',
        'singular_name'           => 'Topic',
        'add_new'                 => 'Add New Topic', // menu title
        'add_new_item'            => 'Add New Topic', // page title
        'new_item'                => 'New Topic',
        'view_item'               => 'View Topic',
        'view_items'              => 'View Topics',
        'search_items'            => 'Search Topics',
        'not_found'               => 'No Topic Found',
        'not_found_in_trash'      => 'No Topic Found in Trash',
        'all_items'               => 'All Topics',
        'attributes'              => 'Topics Attributes',
        'archive'                 =>  'pipo',
        'insert_into_item'        => 'Insert into Topic',
        'uploaded_to_this_item'   => 'Uploaded to this Topic'

    );

    $args = array (
        'labels'                => $labels,
        'description'           => 'Discussion Forum',
        'public'                => true ,
        'menu_position'         => 1,
        'menu_icon'             => 'dashicons-buddicons-forums',
        'has_archive'           => true,
        'capability_type'       => 'page',
        'rewrite'               => array( 'slug' => 'forum' ),
        'show_in_rest'          => true,
        'supports'              => array( 'title', 'editor', 'author', 'comments' ),
      );

    register_post_type( 'forum', $args );

}
add_action( 'init', 'stcForum_register_cpt');



// activate plugin
function stcForum_pluginActivation(){
    stcForum_register_cpt();
    flush_rewrite_rules();  // rewrite permalinks
}
register_activation_hook( __FILE__, 'stcForum_pluginActivation' );



// deactivate plugin
function stcForum_pluginDeactivation(){
    unregister_post_type( 'forum' );
    flush_rewrite_rules();  // rewrite permalinks
}
register_deactivation_hook( __FILE__, 'stcForum_pluginDeactivation' );




// delete plugin -- uninstall plugin
function stcForum_delete_plugin(){
    
    // get all post CPT = 'forum';
    $allPosts = get_posts( array(
          'post_type' => 'forum',
          'numberpost' => -1
    ));

    // delete all post CPT = forum from DB
    foreach($allPosts as $key => $values) {
        wp_delete_post($values->ID, true);
  }
}
register_uninstall_hook( __FILE__, 'stcForum_delete_plugin' );
