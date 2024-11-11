<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
    </head>
    <body>
        <?php
        echo '<p>Hello World</p>';
        $ip = "";
        $which_ip = "";
        if (isset($_SERVER['http_cf_connecting_ip'])) { // Cloudflare対応
            $ip = $_SERVER['http_cf_connecting_ip'];
            $which_ip = "http_cf_connectiong_ip";
        } elseif (isset($_SERVER['REMOTE_ADDR']) === true) {
            $ip = $_SERVER['REMOTE_ADDR'];
            $which_ip = "REMOTE_ADDR";
            if (preg_match('/^(?:127|10)\.0\.0\.[12]?\d{1,2}$/', $ip)) {
                if (isset($_SERVER['HTTP_X_REAL_IP'])) {
                    $ip = $_SERVER['HTTP_X_REAL_IP'];
                    $which_ip = "HTTP_X_REAL_IP";
                } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    $which_ip = "http_x_forwarded_for";
                }
            } elseif (preg_match('/^(169)\.(254)\.(129)\.[0-9]+$/', $ip)) {
                if (isset($_SERVER['HTTP_X_REAL_IP'])) {
                    $ip = $_SERVER['HTTP_X_REAL_IP'];
                    $which_ip = "HTTP_X_REAL_IP";
                } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    $which_ip = "http_x_forwarded_for";
                }
            }
        } else {
            $ip = "127.0.0.1";
            $which_ip = "loopback0";
        }
        //echo $which_ip."<br>";
        $output = <<<EOL
        <pre>
        =========<br>
        REMOTE_ADDR              : {$_SERVER['REMOTE_ADDR']}
        HTTP_X_FORWARDED_FOR     : {$_SERVER['HTTP_X_FORWARDED_FOR']}
        HTTP_CLIENT_IP           : {$_SERVER['HTTP_CLIENT_IP']}
        HTTP_CLIENTADDRESS       : {$_SERVER['HTTP_CLIENTADDRESS']}
        HTTP_X_REAL_IP           : {$_SERVER['HTTP_X_REAL_IP']}
        HTTP_X_REAL_FORWARDED_FOR: {$_SERVER['HTTP_X_REAL_FORWARDED_FOR']}
        <br>=========<br></pre>
EOL;
        echo $output;
        if( str_contains($ip,":")){
            $ip_array = explode(':',$ip);
            $ip = $ip_array[0];
        }
        
        $url = "https://api.iplocation.net/?ip=".$ip;
        $json = mb_convert_encoding(file_get_contents($url), 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $json_arr = json_decode($json,true);
        if ($json_arr === NULL) {
            echo "データがありません";
            return;
        }else{
            $country_name = $json_arr["country_name"];
            $country_code = $json_arr["country_code2"];
            echo "<p>【".$ip."】 your country is $country_name($country_code)</p>";
            //var_dump($json_arr);
        }
        ?>
    </body>
</html>