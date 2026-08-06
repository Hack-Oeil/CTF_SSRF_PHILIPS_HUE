<?php
$socket = stream_socket_server("tcp://0.0.0.0:465", $errno, $errstr);
if (!$socket) {
    die("Erreur: $errstr ($errno)\n");
}
echo "Serveur TCP (mock) en ecoute sur le port 465...\n";

while ($conn = stream_socket_accept($socket, -1)) {
    stream_set_blocking($conn, false);

    $data = "";
    $read = [$conn];
    $write = null;
    $except = null;

    // Attendre 0.2s pour voir si le client "parle" en premier (ex: HTTP, Gopher)
    if (stream_select($read, $write, $except, 0, 200000) > 0) {
        while (true) {
            $chunk = fread($conn, 8192);
            if ($chunk === false || $chunk === '') {
                break;
            }
            $data .= $chunk;
            $read2 = [$conn];
            // Pause très courte pour s'assurer qu'on a lu la fin du paquet
            if (stream_select($read2, $write, $except, 0, 50000) == 0) {
                break;
            }
        }
    } else {
        // Le client attend (vrai client SMTP)
        stream_set_blocking($conn, true);
        fwrite($conn, "220 Mock SMTP Server Ready\r\n");
        stream_set_timeout($conn, 2);
        while ($line = fgets($conn)) {
            $data .= $line;
            $cmd = strtoupper(substr(trim($line), 0, 4));
            if ($cmd === 'QUIT') {
                fwrite($conn, "221 Bye\r\n");
                break;
            } elseif ($cmd === 'DATA') {
                fwrite($conn, "354 End data with <CR><LF>.<CR><LF>\r\n");
                while ($dline = fgets($conn)) {
                    $data .= $dline;
                    if (trim($dline) === '.') {
                        break;
                    }
                }
                break;
            } else {
                if (trim($cmd) !== '') {
                    fwrite($conn, "250 OK\r\n");
                }
            }
        }
    }

    stream_set_blocking($conn, true);

    $is_http = (strpos($data, 'HTTP/') !== false && (strpos($data, 'GET ') === 0 || strpos($data, 'POST ') === 0));
    $resp_body = "ERROR_PROTOCOL";
    if ($is_http) {
        $resp = "HTTP/1.1 200 OK\r\n";
        $resp .= "Content-Type: text/plain\r\n";
        $resp .= "Connection: close\r\n";
        $resp .= "Content-Length: " . strlen($resp_body) . "\r\n\r\n";
        $resp .= $resp_body;
        fwrite($conn, $resp);
    } else {
        if (strpos($data, 'DATA') !== false) {
            fwrite($conn, "250 $resp_body\r\n");
        } else {
            fwrite($conn, $resp_body);
        }
    }

    fclose($conn);
}
