<?php

$start_time = microtime(TRUE);
ini_set("display_errors", 1);
error_reporting(E_ALL);
define( 'SHORTINIT', true );

require( '../wp-load.php' );
require 'functions.php';

$wpdb = $GLOBALS['wpdb'];
?>

<form enctype='multipart/form-data' action='' method='post'>
    <label>Upload Product CSV file Here</label>
    <input size='50' type='file' name='filename'>
    <br />
    <input type='submit' name='submit' value='Upload Products'>
</form>

<?php

if (isset($_POST['submit']))
{

    $handle = fopen($_FILES['filename']['tmp_name'], "r");
    $headers = fgetcsv($handle, 1000, ",");
    $lines = [];
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
        $lines[] = [
            'username' => $data[0],
            'email' => $data[1],
            'firstName' => $data[2],
            'registered' =>  $data[3],
            'city' => $data[4],
            'country' => $data[5],
            'language' => $data[6],
            'phone' => $data[7],
        ];
    }
    fclose($handle);

    insert_multiple_rows('user_export', $lines);
}
$end_time = microtime(TRUE);
$time_taken = ($end_time - $start_time)*1000;
$time_taken = round($time_taken,5);

echo 'Page generated in '.$time_taken.' seconds.';
echo '<br/><a href="/testing/">Go back...</a>';

