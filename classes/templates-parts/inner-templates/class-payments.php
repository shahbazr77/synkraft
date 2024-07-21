<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Payments
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
        if (!function_exists('synkraft_payment_content')) {
            function synkraft_payment_content()
            {
                return '<div class="data">
    <main class="dashboard">
        <p class="title">'.esc_html__('Payments Overview','synkraft').'</p>
        <hr />
        <div class="d-flex flex-wrap mt-5">
          <table class="table">
             <thead class="table-light">
                <tr>
                  <th scope="col">'.esc_html__('Product Name','synkraft').'</th>
                  <th scope="col">'.esc_html__('Order Id','synkraft').'</th>
                  <th scope="col">'.esc_html__('Order Amount','synkraft').'</th>
                  <th scope="col">'.esc_html__('Status','synkraft').'</th>
                </tr>
             </thead>
              <tbody>
             <tr>
              <td>'.esc_html__('Yodo Product-1 ','synkraft').'</td>
              <td>'.esc_html__('2947392732','synkraft').'</td>
              <td>'.esc_html__('15$','synkraft').'</td>
              <td>'.esc_html__('Purchased','synkraft').'</td>
             </tr>
            <tr>
              <td>'.esc_html__('Yodo Product-2 ','synkraft').'</td>
              <td>'.esc_html__('294739242','synkraft').'</td>
              <td>'.esc_html__('20$','synkraft').'</td>
              <td>'.esc_html__('Pending','synkraft').'</td>
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