<?php require_once(REDI_RESTAURANT_TEMPLATE. '../js/hotjar.js');?>
<div class="wrap">
    <h3><?php _e('Welcome to the ReDi Restaurant Reservation plugin', 'redi-restaurant-reservation'); ?></h3>
    <div id="account_activation_container">
        <div class="account_activation_wrapper">
            <?php if( isset($_GET['no_page']) ){  ?>
                <div class="redi-setting-header">
                    <h3><?php _e(' Reservation page', 'redi-restaurant-reservation'); ?></h3>
                </div>
                <div class="redi-setting-body">
                    <div class="redi-body-form-inputs">
                        <p><span><?php _e('You can create dedicated reservation page below, or you can skip this step and create page manually. When you create page manually, insert [redireservation] shortcode to the page.', 'redi-restaurant-reservation'); ?></span></p>
                        <label for="reservation-page-input"><?php _e('Page name', 'redi-restaurant-reservation'); ?>*
                            <input type="text" name="reservation-page-input" id="reservation-page-create" placeholder="">
                        </label>
                        <div class="error_validation_message"></div>
                    </div>
                    <div class="redi-body-button">
                        <input type="submit" class="page_creation_res" data-type="page_skip" value="Skip">
                        <input type="submit" class="page_creation_res" data-type="page_create" value="Next">
                        <span id="loading"></span>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="api-form">
                    <div class="redi-body-form-inputs">
                        <?php if(!empty($this->ApiKey)){  ?>
                            <p><span><?php _e('Below is your API Key, please use it when you ask for a support. ', 'redi-restaurant-reservation'); ?></span></p>
                            <label for="api_key"><?php _e('API Key', 'redi-restaurant-reservation'); ?>
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
                        <a href="<?php echo esc_url(add_query_arg('no_page', 'true', esc_url_raw($_SERVER['REQUEST_URI']))); ?>" class="account_activation"><?php _e('Next', 'redi-restaurant-reservation'); ?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>    
</div>           
<script>
    jQuery(".page_creation_res").on("click", function() {
        jQuery(".error_validation_message").html('');
        jQuery("#loading").addClass('spinner_ctm');
        jQuery(this).prop('disabled','disabled');
        let type = jQuery(this).data('type');
        let data = '';
        let consent = '';

        data = jQuery("#reservation-page-create").val();
        if(data == '' && type == 'page_create'){
            jQuery( ".error_validation_message" ).html("Page name is required");
            jQuery(".page_creation_res").removeAttr('disabled');
            jQuery("#loading").removeClass('spinner_ctm');
            return true;
        }
    
        jQuery.post(ajaxurl, { action: "redi_restaurant-page_create", get: "createPageForReDiReservation", type: type, pagedata: data, redi_plugin_nonce: "<?php echo wp_create_nonce('redi_restaurant_ajax') ?>" } , function(response) {
                jQuery("#loading").removeClass('spinner_ctm');
                if(response == "success") {
                    location.reload();
                }else if(response == "page_skiped"){
                    location.reload();
                } else {
                    jQuery( ".error_validation_message" ).html(response);
                }
        }).done(function () {
            jQuery(".page_creation_res").removeAttr('disabled');
        });
    });
</script>
