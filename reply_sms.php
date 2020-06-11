<?php
require_once 'twilio-php-app/vendor/autoload.php';
use Twilio\TwiML\MessagingResponse;

// Set the content-type to XML to send back TwiML from the PHP Helper Library
header("content-type: text/xml");

$response = new MessagingResponse();
$response->message(
    "This is BizPlanEasy Support SMS!"
);

echo $response;
?>
