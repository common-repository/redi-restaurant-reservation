<?php require_once(REDI_RESTAURANT_TEMPLATE. '../js/hotjar.js');?>
<div class="wrap">
    <h3><?php _e('Welcome to the ReDi Restaurant Reservation plugin', 'redi-restaurant-reservation'); ?></h3>
    <div id="account_activation_container">
        <div class="account_activation_wrapper">
            <div class="redi-setting-header">
                <h3><?php _e(' Registration', 'redi-restaurant-reservation'); ?></h3>
            </div>
            <div class="redi-setting-body">
                <?php if(!isset($_GET['email_skip'])){ $currentScreen = get_current_screen(); ?>
                <div class="email-form">
                    <div class="redi-body-form-inputs">
                        <p><span><?php _e('Please provide your email address to generate API Key', 'redi-restaurant-reservation'); ?></span></p>
                        <label for="email"><?php _e('Email', 'redi-restaurant-reservation'); ?>*
                            <input type="email" name="email" id="account_activation_email" placeholder="Email">
                        </label>
                        <div class="error_validation_message"></div>
                        <label class="consent">
                        <input class="consent-checkbox" type="checkbox" name="consent" id="consent-checkbox">
                        <?php _e('Allow to send information about the plugin', 'redi-restaurant-reservation'); ?></label>
                    </div>
                    <div class="addapi_key_message"><p><?php _e('If you have already an API key, you can skip this step and provide API key on next step.', 'redi-restaurant-reservation'); ?></p></div>
                    <div class="redi-body-button">
                        <a type="submit" class="email_form_skip" data-type="email-skip" href="<?php echo get_admin_url(); ?>/admin.php?page=<?php echo $currentScreen->parent_base; ?>&email_skip=true">Skip</a>
                        <input type="submit" class="account_activation" data-type="email" value="Next"><span id="loading"></span>
                    </div>
                </div>
                <?php }else{ ?>
                    <div class="api-form">
                        <div class="redi-body-form-inputs">
                            <?php if(!empty($this->ApiKey)){  ?>
                                <p><span><?php _e('Below is your API Key, please use it when you ask for a support. ', 'redi-restaurant-reservation'); ?></span></p>
                                <label for="api_key"><?php _e('API Key', 'redi-restaurant-reservation'); ?>*
                                    <input type="text" id="account_activation_key" name="api_key" placeholder="Key" value="<?php echo $this->ApiKey; ?>" disabled>
                                </label>
                            <?php }else{ ?>
                                <p><span><?php _e('Please provide your API Key in order to continue using plugin', 'redi-restaurant-reservation'); ?></span></p>
                                <label for="api_key"><?php _e('API Key', 'redi-restaurant-reservation'); ?>*
                                    <input type="text" id="account_activation_key" name="api_key" placeholder="Key">
                                </label>
                                <div class="error_validation_message"></div>
                            <?php } ?>
                        </div>
                        <div class="redi-body-button">
                            <input type="submit" class="account_activation" data-type="key" value="Next"><span id="loading"></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>    
    </div>
            
    <script>
    jQuery( document ).ready(function() {
        function removeParam(name, _url){
            var reg = new RegExp("((&)*" + name + "=([^&]*))","g");
            return _url.replace(reg,'');
        }

        jQuery(".account_activation").on("click", function() {
            jQuery(".error_validation_message").html('');
            jQuery("#loading").addClass('spinner_ctm');
            jQuery(this).prop('disabled','disabled');
            jQuery(".email_form_skip").css('cursor','not-allowed');
            let type = jQuery(this).data('type');
            let data = '';
            let consent = '';

            if (type == 'key'){
                data = jQuery("#account_activation_key").val();
                if(data == ''){
                    jQuery( ".error_validation_message" ).html("Api key should be a GUID number.");
                    jQuery(".account_activation").removeAttr('disabled');
                    jQuery("#loading").removeClass('spinner_ctm');
                    return true;
                }
                jQuery("#account_activation_email").val('');
            } else {
                data = jQuery("#account_activation_email").val();
                if(data == ''){
                    jQuery( ".error_validation_message" ).html("Email is required.");
                    jQuery(".account_activation").removeAttr('disabled');
                    jQuery("#loading").removeClass('spinner_ctm');
                    return true;
                }
                consent = jQuery("#consent-checkbox").prop('checked');
            }
            function isJSON (something) {
                if (typeof something != 'string')
                    something = JSON.stringify(something);

                try {
                    JSON.parse(something);
                    return true;
                } catch (e) {
                    return false;
                }
            }
            jQuery.post(ajaxurl, { action: "redi_restaurant-submit", get: "activationCheck", type: type, data: data, consentContact :consent, redi_plugin_nonce: "<?php echo wp_create_nonce('redi_restaurant_ajax') ?>" } , function(response) {
                jQuery("#loading").removeClass('spinner_ctm');
                if( isJSON(response) ){
                    var responseObj = JSON.parse(response);
                    var is_success = responseObj.success;
                }else{
                    var is_success = response;
                }
                if( is_success == "success") {
                    if(responseObj.type == 'email'){
                        if(document.location.href.indexOf('?') > -1) {
                            var url = document.location.href+"&api_key=true&email_skip=false";
                        }else{
                            var url = document.location.href+"?&api_key=true&email_skip=false";
                        }
                        document.location = url;
                    }else{
                        url = removeParam('api_key', document.location.href);
                        url = removeParam('email_skip', url);
                        url = url+"?&no_page=true";
                        window.location.href = url
                    } 

                } else {
                    jQuery(".error_validation_message" ).html(response);
                    jQuery(".account_activation").removeAttr('disabled');
                    
                }
            }).done(function () {
                jQuery(".email_form_skip").css('cursor','pointer');
            });
        });
    });
    </script>
</div>