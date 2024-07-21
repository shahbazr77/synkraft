<?php
if(!defined('ABSPATH')) {
    return;
}
class SYNK_License
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
        if (!function_exists('synkraft_license_content')) {
            function synkraft_license_content()
            {
                $dashboard_logo = SYNKRAFT_Plugin_Url . 'assets/css/icons/logo.png';
                $subscriber_url = "https://synkraft.com/";
                $disable_input = "";
                $connect_button = "";
                $connect_form = "license-check";
                $style_status_pro="";
                $style_status_free="";
                $connected_email="";
                $register_email="";
                $register_expire='';
                $profile_url="https://phpstack-1021230-3737300.cloudwaysapps.com/login";
                $expiry_status=synk_compare_expiry_secret_key();

                if(class_exists('Pro_Synkraft_Main')) {
                    $user_data=wp_get_current_user();
                    $admin_id= $user_data->ID;
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'synkraft_plugin_settings';
                    $plugin_db_result = $wpdb->get_row('SELECT * FROM ' . $table_name . '  where wp_user_id="' . $admin_id . '" AND api_secert_key!=""');
                    if ($expiry_status==true) {
                        $register_email=get_user_meta($admin_id, 'secret_key_email',true);
                        $register_expire= get_user_meta($admin_id, 'secret_expire', true);
                        $style_status_pro="block";
                        $style_status_free="none";
                    }else{
                        $style_status_pro="none";
                        $style_status_free="block";
                    }
                }
                if (!class_exists('Pro_Synkraft_Main')) {
                    return '<div class="data" >
                                <main class="dashboard">
                                    <p class="title">' . esc_html__('License Overview', 'synkraft') . '</p>
                                    <hr/>
                                    <div class="d-flex flex-wrap mt-5">
                                        <div class="license-check col-sm-6">
                                            <div class="form-group col-sm-6">
                                                <label for="disabledTextInput">' . esc_html__("Please Purchase Our Pro Plugin", "synkraft") . '</label>
                                                <a href="' . esc_url($subscriber_url) . '" target="_blank" class="my-2 btn-custom pro-button">' . esc_html__("Register For Pro", "synkraft") . '</a>
                                            </div>  
                                        </div>
                                    </div>
                                </main>
                            </div>';
                } else {
                    $html = '';
                    $html .= '
                            <div class="data">
                                <main class="screen">
                                    <p class="screen-title">Account</p>
                                    <hr />
                                    <div class="d-flex flex-wrap mt-5">
<div class="modal fade" id="synklicensModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="synkformlogin" class="modal-body">
     <i class="bi bi-x-circle-fill float-end" style="font-size: 22px;color:red;margin-right: 3px;cursor: pointer"  data-bs-dismiss="modal" aria-label="Close"></i>
    <!-- Icon -->
      <div class="fadeIn first my-4">
      <img src="'.esc_url($dashboard_logo).'" id="icon" alt="SynkFiniti Logo" />
      <h4 class="pt-3 active">Connect Form</h4>
      </div>
    <!-- Login Form -->
    <form class="sk_connecting_license" novalidate>
      <input type="email" id="synkemail" value="mwaleedafzal@gmail.com" class="form-control fadeIn second" name="email" placeholder="email" required>
      <input type="password" id="synkpassword" class="form-control fadeIn third" name="login" placeholder="password" required>
      <input id="sk_license_btn_connect_api" type="submit" class="fadeIn fourth" value="Log In">
    </form>
      </div>
    </div>
  </div>
</div>                            

                                        <form class="sk_check_license_input col-sm-12" novalidate>
                                            <!-- Before license -->
                                            <div class="form-group col-sm-6" id="sk_before_license" style="display: '.$style_status_free.'">
                                                <label for="sk_license_email" id="sk_license_status"> Not connected </label>
                                                <input name="sk_license_email" id="sk_license_email" style="border:1px solid #0c0c0c !important;width:100%;" type="email" class="my-2 form-control" value="mwaleedafzal@gmail.com"  placeholder="Enter your email here" required />
                                                <!--<button id="sk_license_btn_connect" type="submit" class="my-2 btn btn-primary"> Connect </button>-->
                                              <!-- <button id="sk_license_btn_connect_api" type="button" class="my-2 btn btn-primary"> Connect </button>-->
                                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#synklicensModal">Connect</button>
                                          
                                         
                                            </div>
                                            <!-- After license -->
                                            <div class="account-detail disconnect_tab" id="sk_after_license" style="display: '.$style_status_pro.'">
                                                <div class="row detailing">
                                                    <div class="col-sm-3 align-self-center"><p>Email</p></div>
                                                    <div class="col-sm-9">
                                                    <div>
                                                        <input class="form-control w-auto" placeholder="hello@example.com" id="sk_license_btn_switch_account" value="'.$register_email.'" disabled />
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="row detailing">
                                                    <div class="col-sm-3 align-self-center"><p>License</p></div>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <button type="button" class="btn-custom-primary disabled">
                                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" fill="white" viewBox="0 0 512 512">
                                                                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                                <path
                                                                d="M357.4 473.6c7.7 7.2 19.2 8.5 28.3 3.2C461.4 433 512 349.3 512 256s-50.6-177-126.3-220.8c-11.5-6.6-26.2-2.7-32.8 8.8s-2.7 26.2 8.8 32.8C422.7 112.1 464 180.1 464 256c0 69.6-34.7 132.6-87.6 169.8L200.3 262.4c-9.7-9-24.9-8.4-33.9 1.3s-8.4 24.9 1.3 33.9l189.7 176zM154.6 38.4c-7.7-7.2-19.2-8.5-28.3-3.2C50.6 79 0 162.7 0 256s50.6 177 126.3 220.8c11.5 6.6 26.2 2.7 32.8-8.8s2.7-26.2-8.8-32.8C89.3 399.9 48 331.9 48 256c0-69.6 34.7-132.6 87.6-169.8L311.7 249.6c9.7 9 24.9 8.4 33.9-1.3s8.4-24.9-1.3-33.9L154.6 38.4z"
                                                                />
                                                            </svg>
                                                            Connected
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row detailing">
                                                    <div class="col-sm-3 align-self-center"><p>License Renewal</p></div>
                                                    <div class="col-sm-9">
                                                        <div class="d-flex flex-wrap">
                                                            <div class="disconnected_tab_deactivate">
                                                                <div class="bill"><span>Your next billing date is <span id="expire-date">'.$register_expire.'</span></span></div>
                                                                <input type="hidden" id="userid" name="userid" value="'.$admin_id.'">
                                                                <button class="btn-custom-primary red red-primary-btn" type="button" id="sk_license_btn_disconnect" data-email="'.$register_email.'">
                                                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" fill="white" viewBox="0 0 512 512">
                                                                    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                                                    <path
                                                                    d="M357.4 473.6c7.7 7.2 19.2 8.5 28.3 3.2C461.4 433 512 349.3 512 256s-50.6-177-126.3-220.8c-11.5-6.6-26.2-2.7-32.8 8.8s-2.7 26.2 8.8 32.8C422.7 112.1 464 180.1 464 256c0 69.6-34.7 132.6-87.6 169.8L200.3 262.4c-9.7-9-24.9-8.4-33.9 1.3s-8.4 24.9 1.3 33.9l189.7 176zM154.6 38.4c-7.7-7.2-19.2-8.5-28.3-3.2C50.6 79 0 162.7 0 256s50.6 177 126.3 220.8c11.5 6.6 26.2 2.7 32.8-8.8s2.7-26.2-8.8-32.8C89.3 399.9 48 331.9 48 256c0-69.6 34.7-132.6 87.6-169.8L311.7 249.6c9.7 9 24.9 8.4 33.9-1.3s8.4-24.9-1.3-33.9L154.6 38.4z"
                                                                    />
                                                                </svg>
                                                                Deactivate
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row detailing">
                                                    <div class="col-sm-3 align-self-center"><p>My Account</p></div>
                                                    <div class="col-sm-9">
                                                        <div class="d-flex">
                                                            <a class="btn-custom-primary transparent" href=" '.esc_url($profile_url).'" target="_blank">
                                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> &nbsp; Manage Your Account
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </main>
                            </div> ';
return $html;
                }
            }
        }

    }
}





