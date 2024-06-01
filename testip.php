// #php 7.x
<?php
 if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    echo 'A:'.$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    echo 'B:'.$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    echo 'C:'.$ip = $_SERVER['REMOTE_ADDR'];
}
?>