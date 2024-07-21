<?php
if(!defined('ABSPATH')) {
    return;
}

class SYNK_Admin_Scripts {

  protected static $instance = null;

  protected function __construct(){
      add_action('admin_enqueue_scripts', array($this,'synkraft_framework_scripts'));
      add_action('wp_enqueue_scripts', array($this,'synkraft_frontend_scripts'));
  }

  public static function get_instance(){
    if(self::$instance===null){
       self::$instance=new self();
    }
    return self::$instance;
  }

    function synkraft_framework_scripts()
    {
        global $pagenow;
        if(!empty($_GET['page'])) {
            if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkraft.php' || $_GET['page'] === 'synkupdate.php' || $_GET['page'] === 'synkorder.php' || $_GET['page'] === 'synkprefer.php' || $_GET['page'] === 'synklicense.php' || $_GET['page'] === 'synkcoupons.php' || $_GET['page'] === 'synkpayments.php' || $_GET['page'] === 'synksettings.php' || $_GET['page'] === 'synksysteminfo.php' || $_GET['page'] === 'synkexplore.php' || $_GET['page'] === 'featuresetting.php' || $_GET['page'] === 'synkwizard.php' || $_GET['page'] === 'synkcategory.php') {
                wp_enqueue_style('synkraft_google_fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Roboto+Mono:wght@100&display=swap');
                wp_enqueue_style('synkraft_bootstrap', SYNKRAFT_Plugin_Url . 'assets/css/bootstrap.min.css');
                wp_enqueue_style('bootstrap-icons', SYNKRAFT_Plugin_Url . 'assets/css/bootstrap-icons.css');
                wp_enqueue_style('synkraft_custom', SYNKRAFT_Plugin_Url . 'assets/css/main.css');
                wp_enqueue_script('jquery', SYNKRAFT_Plugin_Url . 'assets/js/jquery.min.js', false, false, true);
                wp_enqueue_script("notiflix", SYNKRAFT_Plugin_Url . "assets/js/notiflix.js", false, false, true);
                wp_enqueue_script('synkraft_bootstrap', SYNKRAFT_Plugin_Url . 'assets/js/bootstrap.bundle.min.js', false, false, true);
                wp_enqueue_script('fuse', SYNKRAFT_Plugin_Url . 'assets/js/fuse.js', false, false, true);
                // wp_enqueue_script('smooth-scrollbar', SYNKRAFT_Plugin_Url . 'assets/js/smooth-scrollbar.js', false, false, true);
                wp_enqueue_script('synkraft_custom', SYNKRAFT_Plugin_Url . 'assets/js/main.js', false, false, true);
                $info_img = SYNKRAFT_Plugin_Url . 'assets/css/icons/info-circle.svg';
                $explore_page_url = menu_page_url('synkexplore.php', false);
                $user_data = wp_get_current_user();
                $admin_id = $user_data->ID;
                wp_localize_script('synkraft_custom', 'synkraft_strings', array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('ajax-nonce'),
                    'site_url' => get_site_url(),
                    'site_parth_js' => SYNKRAFT_Plugin_Url . 'assets/js/',
                    'toestor_title_confirm' => __("Confirmation", 'synkraft'),
                    'pro_web' => 'https://synkraft.com/',
                    'info_img' => $info_img,
                    'feature_url' => $explore_page_url,
                    'admin_user_id' => $admin_id,
                    'api_check_pro' => '/wp-json/custom/v1/synkraf-check-secret',
                    'pro_check' => synk_compare_expiry_secret_key(),
                ));
            }
        }
    }


    function  synkraft_frontend_scripts(){
        wp_enqueue_style('synkraft_front_bootstrap', SYNKRAFT_Plugin_Url . 'assets/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap-front-icons', SYNKRAFT_Plugin_Url . 'assets/css/bootstrap-icons.css');
        wp_enqueue_script( 'synkraft_front_bootstrap',  SYNKRAFT_Plugin_Url . 'assets/js/bootstrap.bundle.min.js', false, false, true );
    }
}