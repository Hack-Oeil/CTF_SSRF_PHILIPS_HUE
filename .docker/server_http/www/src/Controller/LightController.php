<?php
namespace App\Controller;

use Yoop\AbstractController;

class LightController extends AbstractController
{
    public function index()
    {
        // s'assurer que c'est un appel du serveur lui même
        if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '0.0.0.0' && $_SERVER['REMOTE_ADDR'] !== 'localhost') {
            die('Accès non autorisé');
        }
        $defaults = array(
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $_POST['serverMail'],
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 2,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query(['name' => $_POST['name']??null, 'message' => $_POST['message']??null ])
        );

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        $result = curl_exec($ch);

        curl_close($ch);
        // vérifier que dans result j'ai : {"status":"OK","newState":1} en faisant un json_decode
        $result = json_decode($result, true);
        if ($result['status'] === 'OK' && (int) $result['newState'] === 1) {
            // afficher une page avec le flag au passage
            return 'FLAG';
        } elseif ($result['status'] === 'OK' && (int) $result['newState'] === 2) {
            // afficher une page avec le flag au passage
            return 'FLAG2';
        } else {
            return 'ERROR';
        }
    }
}