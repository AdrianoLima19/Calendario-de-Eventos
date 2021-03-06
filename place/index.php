<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Locais Evea </title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../images/evea-icon-fundo-preto.png" >
    <!-- Jquery , Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <header class="top">
            <a href="../calendar/"><img src="../images/Sistema Fiep-negativo-horizontal.png" alt="Logo SENAI"></a>
            <nav class="options">
                <ul>
                    <li><a href="../calendar/">Calendário</a></li>
                    <li><a href="../event/">Eventos</a></li>
                    <li><a href="../place/">Locais</a></li>
                    <li><a href="../collaborator/">Colaboradores</a></li>
                    <li><a href="">Manual</a></li>
                    <li><a href="">Configurações</a></li>
                    <li><a href="../login/checker/logout.php">Sair</a></li>
                </ul>
            </nav>
        </header>
        
        <main class="content">
            <h3 class="contentTitle"> Locais </h3>
            <div class="contentOptions">
                <div class="search"></div>
                <div class="contentAdd">
                    <img src="../images/plusSign.png" alt="">
                </div>
            </div>
            <table class="contentTable">
                <tr class="tableTitle">
                <th>Local</th>
                    <th>Ativo</th>
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>
                <tr clas="contentList">
                </tr>
            </table>
        </main>

        <footer class="bottom">
            <h3>Copyright &copy; 2019 Grupo Evea - todos os direitos reservados</h3>
        </footer>

        <div class="closeSpace">
            <div class="close-mod">
                <span class="btn-close-mod">X</span>
            </div>
        </div>

        <div class="createModal">
            <form class="formCreateModal">
                <div class="col formPlace">
                    <label for="createPlaceName">Local</label>
                    <input type="text" name="" id="createPlaceName">
                </div>
                <div class="col formisActive">
                    <h4>Ativo</h4>
                    <div class="row">
                        <div class="rowOpt">
                            <label for="createActive">Sim</label>
                            <input type="checkbox" class="check" id="createActive" value="active">
                        </div>
                        <div class="rowOpt">
                            <label for="createInactive">Não</label>
                            <input type="checkbox" class="check" id="createInactive" value="inactive">
                        </div>
                    </div>
                    <div class="div-error">
                        <p>Selecione uma opção.</p>
                    </div>
                </div>
                <div class="col submit">
                    <input type="submit" value="Criar">
                </div>
            </form>
        </div>

        <div class="editModal">
            <form class="formEditModal">
                <input type="hidden" id="placeID">
                <div class="col formPlace">
                    <label for="editPlaceName">Local</label>
                    <input type="text" name="" id="editPlaceName">
                </div>
                <div class="col formisActive">
                    <h4>Ativo</h4>
                    <div class="row">
                        <div class="rowOpt">
                            <label for="editActive">Sim</label>
                            <input type="checkbox" class="check" id="editActive" value="active">
                        </div>
                        <div class="rowOpt">
                            <label for="editInactive">Não</label>
                            <input type="checkbox" class="check" id="editInactive" value="inactive">
                        </div>
                    </div>
                    <div class="div-error">
                        <p>Campo vazio ou em uso.</p>
                    </div>
                </div>
                <div class="col submit">
                    <input type="submit" value="Atualizar">
                </div>
            </form>
        </div>
    
        <div class="deleteModal">
            <form class="formDeleteModal">
                <h2>Tem certeza que deseja deletar <span class="deleteName">:evento</span> ?</h2>
                <div class="formOptions">
                    <input type="hidden" id="contentID" value="">
                    <input type="submit" value="Sim" id="deleteContent">
                    <input type="button" value="Não" id="closeDeleteForm">
                </div>
            </form>
        </div>
    </div>

    <script src="main.js"></script>
</body>
</html>