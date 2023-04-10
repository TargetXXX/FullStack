
<form id="content" class="needs-validation" action="?page=save" method="POST">
  <input type="hidden" name="action" value="cadDev">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">Nome completo</label>
      <input type="text" maxlength="50" class="form-control" name="Nome" id="validationCustom01" placeholder="Nome completo" required spellcheck="false">
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationCustomNivel">Nivel</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="inputGroupPrepend">@</span>
        </div>
        <select id="nivel" name="Nivel"  class="form-select" aria-label="Escolha um nível." required>
            <?php 
                $NivelAPI = new NivelService($con); 

                $sql = "SELECT * FROM niveis";

                $res = $con->query($sql);
            
                $qtd = $res->num_rows;
                if($qtd > 0) {

                    while($row = $res->fetch_object()) {

                        $Nivel = $row->Nivel;
                        $Id = $row->Id;

                        echo "<option value='$Id'> $Nivel </option>";

                    }


                } 
            ?>
        </select>
      </div>
      <div class="col-md-4 mb-3">

        <br>
        <label for="validationCustom01">Data de nascimento</label>
        <input type="date" class="form-control" name="Data" data-date-format="dd/mm/yyyy" id="validationCustom01" placeholder="Data nascimento" required>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustom01">Sexo</label>
        <select id="nivel" name="Sexo"  class="form-select" aria-label="Selecione o Sexo." required>
            <option value='MA'> Masculino </option>
            <option value='FE'> Feminino </option>
            <option value='NA'> Prefiro não dizer </option>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustomH">Hobby</label>
        <textarea class="form-control" name="Hobby" id="validationCustomH" maxlength="50" placeholder="Hobby" required spellcheck="false"></textarea>
      </div>
    </div>
  </div>

    <button class="btn btn-primary" type="submit">Cadastar</button>
</form>

<style>

    #validationCustomH {

        width: 300px;
        height: 80px;

    }

</style>
<?php
    //Printando erro ao processar dados no saveRequest.php
    $error = isset($_GET['error']) ? print $_GET['error'] : '';
?>