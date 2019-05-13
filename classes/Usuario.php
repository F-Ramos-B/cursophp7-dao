<?php

require_once("config.php");

$dbconn = new DBConn();

echo json_encode($dbconn->select("SELECT * FROM TB_USUARIOS"));

?>