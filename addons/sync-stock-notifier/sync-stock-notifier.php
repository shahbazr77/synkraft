<?php
/*
Plugin Name: Synkraft Stock Notifications
Plugin URI: [Plugin URI]
Description: Sends notifications when product stock is low.
Version: 0.01
Author: Notifications, Stock Notifications, Woocommerce
Author URI: [Your Author URI]
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: woocommerce-stock-notifications
Domain Path:
Requires at least:Woo_stock_notifier
Requires PHP:stock_notifer_page_callback
*/

//Exit if accessed directly
if(!defined('ABSPATH')){
    return;
}
define('WC_SN_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WC_SN_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SN_THEMEURL_PLUGIN', get_template_directory_uri() . '/');

class Synkraft_Stock_Notify
{
    public static $instance=null;
    //Get instance
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        require WC_SN_PLUGIN_PATH . 'classes/inc/stock_notifier_option-page.php';
        Woo_stock_notifier::get_instance();
        
        if(!class_exists('Synkraft_Stock_Notify_Pro')){
    
            $this->synk_stock_notify_create_table();
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            require WC_SN_PLUGIN_PATH . 'classes/templates/single-product.php';
            Woo_stock_notifier_single_product::get_instance();
            add_action( 'after_setup_theme', array($this,'synk_stock_register_custom_image_sizes'));
            add_action('admin_enqueue_scripts',array($this, 'synk_stock_enqueue_scripts_admin'));
            add_action('wp_enqueue_scripts',array($this,'stock_notification_woocommerce_ajax_add_to_cart_js'));
            register_activation_hook( __FILE__, array($this,'synk_stock_create_custom_table_on_activation'));
        }
    }

    function synk_stock_notify_create_table(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_custom_table';
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            customer_name VARCHAR(255) NOT NULL,
            customer_email VARCHAR(255) NOT NULL,
            customer_phone_number VARCHAR(255) NOT NULL,
            customer_product_id INT(11) NOT NULL,
            customer_product_name VARCHAR(255) NOT NULL,
            mail_status VARCHAR(255) NOT NULL,
            PRIMARY KEY (id)
            )";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

    }

    function synk_stock_register_custom_image_sizes() {
        add_image_size( 'custom-thumbnail-size', 600, 1170, true );
    }
    function synk_stock_enqueue_scripts_admin() {

        $plugin_dir = plugin_dir_url(__FILE__);
        wp_enqueue_style( 'wc-stock-admin-style', $plugin_dir . 'assets/css/wc-stock-admin-style.css' );
        wp_enqueue_script('my-admin-script', $plugin_dir . 'assets/js/admin_scripts.js', array('jquery'), '1.0', true);
    }
    function stock_notification_woocommerce_ajax_add_to_cart_js() {
        if (function_exists('is_product') && is_product()) {
            wp_enqueue_style( 'wc-stock-style', plugin_dir_url( __FILE__ ) . 'assets/css/wc-stock-style.css' );
            wp_enqueue_script('jquery', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.js', array(), '3.6.0', true ); // Enqueue custom jQuery
            wp_enqueue_script('custom_stock_notifier_script', plugin_dir_url( __FILE__ ) . 'assets/js/custom_admin.js', array('jquery'), '1.0', true );
           
            wp_localize_script('custom_stock_notifier_script', 'ajax_object', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce( 'custom_stock_notifier_nonce' ),
            ));
        }
    }
    function synk_stock_create_custom_table_on_activation() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'stock_custom_table';

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            customer_name VARCHAR(255) NOT NULL,
            customer_email VARCHAR(255) NOT NULL,
            customer_phone_number VARCHAR(255) NOT NULL,
            customer_product_id INT(11) NOT NULL,
            customer_product_name VARCHAR(255) NOT NULL,
            mail_status VARCHAR(255) NOT NULL,
            PRIMARY KEY (id)
            )";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
    }
    function synk_stock_remove_custom_table_on_uninstall() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_custom_table';
        $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
    }

}

Synkraft_Stock_Notify::get_instance();