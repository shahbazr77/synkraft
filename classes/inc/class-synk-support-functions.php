<?php
if(!defined('ABSPATH')) {
    return;
}
class SYNK_Support_Function{
    protected static $instance = null;
    public static function get_instance(){
        if(self::$instance===null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        //add_action('admin_menu',array($this,'add_synkraft_menu'));
        function synk_verify_nonce($nonce, $key)
        {
            if (!wp_verify_nonce($nonce, $key)) {
                $return = array('message' => esc_html__('Direct access not allowed', 'synkraft'));
                wp_send_json_error($return);
            }
        }
        function active_deactive_plugin($plugin_status,$plugin_name,$plugin_version,$plugin_image,$plugin_type){
            global $wpdb;
            $table_name = $wpdb->prefix.'synkraft_plugin_status_table';
            $plugin_db_result = $wpdb->get_row( 'SELECT id FROM '.$table_name.'  where plugin_name="'.$plugin_name.'"');
            if($plugin_db_result){
                $plugin_id= $plugin_db_result->id;
                $data =  array(
                    'plugin_name' => $plugin_name,
                    'plugin_version' => $plugin_version,
                    'plugin_status' => $plugin_status,
                    'plugin_key' => '788jjsahfkhakhfdjksa',
                    'plugin_img_url' => $plugin_image,
                    'plugin_type' => $plugin_type,

                );
                $data_insert_status= $wpdb->update($table_name, $data, array('id' => $plugin_id));
            }else{
                $data_insert_status= $wpdb->insert(
                    $table_name,
                    array(
                        'plugin_name' => $plugin_name,
                        'plugin_version' => $plugin_version,
                        'plugin_status' => $plugin_status,
                        'plugin_key' => '788jjsahfkhakhfdjksa',
                        'plugin_img_url' => $plugin_image,
                        'plugin_type' => $plugin_type,

                    )
                );

            }
            return $data_insert_status;

        }
        function active_deactive_global_setting($setting_id,$setting_status_global,$setting_name,$setting_option){
            global $wpdb;
            $table_name = $wpdb->prefix.'synkraft_plugin_global_settings';
            $plugin_db_result = $wpdb->get_row( 'SELECT * FROM '.$table_name.'  where id="'.$setting_id.'"');
            if($plugin_db_result){
                $plugin_id= $plugin_db_result->id;
                $data =  array(
                    'settings_value' => $setting_status_global,
                );
                $data_insert_status= $wpdb->update($table_name, $data, array('id' => $plugin_id));
            }
            return $data_insert_status;

        }
        function update_pro_user_update($admin_id,$pro_user_login_id,$pro_user_token,$pro_user_login_eamil,$pro_user_login_active){
            $data_insert_status="";
            global $wpdb;
            $table_name = $wpdb->prefix .'synkraft_plugin_settings';
            $plugin_db_result = $wpdb->get_row( 'SELECT * FROM '.$table_name.'  where api_email="'.$pro_user_login_eamil.'"');
            if($plugin_db_result){
                $user_id= $plugin_db_result->id;
                $data=array(
                    'wp_user_id' => $admin_id,
                    'api_user_id' => $pro_user_login_id,
                    'api_secert_key' => $pro_user_token,
                    'api_email' => $pro_user_login_eamil,
                    'api_is_active' => $pro_user_login_active
                );
                $where = array('id' => $user_id);
                $data_insert_status=$wpdb->update($table_name,$data,$where);
            }else{
                $data_insert_status= $wpdb->insert(
                    $table_name,
                    array(
                        'wp_user_id' => $admin_id,
                        'api_user_id' => $pro_user_login_id,
                        'api_secert_key' => $pro_user_token,
                        'api_email' => $pro_user_login_eamil,
                        'api_is_active' => $pro_user_login_active
                    )
                );

            }

            return $data_insert_status;
        }
        function get_plugin_names_in_directory($plugin_directory) {
            $plugin_names = array();
            $php_files_paths = array();
            if (is_dir($plugin_directory)) {
                $plugins = scandir($plugin_directory);
                foreach ($plugins as $plugin) {
                    if ($plugin === '.' || $plugin === '..') {
                        continue;
                    }
                    $plugin_file = $plugin_directory .$plugin.'/'.$plugin.".php";
                    if (is_file($plugin_file) && strtolower(pathinfo($plugin_file, PATHINFO_EXTENSION)) === 'php') {
                        //$plugin_data = get_plugin_data($plugin_file);
                        //$plugin_names[] = $plugin_data['Name'];
                        //$plugin_names[] = $plugin_data['Version'];
                        $php_files_paths[]=$plugin_file;
                    }
                }
            }
            return $php_files_paths;
        }
        function get_plugins_logo_img(){
            $plugin_url = plugins_url();
             $plugin_logo =array();
            $relative_image_path = '/synkraft/addons/*/assets/images/screen.png';
            $image_files = glob(WP_PLUGIN_DIR . $relative_image_path);
            $valu_index=0;
            foreach ($image_files as $image_file) {
                $image_url = str_replace(WP_PLUGIN_DIR, $plugin_url, $image_file);
                $plugin_logo["plugin_png".$valu_index] = $image_url;
                $valu_index ++;
            }
            return $plugin_logo;
        }
        function sidebar_category(){
            $spam_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/spam.svg';
            $spam_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/spam_active.svg';
            $login_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/login.svg';
            $login_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/login_active.svg';
            $product_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/product.svg';
            $product_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/product_active.svg';
            $currencies_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/currencies.svg';
            $currencies_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/currencies_active.svg';
            $compliance_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/compliance.svg';
            $compliance_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/compliance_active.svg';
            $shipping_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/shipping.svg';
            $shipping_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/shipping_active.svg';
            $customize_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/customize.svg';
            $customize_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/customize_active.svg';
            $subscriptions_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/subscriptions.svg';
            $subscriptions_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/subscriptions_active.svg';
            $notification_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/notification.svg';
            $notification_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/notification_active.svg';
            $popup_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/popup.svg';
            $popup_active_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/active/popup_active.svg';
            $currentUrl = 'admin.php?page=synkcategory.php';
            $spam_active = $login_active = $product_active  = $currencies_active = $compliance_active = $shipping_active = $customize_active = $subscriptions_active = $notifications_active = $popups_active = $synksetting_active ="";
            global $pagenow;
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'spam') {
                $spam_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'login') {
                $login_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'product') {
                $product_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'currencies') {
                $currencies_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'compliance') {
                $compliance_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'shipping') {
                $shipping_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'customize') {
                $customize_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'subscriptions') {
                $subscriptions_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'notifications') {
                $notifications_active="active";
            }
            if ($pagenow === 'admin.php' && isset($_GET['tag']) && $_GET['tag'] === 'popups') {
                $popups_active="active";
            }
            $left_sidebar_feature_html = '
                <a href="' . esc_url(add_query_arg('tag', 'spam', $currentUrl)) . '" class="menu-item '.$spam_active.'">
                <img src="' . ($spam_active ? esc_url($spam_active_svg) : esc_url($spam_svg)). '" />
                <span>'. esc_html__('Spam','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'login', $currentUrl)) . '" class="menu-item ' . $login_active .'">
                    <img src="' .($login_active ? esc_url($login_active_svg) : esc_url($login_svg))  . '" />
                    <span>'. esc_html__('Login','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'product', $currentUrl)) . '" class="menu-item '.$product_active . '">
                    <img src="' .($product_active ? esc_url($product_active_svg) : esc_url($product_svg))  . '" />
                    <span>'. esc_html__('Product','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'currencies', $currentUrl)) . '" class="menu-item '.$currencies_active.'">
                    <img src="' . ($currencies_active ? esc_url($currencies_active_svg) : esc_url($currencies_svg)) . '" />
                    <span>'. esc_html__('Currencies','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'compliance', $currentUrl)) . '" class="menu-item '.$compliance_active.' ">
                    <img src="' . ($compliance_active ? esc_url($compliance_active_svg) : esc_url($compliance_svg))  . '" />
                    <span>'. esc_html__('Compliance','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'shipping', $currentUrl)) . '" class="menu-item '. $shipping_active .'">
                    <img src="' .($shipping_active ? esc_url($shipping_active_svg) : esc_url($shipping_svg)) . '" />
                    <span>'. esc_html__('Shipping','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'customize', $currentUrl)) . '" class="menu-item '.$customize_active.'">
                    <img src="' . ($customize_active ? esc_url($customize_active_svg) : esc_url($customize_svg)) . '" />
                    <span>'. esc_html__('Customize','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'subscriptions', $currentUrl)) . '" class="menu-item '.$subscriptions_active.'">
                    <img src="' . ($subscriptions_active ? esc_url($subscriptions_active_svg) : esc_url($subscriptions_svg)) . '" />
                    <span>'. esc_html__('Subscriptions','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'notifications', $currentUrl)) . '" class="menu-item '.$notifications_active.'">
                    <img src="' . ($notifications_active ? esc_url($notification_active_svg) : esc_url($notification_svg)) . '" />
                    <span>'. esc_html__('Notifications','synkraft').'</span>
                </a>
                <a href="' . esc_url(add_query_arg('tag', 'popups', $currentUrl)) . '" class="menu-item '.$popups_active.'">
                    <img src="' .($popups_active ? esc_url($popup_active_svg) : esc_url($popup_svg))  . ' " />
                    <span>'. esc_html__('Popups','synkraft').'</span>
                </a>
                ';
            return $left_sidebar_feature_html;
        }
        function class_sub_categories_free($plugin_directory, $selectedCategory){
            $all_plugins_names= array();
            $found_plugins = array();
            $tags = '';
            $name = '';
            foreach ($plugin_directory as $plugin_file) {
                $get_all_plugin_files = file($plugin_file, FILE_IGNORE_NEW_LINES);
                foreach ($get_all_plugin_files as $get_all_plugin_file) {
                    if (strpos($get_all_plugin_file, 'Author:') !== false) {
                        $tags = trim(substr($get_all_plugin_file, strpos($get_all_plugin_file, 'Author:')));
                        $tags = strtolower($tags);
                    }
                    if (strpos($get_all_plugin_file, 'Plugin Name:') !== false) {
                        $name = trim(substr($get_all_plugin_file, strpos($get_all_plugin_file, 'Plugin Name:')));
                    }
                }
                if (!empty($tags) && !empty($selectedCategory) && strpos($tags, $selectedCategory) !== false) {
                    $plugin_name =   basename($name);
                    $all_plugins_names[] = $plugin_name;
                }
            }
            // Function to clean plugin names
            function clean_plugin_name($name) {
                preg_match('/Plugin Name: (.+)/', $name, $matches);
                if (isset($matches[1])) {
                    return trim($matches[1]);
                }
                return $name;
            }
            $cleaned_target_plugin_names = array_map('clean_plugin_name', $all_plugins_names);
            foreach ($plugin_directory as $plugin_url) {
                $plugin_data = get_plugin_data($plugin_url);
                if (isset($plugin_data['Name'])) {
                    $plugin_name = clean_plugin_name($plugin_data['Name']);
                    if (in_array($plugin_name, $cleaned_target_plugin_names)) {
                        $found_plugins[] = $plugin_url;
                    }
                }
            }
            return $found_plugins;
        }
        function class_sub_categories_pro($plugin_directory_pro, $selectedCategory_pro){
            $all_plugins_names_pro= array();
            $tags = '';
            $name = '';
            $found_plugins_pro = array();
            foreach ($plugin_directory_pro as $plugin_file) {
                $get_all_plugin_files = file($plugin_file, FILE_IGNORE_NEW_LINES);
                foreach ($get_all_plugin_files as $get_all_plugin_file) {
                    if (strpos($get_all_plugin_file, 'Author:') !== false) {
                        $tags = trim(substr($get_all_plugin_file, strpos($get_all_plugin_file, 'Author:')));
                        $tags = strtolower($tags);
                    }
                    if (strpos($get_all_plugin_file, 'Plugin Name:') !== false) {
                        $name = trim(substr($get_all_plugin_file, strpos($get_all_plugin_file, 'Plugin Name:')));
                    }
                }
                if (!empty($tags) && !empty($selectedCategory_pro) && strpos($tags, $selectedCategory_pro) !== false) {
                    $plugin_name =   basename($name);
                    $all_plugins_names_pro[] = $plugin_name;
                }
            }
            // Function to clean plugin names
            function clean_plugin_name_pro($name) {
                preg_match('/Plugin Name: (.+)/', $name, $matches);
                if (isset($matches[1])) {
                    return trim($matches[1]);
                }
                return $name;
            }
            $cleaned_target_plugin_names_pro = array_map('clean_plugin_name_pro', $all_plugins_names_pro);
            foreach ($plugin_directory_pro  as $plugin_url) {
                $plugin_data_pro = get_plugin_data($plugin_url);
                if (isset($plugin_data_pro['Name'])) {
                    $plugin_name = clean_plugin_name_pro($plugin_data_pro['Name']);
                    if (in_array($plugin_name, $cleaned_target_plugin_names_pro)) {
                        $found_plugins_pro[] = $plugin_url;
                    }
                }
            }
            return $found_plugins_pro;
        }
        function synk_compare_expiry_secret_key(){
            $args = array('meta_query' => array(array('key' => 'secret_key',),),);
            $users = get_users($args);
            if (!empty($users)) {
                $user_id = $users[0]->ID;
                $user_secret_key = get_user_meta($user_id, 'secret_key', true);
                $user_secret_email = get_user_meta($user_id, 'secret_key_email', true);
                $user_secret_expiry = get_user_meta($user_id, 'secret_expire', true);
                $user_secret_all_about = get_user_meta($user_id, 'secret_key_all_json', true);
                $currentDate = date('d-m-Y');
                $time_pexpire = strtotime($user_secret_expiry);
                $time_current = strtotime($currentDate);
                if ($time_pexpire > $time_current and $user_secret_key != "") {
                    return true;
                } else {
                    return false;
                }
            }else{
                return false;
            }
        }
        function active_deactive_option_page_button($selected_plugin_name,$selected_class_name,$selected_class_function){
           if(!empty($selected_class_name) && !empty($selected_class_function)) {
                if (class_exists($selected_class_name)) {
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'synkraft_plugin_status_table';
                    $check_pro_name = $selected_plugin_name . " Pro";
                    $crown_imag=SYNKRAFT_Plugin_Url.'assets/css/icons/optionactive.svg';
                    $icon_png_pro='<img class="px-2" src="'.$crown_imag.'" />';
                    $query_pro = 'SELECT plugin_status FROM ' . $table_name . ' where plugin_name="' . $check_pro_name . '" and plugin_status=1 and plugin_type!="free" ';
                    $plugin_db_result_pro = $wpdb->get_results($query_pro);
                    $plugin_status_pro = isset($plugin_db_result_pro[0]->plugin_status) ? $plugin_db_result_pro[0]->plugin_status : "";
                    $pro_plugin_button = '<button type="button" class="child-deactive-button child-plugin-button  plugin-status-button synkpluginnotify-larggrid" data-feature="1"   data-name="' . $check_pro_name . '" data-ptype="pro"   data-status="'.(isset($plugin_status_pro) && $plugin_status_pro == '1' ? 'Deactivate' : 'Activate').'">'.(isset($plugin_status_pro) && $plugin_status_pro == '1' ? 'Deactivate Pro Features' : 'Activate Pro Features').'</button>';
                    return $pro_plugin_button;
                }
            }
        }
    }
}