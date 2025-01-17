<?php
$serverName = "192.168.190.18\SQLexpress"; //serverName\instanceName
$connectionInfo = array("Database"=>"MCS", "UID"=>"ASILA", "PWD"=>"NGK@123");
$con = sqlsrv_connect( $serverName, $connectionInfo);
?>