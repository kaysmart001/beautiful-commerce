<?php
// Error Reporting Turn On
ini_set('error_reporting', E_ALL);

// Setting up the time zone
date_default_timezone_set('Africa/Lagos');

// Host Name
$dbhost = 'sql311.epizy.com';

// Database Name
$dbname = 'epiz_33459705_store_db';

// Database Username
$dbuser = 'epiz_33459705';

// Database Password
$dbpass = 'hvZgW4p2guu7';

// Defining base url
define("BASE_URL", "http://thekaysmart.epizy.com/store/");

// Getting Admin url
define("ADMIN_URL", BASE_URL . "admin" . "/");

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}


$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$preloader = $row['preloader'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$meta_title_home = $row['meta_title_home'];
    $meta_keyword_home = $row['meta_keyword_home'];
    $meta_description_home = $row['meta_description_home'];
    $before_head = $row['before_head'];
    $after_body = $row['after_body'];
    $theme_color = $row['color'];
	$paypal_email                    = $row['paypal_email'];
    $stripe_public_key               = $row['stripe_public_key'];
    $stripe_secret_key               = $row['stripe_secret_key'];
    $paystack_public_key             = $row['paystack_public_key'];
    $paystack_secret_key             = $row['paystack_secret_key'];
	$flutterwave_public_key          = $row['flutterwave_public_key'];
    $flutterwave_secret_key          = $row['flutterwave_secret_key'];
    $bank_detail                     = $row['bank_detail'];
}

$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Getting all language variables into array as global variable
$i=1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);             
foreach ($result as $row) {
  define('LANG_VALUE_'.$i,$row['lang_value']);
  $i++;
}

$statement = $pdo->prepare("SELECT * FROM tbl_currency WHERE currency_name=?");
$statement->execute(array(LANG_VALUE_1));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);             
foreach ($result as $row) {
  $currency =$row['currency_code'];
}

$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);             
  foreach ($result as $row) {
    $about_meta_title = $row['about_meta_title'];
    $about_meta_keyword = $row['about_meta_keyword'];
    $about_meta_description = $row['about_meta_description'];
    $faq_meta_title = $row['faq_meta_title'];
    $faq_meta_keyword = $row['faq_meta_keyword'];
    $faq_meta_description = $row['faq_meta_description'];
    $blog_meta_title = $row['blog_meta_title'];
    $blog_meta_keyword = $row['blog_meta_keyword'];
    $blog_meta_description = $row['blog_meta_description'];
    $contact_meta_title = $row['contact_meta_title'];
    $contact_meta_keyword = $row['contact_meta_keyword'];
    $contact_meta_description = $row['contact_meta_description'];
    $pgallery_meta_title = $row['pgallery_meta_title'];
    $pgallery_meta_keyword = $row['pgallery_meta_keyword'];
    $pgallery_meta_description = $row['pgallery_meta_description'];
    $vgallery_meta_title = $row['vgallery_meta_title'];
    $vgallery_meta_keyword = $row['vgallery_meta_keyword'];
    $vgallery_meta_description = $row['vgallery_meta_description'];
  }
