<?php
include 'db_connect.php'; // Include il file di connessione al database

// Ottieni i dati inviati dal modulo
$username = $_POST['username'];
$password = $_POST['password'];

// Hash della password per la verifica
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Verifica se l'utente esiste già
    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // L'utente esiste, verifica la password
        if (password_verify($password, $user['password'])) {
            // Imposta una sessione o reindirizza l'utente a un'altra pagina
            header("Location: index.html");
            exit(); // Assicurati di interrompere l'esecuzione dello script dopo il reindirizzamento
        } else {
            // Password errata
            header("Location: login.html?error=wrongpassword");
            exit();
        }
    } else {
        // L'utente non esiste, aggiungilo
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword
        ]);

        // Registrazione effettuata e login riuscito
        header("Location: index.html");
        exit(); // Assicurati di interrompere l'esecuzione dello script dopo il reindirizzamento
    }
} catch (PDOException $e) {
    // Errore nel database
    header("Location: error.html?message=" . urlencode($e->getMessage()));
    exit();
}
?>
