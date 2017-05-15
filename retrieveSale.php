<?php
$host   = "https://api.avangate.com";
$client = new SoapClient($host . "/soap/3.0/?wsdl", array(
    'location' => $host . "/soap/3.0/",
    "stream_context" => stream_context_create(array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false
        )
    ))
));

function hmac($key, $data)
{
    $b = 64; // byte length for md5
    if (strlen($key) > $b) {
        $key = pack("H*", md5($key));
    }

    $key    = str_pad($key, $b, chr(0x00));
    $ipad   = str_pad('', $b, chr(0x36));
    $opad   = str_pad('', $b, chr(0x5c));
    $k_ipad = $key ^ $ipad;
    $k_opad = $key ^ $opad;
    return md5($k_opad . pack("H*", md5($k_ipad . $data)));
}
$merchantCode = "31887";// your account's merchant code available in the 'System settings' area of the cPanel: https://secure.avangate.com/cpanel/account_settings.php
$key = "5U[p7@6^f6^e_F2*v7t)";// your account's secret key available in the 'System settings' area of the cPanel: https://secure.avangate.com/cpanel/account_settings.php
$now          = date('Y-m-d H:i:s'); //date_default_timezone_set('UTC')
$string = strlen($merchantCode) . $merchantCode . strlen($now) . $now;
$hash   = hmac($key, $string);
try {
    $sessionID = $client->login($merchantCode, $now, $hash);
}
catch (SoapFault $e) {
    echo "Authentication: " . $e->getMessage();
    exit;
}
$orderReference = '11324217';
try {
    $fullOrderDetails = $client->getOrder    ($sessionID, $orderReference);
}
catch (SoapFault $e) {
    echo "fullOrderDetails: " . $e->getMessage();
    exit;
}
var_dump("fullOrderDetails", $fullOrderDetails);
?>
