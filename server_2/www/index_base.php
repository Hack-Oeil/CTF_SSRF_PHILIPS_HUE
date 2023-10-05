<?php

function rgb_to_cie($red = 0, $green = 0, $blue = 0) {
	//Apply a gamma correction to the RGB values, which makes the color more vivid and more the like the color displayed on the screen of your device
	$red 	= ($red > 0.04045) ? pow(($red + 0.055) / (1.0 + 0.055), 2.4) : ($red / 12.92);
	$green 	= ($green > 0.04045) ? pow(($green + 0.055) / (1.0 + 0.055), 2.4) : ($green / 12.92);
	$blue 	= ($blue > 0.04045) ? pow(($blue + 0.055) / (1.0 + 0.055), 2.4) : ($blue / 12.92); 
	//RGB values to XYZ using the Wide RGB D65 conversion formula
	$X 		= $red * 0.664511 + $green * 0.154324 + $blue * 0.162028;
	$Y 		= $red * 0.283881 + $green * 0.668433 + $blue * 0.047685;
	$Z 		= $red * 0.000088 + $green * 0.072310 + $blue * 0.986039;
	//Calculate the xy values from the XYZ values
	$xLight 		= number_format($X / ($X + $Y + $Z), 4);
	$yLight 		= number_format($Y / ($X + $Y + $Z), 4); 

	return json_encode([is_nan($xLight) ? 0 : $xLight, is_nan($yLight) ? 0 : $yLight]);
}

function light($url, $color)
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