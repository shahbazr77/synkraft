<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Update
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
        if (!function_exists('synkraft_update_content')) {
            function synkraft_update_content()
            {
                return '<div class="data">
    <main class="dashboard">
        <p class="title">'.esc_html__('Features Updates','synkraft').'</p>
        <hr />
        <p>Sorry! No update Found.... </p>
    </main>
</div>';

            }
        }
    }

}