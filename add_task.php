<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    // Vérifier si l'utilisateur existe
    $sql = "SELECT id FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Insertion de la tâche si l'utilisateur existe
        $sql = "INSERT INTO tasks (user_id, titre, description) VALUES ('$user_id', '$titre', '$description')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>Tâche ajoutée avec succès ! <a href='index.php'>Retour à la liste des tâches</a></p>";
        } else {
            echo "<p style='color: red;'>Erreur d'ajout de la tâche : " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Utilisateur non valide !</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Tâche</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter une Tâche</h2>
        <form action="add_task.php" method="POST">
            <label for="titre">Titre de la tâche</label>
            <input type="text" name="titre" required>

            <label for="description">Description de la tâche</label>
            <textarea name="description" required></textarea>

            <button type="submit">Ajouter la tâche</button>
        </form>
        <div class="message">
            <a class="back-link" href="index.php">Retour à la liste des tâches</a>
        </div>
    </div>
</body>
</html>
