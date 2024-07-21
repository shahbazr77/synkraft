<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Coupon{

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
        if (!function_exists('synkraft_coupon_content')) {
            function synkraft_coupon_content()
            {
                return '<div class="data">
    <main class="dashboard">
        <p class="title">'.esc_html__('Coupons Overview','synkraft').'</p>
        <hr />
        <div class="d-flex flex-wrap mt-5">
          <table class="table">
             <thead class="table-light">
                <tr>
                  <th scope="col">'.esc_html__('Coupon Id','synkraft').'</th>
                  <th scope="col">'.esc_html__('Expiry Date','synkraft').'</th>
                  <th scope="col">'.esc_html__('Uses','synkraft').'</th>
                </tr>
             </thead>
              <tbody>
             <tr>
              <td>'.esc_html__('@Pakistan&123','synkraft').' </td>
              <td>'.esc_html__('15-06-2023','synkraft').'</td>
              <td>'.esc_html__('1time','synkraft').'</td>
             </tr>
            <tr>
              <td>'.esc_html__('@Lahore&333','synkraft').'</td>
              <td>'.esc_html__('17-06-2023','synkraft').'</td>
              <td>'.esc_html__('2time','synkraft').'</td>
            </tr>
          </tbody>
          </table>
        </div>
    </main>
</div>';
            }
        }
    }
}