<?php

require_once("config.php");

$visualizar = new Usuario();

$visualizar->loadById(1);

echo $visualizar;


?>