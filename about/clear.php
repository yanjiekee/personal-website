<!-- https://www.smashingmagazine.com/2012/05/building-real-time-commenting-system/ -->
<?php
require('Persistence.php');

$db = new Persistence();
$db->delete_all();

print_r($db->get_all_comments());
?>
<form action="/about/index.php" method="post">
    <input name="back" type="submit" value="Back (Test)"/>
</form>
