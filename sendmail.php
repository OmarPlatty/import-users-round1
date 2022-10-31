<?php

$start_time = microtime(TRUE);
ini_set("display_errors", 1);

require_once('./vendor/autoload.php');
use Postmark\PostmarkClient;

error_reporting(E_ALL);

?>

    <form enctype='multipart/form-data' action='' method='post'>
        <label>How many users to email:</label>
        <input size='50' type='number' name='limit'>
        <br />
        <input type='submit' name='submit' value='Submit'>
    </form>

<?php

$limit = isset($_POST['limit']) ? $_POST['limit'] : 0;

if (isset($_POST['submit']) && $limit > 0 && $limit < 500) {
  define( 'SHORTINIT', true );

  include_once '../wp-load.php';
  include_once '../wp-config.php';
  $dev = true;

  global $wpdb;
  require 'functions.php';

  $api = '09423d04-7993-4bf0-89a2-e20724e22aa7';
  $sender = 'contact@studyaustraliaexperience.com';
  $client = new PostmarkClient($api);

  $mails = [];
  $users = getUsersToEmail($limit);
  foreach($users as $user) {
    $templateId = $user->language == 'PT' ? 29632682: 29628514;
    $email = $dev ? 'lptheory@gmail.com' : $user->email;
    $mails[] = [
      'To' => $email,
      'From' => $sender,
      'TemplateID' => $templateId,
      'TemplateModel' => ['password' => 'SAE2.0'.$user->user_id, 'name' => $user->firstName]
    ];
    // $wpdb->update('user_export',['emailed' => 1],['userId' => $user->userId]);
    // echo "E-Mail sent to: {$user->username} with ID: {$user->user_id} to {$user->email} <br/>";
  }

  $responses = $client->sendEmailBatchWithTemplate($mails);
  echo '<pre>';
  foreach($responses as $key => $response){
    $user = $users[$key];
    if ($response['Message'] == "OK") {
      $wpdb->update('user_export',['emailed' => 1],['userId' => $user->userId]);
      echo "E-Mail sent to: {$user->username} with ID: {$user->user_id} to {$user->email} <br/>";
    } else {
      echo "There was an error emailing user:";
      var_dump($user);
    }
  }
  echo '</pre>';
} if ($limit > 500) {
  echo "We can only send 500 emails at a time.";
}

$end_time = microtime(TRUE);
$time_taken = ($end_time - $start_time)*1000;
$time_taken = round($time_taken,5);

echo 'Page generated in '.$time_taken.' seconds.';
echo '<br/><a href="/testing/">Go back...</a>';