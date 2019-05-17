<h2><a href=".">Atualizar</a></h2>
<?php
require_once("config.php");
if (isset($_GET["msg"]) && null !== $_GET["msg"]) {
    echo "<font color='red'>" . $_GET["msg"] . "</font>";
}
?>
<hr>


<?php
if (isset($_GET["task"]) && $_GET["task"] == "editar") {
    $edit_id = $_GET["edit_id"];
    $user = new Usuario();
    $user->loadById($edit_id);
    $edit_login = $user->getLogin();
    $edit_senha = $user->getSenha();
    echo "<h3>Editar usuário $edit_login</h3>";
    echo "<a href='.?task=remover&del_id=$edit_id'>Remover</a><br><br>";
    echo '<form action=".?task&$edit_login&$edit_senha" method="get">';
    echo '<input type="hidden" id="task" name="task" value="editou">';
    echo "<input type='hidden' id='editou_id' name='editou_id' value='$edit_id'>";
    echo "Login: <input type='text' name='edit_login' value='$edit_login'><br>";
    echo "Senha: <input type='text' name='edit_senha' value='$edit_senha'><br>";
    echo '<input type="submit" value="Alterar">';
    echo '</form>';
    echo '<hr>';
}

if (isset($_GET["task"]) && ($_GET["task"]) == "editou") {
    $edit_id = $_GET["editou_id"];
    $editado_login = $_GET["edit_login"];
    $editado_senha = $_GET["edit_senha"];
    $user = new Usuario();
    $user->loadById($edit_id);
    $user->editar($editado_login, $editado_senha);
    $msg = "Usuário editado com sucesso!";
    header("Location: index.php?msg=$msg");
}

if (isset($_GET["task"]) && ($_GET["task"]) == "remover") {
    Usuario::delete($_GET["del_id"]);
    $msg = "Usuário removido com sucesso.";
    header("Location: index.php?msg=$msg");
}
?>

<h3>Adicionar</h3>

<form action=".?task&flogin&fsenha" method="get">
    <input type="hidden" id="task" name="task" value="inserir">
    Login: <input type="text" name="flogin"><br>
    Senha: <input type="text" name="fsenha"><br>
    <input type="submit" value="Criar">
</form>

<?php
if (isset($_GET["task"]) && ($_GET["task"]) == "inserir") {
    $l_add = $_GET["flogin"];
    $s_add = $_GET["fsenha"];
    Usuario::inserir($l_add, $s_add);
    echo "<br>Usuário adicionado!<br>";
    header("Location: index.php");
}
?>
<hr>
<h3>Retorna pelo id</h3>

<form action=".?task&fid" method="get">
    <input type="hidden" id="task" name="task" value="buscaid">
    ID: <input type="text" name="fid"><br>
    <input type="submit" value="Pesquisar">
</form>

<?php
if (isset($_GET["task"]) && $_GET["task"] == "buscaid") {
    $id_load = $_GET["fid"];
    $user = new Usuario();
    $user->loadById($id_load);
    if (null !== $user->getIdusuario()) {
        echo $user;
    } else {
        echo "Usuário não localizado.";
    }
}
?>

<hr>
<h3>Busca</h3>

<form action=".?task&f_busca" method="get">
    <input type="hidden" id="task" name="task" value="buscar">
    Login: <input type="text" name="f_busca"><br>
    <input type="submit" value="Buscar">
</form>


<?php
if (isset($_GET["task"]) && $_GET["task"] == "buscar") {
    $nome_buscar = $_GET["f_busca"];
    $busca = Usuario::search($nome_buscar);
    if (count($busca) > 0) {
        foreach ($busca as $campo) {
            echo json_encode($campo);
            echo "<br>";
        }
    } else {
        echo "Usuário não localizado.";
    }
}
?>

<hr>
<h3>Autenticar</h3>

<form action=".?task&f_autent_login&f_autent_senha" method="get">
    <input type="hidden" id="task" name="task" value="autenticar">
    Login: <input type="text" name="f_autent_login"><br>
    Senha: <input type="text" name="f_autent_senha"><br>
    <input type="submit" value="Autenticar">
</form>

<?php
if (isset($_GET["task"]) && $_GET["task"] == "autenticar") {
    $login_autenticar = $_GET["f_autent_login"];
    $senha_autenticar = $_GET["f_autent_senha"];
    $autenticado = Usuario::autenticar($login_autenticar, $senha_autenticar);
    if (count($autenticado) > 0) {
        echo "Usuário " . $autenticado[0]['deslogin'] . " autenticado com sucesso!<br>";
        echo json_encode($autenticado);
        echo "<br>";
    } else {
        echo "Este login e senha não combinam com nenhum usuário.";
    }
}
?>
<hr>
<h3>Procedure</h3>

<form action=".?task&f_proc_login&f_proc_senha" method="get">
    <input type="hidden" id="task" name="task" value="procedure">
    Login: <input type="text" name="f_proc_login"><br>
    Senha: <input type="text" name="f_proc_senha"><br>
    <input type="submit" value="Criar">
</form>

<?php
if (isset($_GET["task"]) && ($_GET["task"]) == "procedure") {
    $l_proc = $_GET["f_proc_login"];
    $s_proc = $_GET["f_proc_senha"];
    $user = new Usuario();
    $user->setLogin($l_proc);
    $user->setSenha($s_proc);
    $user->procedure();
    echo $user;
    echo "<br>Usuário adicionado pela procedure!<br>";
}
echo "<hr>";
echo "<h3>Listar todos</h3>";

$lista = Usuario::listar();

echo "Clique para editar.<br>";

foreach ($lista as $campo) {
//    $id = $campo[0];
    echo '<a href=".?task=editar&edit_id=' . $campo['idusuario'] . '">' . json_encode($campo) . "</a>";
    echo "<br>";
}



echo "<br>";
foreach ($lista as $row) {
    foreach ($row as $key => $value) {
        echo "<strong>" . $key . ":</strong> " . $value . "<br>";
    }
    echo "<br>";
}
?>

