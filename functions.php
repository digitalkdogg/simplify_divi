<?php
/* Write your awesome functions below */
add_action('wp_enqueue_scripts', 'simplify_custom_js');
function simplify_custom_js() {
    wp_enqueue_script('simplify', get_stylesheet_directory_uri().'/simplify.js');
}

function get_hash_string() {
  $hash = 'q=PcD';
  for ($x = 0; $x <= 10; $x++) {

    switch ((string) $x) {
      case "1":
        $hash = $hash . mt_rand() . '#';
        break;
      case "2":
          $hash = $hash . mt_rand() . '^gHJk/';
          break;
      case "3":
        $hash = $hash . mt_rand() . '*1D%';
        break;
      case "4":
        $hash = $hash . mt_rand() . 'h3f%';
        break;
      case "5":
        $hash = $hash . mt_rand() . ')zd';
        break;
      case "6":
        $hash = $hash . mt_rand() . '!aBt';
        break;
      case "7":
          $hash = $hash . mt_rand() . '(';
          break;
      case "9":
          $hash = $hash . mt_rand() . 'po|lut';
          break;
      case "10": 
          $hash = $hash . mt_rand();
          break;
      default:
      $hash = $hash . mt_rand() . '_';
    }
  }

  return $hash ;
}

function send_to_email($to, $message) {

    $subject = 'New Employee Submission';
  
    $headers = array('Content-Type: text/html; charset=UTF-8','From:SecureUpload <secureupload@simplifyprofessionalservices.com>');

    $mail = wp_mail( $to, $subject, $message, $headers );

    $message = 'Thank you for the submission.  We will be in contact with you shortly <br /><br />' .
    'Have a great day!: <br /> <br />'. 
    '<p>Please do not reply to this email as this inbox is not monitored</p>';


    $mail = send_from_email($_POST['email_name'], $message);

    return $mail;
 }

 function send_from_email($to, $message) {
  //$to = 'becky@simplifyprofessionalservices.com';
 // $to = 'kevinbollman@gmail.com';
  $subject = 'Thank You For Your Submission';
  
  $headers = array('Content-Type: text/html; charset=UTF-8','From:SecureUpload <secureupload@simplifyprofessionalservices.com>');

  $mail = wp_mail( $to, $subject, $message, $headers );

  return $mail;
}
?>