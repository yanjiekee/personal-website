<!-- https://www.smashingmagazine.com/2012/05/building-real-time-commenting-system/ -->
<?php
require('Persistence.php');
require('pusher_config.php');

$db = new Persistence();
$added = $db->add_comment($_POST);

if($added) {
  header( 'Location: index.php' );
}
else {
  header( 'Location: index.php?error=Your comment was not posted due to errors in your form submission' );
}
?>
