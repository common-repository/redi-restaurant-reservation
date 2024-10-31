<?php

if (!class_exists('ReDiNotice')) {

    class ReDiNotice
    {
        function show_notices($inst)
        {
            global $wpdb;

            $reservation_results = [];

            // Prepare a query to check if the table exists
            $table_name = $wpdb->prefix . $inst->table_name;
            $check_table_query = $wpdb->prepare("SHOW TABLES LIKE %s", $table_name);
            $table_exists = $wpdb->get_var($check_table_query);

            if ($table_exists === $table_name) {
                // Prepare a query to fetch results from the table
                $select_query = "SELECT * FROM {$table_name} LIMIT 1";
                $reservation_results = $wpdb->get_results($select_query);
            }

            // If there are reservations, all is good
            if (!empty($reservation_results)) {
                return;
            }

            // don't show while on wizard
            if (isset($_GET["page"]) && $_GET["page"] == "redi-restaurant-reservation-reservations") {
                return;
            }

            if (empty($inst->ApiKey)) {
                add_action('admin_notices', array($this, 'redi_admin_notice_finilize_wizard_no_api_key'));
            } else if (get_option($inst->_name . '_page_skip') == false && empty(get_option($inst->_name . '_page_title'))) {
                add_action('admin_notices', array($this, 'redi_admin_notice_finilize_wizard_page_not_defined'));
            } else if (get_option($inst->_name . '_settings_saved') == false) {
                add_action('admin_notices', array($this, 'redi_admin_notice_finilize_setup'));
            } else if (empty($reservation_results)) {
                add_action('admin_notices', array($this, 'redi_admin_notice_finilize_setup_create_reservation'));
            }
        }

        function redi_admin_notice_finilize_wizard_no_api_key()
        {
            $wizardPageURL = "<div class='link_wrapper'><a class='redi-notice-button' href=" . esc_url(admin_url() . "admin.php?page=redi-restaurant-reservation-reservations") . ">" . __("Open setup wizard", 'redi-restaurant-reservation') . "</a></div>";

            // Translators: %s is the HTML link to the setup wizard.
            $redi_notice = sprintf(
                __(
                    "<h3>ReDi Restaurant Reservation Plugin</h3> <p>Plugin is active but API key is not generated yet to use the plugin. Finilize setup wizard now for seamless bookings.</p> %s",
                    'redi-restaurant-reservation'
                ),
                $wizardPageURL
            );

            $plugin_img = plugin_dir_url(__DIR__);
            echo '<div class="redi_notice notice notice-warning is-dismissible">
                        <div class="redi-plugin-notice-aside">
                            <img src="' . $plugin_img . 'img/Logo_ReDi.svg" alt="ReDi">
                        </div>
                        <div class="redi-plugin-notice-inner">
                            <div class="redi-plugin-notice-content">
                                ' . $redi_notice . '
                            </div>
                        </div>
                </div>';
        }

        function redi_admin_notice_finilize_wizard_page_not_defined()
        {
            // Translators: %s is the HTML link to the setup wizard.
            $redi_notice = sprintf(
                __(
                    '<h3>ReDi Restaurant Reservation Plugin</h3> <p>Plugin is active but you have not created a page with reservation form. Finilize setup wizard now for seamless bookings.</p> %s',
                    'redi-restaurant-reservation'
                ),
                "<div class='link_wrapper'><a class='redi-notice-button' href=" . esc_url(admin_url() . "admin.php?page=redi-restaurant-reservation-reservations") . ">" . __("Open setup wizard", 'redi-restaurant-reservation') . "</a></div>"
            );
            $plugin_img = plugin_dir_url(__DIR__ );
            echo '<div class="redi_notice notice notice-warning is-dismissible">
                        <div class="redi-plugin-notice-aside">
                            <img src="' . $plugin_img . 'img/Logo_ReDi.svg" alt="ReDi">
                        </div>
                        <div class="redi-plugin-notice-inner">
                            <div class="redi-plugin-notice-content">
                                ' . $redi_notice . '
                            </div>
                        </div>
                </div>';
        }

        function redi_admin_notice_finilize_setup()
        {
            // Translators: %s is the HTML link to the configuration page.
            $redi_notice = sprintf(
                __(
                    '<p>You have not made any changes to settings since you have installed the plugin. Finilize <b>ReDi Restaurant Reservation Plugin</b> setup now for seamless bookings. Visit the %1$s to finilize configuration and start impress your clients!</p> %2$s',
                    'redi-restaurant-reservation'
                ),
                __("Configuration page", 'redi-restaurant-reservation'),
                "<div class='link_wrapper'><a class='redi-notice-button' href=" . esc_url(admin_url() . "admin.php?page=redi-restaurant-reservation-settings") . ">" . __("Configuration page", 'redi-restaurant-reservation') . "</a></div>"
            );

            $plugin_img = plugin_dir_url(__DIR__ );
            echo '<div class="redi_notice notice notice-warning is-dismissible">
                        <div class="redi-plugin-notice-aside">
                            <img src="' . $plugin_img . 'img/Logo_ReDi.svg" alt="ReDi">
                        </div>
                        <div class="redi-plugin-notice-inner">
                            <div class="redi-plugin-notice-content">
                                <p>' . $redi_notice . '</p>
                            </div>
                        </div>
                </div>';
        }


        function redi_admin_notice_finilize_setup_create_reservation()
        {
            global $wpdb;
            $red_results = $wpdb->get_results("SELECT ID, post_title, guid FROM " . $wpdb->posts . " WHERE post_content LIKE '%[redirestaurant]%' AND post_status = 'publish'");

            $reservationPageURL = isset($red_results[0]->ID) ? esc_url(get_the_permalink($red_results[0]->ID)) : "javascript:;";
            $reservationPageLink = isset($red_results[0]->ID) ? __("Click here to open reservation page", 'redi-restaurant-reservation') : "";

            $reservationLinkHTML = sprintf(
                '<div class="link_wrapper"><a class="redi-notice-button" target="_blank" href="%s">%s</a></div>',
                $reservationPageURL,
                $reservationPageLink
            );

            $shortcodeNotice = isset($red_results[0]->ID) ? "" : __("Please create a reservation page and add this <b>[redirestaurant]</b> shortcode to that page.", 'redi-restaurant-reservation');

            $redi_notice = sprintf(
                __(
                    "Finally, one last step in <b>ReDi Restaurant Reservation Plugin</b> setup to impress your clients, make a test reservation. <b>%1\$s</b>%2\$s",
                    'redi-restaurant-reservation'
                ),
                $reservationLinkHTML,
                $shortcodeNotice
            );
            $plugin_img = plugin_dir_url(__DIR__);
            echo '<div class="redi_notice notice notice-warning is-dismissible">
                        <div class="redi-plugin-notice-aside">
                            <img src="' . $plugin_img . 'img/Logo_ReDi.svg" alt="ReDi">
                        </div>
                        <div class="redi-plugin-notice-inner">
                            <div class="redi-plugin-notice-content">
                                <p>' . $redi_notice . '</p>
                            </div>
                        </div>
                </div>';
        }
    }
}
?>