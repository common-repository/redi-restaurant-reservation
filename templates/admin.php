<style type="text/css">
    .tab_wrap {
        background-color: #FFFFFF;
        border: 1px solid #CCCCCC;
        padding: 10px;
        min-width: 763px;
    }

    .redi_required {
        color: #DD0000;
    }

    .redi-admin-left {
        float: left;
        width: 68%;
    }

    .redi-admin-right {
        width: 30%;
        margin-top: 35px;
        float: right;
    }

    .postbox h3 {
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
        padding: 8px 12px;
    }

    .nav-tab-basic {
        background-color: #78DD88;
    }

    .nav-tab-basic:hover {
        background-color: #7FFF8E;
    }
</style>

<?php require_once(REDI_RESTAURANT_TEMPLATE. '../js/hotjar.js');?>

<script type="text/javascript">
    // Include the UserVoice JavaScript SDK (only needed once on a page)
    UserVoice = window.UserVoice || [];
    (function () {
        var uv = document.createElement('script');
        uv.type = 'text/javascript';
        uv.async = true;
        uv.src = '//widget.uservoice.com/gDfKlRGSIwZxjtqDE5rg.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(uv, s)
    })();
    UserVoice.push(['set', {locale: '<?php echo get_locale()?>'}]);
    UserVoice.push(['identify', {
        email: '<?php echo get_option('admin_email');?>',
        name: '<?php echo get_option('blogname');?>',
        type: 'ReDi Restaurant Reservation',
    }]);
    UserVoice.push(['addTrigger', {mode: 'smartvote', trigger_position: 'bottom-right'}]);

    var remainder_name = <?php echo wp_json_encode(__('Reminder', 'redi-restaurant-reservation')); ?>;
    var newsletter_name = <?php echo wp_json_encode(__('Newsletter', 'redi-restaurant-reservation')); ?>;
    var sms_confirmation_name = <?php echo wp_json_encode(__('SMS', 'redi-restaurant-reservation')); ?>;
    var whatsapp = <?php echo wp_json_encode(__('Whatsapp', 'redi-restaurant-reservation')); ?>;
    var gdpr_name = <?php echo wp_json_encode(__('Privacy policy', 'redi-restaurant-reservation')); ?>;
    var birthday_name = <?php echo wp_json_encode(__('Birthday', 'redi-restaurant-reservation')); ?>;
    var remainder_name_text = <?php echo wp_json_encode(__('Send me reservation reminder', 'redi-restaurant-reservation')); ?>;
    var newsletter_name_text = <?php echo wp_json_encode(__('Send me newsletter and promotions', 'redi-restaurant-reservation')); ?>;
    var sms_confirmation_name_text = <?php echo wp_json_encode(__('Allow to receive SMS', 'redi-restaurant-reservation')); ?>;
    var whatsapp_text = <?php echo wp_json_encode(__('Allow to contact via Whatsapp', 'redi-restaurant-reservation')); ?>;
    var gdpr_name_text = <?php echo wp_json_encode(__('I agree to the privacy policy', 'redi-restaurant-reservation')); ?>;
    var birthday_name_text = <?php echo wp_json_encode(__('Birthday (dd/mm)', 'redi-restaurant-reservation')); ?>;

    function prefill_name_and_text(field_name, field_text, type) {
        var name_field = jQuery('#' + field_name);
        var text_field = jQuery('#' + field_text);

        if (name_field.val() == '') {
            switch (type) {
                case 'reminder':
                    name_field.val(remainder_name);
                    text_field.val(remainder_name_text);
                    break;
                case'newsletter':
                    name_field.val(newsletter_name);
                    text_field.val(newsletter_name_text);
                    break;
                case 'allowsms':
                    name_field.val(sms_confirmation_name);
                    text_field.val(sms_confirmation_name_text);
                    break;
                case 'allowwhatsapp':
                    name_field.val(whatsapp);
                    text_field.val(whatsapp_text);
                    break;
                case 'gdpr':
                    name_field.val(gdpr_name);
                    text_field.val(gdpr_name_text);
                    break;
                case 'birthday':
                    name_field.val(birthday_name);
                    text_field.val(birthday_name_text);
                    break;
            }
        }
    }
    
    jQuery(document).on('click', '#key_edit', function () {
        if (jQuery("#form_key").is(":visible")) {
            jQuery("#form_key").hide();
        } else {
            jQuery("#form_key").show();
        }

    })
</script>
<?php $admin_slug = 'redi-restaurant-reservation-settings' ?>
<div class="wrap"><h2 style="display:none;"></h2></div>
<div class="wrap rr_setting_page">

    <?php if (get_option($this->_name . '_settings_saved') == false): ?>
        <div class="notice notice-warning"><p><?php _e('<strong>Attention</strong>: New settings are available for review and saving, please take a moment to update your preferences or fill out the required settings and click on the save button.', 'redi-restaurant-reservation') ?></p></div>    
    <?php endif ?>

    <a class="nav-tab <?php if (!isset($_GET['sm']) || (isset($_GET['sm']) && $_GET['sm'] == 'free')): ?> nav-tab-active<?php endif; ?>"
       href="admin.php?page=<?php echo $admin_slug ?>&amp;sm=free"><?php _e('Free package settings', 'redi-restaurant-reservation') ?></a>
    <a class="nav-tab <?php if ((isset($_GET['sm']) && $_GET['sm'] == 'cancel')): ?> nav-tab-active<?php endif; ?>"
       href="admin.php?page=<?php echo $admin_slug ?>&amp;sm=cancel"><?php _e('Cancel reservation', 'redi-restaurant-reservation') ?></a>
	<div class="redi-admin-parent">
    <?php if (!isset($_GET['sm']) || (isset($_GET['sm']) && $_GET['sm'] == 'free')): ?>
        <div class="redi-admin-right">

                        
            <div class="postbox">
                <h3><?php _e('Plugin Info', 'redi-restaurant-reservation') ?></h3>
                <div class="redi_admin_head">
                <div class="image">
                    <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/sergei1.jpg'); ?>" alt="<?php _e('sergei', 'redi-restaurant-reservation'); ?>">
                </div>
            </div>
            <div class="redi_admin_info">
                <h4><?php _e('Name', 'redi-restaurant-reservation') ?>: <?php _e('Redi Restaurant Reservation', 'redi-restaurant-reservation'); ?></h4>
                <p><?php _e('Version', 'redi-restaurant-reservation') ?>: <?php echo $this->version ?></p>
                <div class="text">
                    <ul>
                        <li>
                            <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/2692815.png'); ?>"><a target="_blank" href="https://www.facebook.com/ReDiReservation"><?php _e('News', 'redi-restaurant-reservation'); ?></a>
                        </li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/10111798.png'); ?>"><a target="_blank" href="https://www.youtube.com/channel/UCvMNupiAUT7enwnDhgrbKOg"><?php _e('Video tutorials', 'redi-restaurant-reservation'); ?></a>
                    </li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/2910760.png'); ?> "><a target="_blank" href="https://redi.atlassian.net/wiki/spaces/REDIPLUGINDOCS/overview"><?php _e('User guide', 'redi-restaurant-reservation'); ?></a></li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/2951114.png'); ?>"><a target="_blank" href="https://reservationdiary-wp-plugin.uservoice.com/clients/widgets/classic_widget?referrer=wordpress-redirestaurant-reservation-apikey-<?php echo $this->ApiKey; ?>#contact_us"><?php _e('Create a support ticket', 'redi-restaurant-reservation'); ?></a>
                    </li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/email.png'); ?>"><a target="_blank" href="mailto:info@reservationdiary.eu">info@reservationdiary.eu</a>
                    </li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/179338.png'); ?>"><a target="_blank" href="skype:thecatkin?chat">thecatkin</a>
                    </li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/mobile.png'); ?>"><a target="_blank" href="tel:+3725165285">+372 51 65 285 (10AM - 10PM UTC)</a>
                    </li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/2504845.png'); ?>"><a href="https://wa.me/+3725165285" target="_blank"> +372 51 65 285 (10AM - 10PM UTC)</a>
                    </li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/168810.png'); ?>"> <a href="https://profiles.wordpress.org/thecatkin/" target="_blank">Catkin</a> & <a href="https://profiles.wordpress.org/robbyroboter/" target="_blank">Robby Roboter</a>
                    </li>
                    <li>
                        <img src="<?php echo esc_url(plugin_dir_url(__DIR__).'img/rate.png'); ?>"> <a href="https://wordpress.org/support/plugin/redi-restaurant-reservation/reviews/" target="_blank"><?php _e('Rate the plugin, help us grow', 'redi-restaurant-reservation');?></a>
                    </li>
                </ul>
                </div>
            </div>
            </div>
        </div>
    <?php endif ?>
    <div class="tab_wrap <?php echo isset($_GET['sm']) ? htmlspecialchars($_GET['sm']) : ""; if (!isset($_GET['sm']) || (isset($_GET['sm']) && $_GET['sm'] == 'free')): ?>redi-admin-left<?php endif ?>">

        <?php if (isset($settings_saved) && $settings_saved): ?>
            <div class="updated" id="message">
                <p>
                    <?php _e('Your settings have been saved!', 'redi-restaurant-reservation') ?>
                </p>
            </div>
        <?php endif ?>
        <?php if (isset($cancel_success) && !empty($cancel_success)): ?>
            <div class="updated">
                <p>
                    <?php echo $cancel_success; ?>
                </p>
            </div>
        <?php endif; ?>
        <?php if (isset($errors)): ?>
            <?php foreach ((array)$errors as $error): ?>
                <div class="error">
                    <p>
                        <?php echo $error; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif ?>

        <?php if (!isset($_GET['sm']) || (isset($_GET['sm']) && $_GET['sm'] == 'free')): ?>
            <form name="redi-restaurant" method="post" id="redi-setting-form">
            <input type="hidden" name="redi_plugin_nonce" value="<?php echo wp_create_nonce('redi_restaurant_ajax') ?>" />
            <div class="icon32" id="icon-admin"><br></div>
            <div>
            <h2><?php _e('Data Input Appearance', 'redi-restaurant-reservation'); ?></h2>
        </div>
            <p><a href="javascript:;" data-id="sGzJlJrxhtk" class="button-primary1 redi_video_btn"><?php _e("Video Tutorial", "redi-restaurant-reservation") ?></a></p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/sGzJlJrxhtk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display:none;"></iframe>

                <table class="form-table redi_data_input_table">
                <tr>
                        <th scope="row">
                            <label for="EnableCancelForm">
                                <?php _e('Enable cancel form', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="EnableCancelForm" id="EnableCancelForm"
                                   value="1" <?php if (isset($EnableCancelForm) && $EnableCancelForm) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Enable or Disable reservation cancel form.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="EnableModifyReservations">
                                <?php _e('Enable modify reservations', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="EnableModifyReservations" id="EnableModifyReservations"
                                   value="1" <?php if (isset($EnableModifyReservations) && $EnableModifyReservations) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Enable or Disable modify reservation.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="userfeedback">
                                <?php _e('Collect user experience feedback', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="userfeedback" id="userfeedback"
                                   value="true" <?php checked( $userfeedback, 'true' , true); ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('The enabled feedback collection option allows users of the reservation form to provide valuable input for improving the plugin. By keeping this option enabled, you can continuously enhance the plugin based on user feedback, ensuring an exceptional reservation experience for restaurant visitors.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
					<tr>
                        <th scope="row">
                            <label for="EnableSocialLogin">
                                <?php _e('Enable social network login', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="EnableSocialLogin" id="EnableSocialLogin"
                                   value="1" <?php if (isset($EnableSocialLogin) && $EnableSocialLogin) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Enable or Disable social network account login. When enabled clients can login with any social network accounts like Facebook and then reservation form will be pre-filled with personal information. Also if user logins with social network but does not complete the reservation, he will receive a reminder to finalize it. You need to install and setup plugin with name \'Super Socializer\' from WordPress directory.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>



                <tr style="width: 250px">
                        <th scope="row">
                            <label for="Calendar">
                                <?php _e('Calendar type', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="Calendar">
                                <option value="show"
                                        <?php if ($calendar === 'show'): ?>selected="selected"<?php endif; ?>>Always
                                    show
                                </option>
                                <option value="hide"
                                        <?php if ($calendar === 'hide'): ?>selected="selected"<?php endif; ?>>Shown on
                                    click
                                </option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('This field lets you select the style in which the calendar control is displayed. It can be either "Show on click" or "Always show”.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('Shown on click', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('Selecting this option, the calendar is set to popup when the user clicks the calendar control.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('Always show', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('This option sets the calendar control to display all the time.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr style="vertical-align:top">

<th style="width:15%;">
    <label for="DateFormat">
        <?php _e('Date format', 'redi-restaurant-reservation'); ?>
    </label>
</th>
<td>
    <select id="DateFormat" name="DateFormat">
        <optgroup label="<?php _e('Hyphen', 'redi-restaurant-reservation'); ?>">
            <option <?php if ($place->DateFormat == 'yyyy-MM-dd'): ?> selected="selected" <?php endif ?> value="yyyy-MM-dd">yyyy-mm-dd</option>
            <option <?php if ($place->DateFormat == 'MM-dd-yyyy'): ?> selected="selected" <?php endif ?> value="MM-dd-yyyy">mm-dd-yyyy</option>
            <option <?php if ($place->DateFormat == 'dd-MM-yyyy'): ?> selected="selected" <?php endif ?> value="dd-MM-yyyy">dd-mm-yyyy</option>
        </optgroup>
        <optgroup label="<?php _e('Dot', 'redi-restaurant-reservation'); ?>">
            <option <?php if ($place->DateFormat == 'yyyy.MM.dd'): ?> selected="selected" <?php endif ?> value="yyyy.MM.dd">yyyy.mm.dd</option>
            <option <?php if ($place->DateFormat == 'MM.dd.yyyy'): ?> selected="selected" <?php endif ?> value="MM.dd.yyyy">mm.dd.yyyy</option>
            <option <?php if ($place->DateFormat == 'dd.MM.yyyy'): ?> selected="selected" <?php endif ?> value="dd.MM.yyyy">dd.mm.yyyy</option>
        </optgroup>
        <optgroup label="<?php _e('Slash', 'redi-restaurant-reservation'); ?>">
            <option <?php if ($place->DateFormat == 'yyyy/MM/dd'): ?> selected="selected" <?php endif ?> value="yyyy/MM/dd">yyyy/mm/dd</option>
            <option <?php if ($place->DateFormat == 'MM/dd/yyyy'): ?> selected="selected" <?php endif ?> value="MM/dd/yyyy">mm/dd/yyyy</option>
            <option <?php if ($place->DateFormat == 'dd/MM/yyyy'): ?> selected="selected" <?php endif ?> value="dd/MM/yyyy">dd/mm/yyyy</option>
        </optgroup>
    </select>
</td>
<td>
    <p class="description">
        <?php _e('The way date format is displayed on the date control. You can select from a drop down list of different date formats.', 'redi-restaurant-reservation'); ?>
    </p>
</td>
</tr>
                <?php if ($newInstallation === 'no'): ?>
                    <tr>
                        <th scope="row">
                            <label for="TimePicker">
                                <?php _e('TimePicker type', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="TimePicker">
                                <option value="plugin"
                                        <?php if ($timepicker === 'plugin'): ?>selected="selected" <?php endif; ?>>
                                    jQuery plugin
                                </option>
                                <option value="dropdown"
                                        <?php if ($timepicker === 'dropdown'): ?>selected="selected" <?php endif; ?>>
                                    dropdown
                                </option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('This field lets you select the way time picker is displayed. You can choose from "jQuery plugin" and "HTML dropdown".', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('jQuery plugin', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('Time picker type if selected to be jQuery plugin, it is set to pop up with the hour and time.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('HTML dropdown', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('With this option selected, the Time Picker is shown to be simple dropdown for selecting the hour and time.', 'redi-restaurant-reservation'); ?>

                            </p>
                        </td>
                    </tr>
                <?php endif; ?>

                    <tr style="vertical-align:top">
                        <th scope="row" style="width:25%;">
                            <label for="MinPersons"><?php _e('Min persons per reservation', 'redi-restaurant-reservation'); ?> </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="MinPersons" id="MinPersons">
                                <?php foreach (range(1, 10) as $current): ?>
                                    <option value="<?php echo $current ?>"
                                            <?php if ($current == $minPersons): ?>selected="selected"<?php endif; ?>>
                                        <?php echo $current ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Minimum number of persons allowed for each reservation. Drop down list of persons starts from this number.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>
                    <tr style="vertical-align:top">
                        <th scope="row" style="width:15%;">
                            <label for="MaxPersons"><?php _e('Max persons per reservation', 'redi-restaurant-reservation'); ?> </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="MaxPersons" id="MaxPersons">
                                <?php foreach (range(1, 500) as $current): ?>
                                    <option value="<?php echo $current ?>"
                                            <?php if ($current == $maxPersons): ?>selected="selected"<?php endif; ?>>
                                        <?php echo $current ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Maximum number of persons allowed for each reservation. Drop down list of persons ends with this number.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row" style="width:25%;">
                            <label for="LargeGroupsMessage">
                                <?php _e('Message for large groups', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <textarea maxlength="250" name="LargeGroupsMessage" id="LargeGroupsMessage" rows="5"
                                      cols="40"><?php echo $largeGroupsMessage ?></textarea>
                        </td>
                        <td style="width:75%; vertical-align: top;">
                            <p class="description">
                                <?php _e('If this field is filled, the drop down menu of persons would show "Large Groups" and upon selection, the specified message would appear.', 'redi-restaurant-reservation'); ?>
                                <?php _e('In case you need to show it in multiple languages, then use following format [lang]Text[/lang]. Example: [en]Text[/en][es]Texto[/es]', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
	                <tr>
                        <th scope="row" style="width:25%;">
                            <label for="ChildrenSelection"><?php _e('Сhildren selection', 'redi-restaurant-reservation'); ?> </label>
                        </th>
                        <td>
                            <input type="checkbox" name="ChildrenSelection" id="ChildrenSelection"
                                   value="1" <?php if (isset($childrenSelection) && $childrenSelection) echo 'checked="checked"' ?>>	
                        </td>
                        <td>
                            <p class="description">
                                <?php _e('Enable/Disable children dropdown', 'redi-restaurant-reservation');?>
                            </p>
                        </td>
                    </tr>					
					<tr>
						<th></th>
						<td>
							<input id="ChildrenDescription" type="text" value="<?php echo $childrenDescription ?>" name="ChildrenDescription"/>
						</td>
						<td>
                            <p class="description">
                                <?php _e('Description for children dropdown', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
					</tr>
                </table>

                    <h2><?php _e('Available Time Appearance', 'redi-restaurant-reservation'); ?></h2>
                    <p><a href="javascript:;" data-id="5M2DKmB1pmQ" class="button-primary1 redi_video_btn"><?php _e("Video Tutorial", "redi-restaurant-reservation") ?></a></p>
                    <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/5M2DKmB1pmQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                    
                    <table class="form-table redi_available_time_table">

                    <tr style="width: 250px">
                        <th scope="row">
                                <?php _e('Time format', 'redi-restaurant-reservation'); ?>
                        </th>
                        <td style="vertical-align: top;">

                        <?php echo current_time(get_option('time_format')) ?>

                    </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('This is how the available time will be shown. This setting is taken from generic WordPress settings. You can change it in Settings -> General -> Time Format', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>

                    <?php if ($newInstallation === 'no'): ?>
                    <tr style="width: 250px">
                        <th scope="row">
                            <label for="TimeShiftMode">
                                <?php _e('TimeShift Mode', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="TimeShiftMode">
                                <option value="normal"
                                        <?php if ($timeshiftmode === 'normal'): ?>selected="selected"<?php endif; ?>>
                                    normal
                                </option>
                                <option value="byshifts"
                                        <?php if ($timeshiftmode === 'byshifts'): ?>selected="selected"<?php endif; ?>>
                                    byshifts
                                </option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Mode how available working hours presented to user so that they can choose time slots most convenient to them.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('Normal', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('In this mode, the user selects the desired time and the system verifies its availability to present five different alternative times to the customer.', 'redi-restaurant-reservation'); ?>
                                <br/>
                                <b><?php _e('By shifts', 'redi-restaurant-reservation'); ?></b>
                                – <?php _e('In this mode, the system automatically displays all the available times for the date selected without any manual time input.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <?php endif; ?>

					<!--- show end reservation time starts -->
                    <tr style="width: 250px">
                        <th scope="row">
                            <label for="EndReservationTime">
                                <?php _e('Show end reservation time', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                           
							 <input type="checkbox" name="EndReservationTime" id="EndReservationTime"
                                   value="true"  <?php checked( $endreservationtime, 'true' , true); ?> >
								
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('When this enabled, start and end of reservation time will be displayed. This is useful when you want to inform the guest about fixed reservation time frame.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>  
					<!--- show end reservation time ends -->
					<tr>
						<th scope="row">
							<label for="DisplayLeftSeats">
								<?php _e('Display left seats', 'redi-restaurant-reservation'); ?>
							</label>
						</th>
						<td style="vertical-align: top;">
							<input type="checkbox" name="DisplayLeftSeats" id="DisplayLeftSeats" value="1" <?php if (isset($displayLeftSeats) && $displayLeftSeats) echo 'checked="checked"' ?>>
						</td>
						<td style="width:75%">
							<p class="description">
								<?php _e('If checkbox is checked then seats left will be shown under selected time.', 'redi-restaurant-reservation'); ?>
							</p>
						</td>
					</tr>
                    <tr>
                        <th scope="row">
                            <label for="AlternativeTimeStep">
                                <?php _e('Alternative time step', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="AlternativeTimeStep">
                                 <option value="10"
                                        <?php 
                                        // Translators: %d is the number of minutes for the time step option in the dropdown menu
                                        if ($alternativeTimeStep == 10): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 10); ?></option>
                                <option value="15"
                                <?php 
                                        // Translators: %d is the number of minutes for the time step option in the dropdown menu
                                         if ($alternativeTimeStep == 15): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 15); ?></option>
                                <option value="20"
                                <?php 
                                        // Translators: %d is the number of minutes for the time step option in the dropdown menu
                                         if ($alternativeTimeStep == 20): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 20); ?></option>
                                <option value="30"
                                <?php 
                                        // Translators: %d is the number of minutes for the time step option in the dropdown menu
                                         if ($alternativeTimeStep == 30): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 30); ?></option>
                                <option value="60"
                                <?php 
                                        // Translators: %d is the number of minutes for the time step option in the dropdown menu
                                         if ($alternativeTimeStep == 60): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 60); ?></option>
                                <option value="90"
                                <?php 
                                        // Translators: %d is the number of minutes for the time step option in the dropdown menu
                                         if ($alternativeTimeStep == 90): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 90); ?></option>
                                <option value="120"
                                <?php 
                                        // Translators: %d is the number of minutes for the time step option in the dropdown menu
                                         if ($alternativeTimeStep == 120): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 120); ?></option>
								<option value="180"
                                <?php 
                                        // Translators: %d is the number of minutes for the time step option in the dropdown menu
                                         if ($alternativeTimeStep == 180): ?>selected="selected" <?php endif; ?>><?php printf(__('%d min', 'redi-restaurant-reservation'), 180); ?></option>		
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Displays the available time with time step to the clients. For instance, if one selects 15 min time step, then alternative time will be 10:00, 10:15, 10:30, etc.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="FullyBookedMessage">
                                <?php _e('Override fully booked message text', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
							<textarea maxlength="250" name="FullyBookedMessage" id="FullyBookedMessage" rows="5"
                                      cols="40"><?php echo $fullyBookedMessage ?></textarea>	
                        </td>
                        <td style="width:75%; vertical-align: top;">
                            <p class="description">
                                <?php _e('Text that will be displayed when there are no available time for selected day/time.', 'redi-restaurant-reservation'); ?>
                                <?php _e('In case you need to show it in multiple languages, then use following format [lang]Text[/lang]. Example: [en]Text[/en][es]Texto[/es]', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="WaitList">
                                <?php _e('Wait List', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="WaitList" id="WaitList"
                                   value="1" <?php if (isset($waitlist) && $waitlist) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('When this option is enabled, guest will have an opportunity to fill out Wait List form in case it\'s fully booked. Then if someone cancels reservation, this guest can be contacted and offered a reservation.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>


                                        </table>

                    <h2><?php _e('Reservation Form settings', 'redi-restaurant-reservation'); ?></h2>
                    <p><a href="javascript:;" data-id="_fhxq-RshgU" class="button-primary1 redi_video_btn"><?php _e("Video Tutorial", "redi-restaurant-reservation") ?></a></p>
                    <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/_fhxq-RshgU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                    <table class="form-table redi_reservation_form_table">


					<!--- first/last name starts -->
                    <tr style="width: 250px">
                        <th scope="row">
                            <label for="EnableFirstLastName">
                                <?php _e('Collect First and Last name', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">                         
							
							  <input type="checkbox" name="EnableFirstLastName" id="EnableFirstLastName"
                                   value="true"  <?php checked( $enablefirstlastname, 'true' , true); ?> >
								   
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('When this option is enabled, then guest has to provide first and last name separately when filling reservation form. Otherwise Name is collected in a single field.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>  
					<!--- first/last name ends -->
					<!--- phone number with country code starts -->
                    <tr style="width: 250px">
                        <th scope="row">
                            <label for="CountryCode">
                                <?php _e('Collect phone number with country code', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
							 <input type="checkbox" name="CountryCode" id="CountryCode"
                                   value="true"  <?php checked( $countrycode, 'true' , true); ?> >
								
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('When enabled guests has to enter their phone number with country code. This is most useful when there is a good amount of foreign visitors. Also this option has to be enabled when SMS addon is in use, as SMS Providers requires full phone number.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>  
					<!--- phone number with country code ends -->
					<tr>
                        <th scope="row">
                            <label for="Captcha">
                                <?php _e('Captcha', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="Captcha" id="Captcha"
                                   value="1" <?php if (isset($captcha) && $captcha) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Enable/Disable captcha on reservation form.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
					<tr>
						<th scope="row">
                        <label for="CaptchaKey">
                                <?php _e('Captcha key', 'redi-restaurant-reservation'); ?>
                            </label>

                        </th>
						<td>
							<input id="CaptchaKey" type="text" value="<?php echo $captchaKey ?>" name="CaptchaKey"/>
						</td>
						<td>
                            <p class="description">
                                <?php _e('Obtain your captcha key from Google.', 'redi-restaurant-reservation'); ?> <a target='_blank' href='https://www.google.com/recaptcha/admin/create'><?php _e('Visit Google site', 'redi-restaurant-reservation'); ?></a>
                            </p>
                        </td>
					</tr>

                    <tr>
						<th scope="row">
                        <label for="MandatoryCancellationReason">
                                <?php _e('Mandatory Cancellation Reason', 'redi-restaurant-reservation'); ?>
                            </label>

                        </th>
						<td>
                            <input type="checkbox" name="MandatoryCancellationReason" id="MandatoryCancellationReason"
                                   value="1" <?php if (isset($mandatoryCancellationReason) && $mandatoryCancellationReason) echo 'checked="checked"' ?>>						
                                </td>
						<td>
                            <p class="description">
                                <?php _e('Force users to provide a reason when canceling reservation.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
					</tr>


                    </table>

<h2><?php _e('Reservation settings', 'redi-restaurant-reservation'); ?></h2>
                    <p><a href="javascript:;" data-id="qowhT46dQgg" class="button-primary1 redi_video_btn"><?php _e("Video Tutorial", "redi-restaurant-reservation") ?></a></p>
                    <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/qowhT46dQgg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->

                    <table class="form-table redi_reservation_settings_tbl">

<tr>
                        <th scope="row">
                                <?php _e('Current time', 'redi-restaurant-reservation'); ?>
                        </td>
                        <td style="vertical-align: top;">
                        <?php echo current_time(get_option('date_format')) . ' ' .  current_time(get_option('time_format')) ?>

                    </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Please verify you current time. This is important as this time is taken and used in reservation logic. In case time is differnet than your current time, please change time zone in Settings -> General -> Time Zone', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="ManualReservation">
                                <?php _e('Manual reservation', 'redi-restaurant-reservation'); ?>
                            </label>
                        </td>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="ManualReservation" id="ManualReservation"
                                   value="1" <?php if (isset($manualReservation) && $manualReservation) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('If checkbox is checked then reservations will not be automatically confirmed. You will receive email with reservation request and each reservation needs to be confirmed or rejected manually.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="EmailFrom">
                                <?php _e('Send confirmation email to client', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <select name="EmailFrom">
                                <option value="ReDi"
                                        <?php if ($emailFrom == ReDiSendEmailFromOptions::ReDi): ?>selected="selected" <?php endif; ?>><?php _e('From ReservationDiary.eu', 'redi-restaurant-reservation'); ?></option>
                                <option value="CustomSMTP"
                                        <?php if ($emailFrom == ReDiSendEmailFromOptions::CustomSMTP): ?>selected="selected" <?php endif; ?>><?php _e('From Custom SMTP', 'redi-restaurant-reservation'); ?></option>
                                <option value="WordPress"
                                        <?php if ($emailFrom == ReDiSendEmailFromOptions::WordPress): ?>selected="selected" <?php endif; ?>><?php _e('From WordPress email account', 'redi-restaurant-reservation'); ?></option>
                                <option value="Disabled"
                                        <?php if ($emailFrom == ReDiSendEmailFromOptions::Disabled): ?>selected="selected" <?php endif; ?>><?php _e('Disable confirmation email', 'redi-restaurant-reservation'); ?></option>
                            </select>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('The way you want confirmation email to be delivered to the client. It can be "From WordPress email account", "From reservationdiary.eu", "Custom SMTP" or "Disable confirmation email".', 'redi-restaurant-reservation') ?>
                                <br/>
                                <b><?php _e('From WordPress email account', 'redi-restaurant-reservation') ?></b>
                                - <?php _e('The confirmation email will be sent out from your email set in WordPress.', 'redi-restaurant-reservation') ?>
                                <br/>
                                <b><?php _e('From Custom SMTP', 'redi-restaurant-reservation') ?></b>
                                - <?php _e('Emails will be sent via SMTP server that is configured in Basic settings.', 'redi-restaurant-reservation') ?>                                
                                <br/>
                                <b><?php _e('From ReservationDiary.eu', 'redi-restaurant-reservation') ?></b>
                                - <?php _e('The confirmation email will be sent out from info@reservationdiary.eu. When the client replies to confirmation email, you will receive it.', 'redi-restaurant-reservation') ?>
                                <br/>
                                <b><?php _e('Disable confirmation email', 'redi-restaurant-reservation') ?></b>
                                - <?php _e('With this option, confirmation email is not sent to the client.', 'redi-restaurant-reservation') ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                        <label for="ConfirmationPage">
                                <?php _e('Confirmation page', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;"><?php 
                        $dropdown_args = array(
                            'show_option_none' => 'Please select a page',
                            'name' => 'ConfirmationPage',
                            'selected' => $confirmationPage
                        );
                        wp_dropdown_pages($dropdown_args); ?></td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('If you want to customize confirmation page or have a separated page for marketing purposes, then select custom reservation confirmation page. If not specified, then built in confirmation page will be used.', 'redi-restaurant-reservation') ?>
                                <?php _e('In order to display reservation id on that page, install plugin GET Params and add following short code: [display-get-param name="reservation_id"]', 'redi-restaurant-reservation') ?></p>
                        </td>
                    </tr>
                </table>
                <br/>
                <div class="icon32" id="icon-admin"><br></div>
            <div>
                <h2><?php _e('Frontend settings', 'redi-restaurant-reservation'); ?></h2></div>
                <p><a href="javascript:;" data-id="DRg3p_ebd5U" class="button-primary1 redi_video_btn"><?php _e("Video Tutorial", "redi-restaurant-reservation") ?></a></p>
                <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/DRg3p_ebd5U" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                <table class="form-table redi_frontend_settings">
                <tr style="width: 250px">
                        <th scope="row">
                            <label for="Hidesteps">
                                <?php _e('Hide steps', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                             <input type="checkbox" name="Hidesteps" id="Hidesteps"
                             value="1" <?php if (isset($hidesteps) && $hidesteps) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('Hide previous steps (only for timeshiftmode byshifts)', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="Thanks">
                                <?php _e('Support us', 'redi-restaurant-reservation'); ?>
                            </label>
                        </th>
                        <td style="vertical-align: top;">
                            <input type="checkbox" name="Thanks" id="Thanks"
                                   value="1" <?php if (isset($thanks) && $thanks) echo 'checked="checked"' ?>>
                        </td>
                        <td style="width:75%">
                            <p class="description">
                                <?php _e('If checkbox is checked, a logo of <b>"Powered by ReservationDiary.eu"</b> is displayed. Thank you for supporting us.', 'redi-restaurant-reservation'); ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <div class="icon32" id="icon-admin"><br></div>
                <div>
                <h2><?php _e('Localization', 'redi-restaurant-reservation'); ?></h2>
                </div>
                <p><a href="javascript:;" data-id="OTRZHOUWzCg" class="button-primary1 redi_video_btn"><?php _e("Video Tutorial", "redi-restaurant-reservation") ?></a></p>
                <table class="form-table redi_restaurant_tab">
                    <tbody>
                        <tr>
                            <th>
                                <label for="lang_path">
                                    <?php 
                                        _e('Language Path', 'redi-restaurant-reservation'); 
                                        $lang_path = $this->GetOption('lang_path', '');
                                    ?>
                                </label>
                            </th>
                            <td>
                                <span>/uploads/redi-translate/</span><input type="text" name="lang_path" id="lang_path" placeholder="" value="<?php echo (isset($lang_path) && !empty($lang_path)) ? $lang_path : '' ; ?>">
                            </td>
                            <td>
                                <p class="description">
                                    <?php _e('When translating the plugin, save translations in a separate folder outside the plugin directory. Then, provide the file path with translated strings in this setting to avoid issues with updates.', 'redi-restaurant-reservation'); ?><br/>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <iframe width="560" height="315" src="https://www.youtube.com/embed/OTRZHOUWzCg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                <br/>
                <div id="ajaxed">
                    <?php self::ajaxed_admin_page($placeID, $categoryID, $settings_saved); ?>
                </div>

                <div>
                <input type="hidden" name="action" />
                <input class="button-save" id="submit" type="submit"
                       value="<?php _e('Save Changes', 'redi-restaurant-reservation') ?>" name="submit">
            </form>
        <?php elseif ((isset($_GET['sm']) && $_GET['sm'] == 'cancel')): ?>
            <div id="icon-admin" class="icon32">
                <br>
            </div>

            <h2><?php _e('Cancel reservation', 'redi-restaurant-reservation'); ?></h2>
            <form id="redi-reservation-cancel" name="redi-reservation-cancel" method="post">
                <input type="hidden" name="action" value="cancel"/>
                <input type="hidden" name="redi_plugin_nonce" value="<?php echo wp_create_nonce('redi_restaurant_ajax') ?>" />

                <br/>
                <label for="redi-restaurant-cancel-id"><?php _e('Reservation number', 'redi-restaurant-reservation') ?>:<span
                            class="redi_required">*</span></label><br/>
                <input type="text" value="" name="id" id="redi-restaurant-cancel-id"/>
                <br/>
                <label for="redi-restaurant-cancel-reason"><?php _e('Reason', 'redi-restaurant-reservation') ?>:</label><br/>
                <textarea maxlength="250" name="reason" id="redi-restaurant-cancel-reason" rows="5"
                          cols="60"></textarea>
                <br/>
                <br/>
                <input class="button-secondary" type="submit" name="cancelReservation"
                       value="<?php _e('Cancel reservation', 'redi-restaurant-reservation') ?>">
            </form>
        <?php endif ?>
    </div>
</div>
</div>

<br/>
<br/>
<br/>

<div class="redi_video_modal" style="display:none;">
    <div class="redi_video_modal_dialog">
        <div class="video_modal_body">
            <span class="close">✖</span>
            <iframe height="400" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>