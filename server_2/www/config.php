<?php
if(sizeof($_POST)) { 
    if(!empty($_POST['host']) && !empty($_POST['apikey'])) {
        if(!empty($_POST['lights'])) {
            $data = '';
            $host = $_POST['host'];
            $apiKey = $_POST['apikey'];

            foreach($_POST['lights'] as $light) {
                $data .= "light('http://$host/api/$apiKey/lights/$light/state','#0000ff');".PHP_EOL;
            }
            file_put_contents('index.php', str_replace('{{ CALL_ACTION }}', $data, file_get_contents('index_base.php')));
            exit('ok');
        }
    }
}