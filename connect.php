<?php
$serverName = "192.168.190.40,1433"; //serverName\instanceName
$connectionInfo = array("Database"=>"MCS", "UID"=>"MIS", "PWD"=>"NGK@123");
$con = sqlsrv_connect( $serverName, $connectionInfo);
?>