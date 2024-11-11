<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
    </head>
    <body>
        <?php
        echo '<p>Hello World</p>';
        $ip = "";
        $which_ip = ""
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
                } elseif (isset($_SERVER['http_x_forwarded_for'])) {
                    $ip = $_SERVER['http_x_forwarded_for'];
                    $which_ip = "http_x_forwarded_for";
                }
            }
        } else {
            $ip = "127.0.0.1";
            $which_ip = "loopback0";
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
            echo "<p>your country is $country_name($country_code)</p>";
            var_dump($json_arr);
        }
        ?>
    </body>
</html>