<?php
$result = null;
if(sizeof($_POST)) {
    if(isset($_POST['serverMail'])) {
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $_POST['serverMail'],
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query(['name' => $_POST['name']??null, 'message' => $_POST['message']??null ])
        );
    
        $ch = curl_init();
        curl_setopt_array($ch,$defaults);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Mon super site</title>
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
        nav a:hover, nav a u {
            color: #388E3C;
        }
        main {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 15px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 1em;
        }
        textarea {
            resize: vertical;
        }
        input[type="submit"] {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background: #388E3C;
        }
        .result {
            margin: 15px 0;
            padding: 10px;
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            border-radius: 6px;
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
        <a href="index.php">Accueil</a>
        <a href="javascript:;"><u>Contact</u></a>
    </nav>

    <main>
        <h2>Formulaire de contact</h2>

        <?= (!empty($result)) ? '<div class="result">'.$result.'</div><hr>' : ''; ?>

        <form action="contact.php" method="post">
            <input type="hidden" name="serverMail" value="localhost:8465">

            <label>
                Nom :
                <input type="text" name="name" required>
            </label>

            <label>
                Message :
                <textarea name="message" cols="40" rows="5" required></textarea>
            </label>

            <input type="submit" value="Envoyer">
        </form>
    </main>

    <footer>
        © 2025 - Mon super blog | Tous droits réservés
    </footer>
</body>
</html>
