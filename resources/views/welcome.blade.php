<?php

Midtrans\Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
$clientKey = $_ENV['MIDTRANS_CLIENT_KEY'];

// Uncomment for production environment
// Midtrans\Config::$isProduction = true;

// Enable sanitization
Midtrans\Config::$isSanitized = true;

// Enable 3D-Secure
Midtrans\Config::$is3ds = true;

// Required
$transaction_details = array(
    'order_id' => rand(),
    'gross_amount' => 55000,
);

// Optional
$item1_details = array(
    'id' => 'a1',
    'price' => 55000,
    'quantity' => 1,
    'name' => "Kaos Alumni Kampus ABC"
);

// Optional
$item_details = array($item1_details);

// Optional
$billing_address = array(
    'first_name'    => "Cahyo",
    'last_name'     => "Wicaksono",
    'address'       => "Jl. ABC No 49",
    'city'          => "Bekasi",
    'postal_code'   => "17143",
    'phone'         => "0812111222",
    'country_code'  => 'IDN'
);

// Optional
$shipping_address = array(
    'first_name'    => "Cahyo",
    'last_name'     => "Wicaksono",
    'address'       => "Jl. ABC No 49",
    'city'          => "Bekasi",
    'postal_code'   => "17143",
    'phone'         => "0812111222",
    'country_code'  => 'IDN'
);

// Optional
$customer_details = array(
    'first_name'    => "Cahyo",
    'last_name'     => "Wicaksono",
    'email'         => "cahyo.wicaksono@gmail.com",
    'phone'         => "0812111222",
    'billing_address'  => $billing_address,
    'shipping_address' => $shipping_address
);

// Optional, remove this to display all available payment methods
$enable_payments = array('credit_card','cimb_clicks','mandiri_clickpay','echannel');

// Fill transaction details
$transaction = array(
    'enabled_payments' => $enable_payments,
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

$snapToken = Midtrans\Snap::getSnapToken($transaction);
// echo "snapToken = ".$snapToken;
$base = $_SERVER['REQUEST_URI'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Integrasi Laravel dengan Midtrans - solusikoding.com</title>
</head>
<body>
<br>
<br>
<button id="pay-button">Pay!</button>
<pre><div id="result-json">JSON Response from Midtrans:<br></div></pre> 

    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $clientKey; ?>"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            // SnapToken acquired from previous step
            snap.pay('<?php echo $snapToken?>', {
                // Optional
                onSuccess: function(result){
                    /* You may add your own js here, this is just example */ 
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result){
                    /* You may add your own js here, this is just example */ 
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result){
                    /* You may add your own js here, this is just example */ 
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>  
</body>
</html>
