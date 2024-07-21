<?php
if(!defined('ABSPATH')){
    return;
}
class SYNK_Wizard
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
      if (!function_exists('synkraft_wizard_content')) {
        function synkraft_wizard_content(){
          $explore_page_url = menu_page_url('synkexplore.php', false);
          global $wpdb;
          $table_name = $wpdb->prefix . 'synkraft_plugin_status_table';
          // $plugin_directory = trailingslashit(ABSPATH) . 'wp-content/plugins/synkraft/addons/';
          // $plugin_names_data = get_plugin_names_in_directory($plugin_directory);
          $five_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/5.svg';
          $syn_wizard_logo = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/logo.svg';
          $social_login_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/Social-login.svg';
          $social_login_svgs = SYNKRAFT_Plugin_Url . 'assets/images/screen.png';
          $eamil_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/email.svg';
          $cart_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/Cart.svg';
          $maximize_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/maximize-3.svg';
          $arrow_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/arrow.svg';
          $one_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/1.svg';
          $arrow_btn_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/arrow-btn.svg';
          $arrow_btn_one_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/arrow-btn-1.svg';
          $two_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/2.svg';
          $three_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/3.svg';
          $four_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/4.svg';
          $recaptcha_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/recaptcha.svg';
          $Social_login_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/social-login.svg';
          $email_verifi_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/email-verification.svg';
          $add_to_cart_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/add-to-cart.svg';
          $login_sign_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/login-sign.svg';
          $quick_view_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/quick-view.svg';
          $conversion_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/conversion.svg';
          $subscription_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/subscription.svg';
          $zoom_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/zoom.svg';
          $product_label_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/product-label.svg';
          $product_bundle_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/product-bundle.svg';
          $compare_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/compare.svg';
          $wishlist_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/wishlist.svg';
          $currency_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/currency.svg';
          $gdpr_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/GDPR.svg';
          $shipping_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/shipping.svg';
          $customiz_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/customiz.svg';
          $checkout_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/checkout-field-editor.svg';
          $abondond_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/abondond.svg';
          $notification_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/notification.svg';
          $loader_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/wizard/loader.gif';
          $current_user = get_current_user_id();
          $section1 = get_user_meta($current_user, 'section_1_selected_multiple_plugins', true);
          $section2 = get_user_meta($current_user, 'section_2_selected_multiple_plugins', true);
          $section3 = get_user_meta($current_user, 'section_3_selected_multiple_plugins', true);
          $section4 = get_user_meta($current_user, 'section_4_selected_multiple_plugins', true);
          $section5 = get_user_meta($current_user, 'section_5_selected_multiple_plugins', true);
          $section6 = get_user_meta($current_user, 'section_6_selected_multiple_plugins', true);
          $section7 = get_user_meta($current_user, 'section_7_selected_multiple_plugins', true);
          $section8 = get_user_meta($current_user, 'section_8_selected_multiple_plugins', true);
          $section9 = get_user_meta($current_user, 'section_9_selected_multiple_plugins', true);
          $section10 = get_user_meta($current_user, 'section_10_selected_multiple_plugins', true);
          // $plugin_logo_images = get_plugins_logo_img();
          $iteration_status = 0;
          $plugin_status_check = '';
          $plugins_html = '';
          $modale_pop_up = '';
            ?>
                          

          <div class="data">
            <div id="visit">
              <div class="visit-header">
                <div class="v-icon text-center">
                  <img src="<?php echo $syn_wizard_logo; ?>" />
                </div>
                <div class="progress ctm-progress-bar" role="progressbar" aria-label="Example with label" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar" style="width: 0"></div>
                </div>
              </div>
              <div class="border-container">

                <div class="visit-body">
                  <form id="wizard-steps">
                    <section data-step="1" class="">
                      <div class="details text-center">
                        <h3><?php echo esc_html__( 'Are you interested in increasing the security of your', 'synkraft' );?><br />
                          <?php echo esc_html__( 'website to avoid spam and bots?', 'synkraft' );?>
                          
                        </h3>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                            <div class="option-ctm  <?php if( !empty($section1) && in_array('recaptcha_plugin', $section1)) { echo 'active'; } else { echo ''; } ?>">
                              <div class="form-check">
                                <div class="row">
                                  <div class="check-right col-1">
                                    <input class="form-check-input" type="checkbox" name="step_1_vals" value="recaptcha_plugin" id="flexCheckDefault" <?php if( !empty($section1) && in_array('recaptcha_plugin', $section1)) { echo 'checked'; } else { echo ''; } ?> />
                                  </div>
                                  <div class="label-right col-11">
                                    <!-- <label class="form-check-label" for="start"> -->
                                    <div class="d-flex">
                                      <img src="<?php echo  $recaptcha_svg;?>" />
                                      <div>
                                        <h6><?php echo esc_html__( 'reCAPTCHA', 'synkraft' );?></h6>
                                        <p><small><?php echo esc_html__( 'Increase site security by asking visitors to confirm they\'re not a robot before submitting a forms.', 'synkraft' );?></small></p>
                                      </div>
                                    </div>
                                    <!-- </label> -->
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section1) &&  in_array('email_verifivation_plugin', $section1)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_1_vals" value="email_verifivation_plugin" <?php if(!empty($section1) &&  in_array('email_verifivation_plugin', $section1)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $email_verifi_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Email Verification', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Verifies a new user\'s email address before they can create an account, enhancing security.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="2" class="d-none">

                      <div class="details text-center">
                        <h3><?php echo esc_html__( 'Would you like to simplify the login process and', 'synkraft' );?><br />
                          <?php echo esc_html__( 'enhance security for your users?', 'synkraft' );?>
                        </h3>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if( !empty($section2) &&  in_array('social_login', $section2)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_2_vals" value="social_login" id="flexCheckDefault" <?php if(  !empty($section2) && in_array('social_login', $section2)) { echo 'checked'; } else { echo ''; } ?> />
                                </div> 
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $Social_login_svg; ?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Social Login', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Enables users to register or sign in using their social media accounts, simplify the process.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="3" class="d-none position-relative">
                
                      <div class="details text-center">
                        <h3>
                        <?php echo esc_html__( 'Are you looking for more ways to enhance your product listings', 'synkraft' );?><br />
                        <?php echo esc_html__( 'and help customers make purchase decisions?', 'synkraft' );?>
                        </h3>
                      </div>
                      <div class="row plugins-box sidebar-scroll">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if( !empty($section3) && in_array('quick_view', $section3)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_3_vals" value="quick_view" id="flexCheckDefault" <?php if( !empty($section3) && in_array('quick_view', $section3)) { echo 'checked'; } else { echo ''; } ?>/>
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $quick_view_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Quick View', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Allows customers to preview product details in a pop-up without leaving the current page.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if( !empty($section3) && in_array('zoom_plugin', $section3)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_3_vals" value="zoom_plugin" <?php if( !empty($section3) && in_array('zoom_plugin', $section3)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $zoom_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Zoom', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Allow customers to zoom in on product images for a closer look at details.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section3) && in_array('product_labels', $section3)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_3_vals" value="product_labels" <?php if(!empty($section3) && in_array('product_labels', $section3)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $product_label_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Product Label', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Enables the addition of custom labels on products images (e.g, New Site, etc).', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section3) && in_array('product_bundles', $section3)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_3_vals" value="product_bundles" <?php if(!empty($section3) && in_array('product_bundles', $section3)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $product_bundle_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Product Bundles', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Allows you to sell product bundles at a discounted price.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section3) && in_array('products_compare', $section3)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_3_vals" value="products_compare" <?php if(!empty($section3) && in_array('products_compare', $section3)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $compare_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Compare', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Lets customers compare different products side-by-side to help make purchase decisions.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section3) && in_array('product_wishlist', $section3)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_3_vals" value="product_wishlist" <?php if(!empty($section3) && in_array('product_wishlist', $section3)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $wishlist_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Products Wishlist', 'synkraft' );?><h6>
                                      <p><small><?php echo esc_html__( 'Allows customers to save products they are interested in to a wishlist for future purchase.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="background-rgba"></div>
                    </section>
                    <section  data-step="4" class="d-none">
                      <div class="details text-center">
                        <h3><?php echo esc_html__( 'Do you wish to localize the shopping experience by displaying', 'synkraft' );?> <br /><?php echo esc_html__( 'prices in your customer\'s local currency?', 'synkraft' );?></h3>
                      </div>
                      <div class="row plugins-box sidebar-scroll">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section4) && in_array('currency_switcher', $section4)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_4_vals" value="currency_switcher" <?php if(!empty($section4) && in_array('currency_switcher', $section4)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $currency_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Currency Switcher', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Automatically converts prices into a customer\'s local currency based on their location.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="5" class="d-none">
                      <div class="details text-center">
                        <h3><?php echo esc_html__( 'Are you interested in ensuring your website is compliant with ', 'synkraft' );?><br /><?php echo esc_html__( 'GDPR and other privacy regulations?', 'synkraft' );?></h3>
                      </div>
                      <div class="row plugins-box sidebar-scroll">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section5) && in_array('gdpr_compliance', $section5)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_5_vals" value="gdpr_compliance" <?php if(!empty($section5) && in_array('gdpr_compliance', $section5)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $gdpr_svg; ?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'GDRP Compliance', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Assure your website is compliant with EU\'s GDPR regulations, protecting user data and privacy.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="6" class="d-none">
                      <div class="details text-center">
                        <h3><?php echo esc_html__( 'Would you like to provide your customers with real-time ', 'synkraft' );?> <br /><?php echo esc_html__( 'shipping tracking information?', 'synkraft' );?></h3>
                      </div>
                      <div class="row plugins-box sidebar-scroll">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section6) && in_array('shipping_tracking', $section6)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_6_vals" value="shipping_tracking" <?php if(!empty($section6) && in_array('shipping_tracking', $section6)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $shipping_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Shipping Tracking', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Provides customers with real-time tracking information for their orders.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="7" class="d-none">
                      <div class="details text-center">
                        <h3><?php echo esc_html__( 'Are you interested in personlizing the checkout process and registeration forms of your users?', 'synkraft' );?></h3>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section7) && in_array('customized_registeration', $section7)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_7_vals" value="customized_registeration" <?php if(!empty($section7) && in_array('customized_registeration', $section7)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $customiz_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Customized Registeration Forms', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Lets you edit and customized the user registeration forms as needed.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section7) && in_array('checkout_fields', $section7)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_7_vals" value="checkout_fields" <?php if(!empty($section7) && in_array('checkout_fields', $section7)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $checkout_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Checkout Field Editor', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Lets you customize the fields on your checkout page for a personalized shopping experience.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="8" class="d-none">
                      <div class="details text-center">
                        <h3><?php echo esc_html__( 'Are you interested in Adding the Subscription process and', 'synkraft' );?>
                          <br /><?php echo esc_html__( 'Customize your field?', 'synkraft' );?>
                        </h3>
                      </div>
                      <div class="row plugins-box sidebar-scroll">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section8) && in_array('subscription', $section8)) { echo 'active'; } else { echo ''; } ?> ">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_8_vals" value="subscription" <?php if(!empty($section8) && in_array('subscription', $section8)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $subscription_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Subscription', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Allows you to sell subscription-based products or services, offering recurring revenue.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="9" class="d-none">
                      <div class="details text-center">
                        <h3>
                        <?php echo esc_html__( 'Do you want to automate notifications for instances such as ', 'synkraft' );?><br />
                        <?php echo esc_html__( 'restocked products or abandoned carts?', 'synkraft' );?>
                        </h3>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section9) && in_array('abondoned_cart_recovery', $section9)) { echo 'active'; } else { echo ''; } ?> one" style="height: 80%">
                            <div class="form-check" style="height: 100%">
                              <div class="row" style="height: 100%">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_9_vals" value="abondoned_cart_recovery"  <?php if(!empty($section9) && in_array('abondoned_cart_recovery', $section9)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11" style="height: 100%">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $abondond_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Abondoned Cart Recovery', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Sends reminders to customers who left products in their cart without checking out.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section9) && in_array('back_in_stock', $section9)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_9_vals" value="back_in_stock"  <?php if(!empty($section9) && in_array('back_in_stock', $section9)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $notification_svg;?>" />
                                    <div>
                                      <h6><?php echo esc_html__( 'Back in Stock Notifier', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Sends notifications to customers when an out-of-stock product they\'re interested in becomes available again.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="10" class="d-none">
                      <div class="details text-center">
                        <h3><?php echo esc_html__( 'Are you interested in using pop-ups to enhance user-experience,', 'synkraft' );?><br />
                        <?php echo esc_html__( 'like sign ups, or added to cart notification?', 'synkraft' );?>
                        </h3>
                      </div>

                      <div class="row">
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section10) && in_array('add_to_cart', $section10)) { echo 'active'; } else { echo ''; } ?>">
                            <div class="form-check">
                              <div class="row">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_10_vals" value="add_to_cart"  <?php if(!empty($section10) && in_array('add_to_cart', $section10)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $add_to_cart_svg;?>" />
                                    <div>
                                      <h6> <?php echo esc_html__( 'Add to Cart Popup', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Displaying a pop-up window whenever a customer adds a product to their cart, encouraging them to checkout.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="option-ctm <?php if(!empty($section10) && in_array('login_sign_in_popup', $section10)) { echo 'active'; } else { echo ''; } ?>" style="height: 80%">
                            <div class="form-check" style="height: 100%">
                              <div class="row" style="height: 100%">
                                <div class="check-right col-1">
                                  <input class="form-check-input" type="checkbox" name="step_10_vals" value="login_sign_in_popup"  <?php if(!empty($section10) && in_array('login_sign_in_popup', $section10)) { echo 'checked'; } else { echo ''; } ?> id="flexCheckDefault" />
                                </div>
                                <div class="label-right col-11" style="height: 100%">
                                  <!-- <label class="form-check-label" for="start"> -->
                                  <div class="d-flex">
                                    <img src="<?php echo $login_sign_svg;?>" />
                                    <div>
                                      <h6> <?php echo esc_html__( 'Login Sign Up Popup', 'synkraft' );?></h6>
                                      <p><small><?php echo esc_html__( 'Creates a quick and easy pop-up form for user registation and login.', 'synkraft' );?></small></p>
                                    </div>
                                  </div>
                                  <!-- </label> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section  data-step="11" class="last-screen-1 d-none">
                      <div class="last-screen">
                        <div class="progress ctm-progress-bar" role="progressbar" aria-label="Example with label" aria-valuemin="0" aria-valuemax="100">
                          <div class="progress-bar" style="width: 100%"></div>
                        </div>
                      </div>
                    </section>
                    <section class="last-screen-1 d-none last-screen-2"  data-step="12">
                      <div class="last-screen">
                        <img src="<?php echo $syn_wizard_logo;?>" class="mb-5" />
                        <div class="mt-5">
                          <img src="<?php echo $loader_svg;?>" width="100" height="100" class="mt-5" />
                          <p><?php echo esc_html__( 'Please Hold few moments.', 'synkraft' );?> <br /><?php echo esc_html__( 'We’re Customizing your SynKraft Experience.', 'synkraft' );?></p>
                        </div>
                      </div>
                    </section>
                  </form>
                </div>
              </div>
              <div class="visit-footer">
                <div class="row">
                  <div class="col-sm-6">
                    <button class="visit-btn" id="backBtn"><i class="fa-solid fa-chevron-left"></i> &nbsp; <?php echo esc_html__( 'Back', 'synkraft' );?></button>
                  </div>
                  <div class="col-sm-6">
                    <div class="tooltip-2 w-100">
                      <button class="visit-btn" id="nextBtn">
                      <?php echo esc_html__( 'Next', 'synkraft' );?> &nbsp; <span class="next-btn-icon"><i class="fa-solid fa-chevron-right"></i></span>
                      </button>
                      <input type="hidden" id="dashboard_url" value="<?php echo admin_url('admin.php?page=synkraft.php');?>">
                      <!-- <span class="tooltiptext-1"><i class="fa-solid fa-circle-info"></i>&nbsp; Select any Field First</span> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
        }
      }
    }
}