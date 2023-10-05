<?php
// Si le fichier __DIR__.'/src/controllers/connexion.php' n'existe pas, c'est que le challenge n'est pas encore configuré)
if(!file_exists(__DIR__.'/config_ok')) { header("location:init.php"); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon super site</title>
</head>
<body>
    <a href="javascript:;"><u>Accueil</u></a>
    <a href="contact.php">Contact</a>
    <br /><br />
    Bienvenue sur mon Blog !
    <br>
    <p>
        Je viens de démarrer en programmation, je ne suis pas très bon mais j'aime bien ça.<br />
        Je me suis lancé pour défi, de créer un projet domotique. <br />
        Je veux pouvoir gérer via mon téléphone, mes lumieres, mes stores électriques et ma climatisation.<br />
        Pour le moment j'ai travaillé uniquement sur l'allumage des lumiéres, je suis content du résultat.<br />

        Voici un schéma que j'ai préparé pour ma domotique, je suis très organisé et j'aime partager mon travail avec des inconnus ^^.
        <br />
        <img src="schema.png" >
        <br /><br /> N'hésitez pas à me contacter pour en discuter.
    </p>
</body>
</html>