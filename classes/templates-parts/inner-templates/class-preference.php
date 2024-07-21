<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Preference
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
        if (!function_exists('synkraft_preference_content')) {
            function synkraft_preference_content()
            {
                return '<div class="data">
    <main class="dashboard">
        <p class="title">'.esc_html__('Update Preference','synkraft').'</p>
        <hr />
        <div class="d-flex flex-wrap mt-5">
          <p class="text-center">'.esc_html__('OOPs No Data Found......','synkraft').'</p>
        </div>
    </main>
</div>';
            }
        }
    }
}