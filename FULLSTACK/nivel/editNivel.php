


<?php
    //Printando erro ao processar dados no saveRequest.php
    $error = isset($_GET['error']) ? print $_GET['error'] : '';

    //Pegando o nome pelo ID do SQL

    $sql = "SELECT * FROM niveis WHERE Id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $_GET['Id']);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res){
        $u = $res->fetch_object();

        $nome = $u->Nivel;
        $Id = $u->Id;
    } else {
        $nome = 'default';
        $Id = $_GET['Id'];
    }




    
    

?>

<form class="row g-3" action="?page=save" method="POST">
    <input type="hidden" name="action" value="editNivel">
    <input type="hidden" name="Id" value="<?php echo $Id ?>">
    <div class="col-md-4">
        <label class="form-label">Novo nome do nível</label>
        <input type="text"  name="Nome" class=" form-control is-valid" required spellcheck="false" value="<?php echo $nome; ?>">
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Alterar</button>
    </div>
</form>