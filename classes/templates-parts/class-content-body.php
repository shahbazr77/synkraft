<?php
if(!defined('ABSPATH')){
    return;
}
class SYNK_Content_Body{

    public static $instance=null;

    public static function get_instance(){
        if(self::$instance===null){
            self::$instance=new self();
        }
        return self::$instance;
    }

    public function __construct(){
        add_action('admin_head',array($this,'hide_admin_sidebar'));
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/class-headerstrip.php';
        SYNK_Header_Strip::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-dashboard.php';
        SYNK_Dashboard::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-order.php';
        SYNK_Order::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-payments.php';
        SYNK_Payments::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-preference.php';
        SYNK_Preference::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-coupon.php';
        SYNK_Coupon::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-license.php';
        SYNK_License::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-update.php';
        SYNK_Update::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-setting.php';
        SYNK_Setting::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-feature-settings.php';
        Feature_Setting::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-systeminfo.php';
        SYNK_System_Info::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-explore.php';
        SYNK_Explore::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-insplugin.php';
        SYNK_Install_Plugin::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-wizard.php';
        SYNK_Wizard::get_instance();
        require SYNKRAFT_Plugin_Path . 'classes/templates-parts/inner-templates/class-category.php';
        SYNK_Category::get_instance();
        

        if (!function_exists('synkraft_call_main_body')) {
            function synkraft_call_main_body()
            {
                global $pagenow;
                $main_content_loader = "";
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkraft.php') {
                    $main_content_loader=synkraft_dashboard_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkorder.php') {
                    $main_content_loader=synkraft_order_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkprefer.php') {
                    $main_content_loader=synkraft_preference_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synklicense.php') {
                    $main_content_loader=synkraft_license_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkupdate.php') {
                    $main_content_loader=synkraft_update_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkcoupons.php') {
                    $main_content_loader=synkraft_coupon_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkpayments.php') {
                    $main_content_loader=synkraft_payment_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synksettings.php') {
                    $main_content_loader=synkraft_setting_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synksysteminfo.php') {
                    $main_content_loader=synkraft_sysinfo_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkexplore.php') {
                    $main_content_loader=synkraft_explore_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkinsplugin.php') {
                    $main_content_loader= synkraft_install_plugin_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'featuresetting.php') {
                    $main_content_loader= synkraft_feature_setting_content();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkcategory.php') {
                    $main_content_loader= synkraft_category();
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkwizard.php') {
                    $the_content_loader= synkraft_wizard_content();
                    echo $the_content_loader;
                }


                echo '  <main id="main">
                            <div class="main-container">
                            '.synkraft_header_strip().'
                            '.$main_content_loader.'
                            </div>
                        </main>';
            }
        }

    }

    function hide_admin_sidebar() {
        global $pagenow;
        // Check if we are on the admin option page.
        if(!empty($_GET['page'])) {
            if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkraft.php' || $_GET['page'] === 'synkupdate.php' || $_GET['page'] === 'synkorder.php' || $_GET['page'] === 'synkprefer.php' || $_GET['page'] === 'synklicense.php' || $_GET['page'] === 'synkcoupons.php' || $_GET['page'] === 'synkpayments.php' || $_GET['page'] === 'synksettings.php' || $_GET['page'] === 'synksysteminfo.php' || $_GET['page'] === 'synkexplore.php' || $_GET['page'] === 'featuresetting.php' || $_GET['page'] === 'synkwizard.php' || $_GET['page'] === 'synkcategory.php'  ) {
                echo '<style>#adminmenu,#adminmenuback { display: none;}#wpwrap #wpcontent{margin-left: 0px;padding:0px 15px; }#wpwrap #wpfooter{display: none;}#toplevel_page_synkraft ul li{display: none!important;}#wpadminbar{display: none}</style>';
            }
        }
        else {
            echo '<style>#toplevel_page_synkraft ul li{display: none}#toplevel_page_synkraft ul li.wp-first-item{display: block!important;}</style>';
        }

        if(!empty($_GET['page'])) {
            if ($pagenow === 'admin.php' && $_GET['page'] === 'synkwizard.php' ) {
                echo '<style>#adminmenu,#adminmenuback { display: none;}#wpwrap #wpcontent{margin-left: 0px;padding:0px 15px; }#wpwrap #wpfooter{display: none;}#toplevel_page_synkraft ul li{display: none!important;}#wpadminbar{display: none;} #menuSidebar{display: none;}  #toggleButton {display: none !important;} #main{display:none;}</style>';

            }
        }

    }
}