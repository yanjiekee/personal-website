<!-- https://www.smashingmagazine.com/2012/05/building-real-time-commenting-system/ -->
<?php
require('Persistence.php');
require('pusher_config.php');

$db = new Persistence();
$added = $db->add_comment($_POST);

if($added) {
    // header ( string $header [, bool $replace = TRUE [, int $http_response_code ]] ) : void
    // Send a raw HTTP header
    // Function below goes to index.php
    header( 'Location: index.php' );
}
else {
    header( 'Location: index.php?error=Your comment was not posted due to errors in your form submission' );
}
?>
