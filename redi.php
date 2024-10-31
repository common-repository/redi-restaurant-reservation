<?php

if ( ! defined( 'REDI_API_USER' ) ) {
	define( 'REDI_API_USER', 'User.svc/' );
}
if ( ! defined( 'REDI_API_USERGET' ) ) {
	define( 'REDI_API_USERGET', 'User.svc/get' );
}
if ( ! defined( 'REDI_API_PLACE' ) ) { 
	define( 'REDI_API_PLACE', 'Place.svc/' );
}
if ( ! defined( 'REDI_API_SERVICE' ) ) {
	define( 'REDI_API_SERVICE', 'Service.svc/' );
}
if ( ! defined( 'REDI_API_CATEGORY' ) ) {
	define( 'REDI_API_CATEGORY', 'Category.svc/' );
}
if ( ! defined( 'REDI_API_RESERVATION' ) ) {
	define ( 'REDI_API_RESERVATION', 'Reservation.svc/' );
}
if ( ! defined( 'REDI_API_EMAILCONTENT' ) ) {
	define( 'REDI_API_EMAILCONTENT', 'emailcontent.svc/' );
}
if ( ! defined( 'REDI_API_DATES' ) ) {
	define( 'REDI_API_DATES', 'Date.svc/' );
}
if ( ! defined('REDI_API_CUSTOMFIELDS')){
    define( 'REDI_API_CUSTOMFIELDS', 'CustomFields.svc/' );
}
if ( ! defined( 'REDI_API_REMINDER' ) ) {
	define ( 'REDI_API_REMINDER', 'Reminder.svc/' );
}
if ( ! defined( 'REDI_RESTAURANT_API' ) ) {
	define( 'REDI_RESTAURANT_API', 'https://api.reservationdiary.eu/service/' );
}
if ( ! defined( 'REDI_MAX_CUSTOM_FIELDS' ) ) {
	define( 'REDI_MAX_CUSTOM_FIELDS', 11 );
}
if ( ! defined( 'REDI_API_WAITLIST' ) ) {
    define( 'REDI_API_WAITLIST', 'WaitList.svc/' );
}
if ( ! defined( 'REDI_METHOD_POST' ) ) {
	define( 'REDI_METHOD_POST', 'POST' );
}
if ( ! defined( 'REDI_METHOD_GET' ) ) {
	define( 'REDI_METHOD_GET', 'GET' );
}
if ( ! defined( 'REDI_METHOD_PUT' ) ) {
	define( 'REDI_METHOD_PUT', 'PUT' );
}
if ( ! defined( 'REDI_METHOD_DELETE' ) ) {
	define( 'REDI_METHOD_DELETE', 'DELETE' );
}

if ( ! class_exists( 'ReDi' ) ) {
	class Redi {
		private $ApiKey;

        public function __construct( $ApiKey ) {
            $this->ApiKey = $ApiKey;
            add_action( 'admin_footer', array( $this, '_add_deactivation_feedback_popup' ) );
        }
		public function Redi( $ApiKey ) {
			$this->ApiKey = $ApiKey;
		}

		public function deleteCustomField( $lang, $placeID, $customFieldID ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_CUSTOMFIELDS . $lang . '/' . $this->ApiKey . '/place/' . $placeID . '/customfield/' . $customFieldID, REDI_METHOD_DELETE );
		}

		public function updateCustomField( $lang, $placeID, $customFieldID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_CUSTOMFIELDS .'/v2/'. $lang . '/' . $this->ApiKey . '/place/' . $placeID . '/customfield/' . $customFieldID, REDI_METHOD_PUT,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function saveCustomField( $lang, $placeID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_CUSTOMFIELDS .'/v2/'. $lang . '/' . $this->ApiKey . '/place/' . $placeID, REDI_METHOD_POST,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function getCustomField( $lang, $placeID ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_CUSTOMFIELDS . $lang . '/' . $this->ApiKey . '/place/' . $placeID, REDI_METHOD_GET );
		}

		public function getDateInformation( $lang, $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_DATES  . $lang . '/'.$this->ApiKey.'/'. $categoryID, REDI_METHOD_GET,  self::strParams( $params ) );
		}

		public function getReservationUrl($lang) {
			return 'https://wp.reservationdiary.eu/' . $lang . '/' . $this->ApiKey . '/Reservation/Index?ReturnUrl=' . get_admin_url();
		}

		public function getWaiterDashboardUrl($lang) {
			return 'https://upcoming.reservationdiary.eu/Entry/' . $this->ApiKey . '?ReturnUrl=' . get_admin_url();
		}

		public function getBasicPackageSettingsUrl($lang) {
			return 'https://wp.reservationdiary.eu/' . $lang . '/' . $this->ApiKey . '?ReturnUrl=' . get_admin_url();
		}

		public function getEmailContent( $reservationID, $type, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_EMAILCONTENT . $this->ApiKey . '/' . $reservationID . '/ClientReservation' . $type,
			REDI_METHOD_GET, self::strParams( $params ) );
		}

		public function cancelReservationByClient( $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION .'/v1/'. $this->ApiKey . '/cancelByClient', REDI_METHOD_DELETE,
				self::strParams( $params ) );
		}

		public function cancelReservation( $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . $this->ApiKey . '/cancelByProvider', REDI_METHOD_DELETE,
				self::strParams( $params ) );
		}

		public function findReservation($lang, $reservationID) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . $lang . '/' . $this->ApiKey . '/getReservation/' . $reservationID, REDI_METHOD_GET);
	    }

		public function createReservation( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . $this->ApiKey . '/' . $categoryID, REDI_METHOD_POST,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function createReservation_v1( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . 'v1/' . $this->ApiKey . '/' . $categoryID, REDI_METHOD_POST,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function updateReservation($reservationID, $lang, $currentTime, $dontNotifyClient, $params)
		{
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . $this->ApiKey . '/update/' . $reservationID . 
				'?Lang=' . $lang . '&CurrentTime=' . $currentTime . '&DontNotifyClient=' . $dontNotifyClient, REDI_METHOD_PUT,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function addWaitList($placeID, $params, $currentTime, $lang){
            return $this->request( REDI_RESTAURANT_API . REDI_API_WAITLIST . $lang .'/v1/' . $this->ApiKey . '/place/' . $placeID . '?currentTime='. $currentTime, REDI_METHOD_POST, wp_json_encode( self::unescape_array( $params ) ) );
		}
		
		public function addReminder( $placeID, $lang, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_REMINDER . $lang . '/' . $this->ApiKey . '/place/' . $placeID, REDI_METHOD_POST,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		/**
		 * @param $categoryID
		 * @param $params array
		 * <pre>
		 * StartTime -
		 * EndTime
		 * Quantity
		 * Alternatives
		 * </pre>
		 *
		 * @return array
		 */
		public function query( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . $this->ApiKey . '/' . $categoryID . '/Person',
			REDI_METHOD_GET, self::strParams( $params ) );
		}

		public function createCategory( $placeID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_CATEGORY . $this->ApiKey . '/' . $placeID, REDI_METHOD_POST,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function getServices( $categoryID ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_SERVICE . $this->ApiKey . '/' . $categoryID . '/Person', REDI_METHOD_GET );
		}

		public function deleteServices( $categoryID, $quantity ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_SERVICE . $this->ApiKey . '/' . $categoryID . '/person/delete?quantity=' . $quantity,
			REDI_METHOD_DELETE );
		}

		public function setServiceTime( $categoryID, $timeSet ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_CATEGORY . $this->ApiKey . '/' . $categoryID . '/time',
			REDI_METHOD_PUT,
				wp_json_encode( self::unescape_array( array( 'timeSet' => $timeSet ) ) ) );
		}

		public function getServiceTime( $categoryID ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_CATEGORY . $this->ApiKey . '/' . $categoryID . '/time', REDI_METHOD_GET );
		}

		public function createService( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_SERVICE . $this->ApiKey . '/' . $categoryID, REDI_METHOD_POST,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function createUser( $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_USER, REDI_METHOD_POST, wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function setPlace( $placeID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_PLACE . $this->ApiKey . '/' . $placeID, REDI_METHOD_PUT,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function createPlace( $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_PLACE . $this->ApiKey, REDI_METHOD_POST,
				wp_json_encode( self::unescape_array( $params ) ) );
		}

		public function shiftsStartTime( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_CATEGORY . $this->ApiKey . '/' . $categoryID . '/shiftsStartTime',
			REDI_METHOD_GET, self::strParams( $params ) );
		}

		public function availabilityByDay( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . $this->ApiKey . '/' . $categoryID . '/availabilityByDay/Person',
			REDI_METHOD_GET, self::strParams( $params ) );
		}

		public function availabilityByShifts( $categoryID, $params ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . $this->ApiKey . '/' . $categoryID . '/availabilityByShifts/Person',
			REDI_METHOD_GET, self::strParams( $params ) );
		}

		public function getCustomDurationAvailability( $categoryID, $params) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_RESERVATION . $this->ApiKey . '/' . $categoryID . '/guestsByStayDuration',
			REDI_METHOD_GET, self::strParams( $params ) );
		}

		public function getPlace( $placeID ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_PLACE . $this->ApiKey . '/' . $placeID, REDI_METHOD_GET );
		}

		public function getPlaceCategories( $placeID ) {
			return $this->request( REDI_RESTAURANT_API . REDI_API_PLACE . $this->ApiKey . '/' . $placeID . '/categories', REDI_METHOD_GET );
		}

		public function getPlaces() {
			return $this->request( REDI_RESTAURANT_API . REDI_API_PLACE . $this->ApiKey, REDI_METHOD_GET );
		}

		public function setApiKey( $ApiKey ) {
			$this->ApiKey = $ApiKey;
		}

		public static function strParams( $params ) {
			$url_param = '';
			$first     = 0;

			if ( is_array( $params ) ) {
				foreach ( $params as $param_name => $param_value ) {
					$url_param .= ( ( $first ++ == 0 ) ? '?' : '&' ) . $param_name . '=' . $param_value;
				}
			}

			return $url_param;
		}

		private static function unescape_array( $array ) {
			$unescaped_array = array();
			foreach ( $array as $key => $val ) {
				if ( is_array( $val ) ) {
					$unescaped_array[ $key ] = self::unescape_array( $val );
				} else {
						if (!empty($val))
						{
							$unescaped_array[ $key ] = stripslashes( $val );
						}
				}
			}

			return $unescaped_array;
		}

		private function request( $url, $method = REDI_METHOD_GET, $params_string = null ) {
			$request = new WP_Http;
			$curTime = microtime( true );
			$req     = array(
				'method'  => $method,
				'body'    => (($method === REDI_METHOD_GET || $method === REDI_METHOD_DELETE ) ? null : $params_string),
				'headers' => array(
					'Content-Type'   => 'application/json; charset=utf-8',
					'Content-Length' => ($method === REDI_METHOD_GET || $method === REDI_METHOD_DELETE ) ? 0 : strlen( $params_string )
				)
			);
			$output  = $request->request(
				$url . ( ( $method === REDI_METHOD_GET || $method === REDI_METHOD_DELETE ) ? $params_string : '' ), $req );

			$link = '<a href="mailto:info@reservationdiary.eu;'.get_bloginfo('admin_email').'?subject=' . __("Reservation form is not working", 'redi-restaurant-reservation') . '&body='.get_bloginfo().'">' . __("contact us directly", 'redi-restaurant-reservation') .'</a>';
			
			// Translators: %s is a placeholder for a dynamic link.
			$message = sprintf(__( 'Online reservation service is not available at this time. Try again later or %s', 'redi-restaurant-reservation' ), $link);

			if ( is_wp_error( $output ) ) {
				return array(
					'request_time' => round( microtime( true ) - $curTime, 3 ) * 1000,
					'Error'        => $message,
					'Wp-Error'     => $output->errors
				);
			}

			if ( $output['response']['code'] != 200 && $output['response']['code'] != 400 ) {
				return array(
					'response_code' => $output['response']['code'],
					'Error'         => $message
				);
			}
			$output = $output['body'];

			// convert response
			$output = (array) json_decode( $output );

			return $output;
		}

		public function _add_deactivation_feedback_popup(){
			$screen = get_current_screen();
			if ($screen->base === 'plugins') {
				if ( is_file( plugin_dir_path( __FILE__ ) . 'templates/popup.php' ) ) {
					include_once plugin_dir_path( __FILE__ ) . 'templates/popup.php';
	            }
	        }
		}
	}
}
