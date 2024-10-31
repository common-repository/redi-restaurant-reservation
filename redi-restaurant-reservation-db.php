<?php
if ( ! class_exists( 'ReDiRestaurantReservationDb' ) ) 
{
    class ReDiRestaurantReservationDb
    {
        static function save_reservation($params, $reservation, $table_name)
        {
            if (isset($reservation['Error']))
            {
                return;
            }

            global $wpdb;
            
            $reservParams = $params['reservation'];

            $wpdb->insert( $wpdb->prefix . $table_name, [ 
                'reservation_number' => $reservation['ID'],
                'name'               => $reservParams['UserName'],
                'lastname'           => $reservParams['LastName'],
                'phone'              => $reservParams['UserPhone'],
                'email'              => $reservParams['UserEmail'],
                'date_from'          => $reservParams['StartTime'],
                'date_to'            => $reservParams['EndTime'],
                'guests'             => $reservParams['Quantity'],
                'comments'           => $reservParams['UserComments'],          
                'prepayment'         => $reservParams['PrePayment'],            
                'currenttime'        => $reservParams['CurrentTime'],           
                'language'           => $reservParams['Lang']   
            ] );

            if (!isset($params['reservation']['Parameters']))
            {
                return;
            }

            $custom_fields = $params['reservation']['Parameters'];

            foreach ($custom_fields as $custom_field)
            {
                $wpdb->insert( $wpdb->prefix . $table_name . '_custom_fields', [  
                    'reservation_number' => $reservation['ID'],
                    'field_text'         => htmlentities($custom_field['Text'], ENT_QUOTES),
                    'name'               => $custom_field['Name'],
                    'type'               => $custom_field['Type'],
                    'value'              => $custom_field['Value']
                ] );
            }
        }

        // Create custom database wp_redi_restaurant_reservation if it is not
        public static function CreateCustomDatabase($table_name) {
            global $wpdb;
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';

            if ( !$wpdb->get_var( "show tables like '$wpdb->prefix$table_name'" ) ) {
                $sql = "CREATE TABLE " . $wpdb->prefix . $table_name . "(
                    id INT NOT NULL AUTO_INCREMENT,				
                    reservation_number INT,
                    name VARCHAR(50),					
                    lastname VARCHAR(50),					
                    phone VARCHAR(20),
                    email VARCHAR(50),
                    date_from VARCHAR(30),
                    date_to VARCHAR(30),
                    language VARCHAR(30),
                    currenttime DATETIME,
                    prepayment VARCHAR(30),
                    guests INT,
                    comments TEXT,
                    UNIQUE KEY id (id)

                );";
                dbDelta( $sql );
                
                $sql = "CREATE TABLE " . $wpdb->prefix . $table_name . '_custom_fields' . "(
                    id INT NOT NULL AUTO_INCREMENT,				
                    reservation_number INT,
                    name TEXT,
                    field_text TEXT,					
                    value TEXT,
                    type VARCHAR(100),
                    UNIQUE KEY id (id)
                );";
                dbDelta( $sql );   				 

            }
            /* add lastname column, alter table if column does not exists */
            // Prepare and execute the query to check if the column exists
            $column_check_query = $wpdb->prepare(
                "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = %s AND COLUMN_NAME = %s",
                $wpdb->prefix . $table_name,
                'lastname'
            );
            $row = $wpdb->get_results($column_check_query);

            if (empty($row)) {
                // Prepare and execute the query to add the column if it does not exist
                $alter_table_query = $wpdb->prepare(
                    "ALTER TABLE %s ADD lastname varchar(50) AFTER name",
                    $wpdb->prefix . $table_name
                );
                $wpdb->query($alter_table_query);
            }
        }
    }
}