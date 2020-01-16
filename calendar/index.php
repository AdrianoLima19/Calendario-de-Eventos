<?php
    session_start();
    if (!isset($_SESSION['isLog'])) {
        header("Location: ../login/index.php");
    }
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendário Evea</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../images/evea-icon-fundo-preto.png" >
    <!-- Jquery , Ajax, Popper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.0.0-rc.2"></script>
</head>
<body>
    <div class="container">
        
        <header class="top">
            <img src="../images/Sistema Fiep-negativo-horizontal.png" alt="Logo SENAI">
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

        <nav class="navigation">
            <input type="hidden" id="actualMonthDisplay" value="">
        <div class="title">
                <h2 class="monthTitle"></h2>
            </div>
            <div class="btn-add">
                <input type="button" value="Adicionar">
            </div>
            <div class="btn-arrow">
                <input type="button" value="<<" id="py"> <!-- Previous Year -->
                <input type="hidden" value="<<" id="hpy"> <!-- Previous Year -->

                <input type="button" value="<" id="pm"> <!-- Previous Month -->
                <input type="hidden" value="<" id="hpm"> <!-- Previous Month -->

                <input type="button" value=">" id="nm"> <!-- Next Month -->
                <input type="hidden" value=">" id="hnm"> <!-- Next Month -->

                <input type="button" value=">>" id="ny">  <!-- Next Year -->
                <input type="hidden" value=">>" id="hny">  <!-- Next Year -->
            </div>
            <div class="btn-today">
                <input type="button" value="Hoje" id="btn-today">
                <input type="hidden" value="Hoje" id="hbtn-today">
            </div>
            <div class="search">
                <form action="" id="search-form">
                <input type="month" id="month-search">
                <input type="submit" value="enviar">
                <input type="button" value="Procurar" id="btn-search">
                </form>
            </div>
        </nav>

        <aside class="leftAside">
            <input type="button" class="left-btn-open" value=">">
            <input type="button" class="left-btn-close" value="<">

            <div class="leftEventScroll">
                <div class="leftEventBlock" style="background:transparent;">
                    <div class="eventName">
                        <h4 class="leftEvent"></h4>
                    </div>
                </div>
            </div>
        </aside>

        <main class="calendar">
            <table class="calendar-display">
                <tr class="calendar-title">
                    <th><span>D</span>omingo</th>
                    <th><span>S</span>egunda</th>
                    <th><span>T</span>erça</th>
                    <th><span>Q</span>uarta</th>
                    <th><span>Q</span>uinta</th>
                    <th><span>S</span>exta</th>
                    <th><span>S</span>ábado</th>
                </tr>
                <tr class="space"><td></td></tr>
                <?php
                    for ($i=0; $i < 6; $i++) {
                        
                        echo '<tr class="calendar-week">';

                        for ($j=0; $j < 7; $j++) { 
                            echo "<td class='day'> <div class='organize'> <p>&nbsp;</p> </div> </td>";
                        }

                        echo '</tr>';
                    }
                ?>
            </table>
        </main>

        <main class="event-calendar">
            <table class="event-table"></table>
        </main>
        
        <footer class="bottom">
            <h3>Copyright &copy; 2019 Grupo Evea - todos os direitos reservados</h3>
        </footer>
    </div>

    <form class="modal" autocomplete="off">
        <input type="hidden" id="eventID">
        <div class="close-bg"></div>

        <div class="close-mod">
            <span class="btn-close-mod">X</span>
        </div>
        
        <div class="add">

            <div class="mod-title">
                <span class="req-info">*</span>
                <input type="text" id="inputTitle" placeholder="Digite o nome do Evento" maxlength="80">
            </div>

            <div class="colab">
                <span class="req-info">*</span>
                <select id="inputColab" >
                    <option value="" selected id="selectColabNull">Responsável...</option>
                </select>
            </div>

            <div class="datetime">
                <div class="date">
                    <span class="req-info">*</span>
                    <label for="inputStartDay">Data Inicio:</label>
                    <input type="date" id="inputStartDay" min="<?php echo date('Y-m-d'); ?>" >
                </div>
                <div class="date">
                    
                    <span class="req-info">*</span>
                    <label for="inputEndDay">Data Fim:</label>
                    <input type="date" id="inputEndDay" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" >
                </div>

                <div class="hour">
                <span class="req-info">*</span>
                    <label for="inputStartTime">Hora Inicio:</label>
                    <input type="time" id="inputStartTime" min="08:00" >
                </div>
                <div class="hour">
                    <span class="req-info">*</span>
                    <label for="inputEndTime">Hora Fim:</label>
                    <input type="time" id="inputEndTime" min="08:00" max="22:00" >
                </div>
            </div>

            <div class="placeType">
                <div class="place">
                    <input type="hidden" id="placeIsValid" value="false">
                    <div>
                        <span class="req-info">*</span>
                        <label for="inputPlace">Local</label>
                    </div>
                    <select id="inputPlace" >
                        <option value="" selected id="selectPlaceNull">Escolha...</option>
                    </select>
                </div>

                <div class="type">
                    <div>
                        <span class="req-info">*</span>
                        <label for="inputType">Evento</label>
                    </div>
                    <select id="inputType" >
                        <option value="" selected>Escolha...</option>
                        <option value="tc"> Evento Confirmado </option>
                        <option value="ti"> Interno </option>
                        <option value="te"> Externo </option>
                        <option value="tp"> Parcerias </option>
                    </select>
                </div>
            </div>
            
            <div class="client">
                <label for="">Empresa</label>
                <input type="text" id="inputCompany" placeholder="Digite o nome da Empresa" maxlength="100">

                <label for="">Cliente</label>
                <input type="text" id="inputClient" placeholder="Nome do responsável" maxlength="100">

                <label for="">E-mail</label>
                <input type="email" id="inputEmail" placeholder="E-mail para contato" maxlength="100">

                <label for="">Telefone</label>
                <input type="text" id="inputPhone" placeholder="Telefone para contato" maxlength="15">

            </div>

            <div class="obs">
                <div class="eventTxt">
                    <textarea id="txtEvent" cols="30" rows="10" placeholder="Obersvações sobre o evento!" maxlength="1000"></textarea>
                </div>

                <div class="clientTxt">
                    <textarea id="txtClient" cols="30" rows="10" placeholder="Obersvações sobre o cliente!" maxlength="1000"></textarea>
                </div>
            </div>

            <div class="sub-modal">
                <input type="submit" id="btn-sub-modal" value="">
            </div>

        </div>

    </form>

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
    <script src="main.js"></script>
</body>
</html>