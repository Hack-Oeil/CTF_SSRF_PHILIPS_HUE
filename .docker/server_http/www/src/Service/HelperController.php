<?php
namespace App\Service;
use Yoop\AbstractController;

class HelperController extends AbstractController { 
    /**
     * La fonction getFlag étant en protected on doit ajouter un helper
     */
    public function flag($name) {
        return $this->getFlag($name);
    }

    public function secretIsCorrect(string $data, string $secret) {
        return $this->isSecretData($data, $secret);
    }
    
}