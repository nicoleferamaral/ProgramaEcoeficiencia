<?php
    namespace PHP\Modelo\DAO;

    class Conexao{
        function conectar(){
            try{
                $conn = mysqli_connect('localhost', 'root','','ecoeficiencia');
                if($conn){
          
                    return $conn;
                }
                echo "<br>Algo deu errado!";
            }catch(Except $erro){
                return "Algo deu errado! <br><br>".$erro;
            }

        }
    }

?>

