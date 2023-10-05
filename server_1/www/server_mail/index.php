<?php

if(!empty($_POST['name']) && !empty($_POST['message'])) {
    echo 'Message envoyé !';
} else {
    echo 'Message non envoyé, vous devez saisir tous les champs !';
}