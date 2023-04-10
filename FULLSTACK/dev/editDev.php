<?php
    //Printando erro ao processar dados no saveRequest.php
    $error = isset($_GET['error']) ? print $_GET['error'] : '';

    //Pegando o nome pelo ID do SQL

    $sql = "SELECT * FROM desenvolvedores WHERE Id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $_GET['Id']);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res){
        $u = $res->fetch_object();

        $nome = $u->Nome;
        $Id = $u->Id;
        $Hobby = $u->Hobby;
        $Nivel_Id = $u->Nivel_Id;
        $Sexo = $u->Sexo;
        $Data = $u->DataNascimento;
    }




    
    

?>


<form class="needs-validation" action="?page=save" method="POST">
  <input type="hidden" name="action" value="editDev">
  <input type="hidden" name="Id" value="<?php echo $Id ?>">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Nome completo</label>
      <input type="text" class="form-control" name="Nome" id="validationCustom01" value="<?php echo $nome ?>" placeholder="Nome completo" required spellcheck="false">
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationCustomNivel">Nivel</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
        </div>
        <select id="nivel" name="Nivel"  class="form-select" aria-label="Escolha um nível." required >
            <?php 
                $NivelAPI = new NivelService($con); 

                $sql = "SELECT * FROM niveis";

                $res = $con->query($sql);
            
                $qtd = $res->num_rows;

                if($qtd > 0) {

                    while($row = $res->fetch_object()) {



                        $Nivel = $row->Nivel;
                        $Id = $row->Id;

                        if($NivelAPI->GETNAME($Nivel_Id) == $Nivel) {

                            echo "<option value='$Id' selected> $Nivel </option>";

                        } else {
                            echo "<option value='$Id'> $Nivel </option>";
                        }
                    }


                } 
            ?>
        </select>
      </div>
      <div class="col-md-4 mb-3">

        <br>
        <label for="validationCustom01">Data de nascimento</label>
        <input type="date" class="form-control" name="Data" data-date-format="dd/mm/yyyy" id="validationCustom01" placeholder="Data nascimento" value="<?php  echo $Data; ?>" required>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustom01">Sexo</label>
        <select id="nivel" name="Sexo"  class="form-select" aria-label="Selecione o Sexo." required>
            <option value='MA' <?php echo ($Sexo == 'MA') ? "Selected" : ''; ?>> Masculino </option>
            <option value='FE' <?php echo ($Sexo == 'FE') ? "Selected" : ''; ?>> Feminino </option>
            <option value='NA' <?php echo ($Sexo == 'NA') ? "Selected" : ''; ?>> Prefiro não dizer </option>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustomH">Hobby</label>
        <textarea class="form-control" name="Hobby" id="validationCustomH" maxlength="50" placeholder="Hobby" required spellcheck="false" ><?php echo $Hobby;?></textarea>
      </div>
    </div>
  </div>

    <button class="btn btn-primary" type="submit">Salvar</button>
</form>

<style>

    #validationCustomH {

        width: 300px;
        height: 80px;

    }

</style>