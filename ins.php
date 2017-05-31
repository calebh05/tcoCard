<?php require_once('./2checkout-php/lib/Twocheckout/TwoCheckoutNotification.php');

echo "<pre>"; echo "Hello, world!"; echo "</pre>";

    # Validate the Hash
    $hashSecretWord = "tango"; # Input your secret word
    $hashSid = 102557782; #Input your seller ID (2Checkout account number)
    $hashOrder = $insMessage['sale_id'];
    $hashInvoice = $insMessage['invoice_id'];
    $StringToHash = strtoupper(md5($hashOrder . $hashSid . $hashInvoice . $hashSecretWord));

    if ($StringToHash != $insMessage['md5_hash']) {
        die('Hash Incorrect');
    }

    switch ($insMessage['fraud_status']) {
        case 'pass':
            TwoCheckoutNotificationHelper::fraud_pass($insMessage);
            break;
        case 'fail':
            # Do something when sale fails fraud review.
            break;
        case 'wait':
            # Do something when sale requires additional fraud review.
            break;
    }
}

class TwoCheckoutNotificationHelper
{
    public static function sale_new($insMessage)
    {
        if ($_POST['message_type'] == 'ORDER_CREATED') {

            $insMessage = array();
            foreach ($_POST as $k => $v) {
                echo "<pre>";
                echo $insMessage[$k] = $v;
                echo "</pre>";
            }
        }
    }

    public static function fraud_pass($insMessage)
    {

    }
}