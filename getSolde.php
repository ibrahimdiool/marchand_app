<?php
function getSolde($param1, $id)
{
    require("connexion.php");

    //----------------------------------------------------------------Collect data from data base
    /*$base->exec("SET CHARACTER SET utf8");
    $q = $base->prepare('SELECT * FROM marchand WHERE id = :code');
    $q->bindparam(':code', $idMarchand);
    $q->execute();
    $marchand = $q->fetch();
    $marchandId = $marchand['id'];
    $tokenAll = $marchand['tokenAll'];
    session_start();
    $_SESSION['bename'] = NULL;*/


    //____________________________________________________________________ header for API
    $headers =  [
        "Content-Type: application/json",
        "Authorization: Bearer " . $param1,
        "Access-Control-Allow-Origin: *",
        "Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-GitHub-OTP, X-Requested-With",
        "Access-Control-Expose-Headers: ETag, Link, X-GitHub-OTP, x-ratelimit-limit, x-ratelimit-remaining, x-ratelimit-reset, X-OAuth-Scopes, X-Accepted-OAuth-Scopes, X-Poll-Interval",
        "x-beversion: 3.5.0"
    ];

    $link = curl_init();
    curl_setopt($link, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($link, CURLOPT_RETURNTRANSFER, true);


    curl_setopt($link, CURLOPT_URL, "https://core.diool.me/core/dioolapi/v1/balance");
    //curl_setopt($link, CURLOPT_ , true);
    //curl_setopt($link, CURLOPT_RETURNTRANSFER, true);

    //curl_setopt($link, CURLOPT_POSTFIELDS, $data);

    $reponse = curl_exec($link);
    //echo curl_errno($reponse);
    //echo curl_error($reponse);
    $data1 = json_decode($reponse, true);
    //echo $reponse;
    //echo $data1['errors'];

    $h = curl_getinfo($link, CURLINFO_HTTP_CODE);
    $h1 = $data1['code'];
    curl_close($link);
    //echo $h1;

    if ($data1['code'] == 0) {

        $depositBalance = $data1['result']['depositAccountBalance'];
        $revenueBalance = $data1['result']['revenueAccountBalance'];
        //$co = $data1['message'];
        
        $req3 = "DELETE FROM encour WHERE id ='$id'";
        $base->exec($req3);
        $reply = ("votre deposit balance est de: <b>" .$depositBalance. "</b>  et votre revenue Balance est de: <b>".$revenueBalance."</b> \n \n Diool vous remercie ");

    } else {
        $reply = "echec de transaction coté serveur. entrez votre mot de passe a nouveau\n  \n 10. pour annuler ";
    }

    return $reply;
    //return "My name is ".$param1;
}

/*
$d1=strtotime("July 04 2022");
$d2=ceil(($d1-time())/60/60/24);
echo "There are " . $d1 ." days until 4th of July.";*/
