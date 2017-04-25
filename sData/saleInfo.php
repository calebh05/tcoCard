
<?php
require_once('../2checkout-php/lib/Twocheckout.php');

Twocheckout::username('APICaleb');
Twocheckout::password('Belac0051!');
Twocheckout::sandbox(false);
Twocheckout::format('json');
Twocheckout::VerifySSL(false);
$args = [
    'sale_id' => $_GET['sale_id']
];

echo "Hello, user.";

try {
$result = Twocheckout_Sale::retrieve($args);
    echo "<pre> Sale Dump: "; print_r($result); echo "</pre>";
} catch (Twocheckout_Error $e) {
    $e->getMessage();
}










