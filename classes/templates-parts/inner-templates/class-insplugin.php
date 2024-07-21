<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Install_Plugin{

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
        if (!function_exists('synkraft_install_plugin_content')) {
            function synkraft_install_plugin_content()
            {
                return '<div class="data">
                <main class="dashboard">
               <p class="title">'.esc_html__('Install Plugins','synkraft').'</p>
               <hr/>
                <div class="d-flex flex-wrap mt-5">
        <form method="post" enctype="multipart/form-data" action="options.php">
        '.settings_fields('synkinsplugin').do_settings_sections('synkinsplugin').' 
         <div class="form-group col-sm-6">
        <label for="formFileLg" class="form-label mb-0">'.esc_html__('Please Chose the Plugin File','synkraft').'</label>
         <input class="my-3" id="formFileLg" type="file" name="zip_file">
        </div>
       <input type="submit" name="submit" id="submit" class="btn btn-primary mb-3" value="Install Plugin">
         </form>
        <div id="emailHelp" class="d-block form-text text-muted">
        '.esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled','synkraft').'</div>
         </div>
                </main>
                </div>';



            }
        }
    }
}