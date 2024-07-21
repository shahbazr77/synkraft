<?php
if(!defined('ABSPATH')){
    return;
}
class SYNK_Header_Strip{

  public static $instance=null;

  public static function get_instance(){
      if(self::$instance===null){
          self::$instance=new self();
      }
      return self::$instance;
  }

  public function __construct(){
      if (!function_exists('synkraft_header_strip')) {
          function synkraft_header_strip()
          {
              $pro_status="";
              $message_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/messages.svg';
              $notification_bing_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/notification-bing.svg';
              $notification_png = SYNKRAFT_Plugin_Url . 'assets/css/icons/notification.png';
              $profile_png = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/profile.png';
              $group_png = SYNKRAFT_Plugin_Url . 'assets/css/images/group.png';
              $loader_svg = SYNKRAFT_Plugin_Url . 'assets/css/images/bars-white.svg';
              $headphone_svg = SYNKRAFT_Plugin_Url . 'assets/css/images/bars-headphone.svg';
              $headphone_white_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/headphone_white.svg';
              $user_data=wp_get_current_user();
              $admin_id= $user_data->ID;
              $admin_name=$user_data->display_name;
              $admin_email=$user_data->user_email;
              $admin_avatar=get_avatar_url($admin_id);
              $subscriber_url="https://synkraft.com/";
              $profile_url="https://phpstack-1021230-3737300.cloudwaysapps.com/login";
              $expiry_status=synk_compare_expiry_secret_key();
              $unlock_pro="";

              if(class_exists('Pro_Synkraft_Main') and $expiry_status==true)  {
                $pro_status = '<span class="ctm-badge active">' . esc_html__('Pro Plan', 'synkraft') . '</span>';
                }else{
                $pro_status='<span class="ctm-badge">'.esc_html__('Free','synkraft').'</span>';
                  $unlock_pro='<a class="dropdown-item one unlock-button" target="_blank" href="'.esc_url($subscriber_url,'synkraft').'">'.esc_html__("UNLOCK ALL FEATURES WITH PRO",'synkraft').' &nbsp; <i class="fa-solid fa-arrow-right"></i> </a>';
                }

              return '<div class="header">
              <div class="row">
          <div class="col-xl-9 col-lg-7">
            <div class="d-flex justify-content-between">
              <button class="mobile-closebtn d-lg-none d-block open-sidebar" id="toggleButton"><i class="bi bi-view-list"></i></button>
              <div class="autocomplete w-100">
                <div class="search-input">
                  <div class="align-self-center">
                    <i class="bi bi-search"></i>
                  </div>
                  <input id="search-sugg" class="form-control" type="text" name="search" placeholder="'.esc_attr__("Search",'synkraft').'" />
                  <button class="cancel-btn" onclick="document.getElementById("search-sugg").value ="""><i class="fa-regular fa-circle-xmark"></i>'.esc_html__("Cancel",'synkraft').'</button>
                </div>
                <div class="search-suggestion">
                  <div class="search-data" id="search-data">
                    <h6 class="mt-1 mb-4"><span id="search_count" class="mx-2">0</span>'.esc_html__("Search Results",'synkraft').' </h6>
                    <div class="row mx-0 px-0" id="searchResults">
            
                    </div>
                    <button class="btn-search-sugg">'.esc_html__("See All ",'synkraft').'<i class="fa-solid fa-arrow-right"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-lg-5 align-self-center">
            <div class="header-options">
              <div class="split-button">
              <div class="notification-btn">
                  <button onclick="notificationBtns()" class="option-btn msg" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <img src="'.esc_url($message_svg).'" />&nbsp;<span><i class="fa-solid fa-chevron-down down_arrow" style="font-size:12px;"></i> <i class="fa-solid fa-chevron-up up_arrow d-none"></i></span>
                  </button>
                  <!-- want some help -->
                  <div id="feedback" class="notification-menu">
                    <h4 class="mb-0">'.esc_html__("Want Some Help?",'synkraft').'</h4>
                    
                    <div>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="all-pane" role="tabpanel" aria-labelledby="all" tabindex="0">
                    <ul class="feedback_tabs">
                      <hr>
                      <li>
                        <a class="dropdown-item ctm" target="_blank" href="'.esc_url($subscriber_url,'synkraft').'">
                          <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center icon-with-see-documentaion"> 
                              <div class="tab_contents">'.esc_html__("See Documentation",'synkraft').'</div>
                            </div>
                            <div><i class="fa-solid fa-arrow-right"></i></div>
                          </div>
                        </a>
                      </li>
                      <hr>
                      <li>
                        <a class="dropdown-item ctm" target="_blank" href="'.esc_url($subscriber_url,'synkraft').'">
                          <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center icon-with-feedback">
                                <div class="tab_contents">'.esc_html__("Give Feedback about SynKraft",'synkraft').'
                                </div>
                            </div>
                              <div><i class="fa-solid fa-arrow-right"></i></div>
                          </div>
                        </a>
                      </li>
                      <hr>

                      <li>
                        <a class="dropdown-item ctm" target="_blank" href="'.esc_url($subscriber_url,'synkraft').'">
                          <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center icon-with-support">
                              <div class="tab_contents">'.esc_html__("Support",'synkraft').'</div>
                            </div>
                            <div><i class="fa-solid fa-arrow-right"></i></div>
                          </div>
                        </a>
                      </li>
                      <hr>

                      <li class="help_footer">
                        <div class="want_help_footer">
                          <ul>
                            <li><small><i class="fa-solid fa-circle" style="font-size:6px;"></i></small> &nbsp;<span> <a href="#"> About Synkraft </a></span></li>
                            <li><small><i class="fa-solid fa-circle" style="font-size:6px;"></i></small> &nbsp;<span> <a href="#"> Terms of Use </a></span></li>
                            <li><small><i class="fa-solid fa-circle" style="font-size:6px;"></i></small> &nbsp;<span> <a href="#"> Privacy Policy </a></span></li>
                          </ul>  
                        </div>
                      </li>
                    </ul>
                        </div>
                        <div class="tab-pane fade" id="unread-pane" role="tabpanel" aria-labelledby="unread" tabindex="0">
                          <div class="p-4 notifications">
                            <div class="d-flex justify-content-center mb-3">
                              <img src="'.esc_url($notification_png).'" />
                            </div>
                            <div>
                              <h5 class="">'.esc_html__("No New Notfification yet",'synkraft').'</h5>
                              <p>'.esc_html__("Check this section for updates, exclusive and general notifications.",'synkraft').'</p>
                            </div>
                          </div>
                          <a class="btn-notification mt-3">'.esc_html__("See all Notifications",'synkraft').'</a>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              </div>
              <div class="notification-btn">
                <button onclick="notificationBtn()" class="option-btn notifi mx-1"><img src="'.esc_url($notification_bing_svg).'" /></button>
                <div id="notification" class="notification-menu">
                  <h4 class="mb-0">'.esc_html__("Notification",'synkraft').'</h4>
                  <div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all" data-bs-toggle="tab" data-bs-target="#all-pane" type="button" role="tab" aria-controls="all-pane" aria-selected="true">
                          '.esc_html__("All Notification",'synkraft').'
                        </button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="unread" data-bs-toggle="tab" data-bs-target="#unread-pane" type="button" role="tab" aria-controls="unread-pane" aria-selected="false">
                            '.esc_html__("Unread Notification",'synkraft').'
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="all-pane" role="tabpanel" aria-labelledby="all" tabindex="0">
                        <div class="p-4 notifications">
                          <div class="d-flex justify-content-center mb-3">
                            <img src="'.esc_url($notification_png).'" />
                          </div>
                          <div>
                            <h5 class="">'.esc_html__("No New Notfification yet",'synkraft').'</h5>
                            <p>'.esc_html__("Check this section for updates, exclusive and general notifications.",'synkraft').'</p>
                          </div>
                        </div>
                        <a class="btn-notification mt-3">'.esc_html__("See all Notifications",'synkraft').'</a>
                      </div>
                      <div class="tab-pane fade" id="unread-pane" role="tabpanel" aria-labelledby="unread" tabindex="0">
                        <div class="p-4 notifications">
                          <div class="d-flex justify-content-center mb-3">
                            <img src="'.esc_url($notification_png).'" />
                          </div>
                          <div>
                            <h5 class="">'.esc_html__("No New Notfification yet",'synkraft').'</h5>
                            <p>'.esc_html__("Check this section for updates, exclusive and general notifications.",'synkraft').'</p>
                          </div>
                        </div>
                        <a class="btn-notification mt-3">'.esc_html__("See all Notifications",'synkraft').'</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="dropdown position-relative">
                <button class="option-btn user" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="'.esc_url($admin_avatar).'" />
                </button>
                <ul class="dropdown-menu">
                  <div>
                    <div class="user-detail">
                      <img src="'.esc_url($admin_avatar).'" />
                      <div class="ps-2 align-self-center">
                        <h6 class="mb-0">'.esc_html($admin_name,'synkraft').'</h6>
                        <p class="mb-0 text-mute">'.esc_html($admin_email,'synkraft').'</p>
                      </div>
                    </div>
                    <div class="price-plan">
                      <div>
                        <p class="mb-0">
                          '.esc_html__("Current plan:",'synkraft').'
                          '.$pro_status.'
                        </p>
                      </div>
                    </div>
                  </div>
                  <li>
                  '.$unlock_pro.'
                  </li>
                  <li>
                    <a class="dropdown-item border-bottom" href="'.esc_url($profile_url).'"
                      ><div class="d-flex justify-content-between">
                        <div>'.esc_html__("Manage my account",'synkraft').'</div>
                        <div><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item ctm" target="_blank" href="'.esc_url($subscriber_url,'synkraft').'"
                      ><div class="d-flex justify-content-between">
                        <div>'.esc_html__("Help Center",'synkraft').'</div>
                        <div><i class="fa-solid fa-arrow-right"></i></div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item logout" href="'.esc_url(wp_logout_url()).'"
                      ><div class="d-flex justify-content-between">
                        <div>'.esc_html__("Logout",'synkraft').'</div>
                        <div><i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180"></i></div>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div><div class="synkoverlay_loader"><div class="synkoverlay__inner"><div class="synkoverlay__content"><div class="synkloader"><img class="synk-loader" src="'.esc_url($loader_svg).'" /></div></div></div></div>


    <script>
      const feedback = document.getElementById("feedback");
      const toggleDropdownButton = () => {
        feedback.classList.toggle("open");
      };

      const notification = document.getElementById("notification");
      const notificationBtn = () => {
        notification.classList.toggle("open");
      };

      const notifications = document.getElementById("feedback");
      const upArrow = jQuery(".up_arrow");
      const downArrow = jQuery(".down_arrow");

      const toggleArrows = () => {
        upArrow.toggleClass("d-none");
        downArrow.toggleClass("d-none");
      };

      const notificationBtns = () => {
        notifications.classList.toggle("open");
        toggleArrows();
      };

    </script>';

          }
      }
  }
}