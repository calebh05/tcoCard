<?php

require_once($TCO_LIB. '2checkout-php/lib/Twocheckout.php');
/*require_once("2checkout-php/lib/Twocheckout.php");*/
Twocheckout::privateKey('443EE341-9F38-4002-876B-FA486AA1FDCB');
Twocheckout::sellerId('102557782');
Twocheckout::sandbox(false);  #Uncomment to use Sandbox


try {
    $charge = Twocheckout_Charge::auth(array(
        "sellerId" => "",
        "li_0_merchant_order_id" => "1",
        "type"       => "product",
        "token"      => $_POST['token'],
        "currency"   => "USD",
        "total"      => "1.00",

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

        echo "<p>Sale Number: "; echo '<p><a href="sData/' . $sNumber .'.json">' . $charge['response']['orderNumber']. '</a></p>'; // Link to JSON payload data

        echo "<p>Amount: "; print_r($charge['response']['total']); "<pre/>"; //print total amount $0.00
        echo "<p>Code: "; print_r($charge['response']['responseCode']); "<pre/>"; //print responseCode

        file_put_contents('sData/'.$sNumber.'.json', print_r($charge . "\n", true), FILE_APPEND); //write payload to $sNumber.json (sData/$sNumber.json)

    }
} catch (Twocheckout_Error $e) {
    print_r($e->getMessage());

}
?>

<html>
<h1> Section Below is WIP.</h1>
<form id ='info' action='../tcoCard/sData/<?php echo "<pre>"; $_GET['sale_id']; echo "</pre>"?>' method='post'>
    Sale ID: <input type="text" id="sale_id" value='<?php echo "<pre>"; $_GET['sale_id']; echo "</pre>"?>'>
    <input type="submit" value="submit">
</form>
</html>
