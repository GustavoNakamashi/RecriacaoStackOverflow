<?php
session_start();
header('Content-Type: application/json');
require_once 'gemini.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['mensagem'])) {
    echo json_encode(['erro' => 'Nenhuma mensagem enviada']);
    exit;
}

$mensagem = trim($_POST['mensagem']);
$resposta = chamarGemini($mensagem);

if ($resposta) {
    echo json_encode(['resposta' => $resposta]);
} else {
    echo json_encode(['resposta' => 'Desculpe, não consegui processar sua pergunta. Tente novamente.']);
}
exit;
