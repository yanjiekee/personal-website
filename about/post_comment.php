<?php
require('Persistence.php');
require('pusher_config.php');

require __DIR__ . '/vendor/autoload.php';

// To make sure this is a Ajax request! Refer: js/app.js function: postComment(data)
$ajax = ($_SERVER[ 'HTTP_X_REQUESTED_WITH' ] === 'XMLHttpRequest');

$db = new Persistence();
$added = $db->add_comment($_POST);

// Event (trigger) to send the new comment from client side to Pusher server, then Pusher can distribute to other clients
if($added) {
    $channel_name = 'comments-' . $added['comment_post_ID'];
    $event_name = 'new_comment';
    $socket_id = (isset($_POST['socket_id'])?$_POST['socket_id']:null);

    $pusher = new Pusher\Pusher(APP_KEY, APP_SECRET, APP_ID, array('cluster' => APP_CLUSTER));
    $pusher->trigger($channel_name, $event_name, $added, $socket_id);
}

// Seperate into Ajax and Standard (by refreshing the webpage?) response
if($ajax) {
    sendAjaxResponse($added);
}
else {
    sendStandardResponse($added);
}

// New method to use Ajax aync http request
// By setting the response Content-Type to “application/json” we tell jQuery to convert the returned string into a JavaScript object.
// For more information: https://www.smashingmagazine.com/2012/02/beginners-guide-jquery-based-json-api-clients/
function sendAjaxResponse($added) {
    header("Content-Type: application/json");   // Or application/x-javascript (?)
    if($added) {
        header( 'Status: 201' );
        echo(json_encode($added));
    // Similar example: https://stackoverflow.com/questions/4064444/returning-json-from-a-php-script
    // Don't know what's the purpose of returning JSON from php script...
    }
    else {
        header( 'Status: 400' );
    }
}

// Old method to refresh the webpage
function sendStandardResponse($added) {
    if($added) {
        // header ( string $header [, bool $replace = TRUE [, int $http_response_code ]] ) : void
        // Send a raw HTTP header
        // Function below goes to index.php
        header( 'Location: index.php' );
    }
    else {
        header( 'Location: index.php?error=Your comment was not posted due to errors in your form submission' );
    }
}

// De-buggings
// function console_log($output, $with_script_tags = true) {
//     $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
// ');';
//     if ($with_script_tags) {
//         $js_code = '<script>' . $js_code . '</script>';
//     }
//     echo $js_code;
// }
?>
