<h1>Desenvolvedores Cadastrados</h1>

<script>


    

    function fire(Id) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Não será possível reverter esta ação!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, delete!'        
        }).then((result) => {
            if (result.isConfirmed) {
               location.href = "?page=save&action=deleteDev&Id=" + Id;
            }
        });
        
    }

    function deleted() {
        Swal.fire(
        'Desenvolvedor deletado com sucesso!',
        '',
        'success'
        )
        
    }

    function edited() {
        Swal.fire(
        'Desenvolvedor atualizado com sucesso!',
        '',
        'success'
        )
        
    }

    function cad() {
        Swal.fire(
        'Cadastrado com sucesso!',
        '',
        'success'
        )
        
    }

    
</script>

<?php 



    //Verificando se houve algum erro na inicialização.

    $error = isset($_GET['error']) ? print $_GET['error'] : '';
    $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    if(isset($_GET['res'])) {
        if($_GET['res'] == 'delete') {
            echo "<script>deleted()</script>";

        }
        if($_GET['res'] == 'edit') {
            echo "<script>edited()</script>";

        }
        if($_GET['res'] == 'cad') {
            echo "<script>cad()</script>";

        }
    }

    //Criar a tabela de niveis.

    function table($X, $S, $con) { 

        $NivelAPI = new NivelService($con);

        if($X > 0) {

            echo "<table class='table table-hover table-striped table-bordered'>";
            echo  "<tr>";
            echo  "<th> #</th>";
            echo  "<th> Nome </th>";
            echo "<th> Nivel </th>";
            echo "<th> Data de nascimento </th>";
            echo "<th> Idade </th>";
            echo "<th> Sexo </th>";
            echo "<th> Hobby </th>";
            echo "<th> ... </th>";
            echo "</tr> ";

            while($row = $S->fetch_object()) {
    
                $Id = $row->Id;
                $Nome = $row->Nome;
                $Nivel = $NivelAPI::GETNAME($row->Nivel_Id);
                $Data = str_replace('-', '/', date("d-m-Y", strtotime($row->DataNascimento)));
                $Idade = ((new DateTime())->diff(new DateTime($row->DataNascimento)))->y;;
                $Sexo = $row->Sexo;
                $Hobby = $row->Hobby;
    
                echo "<tr>";
                echo "<td> ".$Id."</td>";
                echo "<td> ".$Nome." </td>";
                echo "<td> ".$Nivel."</td>";
                echo "<td> ".$Data." </td>";
                echo "<td> ".$Idade."</td>";
                echo "<td> ".$Sexo." </td>";
                echo "<td>".$Hobby."</td>";
                echo "<td> <a class='btn btn-sm btn-primary' href='?page=editDev&Id=$Id'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='blue' class='bi bi-pencil-square' viewBox='0 0 16 16'> <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/><path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/></svg> </a> <a class=\"btn btn-sm btn-primary\" onClick=\"fire($Id)\"> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'><path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/><path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/></svg></a></td>";
                echo "</tr>";
            }
            echo "</table>";
            return true;
        } 
    
        echo "<table class='table table-hover table-striped table-bordered'>";
        echo "<tr>";
        echo "<th> Nenhum desenvolvedor cadastrado.</th>";
        echo "</tr> ";
    
        echo "</table>";
    
        return false;

    }

// Definir o número de itens por página
$itensPorPagina = 5;

// Obter o número total de itens
$sqlCount = "SELECT COUNT(*) AS count FROM desenvolvedores";
$resultCount = $con->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalItens = $rowCount['count'];

// Obter o número total de páginas
$totalPaginas = ceil($totalItens / $itensPorPagina);

// Obter a página atual
$paginaAtual = max(min($paginaAtual, $totalPaginas), 1); // Certificar-se de que a página atual esteja dentro dos limites

// Definir o número do primeiro item da página atual
$primeiroItem = ($paginaAtual - 1) * $itensPorPagina;

// Obter os itens para a página atual
$sql = "SELECT * FROM desenvolvedores LIMIT $primeiroItem, $itensPorPagina";
$res = $con->query($sql);

// Exibir a tabela de itens
table($res->num_rows, $res, $con);

// Exibir os links de paginação
echo '<nav>';
echo '<ul class="pagination">';

if ($paginaAtual > 1) {
    echo '<li class="page-item"><a class="page-link" href="?page=listDev&pagina=' . ($paginaAtual - 1) . '">Anterior</a></li>';
}

for ($i = max(1, $paginaAtual - 2); $i <= min($paginaAtual + 2, $totalPaginas); $i++) {
    if ($i == $paginaAtual) {
        echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="?page=listDev&pagina=' . $i . '">' . $i . '</a></li>';
    }
}

if ($paginaAtual < $totalPaginas) {
    echo '<li class="page-item"><a class="page-link" href="?page=listDev&pagina=' . ($paginaAtual + 1) . '">Próxima</a></li>';
}

echo '</ul>';
echo '</nav>';



?>