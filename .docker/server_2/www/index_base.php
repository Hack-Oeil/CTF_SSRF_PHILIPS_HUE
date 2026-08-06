<?php

function light($url)
{
    $defaults = array(
        CURLOPT_POST => 1,
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
		CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => '{"on": true}'
    );

    $ch = curl_init();
    curl_setopt_array($ch,$defaults);
    if( ! $result = curl_exec($ch)) {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
}


{{ CALL_ACTION }}