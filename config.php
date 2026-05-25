<?php
$host = "db.glvdrydonrsmguxvtuoh.supabase.co";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "SuperMario@202021";
try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>