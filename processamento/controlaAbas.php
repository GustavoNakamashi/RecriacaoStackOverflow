<?php

    $aba = isset($_GET['pagina']) ? $_GET['pagina'] : 'perguntas';

    switch ($aba) {
        case 'perguntas':
            include 'sub_perguntas.php';
            break;
            
        case 'dashboard':
            include 'sub_dashboard.php';
            break;
            
        case 'perfil':
            include 'sub_perfil.php';
            break;
            
        default:
            include 'sub_perguntas.php';
            break;
    }
    ?>