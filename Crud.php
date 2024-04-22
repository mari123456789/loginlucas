<?php

class Crud {

    private $connect;
    private $nome;
    private $idade;
    private $email;

    function __construct($conect)
    {
        $this->connect = $conect;

        }

    public function setDados($nome,$idade,$email){

        $this->nome = $nome;
        $this->idade = $idade;
        $this->email = $email;
        
    }

    public function insertDados(){
        $sql = $this->connect->prepare("INSERT INTO clientes(nome, idade, email, data_now) VALUES(?, ?, ?, NOW())");

        $sql->bindParam(1, $this->nome);
        $sql->bindParam(2, $this->email);
        $sql->bindParam(3, $this->idade);

        echo "<br>";
        echo "<br>";
        if($sql->execute()){
        echo "Inserido com Sucesso!";
    }else{
        echo "Deu Ruim!!!!!";
    }

    }// fim do insertDados

    public function readInfo($id = null){
        if(isset($id)){
        $sql = $this->connect->prepare("SELECT * FROM clientes WHERE id=?");

        $sql->bindValue(1,$id);

        $sql->execute();

        $result = $sql->fetch(PDO::FETCH_OBJ);

        return $result;

        }else{
            $this->getAll(); // metado para consultar a tabela inteira
        }

    } // fim do readInfo

    public function getAll(){

        $sql = $this->connect->query("SELECT * FROM clientes"); 

        return  $sql->fetchAll();

    } //fim getAll
 
    public function readInfoAll($nome = null){
        if (isset($nome)) {
           $sql = $this->connect->prepare("SELECT * FROM clientes WHERE nome LIKE ?");

           $sql->bindValue(1,"%$nome%");

           $sql->execute();

           // $result = $sql->fetch(PDO::FETCH_OBJ);

           $result = $sql->fetchAll(PDO::FETCH_ASSOC);

           return $result;

        }else{
            $this->getAll();
        }

    }//fim do readinfoall

    public function update($id,$nome,$idade,$email){

        $sql = $this->connect->prepare("UPDATE clientes SET nome=?, idade=?, email=? WHERE id=?");

        $sql->bindValue(1,$nome,PDO::PARAM_STR);
        $sql->bindValue(2,$idade,PDO::PARAM_STR);
        $sql->bindValue(3,$email,PDO::PARAM_STR);
        $sql->bindValue(4,$id,PDO::PARAM_STR);

        if($sql->execute()){
            echo "Registro Atualizado! <br> <p> <a href='readAll.php'> Voltar </a> </p>";
        }else{
            echo "Problemas ao tentar atualizar o registro! <br> <p> <a href='readAll.php'> Voltar </a> </p>";
        }

    }// fim update

    public function delete($id){

        $sql = $this->connect->prepare("DELETE FROM clientes WHERE id=?");

        $sql->bindValue(1,$id,PDO::PARAM_STR);

        if ($sql->execute()) {
            echo "Registro Excluído! <br> <p> <a href='readAllDelete.php'> Voltar </a> </p>";
        }else{
            echo "Problemas ao tentar excluir o registro! <br> <p> <a href='readAllDelete.php'> Voltar </a> </p>";
        }

    }

}// fim da classe
?>