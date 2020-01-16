<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Colaboradores Evea </title>
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
            <h3 class="contentTitle"> Colaboradores </h3>
            <div class="contentOptions">
                <div class="search"></div>
                <div class="contentAdd">
                    <img src="../images/plusSign.png" alt="">
                </div>
            </div>
            <table class="contentTable">
                <tr class="tableTitle">
                <th>Nome</th>
                    <th>Nível de Permissão</th>
                    <th>E-mail</th>
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

        <div class="createModal">
            <form class="formCreate">
                <div class="col">
                    <label for="">Nome</label>
                    <input type="text" name="" id="">
                </div>
                <div class="col">
                    <select name="" id="">
                        <option value="0">Escolha um perfil</option>
                        <option value="">Administrador</option>
                        <option value="">Gerente</option>
                        <option value="">Convidado</option>
                    </select>
                </div>
                <div class="col">
                    <label for="">E-mail</label>
                    <input type="email" name="" id="">
                </div>
                <div class="col">
                    <label for="">Senha</label>
                    <input type="password" name="" id="">
                </div>
                <div class="col">
                    <input type="submit" value="Salvar">
                </div>
            </form>
        </div>

        <div class="editModal">
            <form class="formEdit">
                <div class="col">
                    <label for="">Nome</label>
                    <input type="text" name="" id="">
                </div>
                <div class="col">
                    <select name="" id="">
                        <option value="0">Escolha um perfil</option>
                        <option value="">Administrador</option>
                        <option value="">Gerente</option>
                        <option value="">Convidado</option>
                    </select>
                </div>
                <div class="col">
                    <label for="">E-mail</label>
                    <input type="email" name="" id="">
                </div>
                <div class="col">
                    <input type="submit" value="Salvar">
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