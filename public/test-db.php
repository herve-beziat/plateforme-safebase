<?php
$host = '127.0.0.1';
$port = 3306;
$dbname = 'silver-micro';
$user = 'root';
$pass = '';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    echo "✅ Connexion réussie à la base de données.";
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}