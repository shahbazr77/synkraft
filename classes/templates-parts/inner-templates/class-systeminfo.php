<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_System_Info
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
        if (!function_exists('synkraft_sysinfo_content')) {
            function synkraft_sysinfo_content()
            {
                return '<div class="data">
          <main class="screen">
            <p class="screen-title">System Information</p>
            <hr>

            <div class="setting-details">
              <div class="row detailing">
                <div class="col-sm-3 align-self-center system_information"><p>'.esc_html__('Server Operating System:','synkraft').'</p></div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    <div class="custom-detail"><span>'.esc_html__('Your next billing date is 9 June, 2021','synkraft').'</span></div>
                  </div>
                </div>
              </div>
              <div class="row detailing">
                <div class="col-sm-3 align-self-center system_information"><p>'.esc_html__('Software:','synkraft').'</p></div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    <div class="custom-detail"><span>'.esc_html__('SysMonitor','synkraft').'</span></div>
                  </div>
                </div>
              </div>
              <div class="row detailing">
                <div class="col-sm-3 align-self-center system_information"><p>'.esc_html__('My SQL Version:','synkraft').'</p></div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    <div class="custom-detail"><span>'.esc_html__('Latest Stable Release','synkraft').'</span></div>
                  </div>
                </div>
              </div>
              <div class="row detailing">
                <div class="col-sm-3 align-self-center system_information"><p>'.esc_html__('PHP Version:','synkraft').'</p></div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    <div class="custom-detail"><span>'.esc_html__('Latest Stable Release','synkraft').'</span></div>
                  </div>
                </div>
              </div>
              <div class="row detailing">
                <div class="col-sm-3 align-self-center system_information"><p>'.esc_html__('Wordpress Memory Limit:','synkraft').'</p></div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    <div class="custom-detail"><span>'.esc_html__('512MB','synkraft').'</span></div>
                  </div>
                </div>
              </div>

              <div class="row detailing">
                <div class="col-sm-3 align-self-center system_information"><p>'.esc_html__('List of installed Plugins on Wordpress website:','synkraft').'</p></div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    <div class="custom-detail">
                      <span>
                        <ol class="d-flex flex-wrap">
                          <li>Yoast SEO</li>
                          <li>Contact Form</li>
                          <li>WooCommerce</li>
                          <li>Aksimat Anti-spam</li>
                        </ol>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row detailing">
                <div class="col-sm-3 align-self-center system_information"><p>'.esc_html__('Any errors that appear:','synkraft').'</p></div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    <div class="custom-detail"><span>'.esc_html__('Allowed memory size of 134217728 bytes exhausted (tried to allocate 4096 bytes) in /path/to/your/file.php on line 123"','synkraft').'</span></div>
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