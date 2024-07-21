<?php
if (!defined('ABSPATH')) {
    return;
}
class Feature_Setting{
    public static $instance = null;
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct(){
        if (!function_exists('synkraft_feature_setting_content')) {
            function synkraft_feature_setting_content(){
                $pro_plugin_button="";
                ob_start();
                ?>
                <div class="data position-relative">
                    <main class="dashboard option-page">
                        <div>
                            <?php
                                $feature_page_url = admin_url('admin.php?page=synkexplore.php');
                            ?>
                            <a href="<?php echo $feature_page_url;?>" class="back-btn"><i class="fa fa-chevron-left"></i>&nbsp; Back to Features</a> 
                            <?php
                                $selected_plugin_name = isset($_GET['plugin_name']) ? $_GET['plugin_name'] : '';
                                $selected_class_name = isset($_GET['plugin_class_name']) ? $_GET['plugin_class_name'] : '';
                                $selected_class_function = isset($_GET['plugin_class_function']) ? $_GET['plugin_class_function'] : '';
                                if(!empty($selected_class_name) && !empty($selected_class_function)){
                                    if (class_exists($selected_class_name)) {
                                        $custom_admin_page = new $selected_class_name();
                                        $custom_admin_page->$selected_class_function();
                                    }
                                }else{

                                    echo '<h5>'.$selected_plugin_name.'</h5>';
                                }
                            ?>
                        </div>
                    </main>
                </div>
                <?php
                $output = ob_get_clean();
                return $output;
            }
        }
    }
}
$feature_setting_instance = Feature_Setting::get_instance();