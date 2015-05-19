<?php 
/*
Core - Cyrpt - Permet de décrypter/Encrypter les chaines de caratère.
*/

function core_encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = CRYPT_KEY;
    $secret_iv = CRYPT_KEY;

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
function base64url_encode($s)
{ 
    return rtrim(strtr(base64_encode($s),"+/", "-_"),"=");
}
function secure_link($path)
{
    $secret = 'jesuistropunouf'; // To make the hash more difficult to reproduce. // This is the file to send to the user.
    $expire = time() + 14400; // At which point in time the file should expire. time() + x; would be the usual usage.
     
    $md5 = base64_encode(md5($secret . $path . $expire, true)); // Using binary hashing.
    $md5 = strtr($md5, '+/', '-_'); // + and / are considered special characters in URLs, see the wikipedia page linked in references.
    $md5 = str_replace('=', '', $md5); // When used in query parameters the base64 padding character is considered special.
    return ''.$path.'?st='.$md5.'&e='.$expire;
}
function generateCallTrace()
{
    $e = new Exception();
    $trace = explode("\n", $e->getTraceAsString());
    // reverse array to make steps line up chronologically
    $trace = array_reverse($trace);
    array_shift($trace); // remove {main}
    array_pop($trace); // remove call to this method
    $length = count($trace);
    $result = array();
    
    for ($i = 0; $i < $length; $i++)
    {
        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
    }
    
    return "\t" . implode("\n\t", $result);
}