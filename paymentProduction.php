

<?php
require_once("2checkout-php/lib/Twocheckout.php");
Twocheckout::privateKey('397081F6-200D-4EE5-A169-293686030BBF');
Twocheckout::sellerId('901274292');
Twocheckout::sandbox(true);  #Uncomment to use Sandbox




try {
    $charge = Twocheckout_Charge::auth(array(
        "sellerId" => "",
        "li_0_merchant_order_id" => "1",
        "type" => "product",
        "token"      => $_POST['token'],
        "currency"   => "USD",
        "total" => "1.00",

       "lineItems" => array(
           "0" => array(
                "name" => $_POST['name'],
                "price" => $_POST['price'],
                "quantity" => $_POST['quantity'],
                "startupFee" => $_POST['startupFee'],
                "tangible" => $_POST['tangible']
                )
             ),
        "billingAddr" => array(
            "name" => $_POST['customer'],
            "addrLine1" => $_POST['addrLine1'],
            "city" => $_POST['city'],
            "state" => $_POST['state'],
            "zipCode" => $_POST['zipCode'],
            "country" => $_POST['country'],
            "email" => $_POST['email'],
            "phoneNumber" => ''
            )
           ));

    if ($charge['response']['responseCode'] == 'APPROVED') {

        
        $sNumber = $charge['response']['orderNumber']; 
        # $json = json_encode(array('data' => $charge));

        echo "<p>Sale Number: "; echo '<p><a href="saleInfo.php?sale_id=' . $sNumber . '">' . $charge['response']['orderNumber']. '</a></p>'; // Link to JSON payload data

        echo "<p>Amount: "; print_r($charge['response']['total']); "<pre/>"; //print total amount $0.00
        echo "<p>Code: "; print_r($charge['response']['responseCode']); "<pre/>"; //print responseCode

        file_put_contents('sData/'.$sNumber.'.json', print_r($charge . "\n", true), FILE_APPEND); //write payload to $sNumber.json (sData/$sNumber.json)

    }
} catch (Twocheckout_Error $e) {
    print_r($e->getMessage());

}
?>

