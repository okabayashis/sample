<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
    </head>
    <body>
        <?php
        echo '<p>Hello World</p>';
        $ip = $_SERVER['X-Forwarded-For'];
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