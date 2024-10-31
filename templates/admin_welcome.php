<?php require_once(REDI_RESTAURANT_TEMPLATE. '../js/hotjar.js');?>

<div class="wrap" style="display: none;">
    <div><?php _e('You plugin is active. Your API Key is', 'redi-restaurant-reservation'); ?> <b><?php echo $this->ApiKey; ?></b></div>
</div>

<?php $admin_slug = 'redi-restaurant-reservation-settings' ?>
<div class="wrap">
    <div id="account_activation_container">
        <div class="account_activation_wrapper">
            <div class="redi-setting-header">
                <h3><?php _e('ReDi Reservation plugin:', 'redi-restaurant-reservation'); ?></h3>
            </div>
            <div class="redi-setting-body">
                <p><?php _e('ReDi restaurant reservation plugin is ready to use', 'redi-restaurant-reservation'); ?> </p>
                <p><?php _e('Your API key is :', 'redi-restaurant-reservation'); ?> <b><?php echo $this->ApiKey; ?></b> </p>

                <p><?php _e('Next step is to configure the plugin, please watch following videos and click on Next to open Settings page', 'redi-restaurant-reservation'); ?></p>
                <div>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/Gnw0qoFKbXE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/eGMjbIEo32Q" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <p><?php _e('Don\'t want to spend time delving into how the plugin works or figuring out the setup process? Sign up for a free personalized assistance call – our team is here to help you get started smoothly.', 'redi-restaurant-reservation'); ?></p>
                    <p><?php _e('To schedule your session, simply click the image below: We provide complimentary one-on-one assistance for plugin setup. You can book a call with us through Calendly or reach out to us via Skype, Facebook ir Whatsapp. Links are below.', 'redi-restaurant-reservation'); ?><br>
                    </p>
                    <p class="calendly_image"><a href="https://calendly.com/reservationdiary/demo?month=2023-04" target="_blank"><img style="width: 100px;" src="<?php echo esc_url(plugin_dir_url(__DIR__)."img/Consultation.png"); ?>" alt="<?php _e('Calendly', 'redi-restaurant-reservation'); ?>"></a>    
                    </p>
                    <div class="social_my_list">
                        <a href="skype:thecatkin?chat"><img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/skype.svg'); ?>" alt="<?php _e('skype', 'redi-restaurant-reservation'); ?>"></a>
                        <a href="https://www.facebook.com/ReDiReservation" target="_blank"><img src="<?php echo esc_url(plugin_dir_url(__DIR__)."img/facebook.svg"); ?>" alt="<?php _e('facebook', 'redi-restaurant-reservation'); ?>"></a>
                        <a href="https://wa.me/+3725165285" target="_blank"><img src="<?php echo esc_url(plugin_dir_url(__DIR__)."img/whatsapp.svg"); ?>" alt="<?php _e('whatsapp', 'redi-restaurant-reservation'); ?>"></a>
                    </div>
                    <p><?php _e("We're here to provide the support you need.", 'redi-restaurant-reservation') ?>
                    </p>

                    <div class="redi-body-button">
                        <a href="<?php echo get_admin_url( null, 'admin.php?page=redi-restaurant-reservation-settings'); ?>" >Next</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>