<?php
$username = 'TESTE';
$password = 'rakoto';
$database = 'localhost'; 

$conn = oci_connect($username, $password, $database);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
?>
