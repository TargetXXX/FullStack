

<form class="row g-3" action="?page=save" method="POST">
    <input type="hidden" name="action" value="cadNivel">
    <div class="col-md-4">
        <label class="form-label">Nome do Nivel</label>
        <input type="text"  maxlength="50" name="Nome" class="form-control is-valid" required spellcheck="false">
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Cadastrar</button>
    </div>
</form>

<?php
    //Printando erro ao processar dados no saveRequest.php
    $error = isset($_GET['error']) ? print $_GET['error'] : '';
?>