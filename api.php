<?php
define('API_BASE_DIR', __DIR__);

require_once API_BASE_DIR . '/MyDBHelper.php';

use tester\helpers\DBHelper;

$content = trim(file_get_contents("php://input"));

// converts content (json formatted) into php-readable array via setting param #2 to true
$decoded = json_decode($content, true);


if( is_array($decoded) ) {

  // Validate key to make sure it's coming from our server
  if( isset($decoded['k']) && filter_var($decoded['k'], FILTER_SANITIZE_STRING) == '19JOAC4Q' ) {
    // Store the de-json'd data and pick out the 'action' key from the array and assign to $action
    $action = filter_var($decoded['action'], FILTER_SANITIZE_STRING);

    // Now we can see what kind of request this was and handle the result accordingly
    switch($action) {
      case 'addEntry':
        $firstName = false;
        $lastName = false;
        $email = false;
        $comment = false; 

        if( isset($decoded['firstName']) ) {
          $firstName = filter_var($decoded['firstName'], FILTER_SANITIZE_STRING);
        }
        if( isset($decoded['lastName']) ) {
          $lastName = filter_var($decoded['lastName'], FILTER_SANITIZE_STRING);
        }
        if( isset($decoded['email']) ) {
          $email = filter_var($decoded['email'], FILTER_SANITIZE_STRING);
        }
        if( isset($decoded['comment']) ) {
          $comment = filter_var($decoded['comment'], FILTER_SANITIZE_STRING);
        }

        // At this point, if anything is false, that means, it didn't get passed through. These are the req fields, so if they're empty we don't do anything
        if( $firstName !== false && $lastName !== false && $email !== false && $comment !== false ) {
          $data = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'comment' => $comment
          ];

          $result = DBHelper::addEntry($data);
        }

        echo json_encode($result);

        break;

      case 'getEntries':
        $result = DBHelper::getEntries();

        if( $result['entries'] !== false ) {
          header('Content-Type: text/csv');
          header('Content-Disposition: attachment; filename="entries.csv"');

          $fp = fopen('php://output', 'wb');
          foreach ( $data as $line ) {
            // $val = explode(",", $line);
            fputcsv($fp, $line);
          }
          fclose($fp);
        }

        break;
      }
      
    }
  }
?>
