<?php
if(!defined('ABSPATH')) {
    return;
}
class SYNK_Register_Menu{
    protected static $instance = null;

    public static function get_instance(){
      if(self::$instance===null){
         self::$instance = new self();
      }
      return self::$instance;
    }

    public function __construct(){
        add_action('admin_menu',array($this,'add_synkraft_menu'));
        add_action('admin_head',array($this,'open_tab_synkraft'));
        require SYNKRAFT_Plugin_Path . 'classes/inc/class-synkraft-load-scripts.php';
        SYNK_Admin_Scripts::get_instance();
        require SYNKRAFT_Plugin_Path.'classes/templates-parts/class-leftsidebar.php';
        SYNK_Left_Sidebar::get_instance();
        include_once SYNKRAFT_Plugin_Path.'classes/templates-parts/class-content-body.php';
        SYNK_Content_Body::get_instance();
    }

    function add_synkraft_menu()
    {
        $page_title = "Synkraft";
        $menu_title = "Synkraft-Dashboard";
        $capability = "manage_options";
        $menu_slug = "synkraft.php";
        $icon_url = "dashicons-airplane";
        $position = "12";
        add_menu_page( $page_title, $menu_title, $capability, $menu_slug, 'synkraft_content_common_render', $icon_url, $position);
        add_submenu_page( $menu_slug, 'Synkupdate', 'Synkraft Update', 'manage_options', 'synkupdate.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkorder', 'Synkraft Orders', 'manage_options', 'synkorder.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkprefer', 'Synkraft Preference', 'manage_options', 'synkprefer.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synklicense', 'Synkraft License', 'manage_options', 'synklicense.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkcoupons', 'Synkraft Coupons', 'manage_options', 'synkcoupons.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkpayments', 'Synkraft Payments', 'manage_options', 'synkpayments.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synksettings', 'Synkraft Settings', 'manage_options', 'synksettings.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synksysinfo', 'Synkraft Systeminfo', 'manage_options', 'synksysteminfo.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkexplore', 'Synkraft Explore', 'manage_options', 'synkexplore.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkinstallplugin', 'Synkraft Install Plugin', 'manage_options', 'synkinsplugin.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkfeatures', 'Synkraft Features Settings', 'manage_options', 'featuresetting.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkwizard', 'Synkraft Wizard', 'manage_options', 'synkwizard.php', 'synkraft_content_common_render',$position = null );
        add_submenu_page( $menu_slug, 'Synkcategory', 'Synkraft Coupons', 'manage_options', 'synkcategory.php', 'synkraft_content_common_render',$position = null );
        function synkraft_content_common_render(){
             echo synkraft_sidebar_menu();
             echo synkraft_call_main_body();
        }

    }
    function open_tab_synkraft()
    {
        ?>
        <script type="text/javascript">
            jQuery(document).ready( function($) {
                $('.toplevel_page_synkraft').attr('target','_blank');
                $('.wp-first-item').attr('target','_blank');
            });
        </script>
        <style>
        #toplevel_page_synkwizard ul li:not(:first-child) {
        display: none !important;
        }
        #toplevel_page_synkraft .wp-submenu  {
        display: none !important;
        }
        </style>
        <?php
    }
}