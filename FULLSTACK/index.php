<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevManager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/complements.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" >DevManager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link"  aria-current="page" href="index.php">Início</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"  href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Niveis
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?page=cadNivel">Cadastrar</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?page=listNivel">Listar</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Desenvolvedores
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="?page=cadDev">Cadastrar</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="?page=listDev">Listar</a></li>
                </ul>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="container c">
        <div class="row">
            
            <div class="col mt-5">
                <?php 
                    //Fazendo a inclusão dos arquivos e criando ações de acordo com as solicitações do usuários.
                    include ('config.php');
                    include('service/Service.php');
                    switch(@$_REQUEST["page"]) {
                        case "cadDev":
                            include("dev/cadDev.php");
                        break;
                        case "listDev":
                            include("dev/listDev.php");
                        break;
                        case "editDev":
                            include("dev/editDev.php");
                        break;
                        case "cadNivel":
                            include("nivel/cadNivel.php");

                        break;
                        case "listNivel":
                            include("nivel/listNivel.php");
                        break;
                        case "editNivel":
                            include("nivel/editNivel.php");
                        break;
                        case "save":
                            include("saveRequest.php");
                        break;
                        default:
                            include("home.php");
                    }

                ?>
            </div>

        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js" ></script>

  </body>
  <footer id="footer" class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-md-4 d-flex align-items-center">
      <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
            <img src="images/ta.jpeg" width="35" height="35" class="bi" viewBox="0 0 16 16">
      </a>
      <span class="mb-3 mb-md-0 text-body-secondary">© 2023 DevManager, Inc</span>
    </div>                
  </footer>

</html>