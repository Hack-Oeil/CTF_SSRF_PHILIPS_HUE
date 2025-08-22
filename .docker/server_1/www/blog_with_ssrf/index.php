<?php
// Si le fichier __DIR__.'/src/controllers/connexion.php' n'existe pas, c'est que le challenge n'est pas encore configuré)
if(!file_exists(__DIR__.'/config_ok')) { header("location:init.php"); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon super site</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background: #4CAF50;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }
        nav {
            margin: 10px 0;
            text-align: center;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            transition: color 0.3s;
        }
        nav a:hover {
            color: #388E3C;
        }
        main {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #ffffff;
        }
        p {
            line-height: 1.6;
        }
        img {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            border: 2px solid #ddd;
            border-radius: 8px;
        }
        footer {
            text-align: center;
            padding: 15px;
            margin-top: 30px;
            background: #f1f1f1;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>Mon super blog</h1>
    </header>

    <nav>
        <a href="./">Accueil</a>
        <a href="./contact.php">Contact</a>
    </nav>

    <main>
        <h2>Bienvenue sur mon blog !</h2>
        <p>
            Je viens de débuter en programmation. Je ne suis pas encore très bon, mais j’aime ça et j’ai envie de progresser.<br><br>
            Je me suis lancé un défi : créer un projet de domotique.  
            Mon objectif est de pouvoir gérer depuis mon téléphone mes lumières, mes stores électriques et ma climatisation.<br><br>
            Pour l’instant, j’ai uniquement travaillé sur l’allumage des lumières, et je suis déjà content du résultat !<br><br>
            Voici un schéma que j’ai préparé pour mon projet domotique. Je suis très organisé et j’aime partager mon travail avec des inconnus ^^
        </p>

        <img src="schema.png" alt="Schéma de mon projet domotique">

        <p>
            <strong>N’hésitez pas à me contacter pour en discuter.</strong>
        </p>
    </main>

    <footer>
        © 2025 - Mon super blog | Tous droits réservés
    </footer>
</body>
</html>
