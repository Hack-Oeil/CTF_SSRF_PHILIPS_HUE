<?php
if(sizeof($_POST)) { 
    if(!empty($_POST['host']) && !empty($_POST['apikey'])) {
        if(!empty($_POST['lights'])) {
            $data = '';
            $host = $_POST['host'];
            $apiKey = $_POST['apikey'];

            foreach($_POST['lights'] as $light) {
                $data .= "light('http://$host/api/$apiKey/lights/$light/state');".PHP_EOL;
            }
            $base = file_get_contents('index_base.php');
            if ($base !== false) {
                $content = str_replace('{{ CALL_ACTION }}', $data, $base);
                $bytes = file_put_contents('index.php', $content);
                if ($bytes !== false && file_exists('index.php') && filesize('index.php') > 0) {
                    exit('config_written_ok');
                }
            }
        }
    }
}
exit('error');