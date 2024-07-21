<?php
/*
* Class Category
*/
class SYNK_Category
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
        if (!function_exists('synkraft_category')) {
            function synkraft_category(){

                global $wpdb;
                $table_name = $wpdb->prefix . 'synkraft_plugin_status_table';
                $highlight_feature = isset($_GET['tag']) ? $_GET['tag'] : '';; 
                $custom_comment = isset($_GET['tag']) ? $_GET['tag'] : '';
                $custom_comment_pro = isset($_GET['tag']) ? $_GET['tag'] : '';
                $plugin_status_check = '';
                $configration_img = SYNKRAFT_Plugin_Url . 'assets/css/icons/setting.svg';
                $info_img = SYNKRAFT_Plugin_Url . 'assets/css/icons/info-circle.svg';
                $plugin_logo_images = get_plugins_logo_img();
                $plugins_view_data = "";
                $iteration_status = 0;
                $iteration_status_pro = 0; 
                $no_plugin_found = '';
                $common_plugins_found = '';
                $no_pro_plugin_found = '';
                $main_png = "";
                $all_plugin_html_updated_feature = "";
                $all_plugin_html_updated_feature_pro = '';
                $expiry_status=synk_compare_expiry_secret_key();
                $spam_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/spam-feature.svg';
                $login_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/login-feature.svg';
                $product_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/product-feature.svg';
                $currencies_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/currencies-feature.svg';
                $compliance_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/compliance-feature.svg';
                $shipping_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/shipping-feature.svg';
                $customize_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/customize-feature.svg';
                $subscriptions_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/customize-feature.svg';
                $notification_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/notifications-feature.svg';
                $popup_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/category/popup-feature.svg';
                $feature_logos = array(
                    'spam' => $spam_svg,
                    'login' => $login_svg,
                    'product' => $product_svg,
                    'currencies' => $currencies_svg,
                    'compliance' => $compliance_svg,
                    'shipping' => $shipping_svg,
                    'customize' => $customize_svg,
                    'subscriptions' => $subscriptions_svg,
                    'notifications' => $notification_svg,
                    'popups' => $popup_svg,
                );

            if (isset($feature_logos[$highlight_feature])) {
                $feature_logo_url = $feature_logos[$highlight_feature];
            } else {
                // If the feature name doesn't exist in the mapping array, set a default logo URL
                $feature_logo_url = ''; // Set the default logo URL here
            }
                $feature_page_url = admin_url('admin.php?page=synkexplore.php');
                $suggestion_pro = '';

                if(isset($custom_comment) && $custom_comment !== ''){
                    $plugin_directory = trailingslashit(ABSPATH) . 'wp-content/plugins/synkraft/addons/';
                    $plugin_names_data = get_plugin_names_in_directory($plugin_directory);
                    $target_plugin_names =  class_sub_categories_free($plugin_names_data, $custom_comment );

                    foreach($target_plugin_names as $plugin) {
                        $plugin_data = get_plugin_data($plugin);
                        
                        if(isset($plugin_data['Name']) && $plugin_data['Name'] !== '') {

                            $query = 'SELECT plugin_status FROM '.$table_name.' where plugin_name="'.$plugin_data['Name'].'" and plugin_status=1 and plugin_type!="pro" ';
                            $plugin_db_result = $wpdb->get_results($query);
                            $plugin_status = isset($plugin_db_result[0]->plugin_status) ? $plugin_db_result[0]->plugin_status : "" ;
                            if(!empty($plugin_logo_images['plugin_png'.$iteration_status])) {
                                $main_png = $plugin_logo_images['plugin_png'.$iteration_status];
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
                            $words = explode(" ", $description);
                            $total_words = count($words);
                            $index_to_remove_from = $total_words - 4;
                            if ($index_to_remove_from >= 0) {
                                array_splice($words, $index_to_remove_from);
                            }
                            $modified_plugin_desc = implode(" ", $words);
                            $description = $plugin_data['Description'];
                            $limited_description = strlen($description) > 50 ? substr($description, 0, 50) . '.....' : $description;

                            if (isset($plugin_status) && $plugin_status != '1') {
                                $plugin_name_link_with_query = ' <h6>' .esc_html($plugin_data['Name'], 'synkraft') . '<sup class="ps-2 text-primary">Free</sup></h6>';
                                $configure_button_html = '
                                    <button class="btn-custom-grey mb-2">
                                    <span class="text-hover"><img src="' . esc_url($configration_img) . '"> </span>
                                    <span class="detail">&nbsp;Configuration</span>
                                    </button>
                                    ';
                            } else {
                                $plugin_name_link_with_query = '<a href="' . esc_url($plugin_page_link_with_query) . '"><h6>'.esc_html($plugin_data['Name'], 'synkraft') .'<sup class="ps-2 text-primary">Free</sup></h6></a>';
                                $configure_button_html = '
                                    <a href="' . $plugin_page_link_with_query . '">
                                    <button class="btn-custom-grey mb-2">
                                    <span class="text-hover"><img src="' . esc_url($configration_img) . '"> </span>
                                    <span class="detail">&nbsp;Configuration</span>
                                        </button>
                                    </a>';
                            }

                            $all_plugin_html_updated_feature .= '<div class="accord-item " id="'.$plugin_data['Name'].'">
                                                                    <div class="accord-main">
                                                                        <div class="img-data">
                                                                            <div class="bg-color">
                                                                            <img class="main-img-accord" src="'.esc_url($main_png).'">
                                                                            </div>
                                                                            <div class="img-text">
                                                                            '.$plugin_name_link_with_query.'
                                                                            <div>
                                                                            
                                                                                <small class="img-text-clr">
                                                                                ' .$limited_description .'</small>
                                                                            
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="data-btn">
                                                                            <div class="d-flex">
                                                                            '.$configure_button_html .'
                                                                            <div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1">
                                                                                <img src="'.esc_url($info_img).'">
                                                                                <span class="tooltiptext-1 see_info">See Info</span>
                                                                            </div>
                                                                            </div>
                                                                            <input type="button" class="btn-custom plugin-status-button synkpluginnotify-larggrid"   data-name="'.$plugin_data['Name'].'" data-ptype="free" data-version="'.$plugin_data['Version'].'" data-png="'.$main_png .'" data-status="'. (isset($plugin_status) && $plugin_status == '1' ? 'Deactivate' : 'Activate').'"  value="'. (isset($plugin_status) && $plugin_status == '1' ? 'Deactivate' : 'Activate').'"  />
                                                                        </div>
                                                                    </div>
                                                                </div>';
                            $iteration_status++;
                        }
                    }
                        

                }
                    
    
                if (class_exists('Pro_Synkraft_Main') && $expiry_status==true) {
                    if(isset($custom_comment_pro) && $custom_comment_pro !== '') {
                        $plugin_directory_pro = trailingslashit(ABSPATH) . 'wp-content/plugins/synkraft-pro/addons-pro/';
                        $plugin_names_data_pro = get_plugin_names_in_directory($plugin_directory_pro);
                        $target_plugin_names_pro =  class_sub_categories_pro($plugin_names_data_pro, $custom_comment_pro );
                        $plugin_logo_images_pro = get_plugins_logo_img_pro();
                        foreach ($target_plugin_names_pro as $php_file_key_pro) {
                            $plugin_data_pro = get_plugin_data($php_file_key_pro);
                            if (isset($plugin_data_pro['Name']) && $plugin_data_pro['Name'] !== '') {
                                $query_pro = 'SELECT plugin_status FROM '.$table_name.' where plugin_name="'.$plugin_data_pro['Name'].'" and plugin_status=1 and plugin_type!="free" ';
                                $plugin_db_result_pro = $wpdb->get_results($query_pro);
                                $plugin_status_pro = isset($plugin_db_result_pro[0]->plugin_status) ? $plugin_db_result_pro[0]->plugin_status : "" ;
                                if(!empty($plugin_logo_images_pro['plugin_png'.$iteration_status_pro])) {
                                    $main_png_pro = $plugin_logo_images_pro['plugin_png'.$iteration_status_pro];
                                }
                                $plugin_page_slug_pro = isset($plugin_data_pro['PageSlug']) ? $plugin_data_pro['PageSlug'] : '';
                                $plugin_page_link_pro = 'admin.php?page=featuresetting.php';
                                $description_pro = $plugin_data_pro['Description'];
                                $words_pro = explode(" ", $description_pro);
                                $total_words_pro = count($words_pro);
                                $index_to_remove_from_pro = $total_words_pro - 4;
                                if ($index_to_remove_from_pro >= 0) {
                                    array_splice($words_pro, $index_to_remove_from_pro);
                                }
                                $modified_plugin_desc_pro = implode(" ", $words_pro);
                                $query_args_update_pro = array(
                                    'plugin_name' => $plugin_data_pro['Name'],
                                    'plugin_class_name' => $plugin_data_pro['RequiresWP'],
                                    'plugin_class_function' => $plugin_data_pro['RequiresPHP']
                                );
                                $plugin_page_link_with_query_pro = add_query_arg($query_args_update_pro, $plugin_page_link_pro);
                                $description_pro = $plugin_data_pro['Description'];
                                $limited_description = strlen($description_pro) > 50 ? substr($description_pro, 0, 50) . '.....' : $description_pro;

                                if (isset($plugin_status_pro) && $plugin_status_pro != '1') {
                                    $plugin_name_link_with_query_pro = ' <h6>' .esc_html($plugin_data_pro['Name'], 'synkraft') . '<sup class="ps-2 text-primary">Pro</sup></h6>';
                                    $configure_button_html_pro = '
                                                <button class="btn-custom-grey mb-2">
                                                    <span class="text-hover"><img src="' . esc_url($configration_img) . '"> </span>
                                                    <span class="detail">&nbsp;Configuration</span>
                                                </button>';
                                } else {
                                    $plugin_name_link_with_query_pro = '<a href="' . esc_url($plugin_page_link_with_query_pro) . '"><h6>'.esc_html($plugin_data_pro['Name'], 'synkraft') .'<sup class="ps-2 text-primary">Pro</sup></h6></a>';
                                    $configure_button_html_pro = '
                                            <a href="' . $plugin_page_link_with_query_pro . '" target="_blank">
                                                <button class="btn-custom-grey mb-2">
                                                    <span class="text-hover"><img src="' . esc_url($configration_img) . '"> </span>
                                                    <span class="detail">&nbsp;Configuration</span>
                                                </button>
                                            </a>';
                                }

                                $all_plugin_html_updated_feature_pro .= '<div class="accord-item " id="'.$plugin_data_pro['Name'].'">
                                                <div class="accord-main" >
                                                    <div class="img-data">
                                                        <div class="bg-color">
                                                        <img class="main-img-accord" src="'.esc_url($main_png_pro).'">
                                                        </div>
                                                        <div class="img-text">
                                                            '.$plugin_name_link_with_query_pro.'
                                                            <div>
                                                                                        
                                                                                            <small class="img-text-clr">
                                                                                            ' .$limited_description .'</small>
                                                                                        
                                                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="data-btn">
                                                        <div class="d-flex">
                                                            '.$configure_button_html_pro .'
                                                            <div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1">
                                                                <img src="'.esc_url($info_img).'">
                                                                <span class="tooltiptext-1 see_info">See Info</span>
                                                            </div>
                                                        </div>
                                                        <input type="button" class="btn-custom plugin-status-button synkpluginnotify-larggrid"   data-name="'.$plugin_data_pro['Name'].'" data-ptype="pro" data-version="'.$plugin_data_pro['Version'].'" data-png="'.$main_png_pro .'" data-status="'. (isset($plugin_status_pro) && $plugin_status_pro == '1' ? 'Deactivate' : 'Activate').'"  value="'. (isset($plugin_status_pro) && $plugin_status_pro == '1' ? 'Deactivate' : 'Activate').'"  />
                                                    </div>
                                                </div>
                                            </div>';
                                $iteration_status_pro++;
                            }
                        }
                    }
                }      
    
                $free_version_has_plugins = !empty($all_plugin_html_updated_feature);
                $pro_version_has_plugins = !empty($all_plugin_html_updated_feature_pro);
                if ($free_version_has_plugins || $pro_version_has_plugins) {
                
                } else {
                   
                    
                    $no_plugin_found = '
                    <main class="dashboard category-page">
                        <div>
                            <a href="'. $feature_page_url.'" class="back-btn"><i class="fa fa-chevron-left"></i>&nbsp; Back to Overview</a> 
                            <h3 class="sub_category_notifications"><img src="' . esc_url($feature_logo_url) . '" />
                            '.ucfirst($highlight_feature).' Features</h3>
                            <hr>
                            <p> No Plugins Found</p>
                        </div>
                    </main>
                ';
                    return $no_plugin_found;
                }
                return '
                <main class="dashboard category-page">
                    <div>
                        <a href="'. $feature_page_url.'" class="back-btn"><i class="fa fa-chevron-left"></i>&nbsp; Back to Overview</a> 
                        <h3 class="sub_category_notifications"><img src="' . esc_url($feature_logo_url) . '" />
                            '.ucfirst($highlight_feature).' Features</h3>
                        <hr>
                        <div class="data mt-5">        
                        '.$all_plugin_html_updated_feature.'
                        '.$all_plugin_html_updated_feature_pro.'
                        '.$no_plugin_found.'
                        </div>
                    </div>
                </main>';

            }
        }
    }
}