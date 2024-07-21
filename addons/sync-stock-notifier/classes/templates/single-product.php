<?php
/**
 * Synkraft Single Product Template
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
class Woo_stock_notifier_single_product{
  protected static $instance = null;
  public $action = null;
  public static function get_instance(){
      if(self::$instance === null){
          self::$instance = new self();
      }
      return self::$instance;
  }
  public function __construct(){
      add_filter('woocommerce_get_stock_html', array($this, 'replace_out_of_stock_button'), 10, 2);
      add_action('woocommerce_single_product_summary', array($this, 'custom_get_product_data'), 30);
      add_action('wp_ajax_nopriv_stock_subscription_notification', array($this, 'woocom_stock_notifiers'));
      add_action('wp_ajax_stock_subscription_notification', array($this, 'woocom_stock_notifiers'));

  }
  /**Add to Watchlist button on shop page */
  function replace_out_of_stock_button($html, $product) {
    $the_id = $product->get_id();
    $my_stock_quantity = $product->get_stock_quantity();
    $radioValue_meta = get_option('show_button', '1');
  
      if($product->is_type('simple')){
        $the_id = $product->get_id();
        if(isset( $radioValue_meta) &&  $radioValue_meta == '1' ){
          if ($product->is_type('simple') || $product->is_type('variable')) {
            if (!$product->is_in_stock()) {
                $wishlist_buttons = '
                <div class="out_of_stock_notif_button">
                    <p class="out_of_stock_descrip">This product is currently out of stock. Please add it to your wishlist, and we will notify you by email when it is back in stock. Thank you!</p>
                    <p class="stock_back_notification">Thank you! You will be notified by email when this product is back in stock.</p>
                    <a  class="favorite-button button btn btn-primary add_to_watch_list">Add to Wishlist</a></div>';
                return $wishlist_buttons;
            }
          }
          if($my_stock_quantity === 0 || $my_stock_quantity === '' ){
            

            $wishlist_buttons = '
            <div class="out_of_stock_notif_button">
            <p class="out_of_stock_descrip">This Product is currently out of stock, please add it to whishslist. Once product is back we\'ll send you a reminder email. Thank You!</p>
              <p class="stock_back_notification">Thank You! You will be notified by email when this product will be back in stock </p>
              <a  class="favorite-button button btn btn-primary add_to_watch_list">Add to Wishlist</a></div>';
                return $wishlist_buttons;
          }
        }

      }elseif ($product->is_type('variable')) {
        
        if(isset( $radioValue_meta) &&  $radioValue_meta == '1' ){
            $variations = $product->get_available_variations();
              foreach ($variations as $variation) {
                if (!$variation['is_in_stock']) {
                    $wishlist_buttons = '
                    <div class="out_of_stock_notif_button">
                    <p class="out_of_stock_descrip">This Product is currently out of stock, please add it to whishslist. Once product is back we\'ll send you a reminder email. Thank You!</p>
                    <p class="stock_back_notification">Thank You! You will be notified by email when this product will be back in stock </p>
                    <a  class="favorite-button button btn btn-primary add_to_watch_list">Add to Wishlist</a></div>';
                        return $wishlist_buttons;
                }
              }
            }
          
        }elseif ($product->is_type('subscription')) {
          if (isset($radioValue_meta) && $radioValue_meta == '1') {
              // Handle subscription products
              if (!$product->is_in_stock()) {
                  // Handle out of stock subscription product
                  $wishlist_buttons = '<div class="out_of_stock_notif_button">
                      <p class="out_of_stock_descrip">This subscription product is currently out of stock, please add it to your wishlist. Once it\'s available, we\'ll send you a reminder email. Thank you!</p>
                      <p class="stock_back_notification">Thank you! You will be notified by email when this subscription product is back in stock.</p>
                      <a class="favorite-button button btn btn-primary add_to_watch_list">Add to Wishlist</a>
                  </div>';
                  return $wishlist_buttons;
              }
          }
      }elseif ($product->is_type('variable-subscription')) {
        if (isset($radioValue_meta) && $radioValue_meta == '1') {
            $variations = $product->get_children();
            $out_of_stock_variations = array();

            foreach ($variations as $variation_id) {
                $variation = wc_get_product($variation_id);

                if (!$variation->is_in_stock()) {
                    // If a variation is out of stock, add it to the list of out of stock variations
                    $out_of_stock_variations[] = $variation;
                }
            }
        }
      }
            
        elseif (!$product->is_in_stock()) {
          if(isset( $radioValue_meta) &&  $radioValue_meta == '1' ){
          $wishlist_buttons = '
          <div class="out_of_stock_notif_button">
          <p class="out_of_stock_descrip">This Product is currently out of stock, please add it to whishslist. Once product is back we\'ll send you a reminder email. Thank You!</p>
                      <p class="stock_back_notification">Thank You! You will be notified by email when this product will be back in stock </p>
          <a  class="favorite-button button btn btn-primary add_to_watch_list">Add to Wishlist</a></div>';
              return $wishlist_buttons;
      }
    }
        return $html;
  }

  

  function custom_get_product_data() {
    global $product;  
    $product_name = $product->get_name();
    $product_price = $product->get_price();
    $product_id = get_the_ID($product);
    $stock_quantity = $product->get_stock_quantity();
    $thumbnail_id = get_post_thumbnail_id($product->get_id());
    $thumbnail = wp_get_attachment_image($thumbnail_id, 'custom-thumbnail-size img-thumbnail' );
    $product_link = get_the_permalink( $product_id);
    $site_title = get_bloginfo('name');
    $permalink = home_url($site_title);
    $product_link = $product->get_permalink();
    ?>
    <input type="hidden" id="product_id" value="<?php echo $product_id;?>"/>
    <input type="hidden" id="product_name" value="<?php echo $product_name;?>"/>
    <input type="hidden" id="product_link" value="<?php echo $product_link;?>"/>
                
    <?php
    echo '
      <div id="popup-modal" class="modal popup_modale" style="display:none;">
        <div class="modal-content">
          <div class="modale_head">
            <div class="logo_title">
              <h4><a href='.home_url().'>'.$site_title.'</a></h4>
              <span class="close">&times;</span>
            </div>
            <p>'. esc_html__( 'Complete below information to get email when product is back in stock.', 'woocommerce-stock-notifications' ).'</p>
          </div>
          <div class="row">
            <div class="col-6 col-lg-6 col-md-6 col-sm-6">
              <div class="product_image_container">
              '.$thumbnail.'
              </div>
            </div>
            <div class="col-6 col-lg-6 col-md-6 col-sm-6">
              <div class="wc_sn_product_summary">
                <div class="product_name_price">
                  <p id="the_product_name">
                  <b>'. esc_html__( 'Name:', 'woocommerce-stock-notifications' ) .' </b>'  .$product_name .'</p>
                  <p><b>'. esc_html__( 'Price:', 'woocommerce-stock-notifications' ) .' </b>'  .  wc_price($product_price).' </p>
                </div>
                <form id="wc_sn_send_email_form"  class="needs-validation" novalidate>
                  <div class="popup_name">
                    <input type="text" class="form-control" id="wc_sn_name" name="first_name" placeholder="Name*" required>
                  </div>
                  <div class="popup_phone">
                    <input type="tel" class="form-control" id="wc_sn_phone_number" minlength="9" maxlength="14" placeholder="Number" name="phone">
                  </div>
                  <div class="popup_mail">
                    <input type="email" class="form-control" id="wc_sn_email" name="email" placeholder="Email(required)" required>
                  </div>
                  <button type="submit" id="submit_stock_notoificationkkk">'. esc_html__( 'Submit', 'woocommerce-stock-notifications' ).'</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
     ';
  }

  function woocom_stock_notifiers()
  {
      check_ajax_referer('custom_stock_notifier_nonce', 'nonce'); // Verify the nonce

      global $wpdb;
      $table_name = $wpdb->prefix . 'stock_custom_table';
      $customer_name = sanitize_text_field($_POST['wc_sn_user_name']);
      $customer_email = sanitize_text_field($_POST['wc_sn_user_email']);
      $customer_phone_number = sanitize_text_field($_POST['wc_sn_user_number']);
      $customer_product_id = sanitize_text_field($_POST['wc_sn_user_poduct_id']);
      $customer_product_name = sanitize_text_field($_POST['wc_sn_user_product_name']);
      $customer_product_link = sanitize_text_field($_POST['wc_sn_product_ref']);
      $linked_product = '<a href="' . esc_url($customer_product_link) . '">' . esc_html($customer_product_name) . '</a>';
      $to = $customer_email;
      $subject = esc_html__( 'Notification Email', 'woocommerce-stock-notifications');
      $body = esc_html__('Thank you for subscribing. You will get an email when the product is in stock. Product: ', 'woocommerce-stock-notifications');
      $body .= '<a href="' . esc_url($customer_product_link) . '">' . esc_html($customer_product_name) . '</a>.';
      $body .= esc_html__(' Thank you', 'woocommerce-stock-notifications');
      $headers = array('Content-Type: text/html; charset=UTF-8');
      
      $sent = wp_mail($to, $subject, $body, $headers);

      $wpdb->insert(
          $table_name,
          array(
              'customer_name' => $customer_name,
              'customer_email' => $customer_email,
              'customer_phone_number' => $customer_phone_number,
              'customer_product_id' => $customer_product_id,
              'customer_product_name' => $linked_product,
          )
      );

      if ($sent) {
          $response = array(
              'success' => true,
              'message' => 'Email sent successfully!',
          );
      } else {
          $response = array(
              'success' => false,
              'message' => 'Failed to send email.',
          );
      }
      wp_send_json($response);
  }
  
}