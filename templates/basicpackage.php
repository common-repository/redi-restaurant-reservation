<div style="clear:both"></div>
<div class="wrap">
    <div class="redi_box">
        <h2><?php _e('Api Information', 'redi-restaurant-reservation'); ?></h2>
        <h3><?php _e('ApiKey', 'redi-restaurant-reservation'); ?>:</h3>
        <b><i><?php echo($this->ApiKey); ?></i></b></br>
        <br/>
        <input value="<?php _e('Change API key', 'redi-restaurant-reservation'); ?>" class="button-primary1" id="key_edit" type="submit">
        <br/>
        <form method="post" id="form_key" style="display: none"><input type="hidden" name="action">
            <input id="new_key" type="text" name="new_key">
            <input type="hidden" name="redi_plugin_nonce" value="<?php echo wp_create_nonce('redi_restaurant_ajax') ?>" />
            <input value="<?php _e('Change', 'redi-restaurant-reservation'); ?>" class="button-primary1" id="key_edit" type="submit">
        </form>
        <br/>
        <?php _e('This is your registration key. Please use it when you send request for support.', 'redi-restaurant-reservation'); ?>
        <br/>
    </div>
    <div class="redi_box">
        <h2><?php _e('Contact Us', 'redi-restaurant-reservation'); ?></h2>
        <p><?php _e('Are you facing trouble configuring the plugin? Don\'t worry! We offer free personal assistance to help you out. You can schedule a session with us using Calendly or reach out to us via Skype, WhatsApp, or Facebook. We\'re here to provide the support you need.', 'redi-restaurant-reservation') ?></p>
        <p class="calendly_image"><a href="https://calendly.com/reservationdiary/demo?month=2023-04" target="_blank"><img style="width: 100px;" src="<?php echo esc_url(plugin_dir_url(__DIR__)."img/Consultation.png"); ?>" alt="<?php _e('Calendly', 'redi-restaurant-reservation'); ?>"></a>    
        </p>
        <div class="social_my_list">
    			<a href="skype:thecatkin?chat"><img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/skype.svg'); ?>" alt="<?php _e('skype', 'redi-restaurant-reservation'); ?>"></a>
                <a href="https://www.facebook.com/ReDiReservation" target="_blank"><img src="<?php echo esc_url(plugin_dir_url(__DIR__)."img/facebook.svg"); ?>" alt="<?php _e('facebook', 'redi-restaurant-reservation'); ?>"></a>
                <a href="https://wa.me/+3725165285" target="_blank"><img src="<?php echo esc_url(plugin_dir_url(__DIR__)."img/whatsapp.svg"); ?>" alt="<?php _e('whatsapp', 'redi-restaurant-reservation'); ?>"></a>
        </div>
        <p>
    		<a target="_blank" href="https://reservationdiary-wp-plugin.uservoice.com/clients/widgets/classic_widget?referrer=wordpress-redirestaurant-reservation-apikey-56a3263a-41e6-4d97-aba2-fded1c329091#contact_us" class="button-primary1"><?php _e('Submit an issue or suggest a feature', 'redi-restaurant-reservation') ?></a>
    	</p>
    </div>
    <div class="redi_box">
        <h2><?php _e('Basic package functionality (paid version)', 'redi-restaurant-reservation'); ?></h2>
        <p class="description">
            ◾ <?php _e('View your upcoming reservations from your Mobile/Tablet PC and never miss your customer. This page should be open on a Tablet PC and so hostess can see all upcoming reservations for today. Page refreshes every 15 min and shows reservations that in past for 3 hours as well as upcoming reservations for next 24 hours. By clicking on reservation you will see reservation details. Demo version can be accessed for 30 days using this link: ', 'redi-restaurant-reservation'); ?>
            <a href="http://upcoming.reservationdiary.eu/Entry/<?php echo $this->ApiKey ?>"
               target="_blank"><?php _e('Open upcoming reservations', 'redi-restaurant-reservation'); ?></a><br/>
            ◾ <?php _e('Setup maximum available seats for online reservation by week day', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Open times. This option will enable you to choose between various working hours whichever is most convenient to you.', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Support for multiple places. Number of places depends on number of subscriptions.', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Blocked Time. Define time range when online reservation should not be accepted. Specify a reason why reservations are not accepted at this time to keep your clients happy.', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Send client reservation confirmation emails from WordPress account.', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Email template customization for all supported languages.', 'redi-restaurant-reservation'); ?><br/>
        </p>
        <?php _e('Basic package price is 19 EUR per month per place. To subscribe please use following PayPal link:') ?>
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=R2KJQFCXB7EMN&item_name=ReDi Restaurant Reservation subscription fee, Api Key: <?php echo($this->ApiKey); ?>"
           target="_blank"><?php _e('Subscribe to basic package') ?></a><br/>
        <?php _e('Please allow 1 business day for us to confirm your payment and upgrade your account.', 'redi-restaurant-reservation'); ?>
        
    </div>
    <div class="redi_box">
        <h2><?php _e('Additional services (by request)', 'redi-restaurant-reservation'); ?></h2>
        <p class="description">
            ◾ <?php _e('We can offer you white labeled restaurant reservation application for Facebook Application, iPhone/iPad Application, Windows Phone Application or Android Application.', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Enhance your business experience by using our Facebook integration service where we try to provide you with profile pictures of your customers if found. You can amaze your customer by knowing him by face when he visits you, especially at the time of first visit.', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Do you want to know what your client thinks about his last visit? We will collect it for you.', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Remind your customer about upcoming reservation via Email or by SMS', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Collect pre-payment for reservations.', 'redi-restaurant-reservation'); ?><br/>
            ◾ <?php _e('If you are building a catalogue of restaurants and looking for the perfect reservation plugin for it, we can provide it to you.', 'redi-restaurant-reservation'); ?>
            <br/>
            ◾ <?php _e('Do you want to write your own module? We have an API. Contact us to get more information.', 'redi-restaurant-reservation'); ?>
            <br/>
        </p>
        <?php _e('If you would like to add some new functionality or have any other queries, please contact us by email: ', 'redi-restaurant-reservation'); ?>
        <a href="mailto:info@reservationdiary.eu">info@reservationdiary.eu</a><br/>
    </div>
</div>