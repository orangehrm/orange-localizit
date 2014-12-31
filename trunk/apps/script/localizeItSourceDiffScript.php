<?php

const USER_NAME = 'root';
const PASSWORD = 'root';
const HOST = 'localhost';
const DATABASE = 'Localizit';

$xml = simplexml_load_file("messages.zz_ZZ.xml");
$transUnit = $xml->file->body->children()->getName();
$sourceArray = array();

foreach ($xml->file->body->$transUnit as $sourceObj) {
    $source = $sourceObj->source[0];
    $sourceArray[] = (string) $source;
}

$servername = HOST;
$username = USER_NAME;
$password = PASSWORD;

$conn = mysql_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$db = mysql_select_db(DATABASE, $conn);
$result = mysql_query('SELECT value AS sourceValue FROM `ohrm_source`');

$dbArray = array();
while ($row = mysql_fetch_array($result)) {
    $dbArray[] = $row['sourceValue'];
}
$different = array_diff($dbArray, $sourceArray);
$string = '';
foreach ($different as $diff) {
    $string .= $diff."\n\n";
}

file_put_contents('diffFile.txt', $string);
