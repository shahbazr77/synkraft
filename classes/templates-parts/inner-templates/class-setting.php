<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Setting
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
        if (!function_exists('synkraft_setting_content')) {
            function synkraft_setting_content()
            {
                global $wpdb;
                $table_name_global_html='';
                $table_name_global = $wpdb->prefix . 'synkraft_plugin_global_settings';
                $query_global = 'SELECT * FROM '.$table_name_global;
                $plugin_db_global = $wpdb->get_results($query_global);
                
                
                if(!empty($plugin_db_global)){
                    $fall_back_image_path = 'assets/css/icons/dashboard/get-started-arrow.svg';
                    foreach ($plugin_db_global as $plugin_db_key) {

                        $db_image_path = $plugin_db_key->settings_image;
                        $settings_image = (!empty($db_image_path)) ? SYNKRAFT_Plugin_Url . $db_image_path : SYNKRAFT_Plugin_Url . $fall_back_image_path;
                        
                        // print_r($plugin_db_key);
                        $plugin_status_global=isset($plugin_db_key->settings_value) ? $plugin_db_key->settings_value : "" ;
                        $table_name_global_html .= '<div class="col-sm-6">
                        <div class="accord-item">
                            <div class="accord-main">
                                <div class="img-data">
                                    <div class="bg-color setting">
                                       <img class="main-img-accord-setting" src="'.esc_url($settings_image).'" />
                                    </div>
                                    <div class="img-text pt-3 pe-3">
                                    <h6 class="text-capitalize">' . esc_html(str_replace('_', ' ', ucwords(strtolower($plugin_db_key->settings_name))), 'synkraft') . '</h6>
                                    <p class="mb-1">
                                            <small class="img-text-clr">' . esc_html(str_replace('_', ' ', ucwords(strtolower($plugin_db_key->settings_option))), 'synkraft') . '</small>
                                        </p>
                                    </div>
                                </div>
                                <div class="data-btn">
                                    <div class="d-flex">
                                        <label class="switch">
                                        <input type="checkbox" id="synkglobal" class="synkpluginglobal" data-settingid="'.$plugin_db_key->id.'"  data-settingname="'.$plugin_db_key->settings_name.'"  data-settingoption="'.$plugin_db_key->settings_option.'"   value="synkpopupglobal"  '. (isset($plugin_status_global) && $plugin_status_global == '1' ? 'Checked' : '').'  />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                    }
                }

                return '<div class="data">
          <main class="screen">
            <p class="screen-title">'.esc_html__('Plugins Settings','synkraft').'</p>
            <hr />
            <div class="setting-details">
              <div class="row">
              '.$table_name_global_html.'          
              </div>          
            </div>
          </main>
        </div>';
            }
        }

    }
}