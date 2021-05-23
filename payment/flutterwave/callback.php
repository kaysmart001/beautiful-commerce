<?php
ob_start();
session_start();
require_once('../../admin/inc/config.php');
$curl = curl_init();
$tx_id=$_GET['transaction_id'];
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$tx_id/verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "Authorization: Bearer $flutterwave_secret_key"
  ),
));

$response = curl_exec($curl);

$err = curl_error($curl);

curl_close($curl);

if($err){
    // there was an error contacting the flutterwave API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response);

if($tranx->status!=='success'){
  // there was an error from the API
  die('API returned error: ' . $tranx->message);
}

if('successful' == $tranx->data->status){
  // transaction was successful...
  // please check other things like whether you already gave value for this ref
  // if the email matches the customer who owns the product etc
  // Give value
      	$payment_date = date('Y-m-d H:i:s');
	    $payment_id = $tranx->data->id;
		$transaction_id=$tranx->data->tx_ref;
		$amount=$tranx->data->amount;
		$card_number=$tranx->data->card->first_6digits . '--'. $tranx->data->card->last_4digits ?? '';
        $card_expiry=$tranx->data->card->expiry ?? '';
		$card_month=explode('/',$card_expiry)[0] ?? '';
		$card_year=end(explode('/',$card_expiry)) ?? '';

	    $statement = $pdo->prepare("INSERT INTO tbl_payment (   
	                            customer_id,
	                            customer_name,
	                            customer_email,
	                            payment_date,
	                            txnid, 
	                            paid_amount,
	                            card_number,
	                            card_cvv,
	                            card_month,
	                            card_year,
	                            bank_transaction_info,
	                            payment_method,
	                            payment_status,
	                            shipping_status,
	                            payment_id
	                        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	    $statement->execute(array(
	                            $_SESSION['customer']['cust_id'],
	                            $_SESSION['customer']['cust_name'],
	                            $_SESSION['customer']['cust_email'],
	                            $payment_date,
	                            $transaction_id,
	                            $amount,
	                            $card_number, 
	                            '',
	                            $card_month, 
	                            $card_year,
	                            '',
	                            'Flutterwave',
	                            'Completed',
	                            'Pending',
	                            $payment_id
	                        ));

	    $i=0;
	    foreach($_SESSION['cart_p_id'] as $key => $value) 
	    {
	        $i++;
	        $arr_cart_p_id[$i] = $value;
	    }

	    $i=0;
	    foreach($_SESSION['cart_p_name'] as $key => $value) 
	    {
	        $i++;
	        $arr_cart_p_name[$i] = $value;
	    }

	    $i=0;
	    foreach($_SESSION['cart_size_name'] as $key => $value) 
	    {
	        $i++;
	        $arr_cart_size_name[$i] = $value;
	    }

	    $i=0;
	    foreach($_SESSION['cart_color_name'] as $key => $value) 
	    {
	        $i++;
	        $arr_cart_color_name[$i] = $value;
	    }

	    $i=0;
	    foreach($_SESSION['cart_p_qty'] as $key => $value) 
	    {
	        $i++;
	        $arr_cart_p_qty[$i] = $value;
	    }

	    $i=0;
	    foreach($_SESSION['cart_p_current_price'] as $key => $value) 
	    {
	        $i++;
	        $arr_cart_p_current_price[$i] = $value;
	    }

	    $i=0;
	    $statement = $pdo->prepare("SELECT * FROM tbl_product");
	    $statement->execute();
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	    foreach ($result as $row) {
	    	$i++;
	    	$arr_p_id[$i] = $row['p_id'];
	    	$arr_p_qty[$i] = $row['p_qty'];
	    }

	    for($i=1;$i<=count($arr_cart_p_name);$i++) {
	        $statement = $pdo->prepare("INSERT INTO tbl_order (
	                        product_id,
	                        product_name,
	                        size, 
	                        color,
	                        quantity, 
	                        unit_price, 
	                        payment_id
	                        ) 
	                        VALUES (?,?,?,?,?,?,?)");
	        $sql = $statement->execute(array(
	                        $arr_cart_p_id[$i],
	                        $arr_cart_p_name[$i],
	                        $arr_cart_size_name[$i],
	                        $arr_cart_color_name[$i],
	                        $arr_cart_p_qty[$i],
	                        $arr_cart_p_current_price[$i],
	                        $payment_id
	                    ));

	        // Update the stock
            for($j=1;$j<=count($arr_p_id);$j++)
            {
                if($arr_p_id[$j] == $arr_cart_p_id[$i]) 
                {
                    $current_qty = $arr_p_qty[$j];
                    break;
                }
            }
            $final_quantity = $current_qty - $arr_cart_p_qty[$i];
            $statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
            $statement->execute(array($final_quantity,$arr_cart_p_id[$i]));
            
	    }
	    unset($_SESSION['cart_p_id']);
	    unset($_SESSION['cart_size_id']);
	    unset($_SESSION['cart_size_name']);
	    unset($_SESSION['cart_color_id']);
	    unset($_SESSION['cart_color_name']);
	    unset($_SESSION['cart_p_qty']);
	    unset($_SESSION['cart_p_current_price']);
	    unset($_SESSION['cart_p_name']);
	    unset($_SESSION['cart_p_featured_photo']);

	    header('location: ../../payment_success.php');
}