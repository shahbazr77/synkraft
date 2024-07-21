<?php
if(!defined('ABSPATH')) {
    return;
}
class SYNK_Addon_Function{
    protected static $instance = null;

    public static function get_instance(){
        if(self::$instance===null){
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct(){
        add_action('admin_init', array($this,'synk_plugin_register_settings'));
        add_action('admin_init',array($this,'synk_plugin_handle_file_upload'));
        add_action('wp_ajax_nopriv_plugin_activat_status', array($this,'change_plugin_activate_status'));
        add_action('wp_ajax_plugin_activat_status', array($this,'change_plugin_activate_status'));
        add_action('wp_ajax_nopriv_plugin_check_pro_status', array($this,'check_pro_plugin_status'));
        add_action('wp_ajax_plugin_check_pro_status', array($this,'check_pro_plugin_status'));
        add_action('wp_ajax_nopriv_plugin_disconnect_check_pro', array($this,'check_pro_disconnect'));
        add_action('wp_ajax_plugin_disconnect_check_pro', array($this,'check_pro_disconnect'));
        add_action('wp_ajax_update_plugin_json_file', array($this,'update_json_file_data'));
        add_action('wp_ajax_nopriv_gloabal_setting_activat_status', array($this,'change_global_activate_status'));
        add_action('wp_ajax_gloabal_setting_activat_status', array($this,'change_global_activate_status'));
        add_action('wp_ajax_save_wizard_data', array($this,'save_wizard_data'));
        add_action('wp_ajax_nopriv_save_wizard_data', array($this,'save_wizard_data')); 
        add_action('wp_ajax_load_features_page_content', array($this,'load_features_page_content'));
        add_action('wp_ajax_nopriv_load_features_page_content', array($this, 'load_features_page_content'));
    }
    function synk_plugin_register_settings() {
        register_setting('synkinsplugin', 'zip_file');
    }
    function synk_plugin_handle_file_upload() {
        if (isset($_FILES['zip_file'])) {
            $file = $_FILES['zip_file'];
            $target_dir =SYNKRAFT_Plugin_Path."addons/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            $target_file = $target_dir . basename($file['name']);
            $upload_success = move_uploaded_file($file['tmp_name'], $target_file);

            if ($upload_success) {
                $zip = new ZipArchive;
                $extract_path = $target_dir . '/';
                if ($zip->open($target_file) === true) {
                    $zip->extractTo($extract_path);
                    $zip->close();

                } else {
                }
                wp_redirect(admin_url('admin.php?page=synksettings.php'));
                exit;
            } else {
            }
        }
    }
    function change_plugin_activate_status()
    {
        $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : "";
        synk_verify_nonce($nonce, 'ajax-nonce');
        $data_insert_status='';
        $plugin_status = (isset($_POST['checkval'])) ? $_POST['checkval'] : '';
        $plugin_name = (isset($_POST['pluginname'])) ? $_POST['pluginname'] : '';
        $plugin_version = (isset($_POST['pluginversion'])) ? $_POST['pluginversion'] : '';
        $plugin_image = (isset($_POST['pluginimg'])) ? $_POST['pluginimg'] : '';
        $plugin_type = (isset($_POST['plugin_type'])) ? $_POST['plugin_type'] : '';
        $data_insert_status=active_deactive_plugin(trim($plugin_status),trim($plugin_name),trim($plugin_version),trim($plugin_image),trim($plugin_type));
        if ($data_insert_status) {
            if($plugin_status==1){
                $return = array('message' => "Plugin Active Successfully");
            }else{
                $return = array('message' => "Plugin Deactivate Successfully");
            }
            wp_send_json_success($return);
            wp_reset_postmeta();
        } else {
            $return = array('message' => "Action Not Perfom");
            wp_send_json_error($return);
        }

    }
    function check_pro_plugin_status()
    {
        $pro_user_nonceemail = isset($_POST['nonce']) ? $_POST['nonce'] : "";
        synk_verify_nonce($pro_user_nonceemail, 'ajax-nonce');
        $data_insert_status='';
        $pro_user_id = (isset($_POST['checkwpid'])) ? $_POST['checkwpid'] : '';
        $pro_user_mail = (isset($_POST['checkmail'])) ? $_POST['checkmail'] : '';
        $pro_user_pwd = (isset($_POST['checkpwd'])) ? $_POST['checkpwd'] : '';
        $pro_user_site = (isset($_POST['checksite'])) ? $_POST['checksite'] : '';
        $pro_user_rute = (isset($_POST['checkrute'])) ? $_POST['checkrute'] : '';
        $pro_user_login_auth = pro_user_verification($pro_user_nonceemail,$pro_user_id,$pro_user_mail,$pro_user_pwd,$pro_user_site,$pro_user_rute);
        if($pro_user_login_auth['response_code']==200){
            $user_data=wp_get_current_user();
            $user_id= $user_data->ID;
            $user = get_user_by('ID', $user_id);
            if ($user) {
                $user_email=isset($pro_user_login_auth['response_body']['data']['user_info']['email']) ? sanitize_email($pro_user_login_auth['response_body']['data']['user_info']['email']) : 0;
                $secret_key=isset($pro_user_login_auth['response_body']['data']['user_info']['secret_key']) ? sanitize_text_field($pro_user_login_auth['response_body']['data']['user_info']['secret_key']) : '';
                $secret_key_expire=isset($pro_user_login_auth['response_body']['data']['license']['license_expiry_data']) ? sanitize_text_field($pro_user_login_auth['response_body']['data']['license']['license_expiry_data']) : '' ;
                update_user_meta($user_id, 'secret_key', $secret_key);
                update_user_meta($user_id, 'secret_key_email', $user_email);
                update_user_meta($user_id, 'secret_expire', $secret_key_expire);
                $resopnse = array(
                    'success' => true,
                    'email' => $user_email,
                    'message' => 'Successfully Pro Connected!',
                    'billdate' => $secret_key_expire
                );
                wp_send_json_success($resopnse);
                die();
            } else {
                $resopnse = array('message' => "Sorry! Wrong email/password.");
                wp_send_json_error($resopnse);
                die();
            }

        }
        else{
            $resopnse = array('message' => "Sorry! Wrong email/password.");
            wp_send_json_error($resopnse);
            die();
        }

    }
    function change_global_activate_status()
    {
        $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : "";
        synk_verify_nonce($nonce, 'ajax-nonce');
        $setting_status_global = (isset($_POST['settingcheckval'])) ? $_POST['settingcheckval'] : '';
        $setting_name = (isset($_POST['settingname'])) ? $_POST['settingname'] : '';
        $setting_option = (isset($_POST['settingoption'])) ? $_POST['settingoption'] : '';
        $setting_id = (isset($_POST['settingid'])) ? $_POST['settingid'] : '';
        $data_insert_status_global=active_deactive_global_setting(trim($setting_id),trim($setting_status_global),trim($setting_name),trim($setting_option));
        if ($data_insert_status_global) {
            if($setting_status_global==1){
                $return = array('message' => "Plugin Active Successfully");
            }else{
                $return = array('message' => "Plugin Deactivate Successfully");
            }
            wp_send_json_success($return);
            wp_reset_postmeta();
        } else {
            $return = array('message' => "Action Not Perfom");
            wp_send_json_error($return);
        }
    }
    function check_pro_disconnect()
    {
        $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : "";
        synk_verify_nonce($nonce, 'ajax-nonce');
        $data_insert_status='';
        $pro_user_mail = (isset($_POST['checkmail'])) ? $_POST['checkmail'] : '';
        $pro_user_id = (isset($_POST['checkid'])) ? $_POST['checkid'] : '';
        if($pro_user_id != ""){
            update_user_meta($pro_user_id, 'secret_key', "");
            update_user_meta($pro_user_id, 'secret_key_email', "");
            update_user_meta($pro_user_id, 'secret_expire', "");
            $resopnse = array(
                'success' => true,
                'email' => $pro_user_mail,
                'message' => 'Successfully Pro Disconnected!'
            );
            wp_send_json_success($resopnse);
            die();
        } else{
            $return = array('message' => "Sorry You are Not Pro User");
            wp_send_json_error($return);
            die();
        }

    }
    function save_wizard_data() {
        $selectedValues1 = isset($_POST['section_1_step_1']) ? $_POST['section_1_step_1'] : array();
        $section_1_step_1 = array_map('sanitize_text_field', $selectedValues1);
        $selectedValues2 = isset($_POST['section_2_step_2']) ? $_POST['section_2_step_2'] : array();
        $section_2_step_2 = array_map('sanitize_text_field', $selectedValues2);
        $selectedValues3 = isset($_POST['section_3_step_3']) ? $_POST['section_3_step_3'] : array();
        $section_3_step_3 = array_map('sanitize_text_field', $selectedValues3);
        $selectedValues4 = isset($_POST['section_4_step_4']) ? $_POST['section_4_step_4'] : array();
        $section_4_step_4 = array_map('sanitize_text_field', $selectedValues4);
        $selectedValues5 = isset($_POST['section_5_step_5']) ? $_POST['section_5_step_5'] : array();
        $section_5_step_5 = array_map('sanitize_text_field', $selectedValues5);
        $selectedValues6 = isset($_POST['section_6_step_6']) ? $_POST['section_6_step_6'] : array();
        $section_6_step_6 = array_map('sanitize_text_field', $selectedValues6);
        $selectedValues7 = isset($_POST['section_7_step_7']) ? $_POST['section_7_step_7'] : array();
        $section_7_step_7 = array_map('sanitize_text_field', $selectedValues7);
        $selectedValues8 = isset($_POST['section_8_step_8']) ? $_POST['section_8_step_8'] : array();
        $section_8_step_8 = array_map('sanitize_text_field', $selectedValues8);
        $selectedValues9 = isset($_POST['section_9_step_9']) ? $_POST['section_9_step_9'] : array();
        $section_9_step_9 = array_map('sanitize_text_field', $selectedValues9);
        $selectedValues10 = isset($_POST['section_10_step_10']) ? $_POST['section_10_step_10'] : array();
        $section_10_step_10 = array_map('sanitize_text_field', $selectedValues10);
        $dont_Show_wizard_again = 1;
        $current_user = get_current_user_id();
        update_user_meta($current_user, 'section_1_selected_multiple_plugins', $section_1_step_1);
        update_user_meta($current_user, 'section_2_selected_multiple_plugins', $section_2_step_2);
        update_user_meta($current_user, 'section_3_selected_multiple_plugins', $section_3_step_3);
        update_user_meta($current_user, 'section_4_selected_multiple_plugins', $section_4_step_4);
        update_user_meta($current_user, 'section_5_selected_multiple_plugins', $section_5_step_5);
        update_user_meta($current_user, 'section_6_selected_multiple_plugins', $section_6_step_6);
        update_user_meta($current_user, 'section_7_selected_multiple_plugins', $section_7_step_7);
        update_user_meta($current_user, 'section_8_selected_multiple_plugins', $section_8_step_8);
        update_user_meta($current_user, 'section_9_selected_multiple_plugins', $section_9_step_9);
        update_user_meta($current_user, 'section_10_selected_multiple_plugins', $section_10_step_10);
        if( isset($section_10_step_10) && $section_10_step_10 !=''){
            update_user_meta($current_user, 'already_gone_through_wizard', $dont_Show_wizard_again);
           }
        echo json_encode(array('status' => 'success'));
        wp_die();
    }
    function load_features_page_content() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'synkraft_plugin_status_table';
        $plugin_directory = trailingslashit(ABSPATH) . 'wp-content/plugins/synkraft/addons/';
        $plugin_names_data = get_plugin_names_in_directory($plugin_directory);
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
                $plugin_page_link_with_query = add_query_arg('plugin-name', $plugin_data['TextDomain'], $plugin_page_link);
                $description = $plugin_data['Description']; 
                echo " <b> Description: </b> " .$description;echo "</br>";
                $name = $plugin_data['Name'];
                echo "  <b> Plugin Name: </b>" .$name; echo "</br>";
                $text_domain = $plugin_data['TextDomain'];
                echo "<b> Text-Domain : </b>" .$text_domain ;
                    $plugin_name_link_with_query='<div class="card-title"><sup class="pe-2 text-primary">Free</sup>'.esc_html($plugin_data['Name'], 'synkraft').'</div>';
                if (isset($plugin_status) && $plugin_status != '1') {
                $plugin_name_link_with_query='<div class="card-title"><sup class="pe-2 text-primary">Free</sup>'.esc_html($plugin_data['Name'], 'synkraft').'</div>';
                }else{
                    $plugin_name_link_with_query='<div class="card-title"><sup class="pe-2 text-primary">Free</sup><a href="' . esc_url($plugin_page_link_with_query) . '" target="">'.esc_html($plugin_data['Name'], 'synkraft') .'</a></div>';
                }
                $plugins_html .= '
                <div class="ctm-col mb-4">
                <div class="feature-card">
                <div class="d-flex justify-content-center">
                    <img class="card-img" src="'.$main_png.'" />
                </div>
                '.$plugin_name_link_with_query.'
                <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                </div>
            </div>
            ';
                $iteration_status++;
            }

        }

    }
}