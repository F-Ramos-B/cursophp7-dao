<?php

require_once("config.php");

class Usuario {

    private $idusuario;
    private $login;
    private $senha;
    private $dtcadastro;

    public function getIdusuario() {
        return $this->idusuario;
    }

    public function setIdusuario($value) {
        $this->idusuario = $value;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($value) {
        $this->login = $value;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($value) {
        $this->senha = $value;
    }

    public function getDtCadastro() {
        return $this->dtcadastro;
    }

    public function setDtCadastro($value) {
        $this->dtcadastro = $value;
    }

    public function loadById($id) {
        $dbconn = new DBConn();
        $results = $dbconn->select("SELECT * FROM TB_USUARIOS WHERE idusuario = :ID", array(":ID" => $id));

        if (count($results) > 0) {
            $row = $results[0];

            $this->setIdusuario($row['idusuario']);
            $this->setLogin($row['deslogin']);
            $this->setSenha($row['dessenha']);
            $this->setDtCadastro(new DateTime($row['dtcadastro']));
        }
    }

    public function __toString() {
        return json_encode(array(
            "idusuario" => $this->getIdusuario(),
            "deslogin" => $this->getLogin(),
            "dessenha" => $this->getSenha(),
            "dtcadastro" => $this->getDtCadastro()->format("d/m/Y H:i:s")
        ));
    }

}

?>