<?php
if(!defined('ABSPATH')){
  return;
}
class SYNK_Left_Sidebar{

    public static $instance=null;

    public static function get_instance(){
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct(){

        if (!function_exists('synkraft_sidebar_menu')) {
            function synkraft_sidebar_menu(){
                $active_class="";
                $dashboard_logo = SYNKRAFT_Plugin_Url . 'assets/css/icons/logo.svg';
                $home_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/Home.svg';
                $order_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/order.svg';
                $preference_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/preference.svg';
                $cube_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/cube.svg';
                $coupons_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/coupons.svg';
                $cash_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/cash.svg';
                $license_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/license.svg';
                $setting_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/setting.svg';
                $bot_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/bot.svg';
                $help_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/help.svg';
                $dashboard_active_icon = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/help_svg_1.svg';
                $license_active = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/cube-active.svg';
                $svg_2 = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/help_svg_2.svg';
                $setting_active = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/help_svg_3.svg';
                $system_info_active = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/help_svg_4.svg';
                $Dashboard_idle_icon = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/dashboard.svg';
                $features_active = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/features_active.svg';
                $features_idle_icon = SYNKRAFT_Plugin_Url . 'assets/css/icons/features.svg';
                $explore_active = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/explore_active.svg';
                $explore_idle_icon = SYNKRAFT_Plugin_Url . 'assets/css/icons/explore.svg';
                $update_active_icon = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/update_active.svg';
                $update_idle_icon = SYNKRAFT_Plugin_Url . 'assets/css/icons/update.svg';
                $system_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/system-info.svg';
                $admin_url=get_admin_url();
                $dashbard_page_url = menu_page_url('synkraft.php', false);
                $update_page_url = menu_page_url('synkupdate.php', false);
                $order_page_url = menu_page_url('synkorder.php', false);
                $preference_page_url = menu_page_url('synkprefer.php', false);
                $license_page_url = menu_page_url('synklicense.php', false);
                $coupon_page_url = menu_page_url('synkcoupons.php', false);
                $payment_page_url = menu_page_url('synkpayments.php', false);
                $setting_page_url = menu_page_url('synksettings.php', false);
                $systeminfo_page_url = menu_page_url('synksysteminfo.php', false);
                $explore_page_url = menu_page_url('synkexplore.php', false);
                $pluginins_page_url = menu_page_url('synkinsplugin.php', false);
                $features_setting = menu_page_url('featuresetting.php', false);
                $category_setting = menu_page_url('synkcategory.php', false);
                $subscriber_url="https://synkraft.com/";
                $expiry_status=synk_compare_expiry_secret_key();
                $pro_buttton_status="";
                if( $expiry_status==true){
                    $pro_buttton_status= '';
                  $footer_style_class = "footer-bottom-fixed";
                }else{
                    $pro_buttton_status='<div class="upgrade-pro">
                    <div class="text-area">
                      <h2>Upgrade to Pro</h2>
                      <a href="'.esc_url($subscriber_url).'"><button class="price-btn">'.esc_html__('See Pricing','synkraft').'</button></a>
                    </div>
                    <img class="bot-img" src="'.esc_url($bot_svg).'" />
                  </div>';
                  $footer_style_class = "footer-bottom-menu";
                }

                $dashboard_active=$featureset_active=$synupdate_active=$synorder_active=$synkprefer_active=$synklicense_active=$update_active=$synkcoupons_active=$synkpayments_active=$synksetting_active=$synksetting_active=$synksysteminfo_active=$synkexplore_active=$synkinstall_active="";
                global $pagenow;
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkraft.php') {
                    $dashboard_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkupdate.php') {
                    $synupdate_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkorder.php') {
                    $synorder_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkprefer.php') {
                    $synkprefer_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synklicense.php') {
                    $synklicense_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkcoupons.php') {
                    $synkcoupons_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkpayments.php') {
                    $synkpayments_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synksettings.php') {
                    $synksetting_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synksysteminfo.php') {
                    $synksysteminfo_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkexplore.php') {
                    $synkexplore_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkinsplugin.php') {
                    $synkinstall_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'featuresetting.php') {
                    $featureset_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkcategory.php') {
                    $category_active="active";
                }





                return '<div class="position-relative sidebar-scroll">
                            <div id="menuSidebar" class="sidebar">
                                <a href="javascript:void(0)" class="closebtn close-sidebar" id="toggleButton1"> <i class="bi bi-arrow-left-circle-fill"></i></a>
                                <div class="menu-list">
                                    <a href="'.esc_url($dashbard_page_url).'" class="logo"><img src="'.esc_url($dashboard_logo).'" /></a>
                                    <div class="mt-5 mb-4">
                                        <a href="'.$admin_url.'" class="wordpress-btn"> 
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.0585 22.75H9.05853C3.62853 22.75 1.30853 20.43 1.30853 15V9C1.30853 3.57 3.62853 1.25 9.05853 1.25H15.0585C20.4885 1.25 22.8085 3.57 22.8085 9V15C22.8085 20.43 20.4885 22.75 15.0585 22.75ZM9.05853 2.75C4.44853 2.75 2.80853 4.39 2.80853 9V15C2.80853 19.61 4.44853 21.25 9.05853 21.25H15.0585C19.6685 21.25 21.3085 19.61 21.3085 15V9C21.3085 4.39 19.6685 2.75 15.0585 2.75H9.05853Z" fill="#832FEE"/>
                                        <path d="M13.9784 16.13H9.05843C8.64843 16.13 8.30843 15.79 8.30843 15.38C8.30843 14.97 8.64843 14.63 9.05843 14.63H13.9784C15.2584 14.63 16.3084 13.59 16.3084 12.3C16.3084 11.01 15.2684 9.96997 13.9784 9.96997H7.20844C6.79844 9.96997 6.45844 9.62997 6.45844 9.21997C6.45844 8.80997 6.79844 8.46997 7.20844 8.46997H13.9784C16.0884 8.46997 17.8084 10.19 17.8084 12.3C17.8084 14.41 16.0884 16.13 13.9784 16.13Z" fill="#832FEE"/>
                                        <path d="M8.62847 11.5201C8.43847 11.5201 8.24847 11.4501 8.09847 11.3001L6.52847 9.73007C6.23847 9.44007 6.23847 8.96007 6.52847 8.67007L8.09847 7.10007C8.38847 6.81007 8.86847 6.81007 9.15847 7.10007C9.44847 7.39007 9.44847 7.87007 9.15847 8.16007L8.11847 9.20007L9.15847 10.2401C9.44847 10.5301 9.44847 11.0101 9.15847 11.3001C9.01847 11.4401 8.82847 11.5201 8.62847 11.5201Z" fill="#832FEE"/>
                                        </svg>
                                        
                                            <i class="vs-icon vs-icon-home"></i>
                                            Back to the Wordpress
                                         </a>
                                    </div>
                                    <a href="' . esc_url($dashbard_page_url) . '" class="menu-item ' . $dashboard_active . '">
                                        <img src="' . ($dashboard_active ? esc_url($dashboard_active_icon) : esc_url($Dashboard_idle_icon)) . '" />
                                        <span>' . esc_html__('Dashboard', 'synkraft') . '</span>
                                    </a>
                                    <a href="'. esc_url( $explore_page_url) .'" class="menu-item '.$synkexplore_active.' ">
                                        <img src="' . ($synkexplore_active ? esc_url($explore_active) : esc_url($explore_idle_icon)) . '" />
                                        <span>'. esc_html__('Explore','synkraft').'</span>
                                    </a>
                                    <a href="'. esc_url( $license_page_url) .'" class="menu-item '.$synklicense_active.'">
                                        <img src="' . ($synklicense_active ? esc_url($license_active) : esc_url($cube_svg)) . '" />
                                        <span>'. esc_html__('License','synkraft').'</span>
                                    </a>
                                    <a href="'. esc_url( $update_page_url) .'" class="menu-item '.$synupdate_active.'">
                                        <img src="' . ($synupdate_active ? esc_url($update_active_icon) : esc_url($update_idle_icon)) . '" />
                                        <span>'. esc_html__('Updates','synkraft').'</span>
                                    </a>
                                    <a href="'. esc_url( $setting_page_url) .'" class="menu-item '.$synksetting_active.'">
                                        <img src="' . ($synksetting_active ? esc_url($setting_active) : esc_url($setting_svg)) . '" />
                                        <span>'. esc_html__('Settings','synkraft').'</span>
                                    </a>
                                                                       
                                    <hr />

                                    <h6>Our Features</h6>
                                   
                                        '.sidebar_category().'

                                    <hr/>
                                    
                                    <div class="menu-footer '.$footer_style_class.'"> 
                                        <a href="'.esc_url($systeminfo_page_url) .'" class="menu-item '. $synksysteminfo_active.'">
                                            <img src="'. esc_url($system_svg).'" />
                                            <span>'. esc_html__('System info', 'synkraft').'</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="openbtn d-none d-lg-block" id="toggleButton" onclick="openNav()"><i class="bi bi-view-list"></i></button>';
            }
        }
    }
}