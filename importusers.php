<?php
$start_time = microtime(TRUE);
ini_set("display_errors", 1);
error_reporting(E_ALL);
define( 'SHORTINIT', true );

include_once '../wp-load.php';
include_once '../wp-config.php';

global $wpdb;
require 'functions.php';

?>

    <form enctype='multipart/form-data' action='' method='post'>
        <label>Import how many users:</label>
        <input size='50' type='number' name='limit'>
        <br />
        <input type='submit' name='submit' value='Import'>
    </form>

<?php

if (isset($_POST['submit'])) {
    $users = getUsers($_POST['limit']);
    foreach($users as $user) {
        //dump($user);
        $metaData = [];
        $exists = getUserByEmail($user->email);
        if (!$exists) {
            $userData = [
                'user_login' => $user->username,
                'user_pass' => '$P$BtCM3owGWG4wwZw3PO9PqTJSsjapDQ.',
                'user_email' => $user->email,
                'user_registered' => $user->registered,
                'display_name' => $user->firstName,
            ];
            $wpdb->insert('wp_users',$userData);
            $lastId = $wpdb->insert_id;
            $metaData =[
                ['user_id' => $lastId, 'meta_key' => 'nickname', 'meta_value' => $user->username],
                ['user_id' => $lastId, 'meta_key' => 'first_name', 'meta_value' => $user->firstName],
                ['user_id' => $lastId, 'meta_key' => 'last_name', 'meta_value' => ''],
                ['user_id' => $lastId, 'meta_key' => 'description', 'meta_value' => ''],
                ['user_id' => $lastId, 'meta_key' => 'rich_editing', 'meta_value' => 'true'],
                ['user_id' => $lastId, 'meta_key' => 'syntax_highlighting', 'meta_value' => 'true'],
                ['user_id' => $lastId, 'meta_key' => 'comment_shortcuts', 'meta_value' => 'false'],
                ['user_id' => $lastId, 'meta_key' => 'admin_color', 'meta_value' => 'fresh'],
                ['user_id' => $lastId, 'meta_key' => 'user_ssl', 'meta_value' => '0'],
                ['user_id' => $lastId, 'meta_key' => 'show_admin_bar_front', 'meta_value' => 'false'],
                ['user_id' => $lastId, 'meta_key' => 'wp_capabilities', 'meta_value' => 'a:1:{s:7:"Student";b:1;}'],
                ['user_id' => $lastId, 'meta_key' => 'country', 'meta_value' => $user->country],
                ['user_id' => $lastId, 'meta_key' => 'city', 'meta_value' => $user->city],
                ['user_id' => $lastId, 'meta_key' => 'user-language', 'meta_value' => $user->language],
                ['user_id' => $lastId, 'meta_key' => 'phone-whatsapp', 'meta_value' => $user->phone],
            ] ;
            insert_multiple_rows('wp_usermeta', $metaData);
            $wpdb->update('user_export',['imported' => 1, 'user_id' => $lastId],['userId' => $user->userId]);
            echo "User: {$user->username} with ID: {$lastId} <br/>";
        } else {
            echo "The email '{$user->email}' is already being used. <br/>";
        }
    }
}

$end_time = microtime(TRUE);
$time_taken = ($end_time - $start_time)*1000;
$time_taken = round($time_taken,5);

echo 'Page generated in '.$time_taken.' seconds.';
echo '<br/><a href="/testing/">Go back...</a>';
