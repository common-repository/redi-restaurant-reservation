<?php 

if ( ! class_exists( 'Email' ) ) {
    class Email{
        public static function send_email($options, $emailContent, $ReDiSendEmailFromOptions){
            
            if ( isset($options['EmailFrom']) && $options['EmailFrom'] == $ReDiSendEmailFromOptions) { 
                $mail_from = $options['Email'];
            }else{
                $mail_from = get_option('admin_email');
            }
            if(!empty($options['Name'])){
               $restro_name = $options['Name']; 
            }else{
               $restro_name = get_option('blogname'); 
            }
            if (!isset($emailContent['Error'])) {
                wp_mail($emailContent['To'], $emailContent['Subject'], $emailContent['Body'],
                    array(
                        'Content-Type: text/html; charset=UTF-8',
                        'From: ' . wp_specialchars_decode($restro_name, ENT_QUOTES) . ' <' . $mail_from . '>' . "\r\n"
                    ));
            }
        }
    }
}

?>