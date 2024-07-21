<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Dashboard
{

    public static $instance = null;

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct()
    {
        if (!function_exists('synkraft_dashboard_content')) {
            function synkraft_dashboard_content()
            {
                $explore_page_url = menu_page_url('synkexplore.php', false);
                global $wpdb;
                $table_name = $wpdb->prefix . 'synkraft_plugin_status_table';
                $plugin_directory = trailingslashit(ABSPATH) . 'wp-content/plugins/synkraft/addons/';
                $plugin_names_data = get_plugin_names_in_directory($plugin_directory);
                $five_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/5.svg';
                $social_login_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/Social-login.svg';
                $social_login_svgs = SYNKRAFT_Plugin_Url . 'assets/images/screen.png';
                $eamil_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/email.svg';
                $cart_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/Cart.svg';
                $maximize_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/maximize-3.svg';
                $one_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/1.svg';
                $arrow_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/get-started-arrow.svg';
                $arrow_btn_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/arrow-btn.svg';
                $arrow_btn_one_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/arrow-btn-1.svg';
                $two_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/2.svg';
                $three_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/3.svg';
                $four_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/4.svg';
                $plugin_logo_images = get_plugins_logo_img();
                $iteration_status = 0;
                $plugins_html = '';
                $plugins_html_pro='';
                $expiry_status=synk_compare_expiry_secret_key();
                foreach ($plugin_names_data as $php_file_key) {
                    $plugin_data = get_plugin_data($php_file_key);
                    $query = 'SELECT plugin_status FROM '.$table_name.' where plugin_name="'.$plugin_data['Name'].'" and plugin_status=1 and plugin_type!="pro" ';
                    $plugin_db_result = $wpdb->get_results($query);
                    $plugin_status=isset($plugin_db_result[0]->plugin_status) ? $plugin_db_result[0]->plugin_status : "" ;
                    if (isset($plugin_data['Name']) && $plugin_data['Name'] !== '' && $plugin_status!='') {
                        if(!empty($plugin_logo_images['plugin_png'.$iteration_status])) {
                            $main_png=$plugin_logo_images['plugin_png'.$iteration_status];
                        }
                        $plugin_page_slug = isset($plugin_data['PageSlug']) ? $plugin_data['PageSlug'] : '';
                        $plugin_page_link = 'admin.php?page=featuresetting.php';
                        $query_args_update = array(
                            'plugin_name' => $plugin_data['Name'],
                            'plugin_class_name' => $plugin_data['RequiresWP'],
                            'plugin_class_function' => $plugin_data['RequiresPHP']
                        );
                        $plugin_page_link_with_query = add_query_arg($query_args_update, $plugin_page_link);
                        $description = $plugin_data['Description'];
                        if (isset($plugin_status) && $plugin_status != '1') {
                            $plugin_name_link_with_query='<div class="card-title"><sup class="pe-2 text-primary"></sup>'.esc_html($plugin_data['Name'], 'synkraft').'</div>';
                            $the_plugin_name_link_with_query ='
                            <div class="feature-card">
                              <div class="d-flex justify-content-center">
                                <img class="card-img" src="'.$main_png.'" />
                              </div>
                              '.$plugin_name_link_with_query.'
                              <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                            </div>';
                        }else{
                            $plugin_name_link_with_query='<div class="card-title"><sup class="pe-2 text-primary"></sup>'.esc_html($plugin_data['Name'], 'synkraft') .'</div>';
                            $the_plugin_name_link_with_query ='
                            <a href="' . esc_url($plugin_page_link_with_query) . '" target="">
                              <div class="feature-card">
                                    <div class="d-flex justify-content-center">
                                      <img class="card-img" src="'.$main_png.'" />
                                    </div>
                                    '.$plugin_name_link_with_query.'
                                    <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                              </div>
                            </a>';
                          }
                            $plugins_html .='<div class="ctm-col mb-4">
                            '.$the_plugin_name_link_with_query.'
                            </div>';
                        $iteration_status++;
                    }

                }
                if (class_exists('Pro_Synkraft_Main') and $expiry_status==true) {
                    $iteration_status_pro = 0;
                    $plugin_name_link_with_query_pro='';
                    $plugin_directory_pro = trailingslashit(ABSPATH) . 'wp-content/plugins/synkraft-pro/addons-pro/';
                    $plugin_names_data_pro = get_plugin_names_in_directory($plugin_directory_pro);
                    $plugin_logo_images_pro = get_plugins_logo_img_pro();
                    foreach ($plugin_names_data_pro as $php_file_key_pro) {
                        $plugin_data_pro = get_plugin_data($php_file_key_pro);
                        $query_pro = 'SELECT plugin_status FROM '.$table_name.' where plugin_name="'.$plugin_data_pro['Name'].'" and plugin_status=1 and plugin_type!="free" ';
                        $plugin_db_result_pro = $wpdb->get_results($query_pro);
                        $plugin_status_pro=isset($plugin_db_result_pro[0]->plugin_status) ? $plugin_db_result_pro[0]->plugin_status : "" ;
                        if (isset($plugin_data_pro['Name']) && $plugin_data_pro['Name'] !== '' && $plugin_status_pro!='') {
                            if(!empty($plugin_logo_images_pro['plugin_png'.$iteration_status_pro])) {
                                $main_png_pro=$plugin_logo_images_pro['plugin_png'.$iteration_status_pro];
                            }
                            $plugin_page_slug_pro = isset($plugin_data_pro['PageSlug']) ? $plugin_data_pro['PageSlug'] : '';
                            $plugin_page_link_pro = 'admin.php?page=featuresetting.php';
                            $query_args_update_pro = array(
                                'plugin_name' => $plugin_data_pro['Name'],
                                'plugin_class_name' => $plugin_data_pro['RequiresWP'],
                                'plugin_class_function' => $plugin_data_pro['RequiresPHP']
                            );
                            $plugin_page_link_with_query_pro = add_query_arg($query_args_update_pro, $plugin_page_link_pro);
                            $description = $plugin_data_pro['Description'];

                            if (isset($plugin_status_pro) && $plugin_status_pro != '1') {
                                $plugin_name_link_with_query_pro='<div class="card-title"><sup class="pe-2 text-primary">Pro</sup>'.esc_html($plugin_data_pro['Name'], 'synkraft').'</div>';
                                $pro_plugin_page_link ='
                                <a href="' . esc_url($plugin_page_link_with_query_pro) . '" target="">
                                  <div class="feature-card">
                                    <div class="d-flex justify-content-center">
                                      <img class="card-img" src="'.$main_png_pro.'" />
                                    </div>
                                    '.$plugin_name_link_with_query_pro.'
                                    <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                                  </div>
                                </a>';
                              }else{
                                $plugin_name_link_with_query_pro='<div class="card-title"><sup class="pe-2 text-primary">Pro</sup>'.esc_html($plugin_data_pro['Name'], 'synkraft') .'</div>';
                                $pro_plugin_page_link ='
                                <a href="' . esc_url($plugin_page_link_with_query_pro) . '" target="">
                                  <div class="feature-card">
                                    <div class="d-flex justify-content-center">
                                      <img class="card-img" src="'.$main_png_pro.'" />
                                    </div>
                                    '.$plugin_name_link_with_query_pro.'
                                    <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                                  </div>
                                </a>';
                              }
                            $plugins_html_pro .= '
                        <div class="ctm-col mb-4">
                        '.$pro_plugin_page_link.'
                      </div>
                      ';
                            $iteration_status_pro++;
                        }
                    }
                }
                if(!empty($plugin_db_result)){
                 foreach ($plugin_db_result as $data_key) {
                    if ( $data_key->plugin_status == 1) {
                        $synk_pop_checked = "Checked";
                    }
                    if ( $data_key->plugin_status == 1) {
                        $synk_stock_check = "Checked";
                    }
                     if ( $data_key->plugin_status == 1) {
                         $synk_recaptcha_check = "Checked";
                     }
                 }
                }
                return '<div class="data">
          <main class="dashboard">
          <div class="back_to_overview">
            <a href="#" class="back-btn back_to_overview_btn"><i class="fa fa-chevron-left"></i>&nbsp; Back to Overview</a> 
          </div>
          <p class="title">'.esc_html__( 'Features Overview', 'synkraft') .'</p>
          <hr />
          <div class="features_over_expand">
            <div class="row d-flex flex-wrap mt-5 features_over_expand_inner">
            '. $plugins_html . '
            </div>
          </div>
          

            <div class="d-flex flex-wrap mt-5 dashboard_view_all_plugins">
              '. $plugins_html . '
              <div class="ctm-col mb-4 text-center">
                <div class="view-all" id-="dashboard-view-all">
                 <a class="exp-view-all" id="exp-view-all" > <h4>'. esc_html__( 'Expand All Features', 'synkraft') .'</h4></a>
                  <img src="'.esc_url($maximize_svg).'" />
                </div>
              </div>
            </div>
            <!-- Modal -->
            <div id="configuration">
              <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightCon" aria-labelledby="offcanvasRightLabelCon">
                <div class="offcanvas-header border-bottom">
                  <h5 class="offcanvas-title" id="offcanvasRightLabel">'.esc_html__( 'reCAPATCHA Configuration', 'synkraft') .'</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="offcanvas-body">
                  <div class="my-2 mx-2">
                    <div class="mt-4">
                      <label class="ctm-label">'.esc_html__( 'Select Type:', 'synkraft') .'</label>
                      <div class="mt-2">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" />
                          <label class="form-check-label" for="inlineRadio1">'.esc_html__( 'reCAPATCHA v1', 'synkraft') .'</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2" />
                          <label class="form-check-label" for="inlineRadio2">'.esc_html__( 'reCAPATCHA v1', 'synkraft') .'</label>
                        </div>
                      </div>
                    </div>
                    <div class="mt-4">
                      <label class="ctm-label">'.esc_html__( 'Language:', 'synkraft') .'</label>
                      <div class="mt-2">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="language" id="1" value="1" />
                          <label class="form-check-label" for="1">'.esc_html__( 'English', 'synkraft') .'</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="language" id="2" value="2" checked />
                          <label class="form-check-label" for="2">'.esc_html__( 'French', 'synkraft') .'</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="language" id="3" value="3" checked />
                          <label class="form-check-label" for="3">'.esc_html__( 'Spanish', 'synkraft') .'</label>
                        </div>
                      </div>
                      <div class="mt-4">
                        <label class="ctm-label">'.esc_html__( 'Size:', 'synkraft') .'</label>
                        <div class="mt-2">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size" id="1" value="1" />
                            <label class="form-check-label" for="1">'.esc_html__( 'Normal', 'synkraft') .'</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size" id="2" value="2" checked />
                            <label class="form-check-label" for="2">'.esc_html__( 'Compact', 'synkraft') .'</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size" id="3" value="3" checked />
                            <label class="form-check-label" for="3">'.esc_html__( 'Invisible', 'synkraft') .'</label>
                          </div>
                        </div>
                      </div>
                      <div class="mt-4">
                        <label class="ctm-label"> '.esc_html__( 'Security Key:', 'synkraft') .'</label>
                        <input class="form-control border mt-2" placeholder="'.esc_attr( 'a1b2C3d4E5f6G7h8I9j0').'" />
                      </div>
                      <div class="mt-4">
                        <label class="ctm-label">'.esc_html__( 'Site Key:', 'synkraft') .'</label>
                        <input class="form-control border mt-2" placeholder="'.esc_attr( 'a1b2C3d4E5f6G7h8I9j0').'" />
                      </div>
                      <div class="mt-4">
                        <label class="ctm-label">'.esc_html__( 'URL:', 'synkraft') .'</label>
                        <input class="form-control border mt-2" placeholder="'.esc_attr( 'https://www.example.com/synkraft' ).'" />
                      </div>
                      <div class="my-4">
                        <button class="ctm-button">'. esc_html__( 'How reCAPATCHA Works?', 'synkraft') .'</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal -->
          </main>
          <main class="dashboard">
            <p class="title">'. esc_html__( 'How to get Started?', 'synkraft') .'</p>
            <hr />
            <div class="bg-arrow">
              <div class="row mt-5">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                  <div class="tutorial">
                    <div class="tut-menu">
                      <h2>01</h2>
                      <h5>'. esc_html__('How to Create an account?', 'synkraft') .'</h5>
                      <div class="d-flex justify-content-center">
                        <img class="img-tut" src="'.esc_url($arrow_svg).'" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                  <div class="tutorial">
                    <div class="tut-menu">
                      <h2>02</h2>
                      <h5>'. esc_html__('How to Activate the Plugins?', 'synkraft') .'</h5>
                      <div class="d-flex justify-content-center">
                        <img class="img-tut" src="'.esc_url($arrow_svg).'" />
                      </div> 
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                  <div class="tutorial">
                    <div class="tut-menu">
                    <h2>03</h2>
                    <h5 class="long-text">How to Deactivate the feature?</h5>
                      <div class="d-flex justify-content-center">
                        <img class="img-tut" src="'.esc_url($arrow_svg).'" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                  <div class="tutorial">
                    <div class="tut-menu">
                    <h2>04</h2>
                    <h5>How to Install SynkFiniti?</h5>
                      <div class="d-flex justify-content-center">
                        <img class="img-tut" src="'.esc_url($arrow_svg).'" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>';
            }
        }
    }
}