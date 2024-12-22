<?php
require_once "veritrans.php";

$veritrans = new veritrans();



$veritrans->set_key_param("00000000001", "500");
var_dump($veritrans->create_key());