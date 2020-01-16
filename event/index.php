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
            <h3 class="contentTitle"> Eventos</h3>
            <div class="contentOptions">
                <div class="search"></div>
                <div class="contentAdd">
                    <img src="../images/plusSign.png" alt="">
                </div>
            </div>
            <table class="contentTable">
                <tr class="tableTitle">
                    <th>Título</th>
                    <th>Colaborador</th>
                    <th>Data Inicio</th>
                    <th>Data Fim</th>
                    <th>Local</th>
                    <th>Empresa</th>
                    <th>Responsável</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Evento</th>
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
            <form class="formCreate">
                <div class="col-full">
                    <input type="text" id="createTitle" placeholder="Título do evento">
                </div>
                <div class="col-md">
                    <select id="createPlace">
                        <option value="" id="nullPlace" >Escolha um local</option>
                    </select>
                </div>
                <div class="col-md">
                    <select id="createType">
                        <option value="0">Tipo de evento</option>
                        <option value="tc"> Evento Confirmado </option>
                        <option value="ti"> Interno </option>
                        <option value="te"> Externo </option>
                        <option value="tp"> Parcerias </option>
                    </select>
                </div>
                <div class="col-md">
                    <label for="createStartDate">Data Inicio</label>
                    <input type="date" id="createStartDate" min="<?php echo date('Y-m-d'); ?>">
                    <label for="createEndDate">Data Fim</label>
                    <input type="date" id="createEndDate" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>">
                </div>
                <div class="col-md">
                    <label for="createStartTime">Hora Inicio</label>
                    <input type="time" id="createStartTime">
                    <label for="createEndTime">Hora Fim</label>
                    <input type="time" id="createEndTime">
                </div>
                <div class="col-md">
                    <select id="createColab">
                        <option value="0" id="nullColab" >Escolha um responsável</option>
                    </select>
                </div>
                <div class="col-md">
                    <input type="text" id="createComp" placeholder="Nome da Empresa">
                </div>
                <div class="col-md">
                    <input type="text" id="createResp" placeholder="Nome do responsável">
                </div>
                <div class="col-md">
                    <input type="text" id="createPhone" placeholder="Telefone">
                </div>
                <div class="col-full">
                    <input type="email" id="createEmail" placeholder="E-mail">
                </div>
                <div class="col-full">
                    <textarea id="createCommEvent" cols="4" rows="5" placeholder="Observações do evento"></textarea>
                </div>
                <div class="col-full">
                    <textarea id="createCommClient" cols="4" rows="5" placeholder="Observações do cliente"></textarea>
                </div>
                <div class="col-full">
                    <input type="submit" value="Salvar">
                </div>
            </form>
        </div>

        <div class="editModal">
        <input type="hidden" id="editEventID">
            <form class="formEdit">
                <div class="col-full">
                    <input type="text" id="editTitle" placeholder="Título do evento">
                </div>
                <div class="col-md">
                    <select id="editPlace">
                        <option value="0" id="editnullPlace" >Escolha um local</option>
                    </select>
                </div>
                <div class="col-md">
                    <select id="editType">
                        <option value="">Tipo de evento</option>
                        <option value="tc"> Evento Confirmado </option>
                        <option value="ti"> Interno </option>
                        <option value="te"> Externo </option>
                        <option value="tp"> Parcerias </option>
                    </select>
                </div>
                <div class="col-md">
                    <label for="editStartDate">Data Inicio</label>
                    <input type="date" id="editStartDate">
                    <label for="editEndDate">Data Fim</label>
                    <input type="date" id="editEndDate">
                </div>
                <div class="col-md">
                    <label for="editStartTime">Hora Inicio</label>
                    <input type="time" id="editStartTime">
                    <label for="editEndTime">Hora Fim</label>
                    <input type="time" id="editEndTime">
                </div>
                <div class="col-md">
                    <select id="editColab">
                        <option value="0" id="editnullColab" >Escolha um responsável</option>
                    </select>
                </div>
                <div class="col-md">
                    <input type="text" id="editCompany" placeholder="Nome da Empresa">
                </div>
                <div class="col-md">
                    <input type="text" id="editResp" placeholder="Nome do responsável">
                </div>
                <div class="col-md">
                    <input type="text" id="editPhone" placeholder="Telefone">
                </div>
                <div class="col-full">
                    <input type="email" id="editEmail" placeholder="E-mail">
                </div>
                <div class="col-full">
                    <textarea id="editCommEvent" cols="4" rows="5" placeholder="Observações do evento"></textarea>
                </div>
                <div class="col-full">
                    <textarea id="editCommClient" cols="4" rows="5" placeholder="Observações do cliente"></textarea>
                </div>
                <div class="col-full">
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