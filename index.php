<?php

require_once("config.php");
echo "<h3>Retorna pelo id</h3>";

$visualizar = new Usuario();

$visualizar->loadById(1);

echo $visualizar;

echo "<hr>";
echo "<h3>Busca</h3>";

$login = "kitoki";

$busca = Usuario::search($login);

foreach ($busca as $campo) {
    echo json_encode($campo);
    echo "<br>";
}

echo "<hr>";
echo "<h3>Listar todos</h3>";

$lista = Usuario::listar();

foreach ($lista as $campo) {
    echo json_encode($campo);
    echo "<br>";
}

echo "<hr>";
echo "<h3>Autenticado</h3>";

$login = "jose";
$senha = "123456";

echo json_encode(Usuario::autenticar($login, $senha));


?>