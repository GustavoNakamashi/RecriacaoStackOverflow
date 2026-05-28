<?php
// processamento/gemini.php
define('GEMINI_API_KEY', 'AIzaSyAUTx45p5MLuMrfpp74JYys71sg1OJNl5Y'); // Coloque sua chave

function chamarGemini($pergunta) {
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . GEMINI_API_KEY;
    
    $dados = [
        'contents' => [
            [
                'parts' => [
                    ['text' => 'Você é um assistente especialista em programação. Responda de forma clara e objetiva: ' . $pergunta]
                ]
            ]
        ]
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $resposta = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        $resultado = json_decode($resposta, true);
        if (isset($resultado['candidates'][0]['content']['parts'][0]['text'])) {
            return $resultado['candidates'][0]['content']['parts'][0]['text'];
        }
    }
    return null;
}
?>