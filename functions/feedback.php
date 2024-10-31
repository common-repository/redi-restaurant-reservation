<?php 
    class ReDiFeedback{

        static function feedback_on_deactivate($data)
        {

            $googleFormsURL = 'https://docs.google.com/forms/d/e/1FAIpQLSfr6jp7WwJhxOnf9WLP0e4R6p-QxgLtnRxVPQP5l0-J9gCXyg/formResponse';
            $data_array = array(
                'entry.1222195415' => stripslashes($data['selected-reason'])
                
            );
            /*I found a better plugin*/
            if (!empty($data['plugin_name']) && $data['selected-reason'] == "I found a better plugin") {
                $data_array['entry.1138066999'] = stripslashes($data['plugin_name']);
                $data_array['pageHistory'] = '0,1';
            }
            /*Plugin does not work on my site*/
            if (!empty($data['plugin_not_work_name']) && !empty($data['plugin_not_work_email'])) {
                $data_array['entry.1753345827'] = stripslashes($data['plugin_not_work_name']);
                $data_array['entry.53301016'] = stripslashes($data['plugin_not_work_email']);
                $data_array['pageHistory'] = '0,2';
            }

            /*I found a better plugin*/
            if (!empty($data['plugin_name']) && $data['selected-reason'] == "It's a temporary deactivation") {
                $data_array['pageHistory'] = '0,-3';
            }

            /*I'm unable to configure it according to my needs*/
            if (!empty($data['plugin_configure_name']) && !empty($data['plugin_configure_email'])) {
                $data_array['entry.738225224'] = stripslashes($data['plugin_configure_name']);
                $data_array['entry.156441836'] = stripslashes($data['plugin_configure_email']);
                $data_array['pageHistory'] = '0,3';
            }

            /*The design of the plugin is outdated*/
            if (!empty($data['plugin_name']) && $data['selected-reason'] == "The design of the plugin is outdated") {
                $data_array['pageHistory'] = '0,-3';
            }

            /*The design of the plugin is outdated*/
            if (!empty($data['plugin_name']) && $data['selected-reason'] == "I do not want to pay for the plugin") {
                $data_array['pageHistory'] = '0,-3';
            }

            /*I did not find a needed feature in the free version*/
            if (!empty($data['plugin_feature_name']) && !empty($data['plugin_feature_email'])) {
                $data_array['entry.215074076'] = stripslashes($data['plugin_feature_email']);
                $data_array['entry.208654697'] = stripslashes($data['plugin_feature_name']);
                $data_array['pageHistory'] = '0,4';
            }

            if ($data['selected-reason'] == '__other_option__') {
                $data_array['entry.1222195415.other_option_response'] = stripslashes($data['comment']);
                $data_array['pageHistory'] = '0,-3';
            }
            
            wp_remote_post($googleFormsURL, array(
                'body' => $data_array,
                'timeout' => 20,
                'sslverify' => true
            ));
        }

        static function feedback_on_experience()
        {
            $responce = [];
            $reservationid = ( !empty( $_POST['reservationid'] ) ) ? $_POST['reservationid'] :  '';
            $review = ( !empty( $_POST['review'] ) ) ? $_POST['review'] :  '';
            $message = ( !empty( $_POST['message'] ) ) ? $_POST['message'] :  '';
            if( !empty($reservationid)){
                $googleFormsURL = 'https://docs.google.com/forms/d/13-R-aF5hsesvxNMeGoNKKKHyhbXag2Qv3GJ2ok9QPDs/formResponse';
                $data_array = array(
                    'entry.58078908' => $reservationid,
                    'entry.119436979' => $review,
                    'entry.842379435' => $message
                );
                $response = wp_remote_post($googleFormsURL, array(
                    'body' => $data_array,
                    'timeout' => 45,
                    'sslverify' => true
                ));
                if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
                    $error_message = is_wp_error($response) ? $response->get_error_message() : 'Request failed.';
                    $responce['message'] = $error_message;
                    $responce['type'] = "Error";
                    
                }else{
                    $responce['message'] = __("Thank you for your feedback.", 'redi-restaurant-reservation');
                    $responce['type'] = "success";
                }
            }else{
                $responce['message'] = __("Reservation id is empty.", 'redi-restaurant-reservation');
                $responce['type'] = "Error";
            }
            echo wp_json_encode($responce); 
            die;            
        }
    }
?>