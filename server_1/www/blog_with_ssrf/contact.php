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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon super site</title>
</head>
<body>
    <a href="index.php">Accueil</a>
    <a href="javascript:;"><u>Contact</u></a>
    <br /><br />
    <?= (!empty($result)) ? $result.'<hr>' : ''; ?>
    <form action="contact.php" method="post">
        <input type="hidden" name="serverMail" value="localhost:8465">
        <label>Nom : <input type="text" name="name"></label><br/>
        <label>Message : <br/><textarea name="message" cols="40" rows ="5"></textarea></label><br/>
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>