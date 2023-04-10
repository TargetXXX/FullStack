<?php 
    class DevService {

        private static $con;
        public function __construct($con){
            self::$con = $con;
        }

        public static function POST($Nivel_Id, $Nome, $Datanascimento, $Hobby, $Sexo) {

            $NivelAPI = new NivelService(self::$con);

            if($Nivel_Id == '' || $Nome == '' || $Datanascimento == '' || $Hobby== '' || $Sexo == '') $error = "<span class='text-danger'> <strong> Preencha todos os campos! </strong> <span>";

            //Verificando se o DEV já está cadastrado.

            if(self::EXISTS($Nome)) $error = "<span class='text-danger'> <strong> Desenvolvedor já cadastrado! </strong> <span>";

            //Verificando se o Nível existe.

            if(!$NivelAPI->EXISTSID($Nivel_Id)) $error = "<span class='text-danger'> <strong> Nivel não existe! </strong> <span>";

            //Verificando se há erros na solicitação.

            if(!empty($error)) return header('Location: ?page=cadDev&error=' . urlencode($error));

            //Inserindo dados na tabela.

            $sql = "INSERT INTO desenvolvedores (Nivel_Id, Nome, DataNascimento, Sexo, Hobby) VALUES (?, ?, ?, ?, ?)";

            $stmt = self::$con->prepare($sql);
            $stmt->bind_param("sssss", $Nivel_Id, $Nome, $Datanascimento, $Sexo, $Hobby);
            $stmt->execute();

            echo "<script>location.href = '?page=listDev&res=cad'</script>";

            return true;

        }

        public static function DELETE($Id) {
            //Verificando se o desenvolvedor existe.

            if(!self::EXISTSID($Id)) $error = "<span class='text-danger'> <strong> Desenvolvedor não existe! </strong></span>";


            //Verificando se há erros na solicitação.

            if(!empty($error)) return header('Location: ?page=listDev&error=' . urlencode($error));


            //Deletando dados na tabela.

            $sql = "DELETE FROM desenvolvedores WHERE ID=?";

            $stmt = self::$con->prepare($sql);
            $stmt->bind_param("s", $Id);
            $stmt->execute();

            echo "<script>location.href = '?page=listDev&res=delete'</script>";

            return true;

        }

            public static function PUT($Id, $Nivel_Id, $Nome, $Datanascimento, $Hobby, $Sexo) {


                //Validando o valor $Id
                if (!ctype_digit(strval($Id)) || $Id <= 0) {
                    $error = "<span class='text-danger'> <strong> ID inválido! </strong> </span>";
                    return header('Location: ?page=editDev&error=' . urlencode($error). '&Id='.$Id);
                }

                //Verificando se o novo nome do nível já existe
                $sql = "SELECT * FROM niveis WHERE Id=?";
                $stmt = self::$con->prepare($sql);
                $stmt->bind_param('s', $Nivel_Id);
                $stmt->execute();
                $res = $stmt->get_result();
                if (mysqli_num_rows($res) < 1) {
                    $error = "<span class='text-danger'> <strong> Nível não existe! </strong> </span>";
                    return header('Location: ?page=editDev&error=' . urlencode($error). '&Id='.$Id);
                }

                //Atualizando dados na tabela.
                $sql = "UPDATE desenvolvedores SET Nivel_Id=?, Nome=?, DataNascimento=?, Sexo=?, Hobby=? WHERE Id=?";
                $stmt = self::$con->prepare($sql);
                $stmt->bind_param('sssssi', $Nivel_Id, $Nome, $Datanascimento, $Sexo, $Hobby, $Id);
                $stmt->execute();

                echo "<script> location.href = '?page=listDev&res=edit'</script>";
                return true;
            }

        public static function GET($Id) {
            return false;
        }

        public static function EXISTS($Nome) {

            //Selecionando dados para verificar a existência pelo nome.

            $sql = "SELECT * FROM desenvolvedores WHERE Nome=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('s', $Nome);
            $stmt->execute();
            $res = $stmt->get_result();

            //Verificando se o nome de desenvolvedor já está cadastrado.

            if(mysqli_num_rows($res) > 0) return true;

            return false;
        }

        public static function EXISTSID($Id) {

            //Selecionando dados para verificar a existência pelo id.


            $sql = "SELECT * FROM desenvolvedores WHERE Id=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('s', $Id);
            $stmt->execute();
            $res = $stmt->get_result();


            //Verificando se o desenvolvedor já está cadastrado.

            if(mysqli_num_rows($res) > 0) return true;

            return false;
        }
    }

    class NivelService {

        private static $con;

        public function __construct($con){
            self::$con = $con;
        }

        public static function POST($Nome) {
            
            if($Nome == '') $error = "<span class='text-danger'> <strong> Preencha todos os campos! </strong> <span>";

            //Verificando se o nivel já está cadastrado.

            if(self::EXISTS($Nome)) $error = "<span class='text-danger'> <strong> Nivel já cadastrado! </strong> <span>";

            //Verificando se há erros na solicitação.

            if(!empty($error)) return header('Location: ?page=cadNivel&error=' . urlencode($error));

            //Inserindo dados na tabela.

            $sql = "INSERT INTO niveis (Nivel) VALUES (?)";

            $stmt = self::$con->prepare($sql);
            $stmt->bind_param("s", $Nome);
            $stmt->execute();

            echo "<script>location.href = '?page=listNivel&res=cad'</script>";

            return true;

        }

        public static function DELETE($Id) {

            //Verificando se o nivel existe

            if(!self::EXISTSID($Id)) $error = "<span class='text-danger'> <strong> Nivel não existe! </strong></span>";

            if(self::RELATED($Id) > 0) $error = "<span class='text-danger'> <strong> Nivel cadastrado a algum desenvolvedor! </strong></span>";

            //Verificando se há erros na solicitação.

            if(!empty($error)) return header('Location: ?page=listNivel&error=' . urlencode($error));


            //Deletando dados na tabela.

            $sql = "DELETE FROM niveis WHERE ID=?";

            $stmt = self::$con->prepare($sql);
            $stmt->bind_param("s", $Id);
            $stmt->execute();

            echo "<script>location.href = '?page=listNivel&res=delete'</script>";

            return true;

        }

        public static function PUT($Id, $newrankName) {

            //Validando o valor $Id
            if (!ctype_digit(strval($Id)) || $Id <= 0) {
                $error = "<span class='text-danger'> <strong> ID inválido! </strong> </span>";
                return header('Location: ?page=editNivel&error=' . urlencode($error). '&Id='.$Id);
            }

            //Verificando se o novo nome do nível já existe
            $sql = "SELECT * FROM niveis WHERE Nivel=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('s', $newrankName);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $error = "<span class='text-danger'> <strong> Nível já existe! </strong> </span>";
                return header('Location: ?page=editNivel&error=' . urlencode($error). '&Id='.$Id);
            }

            //Atualizando dados na tabela.
            $sql = "UPDATE niveis SET Nivel=? WHERE id=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('si', $newrankName, $Id);
            $stmt->execute();

            echo "<script>location.href = '?page=listNivel&res=edit'</script>";
            return true;
        }

        public static function GETNAME($Id) {

            $sql = "SELECT * FROM niveis WHERE Id=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('s', $Id);
            $stmt->execute();
            $res = $stmt->get_result();

            $Nome = '';

            while($row = $res->fetch_object()) {

                $Nome = $row->Nivel;

            }

            return $Nome;
        }

        public static function GETID($Nome) {

            $sql = "SELECT * FROM niveis WHERE Nome=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('s', $Nome);
            $stmt->execute();
            $res = $stmt->get_result();

            $Nome = '';

            while($row = $res->fetch_object()) {

                $Nome = $row->Id;

            }

            return $Nome;
        }

        public static function EXISTS($Nome) {

            //Selecionando dados para verificar a existência pelo nome.

            $sql = "SELECT * FROM niveis WHERE Nivel=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('s', $Nome);
            $stmt->execute();
            $res = $stmt->get_result();

            //Verificando se o nivel já está cadastrado.

            if(mysqli_num_rows($res) > 0) return true;

            return false;
        }

        public static function EXISTSID($Id) {

            //Selecionando dados para verificar a existência pelo id.


            $sql = "SELECT * FROM niveis WHERE Id=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('s', $Id);
            $stmt->execute();
            $res = $stmt->get_result();


            //Verificando se o nivel já está cadastrado.

            if(mysqli_num_rows($res) > 0) return true;

            return false;
        }

        public static function RELATED($Nivel_Id) {

            //Selecionando dados para verificar se existe algum desenvolvedor com tal nivel.




            $sql = "SELECT * FROM desenvolvedores WHERE Nivel_Id=?";
            $stmt = self::$con->prepare($sql);
            $stmt->bind_param('s', $Nivel_Id);
            $stmt->execute();
            $res = $stmt->get_result();


            return mysqli_num_rows($res);


        }
    }