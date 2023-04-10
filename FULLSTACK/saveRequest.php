<?php

    //Processar dados segundo a acao solicitada.

    $DevAPI = new DevService($con); //Instanciando a classe DevService para processar os dados dos DEVS.

    $NivelAPI = new NivelService($con); //Instanciando a classe NivelService para processar os dados dos NIVEIS.

    function verifyArgs($args) {

        $valid = true;

        foreach ($args as $in) {
            if($in == '') $valid = false;
        } 


        return $valid;
    }

    switch($_REQUEST["action"]) {

        case 'cadDev':

            $Nome = $_POST["Nome"];
            $Nivel_Id = $_POST["Nivel"];
            $Data = $_POST["Data"];
            $Sexo = $_POST["Sexo"];
            $Hobby = $_POST["Hobby"];

            if(!verifyArgs([$Nome, $Nivel_Id, $Data, $Sexo, $Hobby])) { 
                
                $error = "<span class='text-danger'> <strong> Preencha todos os campos! </strong></span>";
            
                return header('Location: ?page=cadDev&error=' . urlencode($error));
            }

            //Requisitando o método POST da API.

            $DevAPI::POST($Nivel_Id, $Nome, $Data, $Hobby, $Sexo);

            break;
        case 'editDev':

            $Nome = $_POST["Nome"];
            $Nivel_Id = $_POST["Nivel"];
            $Data = $_POST["Data"];
            $Sexo = $_POST["Sexo"];
            $Hobby = $_POST["Hobby"];
            $Id = $_POST["Id"];


            
            if(!verifyArgs([$Nome, $Nivel_Id, $Data, $Sexo, $Hobby, $Id])) { 
                
                $error = "<span class='text-danger'> <strong> Preencha todos os campos! </strong></span>";
            
                return header('Location: ?page=editDev&Id='.$Id.'&error=' . urlencode($error));
            }


            $DevAPI::PUT($Id, $Nivel_Id, $Nome, $Data, $Hobby, $Sexo);

            break;
        case 'deleteDev':
            $Id = $_REQUEST["Id"];

            //Requisitando o método DELETE da API.

            $DevAPI::DELETE($Id);


            break;  
        case 'cadNivel':

            $rankName = $_POST["Nome"];


            if(!verifyArgs([$rankName])) { 
                
                $error = "<span class='text-danger'> <strong> Preencha todos os campos! </strong></span>";
            
                return header('Location: ?page=cadNivel&error=' . urlencode($error));
            }

            
            //Requisitando o método POST da API.

            $NivelAPI::POST($rankName);

            break;
         case 'editNivel':
            $Id = $_POST["Id"];
            $newrankName = $_POST["Nome"];


            
            if(!verifyArgs([$newrankName, $Id])) { 
                
                $error = "<span class='text-danger'> <strong> Preencha todos os campos! </strong></span>";
            
                return header('Location: ?page=editNivel&Id='.$Id.'&error=' . urlencode($error));
            }


            //Requisitando o método PUT da API.

            $NivelAPI::PUT($Id, $newrankName);
            
            break;
        case 'deleteNivel':
            $Id = $_REQUEST["Id"];


            //Requisitando o método DELETE da API.

            $NivelAPI::DELETE($Id);


            break;  
                
    }

?>