if(typeof(synkraft_strings) !== 'undefined' && synkraft_strings !== null) {

jQuery(function() {
  jQuery('#myModal').on('shown.bs.modal', function () {
    jQuery('#myInput').trigger('focus')
  })
//Sidebar open nav code start Here
  jQuery(".open-sidebar").on('click', function () {
    jQuery("#menuSidebar").css("width", "240px");
    jQuery("#main").css("marginLeft", "240px");

  });
  jQuery(".close-sidebar").on('click', function () {
    jQuery("#menuSidebar").css("width", "0");
    jQuery("#main").css("marginLeft", "0");
  });
//Sidebar open nav code close Here

//local Active Deactive plugin start here
 if(jQuery(".synkpluginnotify-larggrid").length > 0) {
    jQuery(".synkpluginnotify-larggrid").on('click', function () {
      jQuery(".synkoverlay_loader").show();
      var plugin_state=jQuery(this).data("status");
      var check_val;
      if (plugin_state=="Activate") {
        check_val = 1;
      } else if (plugin_state=="Deactivate") {
        check_val = 0;
      }
      var plugin_version = jQuery(this).data("version");
      var plugin_name = jQuery(this).data("name");
      var plugin_img = jQuery(this).data("png");
      var plugin_type=jQuery(this).data("ptype");
      var plugin_feature=jQuery(this).data("feature");
      if(plugin_feature==1 && synkraft_strings.pro_check!=1){
        jQuery(".synkoverlay_loader").hide();
        Notiflix.Notify.Failure("Sorry! You are Not Pro User");
        return false;
      }
      jQuery.post(synkraft_strings.ajax_url, {
        action: 'plugin_activat_status',
        nonce: synkraft_strings.nonce,
        checkval: check_val,
        pluginname: plugin_name,
        pluginversion: plugin_version,
        pluginimg: plugin_img,
        plugin_type:plugin_type
      }).done(function (response) {
       jQuery(".synkoverlay_loader").hide();
        location.reload(true);
        if(response.data.email_pro_active==1){
          //Notiflix.Notify.Failure("Hello Pakistan");
          //Notiflix.Notify.Success(toest_restaurant_unfavorite);
           //Notiflix.Notify.Warning("Hello this is Warnig by me");
            //Notiflix.Notify.Info("This is info by Me");
          Notiflix.Notify.Info(response.data.message,{
            timeout:10000,
          });
            //Notiflix.Notify.Success(toest_restaurant_unfavorite);
         // var plugin_html='<div id="verify-free" class="notice notice-error mb-3"><p>'+response.data.message+'</p></div>';
          //jQuery(plugin_html).prependTo('.data');
        }else {
          Notiflix.Notify.Success("Action Sccessfully Done");
        }

      })

    });
  }
//local Active Deactive plugin close here

 //global setting of setting page active deactive function start Here
  if(jQuery(".synkpluginglobal").length > 0) {
    jQuery(".synkpluginglobal").on('click', function () {
      jQuery(".synkoverlay_loader").show();
      var check_val_global;
      if (jQuery(this).is(":checked")) {
        console.log("Checkbox is checked.");
        check_val_global = 1;
      } else if (jQuery(this).is(":not(:checked)")) {
        console.log("Checkbox is unchecked.");
        check_val_global = 0;
      }
      var setting_name = jQuery(this).data("settingname");
      var setting_option = jQuery(this).data("settingoption");
      var setting_id= jQuery(this).data("settingid");
      jQuery.post(synkraft_strings.ajax_url, {
        action: 'gloabal_setting_activat_status',
        nonce: synkraft_strings.nonce,
        settingcheckval: check_val_global,
        settingname: setting_name,
        settingoption: setting_option,
        settingid: setting_id,
      }).done(function (response) {
        jQuery(".synkoverlay_loader").hide();
        // location.reload(true);
        //alert(response.data.message);
      })
    });
  }
//global setting of setting page active deactive function close Here

//Connect License function start here
  (function () {
    var forms = document.querySelectorAll(".sk_connecting_license")
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener("submit", function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }else {
              connect_api_connect(event);
            }
            form.classList.add("was-validated")
          }, false)
        })
  })()
  if(jQuery("#sk_before_license").length > 0) {
    function connect_api_connect(e) {
      e.preventDefault();
      jQuery(".synkoverlay_loader").show();
      var email_val = jQuery("#synkemail").val();
      var pwd_val = jQuery("#synkpassword").val();
      var wpuid = synkraft_strings.admin_user_id;
      var wpsiteurl = synkraft_strings.site_url;
      var wpsiterute = synkraft_strings.api_check_pro;
      var wppro_wburl = synkraft_strings.pro_web;
      // var url = wppro_wburl + "?wpuid=" + wpuid + "&wpemail=" + email_val + "&wproute=" + wpsiterute + "&wpsiteurl=" + wpsiteurl;
      //window.open(url, '_blank');
      jQuery.post(synkraft_strings.ajax_url, {
        action: 'plugin_check_pro_status',
        nonce: synkraft_strings.nonce,
        checkwpid:wpuid,
        checkmail:email_val,
        checkpwd:pwd_val,
        checksite:wpsiteurl,
        checkrute:wpsiterute,
      }).done(function (response) {
        jQuery(".synkoverlay_loader").hide();
        if (response.data.success === true) {
          jQuery("#synklicensModal").modal('hide');
          Notiflix.Notify.Success(response.data.message);
          jQuery('#sk_before_license').attr('style', 'display:none;');
          jQuery('#sk_after_license').attr('style', 'display:block;');
          jQuery('.upgrade-pro').attr('style', 'display:none;');
          jQuery('.unlock-button').attr('style', 'display:none;');
          jQuery('.menu-footer').removeClass('footer-bottom-menu');
          jQuery('.menu-footer').addClass('footer-bottom-fixed');
          jQuery('#connectedemail').html(response.data.email);
          jQuery('#sk_license_btn_switch_account').val(response.data.email);
          jQuery(".price-plan .ctm-badge").addClass("active");
          jQuery(".price-plan .ctm-badge").html("Pro Plan");
          jQuery(".bill span #expire-date").html(response.data.billdate);
        } else {
          jQuery("#synklicensModal").modal('hide'); // Hide the modal
          Notiflix.Notify.Failure(response.data.message);
          jQuery('#sk_before_license').attr('style', 'display:block;');
          jQuery('#sk_after_license').attr('style', 'display:none;');
          jQuery('.unlock-button').attr('style', 'display:block;');

          //Notiflix.Notify.Failure("Hello Pakistan");
          //Notiflix.Notify.Success(toest_restaurant_unfavorite);
          //Notiflix.Notify.Warning("Hello this is Warnig by me");
          //Notiflix.Notify.Info("This is info by Me");

        }

      })





    }


  }
//Connect  License function close here

//Disconnect  License function start here
  if(jQuery(".disconnected_tab_deactivate").length > 0) {
    jQuery("#sk_license_btn_disconnect").on('click', function () {
      jQuery(".synkoverlay_loader").show();
     // var email_val = jQuery(this).data("email");
      var email_val = jQuery("#sk_license_email").val();
      var user_id = jQuery("#userid").val();
      jQuery.post(synkraft_strings.ajax_url, {
        action: 'plugin_disconnect_check_pro',
        nonce: synkraft_strings.nonce,
        checkmail: email_val,
        checkid:user_id
      }).done(function (response) {
        jQuery(".synkoverlay_loader").hide();
        if(response.data.success === true){
          Notiflix.Notify.Success(response.data.message);
          jQuery('#sk_before_license').attr('style','display:block;');
          jQuery('.upgrade-pro').attr('style','display:block;');
          jQuery('.unlock-button').attr('style','display:block;');
          jQuery('.menu-footer').removeClass('footer-bottom-fixed');
          jQuery('.menu-footer').addClass('footer-bottom-menu');
          jQuery('#sk_after_license').attr('style','display:none;');
          jQuery(".price-plan .ctm-badge").removeClass("active");
          jQuery(".price-plan .ctm-badge").html("Free");
        }else{
          Notiflix.Notify.Failure(response.data.message);
          jQuery('.account-detail').attr('style','display:none;');
          jQuery('#sk_after_license').attr('style','display:block;');
          jQuery('.unlock-button').attr('style','display:none;');
        }
      })

    })
  }
//Disconnect  License function start here

//Search all Plugins in search bar start here
  if(jQuery(".header").length > 0) {
    const searchInput = document.getElementById('search-sugg');
    const searchResultsContainer = document.getElementById('searchResults');
    const searchcounter = document.getElementById('search_count');
    async function fetchJsonData() {
      try {
        const response = await fetch(synkraft_strings.site_parth_js+'pluginupdate.json');
        const jsontext = await response.text();
        const jsonData = JSON.parse(jsontext);
        return jsonData;
      } catch (error) {
        console.error('Error fetching JSON data:', error);
      }
    }
    async  function synkraft_handleSearch() {
      const userInput = searchInput.value;
      const result = await fetchJsonData();
      const result_data= result.data;
      const fuse = new Fuse(result_data, {
        keys: ['name', 'description']
      });
      const searchResults = fuse.search(userInput);
      searchResultsContainer.innerHTML="";
      searchcounter.innerHTML="";
      var innner_div="";
      var number_result=1;
      var main_site_url = synkraft_strings.site_url;
      var main_site_feature_url = synkraft_strings.site_parth_js;

      searchResults.forEach(result => {
        console.log(result);
        searchcounter.innerHTML=number_result;
        var icons_screens = main_site_url+result.item.icon;
      // innner_div +='<div class="col-xl-3 col-lg-6 col-md-6 col-12"><div class="search-card"><img src="https://t4.ftcdn.net/jpg/04/62/63/65/240_F_462636502_9cDAYuyVvBY4qYJlHjW7vqar5HYS8h8x.jpg"/><p><a href="'+synkraft_strings.feature_url+"&p_name="+"#"+result.item.name+'">'+result.item.name+'</a></p></div></div>';
        innner_div +='<div class="col-xl-3 col-lg-6 col-md-6 col-12"><div class="search-card"><img src="'+icons_screens+'"/><p><a href="'+synkraft_strings.feature_url+"&p_name="+result.item.name+"#"+result.item.name+'">'+result.item.name+'</a></p></div></div>';
        searchResultsContainer.innerHTML=innner_div;
        number_result++;
      });
    }
    searchInput.addEventListener('input', synkraft_handleSearch);
 }
//Search all Plugins in search bar close here

//Suggestion against pro in case of only active synkraft free Plugin start
  if(jQuery(".main-pro-plugin").length > 0) {
    const searchResultsContainer = document.getElementById('main-pro-plugin');
    async function fetchJsonData_pro() {
      try {
        const response = await fetch(synkraft_strings.site_parth_js+'pluginupdate.json');
        const jsontext = await response.text();
        const jsonData = JSON.parse(jsontext);
        return jsonData;
      } catch (error) {
        console.error('Error fetching JSON data:', error);
      }
    }
    async  function synkraft_handle_pro_plugin() {
      const result = await fetchJsonData_pro();
      const result_data= result.data;
      searchResultsContainer.innerHTML="";
      var innner_div="";
      console.log(result_data);
      result_data.forEach(result => {
        innner_div +='<div class="accord-item"><div class="accord-main"><div class="img-data"><div class="bg-color"><img class="main-img-accord" src="https://t4.ftcdn.net/jpg/04/62/63/65/240_F_462636502_9cDAYuyVvBY4qYJlHjW7vqar5HYS8h8x.jpg"></div><div class="img-text"><h6>'+result.name+'</h6><p><small class="img-text-clr">'+result.description+':<br>'+result.version+'</small></p></div></div> <div class="data-btn"> <div class="d-flex"><button class="btn-custom-grey mb-2"><span class="text-hover"><img src=""></span><span class="detail">&nbsp;Configuration</span></button><div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1"><img src="'+synkraft_strings.info_img+'"><span class="tooltiptext-1">See Info</span></div></div><input type="button" class="btn-custom plugin-status-button synkpluginnotify-larggrid pro-plugins"   data-name="" data-version="" data-png="" data-status="" value="PRO" disabled /></div></div></div>';
        searchResultsContainer.innerHTML=innner_div;
      });
    }
    window.addEventListener('load', synkraft_handle_pro_plugin);
   // window.addEventListener

  }
//Suggestion against pro in case of only active synkraft free Plugin close

//Wizard of synkraft start code start  here
  if(jQuery("#visit").length > 0) {
    // Animation
    const progressBar1 = document.querySelector("#visit .last-screen-1 .progress");
    progressBar1.addEventListener("animationend", () => {
      progressBar1.style.animation = "progressBarWidth 1s 1";
      progressBar1.style.top = "100%";
      progressBar1.style.width = "0";
    });
    const sections = document.querySelectorAll("section");
    const progressBar = document.querySelector(".progress-bar");
    const ctmProgressBar = document.querySelector(".ctm-progress-bar");
    const footer = document.querySelector(".visit-footer");
    const vIcon = document.querySelector(".v-icon");
    let currentSectionIndex = 0;
    function updateProgressBar() {
      const progressPercentage = (currentSectionIndex / (sections.length - 1)) * 100;
      progressBar.style.width = `${progressPercentage}%`;
    }
    function hideProgressBarAndFooter() {
      progressBar.style.display = "none";
      ctmProgressBar.style.display = "none";
      footer.style.display = "none";
      vIcon.style.textAlign = "center";
    }
    function showProgressBarAndFooter() {
      progressBar.style.display = "block";
      ctmProgressBar.style.display = "block";
      footer.style.display = "block";
      vIcon.style.textAlign = "";
    }
    function hideCtmProgressBar() {
      ctmProgressBar.style.display = "none";
    }
    function hideLogo() {
      vIcon.style.display = "none";
    }
    function showLogo() {
      vIcon.style.display = "block";
    }
    function showSection(index) {
      sections.forEach((section, idx) => {
        if (idx === index) {
          section.classList.add("active");
          section.classList.remove("d-none");
        } else {
          section.classList.remove("active");
          section.classList.add("d-none");
        }
      });

      if (index === sections.length - 1) {
        hideProgressBarAndFooter();
        hideCtmProgressBar();
        showLogo();
      } else {
        showProgressBarAndFooter();
      }
      if (index === sections.length - 2) {
        hideProgressBarAndFooter();
        hideCtmProgressBar();
        hideLogo();
      } else {
        showProgressBarAndFooter();
      }

      currentSectionIndex = index;
      updateProgressBar();
    }

    function goToNextSection() {
      if (currentSectionIndex < sections.length - 1) {
        showSection(currentSectionIndex + 1);
      }
    }

    function goToPreviousSection() {
      if (currentSectionIndex > 0) {
        showSection(currentSectionIndex - 1);
      }
    }
    const backBtn = document.getElementById("backBtn");
    const nextBtn = document.getElementById("nextBtn");
    backBtn.addEventListener("click", goToPreviousSection);
    const optionCtms = document.querySelectorAll(".option-ctm");
    optionCtms.forEach((optionCtm) => {
      optionCtm.addEventListener("click", () => {
        const checkbox = optionCtm.querySelector(".form-check-input");
        const parentLabelRight = optionCtm.querySelector(".label-right");
        checkbox.checked = !checkbox.checked;
        if (checkbox.checked) {
          optionCtm.classList.add("active");
          parentLabelRight.classList.add("active");
        } else {
          optionCtm.classList.remove("active");
          parentLabelRight.classList.remove("active");
        }
      });
    });
    function showLastScreen2() {
      const lastScreen1 = document.querySelector(".last-screen-1");
      // lastScreen1.classList.remove("active");
      lastScreen1.classList.add("d-none");
      const lastScreen2 = document.querySelector(".last-screen-2");
      lastScreen2.classList.add("active");
      lastScreen2.classList.remove("d-none");
    }
    nextBtn.addEventListener("click", () => {
      setTimeout(() => {
        goToNextSection();
        if (currentSectionIndex === sections.length - 2) {
          const lastScreen1 = document.querySelector(".last-screen-1");
          lastScreen1.style.animation = "progressBarWidth 2s 1";
          lastScreen1.style.top = "100%";
          lastScreen1.style.left = "0";
          lastScreen1.style.right = "0";
          lastScreen1.style.margin = "auto";
          lastScreen1.style.width = "0";

          setTimeout(() => {
            showLastScreen2();
          }, 2200);
        }
      }, 100);
    });

    showSection(currentSectionIndex);
  }
  jQuery(document).ready(function($) {
    // Initialize the wizard
    var currentStep = 0;
    $('#nextBtn').on("click" , function() {
      var dashboard_url = $('#dashboard_url').val();
      var step_1_values = [];
      $('input[name="step_1_vals"]:checked').each(function() {
        step_1_values.push($(this).val());
      });
      var step_2_values = [];
      $('input[name="step_2_vals"]:checked').each(function() {
        step_2_values.push($(this).val());
      });
      var step_3_values = [];
      $('input[name="step_3_vals"]:checked').each(function() {
        step_3_values.push($(this).val());
      });
      var step_4_values = [];
      $('input[name="step_4_vals"]:checked').each(function() {
        step_4_values.push($(this).val());
      });
      var step_5_values = [];
      $('input[name="step_5_vals"]:checked').each(function() {
        step_5_values.push($(this).val());
      });
      var step_6_values = [];
      $('input[name="step_6_vals"]:checked').each(function() {
        step_6_values.push($(this).val());
      });
      var step_7_values = [];
      $('input[name="step_7_vals"]:checked').each(function() {
        step_7_values.push($(this).val());
      });
      var step_8_values = [];
      $('input[name="step_8_vals"]:checked').each(function() {
        step_8_values.push($(this).val());
      });
      var step_9_values = [];
      $('input[name="step_9_vals"]:checked').each(function() {
        step_9_values.push($(this).val());
      });
      var step_10_values = [];
      $('input[name="step_10_vals"]:checked').each(function() {
        step_10_values.push($(this).val());
      });
      jQuery('#nextBtn').attr('disabled','disabled');
      $.post(synkraft_strings.ajax_url,
          {
            action: 'save_wizard_data',
            section_1_step_1: step_1_values,
            section_2_step_2: step_2_values,
            section_3_step_3: step_3_values,
            section_4_step_4: step_4_values,
            section_5_step_5: step_5_values,
            section_6_step_6: step_6_values,
            section_7_step_7: step_7_values,
            section_8_step_8: step_8_values,
            section_9_step_9: step_9_values,
            section_10_step_10: step_10_values,
          },
          function(response) {

          }
      )
          .done(function(response){
            var response_results = JSON.parse(response);
            if (response_results.status === 'success' ) {
              if ( jQuery('#wizard-steps > section.active ').attr('data-step') == 11 ) {
                setTimeout(
                    function()
                    {
                      window.location.replace(dashboard_url);
                    }, 5000);
              }
              jQuery('#nextBtn').removeAttr('disabled');
            }
          });
      currentStep++;
    });

    $(".view-all").on("click", function(){
      $(".features_over_expand").css('display','block');
      $(".back_to_overview").css('display','block');
      // $(".dashboard_view_all_plugins").css('display','none');
      var element = document.querySelector(".dashboard_view_all_plugins");
      element.classList.remove("d-flex");
      $(".dashboard_view_all_plugins").css('display', 'none');

    });
    $(".back_to_overview_btn").on("click", function(){
      $(".dashboard_view_all_plugins").addClass("d-flex");
      $(".dashboard_view_all_plugins").css('display','block');
      $(".features_over_expand").css('display','none');
      $(".back_to_overview").css('display','none');

    });
  });
//Wizard of synkraft start code close  here

//Disconnect by Api new work Start Here

//Disconnect by Api new work close Here

});
}





