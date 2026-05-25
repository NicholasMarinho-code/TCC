<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$supabase_url = "https://glvdrydonrsmguxvtuoh.supabase.co";
$supabase_key = "sb_publishable_rYaIHZw7pZmLrJ6Mwb-dZw_WeH7A9yq";

// Busca os últimos 20 registros de cada dispositivo (mais recentes primeiro)
$query = urlencode("select=id,dispositivo_id,temperatura,data_hora&order=data_hora.desc&limit=100");

$ch = curl_init("$supabase_url/rest/v1/Leitura?$query");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "apikey: $supabase_key",
        "Authorization: Bearer $supabase_key",
        "Content-Type: application/json",
    ],
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    http_response_code(500);
    echo json_encode(["erro" => "Falha ao buscar dados", "codigo" => $httpCode]);
    exit;
}

echo $response;