<?php
namespace App\Controller;

use Yoop\AbstractController;

class ContactController extends AbstractController
{
    public function index()
    {
        return $this->render('contact');
    }

    public function submit()
    {
        $on = '0';
        $flag = null;
        $error = null;
        $success = null;
        if (sizeof($_POST)) {
            if (!empty($_POST['name']) && !empty($_POST['message']) && isset($_POST['serverMail'])) {
                $defaults = array(
                    CURLOPT_HEADER => 0,
                    CURLOPT_URL => $_POST['serverMail'],
                    CURLOPT_FRESH_CONNECT => 1,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_FORBID_REUSE => 1,
                    CURLOPT_TIMEOUT => 2
                );

                $ch = curl_init();
                curl_setopt_array($ch, $defaults);
                $result = curl_exec($ch);
                if ($result && strpos($result, 'FLAG') !== false) {
                    $flag = str_replace('FLAG', $this->getFlag('DEFAULT_CTF_FLAG'), $result);
                    $on = '1';
                } elseif ($result && strpos($result, 'FLAG2') !== false) {
                    $flag = str_replace('FLAG2', $this->getFlag('DEFAULT_CTF_FLAG'), $result);
                    $on = '2';
                } elseif ($result && strpos($result, '250 OK') !== false) {
                    $success = __('Merci pour votre message');
                } else {
                    $error = __("Erreur d'envoi de votre message, le serveur n'a pas répondu comme il se doit");
                }

                curl_close($ch);
            } else {
                $error = __('Tout les champs sont obligatoire');
            }
        }
        // La faille SSRF sera implémentée ici par le créateur du challenge
        // Redirection ou affichage après soumission
        return $this->render('contact', ['error' => $error, 'success' => $success, 'flag' => $flag, 'on' => $on]);
    }
}
