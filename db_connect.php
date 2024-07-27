<?php
$servername = "localhost"; // Di solito "localhost"
$username = "root"; // Sostituisci con il tuo username MySQL
$password = "root"; // Sostituisci con la tua password MySQL
$dbname = "tweakerdb";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connessione riuscita!";
} catch(PDOException $e) {
    echo "Connessione fallita: " . $e->getMessage();
}
?>
