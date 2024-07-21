<?php 
/**
 * Plugin Name: Synkraft
 * Plugin URI: https://synkraft/
 * Description: This plugin is essential for configure elementor.
 * Version: 0.01
 * Requires at least:  5.2
 * Requires PHP: 7.2
 * Author: Yodo Developers
 * Author URI: https://synkraft/
 * Text Domain: synkraft
 */
//Exit if accessed directly
if(!defined('ABSPATH')){
    return;
}
define('SYNKRAFT_Plugin_Path', plugin_dir_path(__FILE__));
define('SYNKRAFT_Plugin_Url', plugin_dir_url(__FILE__));
define("SYNKRAFT_Plugin_VERSION",0.01);
class Synkraft_Main
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
        // add_action('admin_init', array($this,'synk_hide_wp_notifications'));
        add_action('admin_init', array($this,'hide_menu_pages'));
        add_action('plugins_loaded', array($this,'synkraft_framework_load_plugin_textdomain'));
        register_activation_hook(__FILE__,array($this,'synkraft_plugin_create_table'));
        add_action('admin_init', array($this, 'synkraft_activation_redirect_conditionally'));
        //this is old hook
       // add_action('init',array($this,'get_my_data_type'),99);

        add_action('init',array($this,'get_my_data_type'),1);
        if (in_array('synkraft/synkraft.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            //admin Menu file and call class
            require_once SYNKRAFT_Plugin_Path . '/classes/inc/class-synk-admin-menu.php';
            SYNK_Register_Menu::get_instance();
            //Plugin Suportive functions and call class
            require_once SYNKRAFT_Plugin_Path . '/classes/inc/class-synk-support-functions.php';
            SYNK_Support_Function::get_instance();
            //Plugin Child function and call class
            require_once SYNKRAFT_Plugin_Path . '/classes/inc/class-addon-function.php';
            SYNK_Addon_Function::get_instance();
            // require SYNKRAFT_Plugin_Path .'addons/sync-stock-notifier/sync-stock-notifier.php';
        }
        register_uninstall_hook(__FILE__,'synkraft_plugin_drop_table');
        function synkraft_plugin_drop_table()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'synkraft_plugin_status_table';
            $table_name_global = $wpdb->prefix . 'synkraft_plugin_global_settings';
            $wpdb->query("DROP TABLE IF EXISTS $table_name");
            $wpdb->query("DROP TABLE IF EXISTS $table_name_global");
        }
    }
    function synk_hide_wp_notifications() {
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
//        add_action('admin_notices', function () {
//            echo 'My notice';
//        });
    }
    function hide_menu_pages() {
        remove_menu_page('stock-notifier');
    }
    function synkraft_framework_load_plugin_textdomain(){
        load_plugin_textdomain( 'synkraft', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }
    function synkraft_plugin_create_table() {
        global $wpdb;
        $table_name = $wpdb->prefix.'synkraft_plugin_status_table';
        // Create the table SQL statement
        $sql_plugin_status = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            plugin_name VARCHAR(255) NOT NULL,
            plugin_version VARCHAR(255) NOT NULL,
            plugin_status INT(11) NOT NULL,
            plugin_key TEXT(255) NOT NULL,
            plugin_type TEXT(255) NOT NULL,
            plugin_img_url VARCHAR(255) NOT NULL,
            PRIMARY KEY (id)
        )";


        $global_setting_table_name = $wpdb->prefix.'synkraft_plugin_global_settings';
        $sql_global_settings = "CREATE TABLE IF NOT EXISTS $global_setting_table_name (
            id INT(11) NOT NULL AUTO_INCREMENT,
            settings_name VARCHAR(255) NOT NULL,
            settings_option VARCHAR(255) NOT NULL,
            settings_value INT(11) NOT NULL,
            settings_image VARCHAR(255) NULL,
            PRIMARY KEY (id)
        )";


        // $global_plugin_Setting_query = "INSERT INTO `wp_synkraft_plugin_global_settings` (`id`, `settings_name`, `settings_option`, `settings_value`) VALUES
        // (1, 'plugin_updates', 'auto_updates', 0),
        // (2, 'plugin_data_policy', 'data_sharing_usage', 1);";

        $global_plugin_Setting_query = "INSERT INTO `wp_synkraft_plugin_global_settings` (`id`, `settings_name`, `settings_option`, `settings_value`, `settings_image`)
        VALUES
        (1, 'plugin_updates', 'auto_updates', 0, '/assets/css/icons/dashboard/auto-updates.svg'),
        (2, 'plugin_data_policy', 'data_sharing_usage', 1, '/assets/css/icons/dashboard/plugin-data-policy.svg');";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta( $sql_plugin_status );
        dbDelta( $sql_global_settings );
        dbDelta( $global_plugin_Setting_query );

        set_transient('synkraft_plugin_activation_redirect', true, 30);

    }    
    function synkraft_activation_redirect_conditionally() {
        $current_user = get_current_user_id();
        $already_gone_through_wizard = get_user_meta($current_user, 'already_gone_through_wizard', true);

        // Only run the redirection logic if 'already_gone_through_wizard' is not set or is empty
        if ($already_gone_through_wizard !== '1') {
            $this->synkraft_activation_redirect();
            add_action('admin_init', array($this,'synkraft_activation_redirect'));

        }
        
    }
    function synkraft_activation_redirect() {
        if (get_transient('synkraft_plugin_activation_redirect')) {
            delete_transient('synkraft_plugin_activation_redirect');
            $admin_page_url = admin_url('admin.php?page=synkwizard.php');
            wp_redirect($admin_page_url);
            exit; 
        }
    }
    function get_my_data_type(){
        $user_data=wp_get_current_user();
        $current_user_id= $user_data->ID;
        $expiry_status=synk_compare_expiry_secret_key();
        global $wpdb;
        $plugin_directory = trailingslashit(ABSPATH) . 'wp-content/plugins/synkraft/addons/';
        $plugin_names_data = get_plugin_names_in_directory($plugin_directory);
        $table_name = $wpdb->prefix . 'synkraft_plugin_status_table';
        if( !function_exists('get_plugin_data') ){
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        if (class_exists('Pro_Synkraft_Main') and $expiry_status==true) {
            $plugin_directory_pro = trailingslashit(ABSPATH) . 'wp-content/plugins/synkraft-pro/addons-pro/';
            $plugin_names_data_pro = get_plugin_names_in_directory($plugin_directory_pro);
            $table_name_pro = $wpdb->prefix . 'synkraft_plugin_status_table';
            foreach ($plugin_names_data_pro as $php_file_key_pro) {
                $plugin_data_pro = get_plugin_data($php_file_key_pro);
                if (isset($plugin_data_pro['Name']) && $plugin_data_pro['Name'] !== '') {
                    $query_pro = 'SELECT plugin_status FROM '.$table_name_pro.' where plugin_name="'.$plugin_data_pro['Name'].'" and plugin_status=1 and plugin_type!="free"';
                    $plugin_db_result_pro = $wpdb->get_results($query_pro);
                    $plugin_status_pro=isset($plugin_db_result_pro[0]->plugin_status) ? $plugin_db_result_pro[0]->plugin_status : "" ;
                    if($plugin_status_pro!="") {
                        $previousDirectory_pro = dirname($php_file_key_pro);
                        $filename_pro = basename($php_file_key_pro);
                        $main_url_require_pro = $previousDirectory_pro . "/" . $filename_pro;
                       // echo $main_url_require_pro;
                        //echo "<br>";
                        require $main_url_require_pro;
                    }
                }
            }
        }
        foreach ($plugin_names_data as $php_file_key) {
            $plugin_data = get_plugin_data($php_file_key);
            if (isset($plugin_data['Name']) && $plugin_data['Name'] !== '') {
                $query = 'SELECT plugin_status FROM '.$table_name.' where plugin_name="'.$plugin_data['Name'].'" and plugin_status=1 and plugin_type!="pro"';
                $plugin_db_result = $wpdb->get_results($query);
                $plugin_status=isset($plugin_db_result[0]->plugin_status) ? $plugin_db_result[0]->plugin_status : "" ;
                if($plugin_status!="") {
                    $previousDirectory = dirname($php_file_key);
                    $filename = basename($php_file_key);
                    $main_url_require = $previousDirectory . "/" . $filename;
                   // echo $main_url_require;
                    //echo "<br>";
                    require $main_url_require;
                }

            }

        }


    }
}
Synkraft_Main::get_instance();