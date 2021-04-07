<?php 
require("../../app/core/Payment.php");

$tahun = $_GET['tahun'];

echo $payment->getNominal($tahun);