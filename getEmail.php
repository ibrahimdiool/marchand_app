<?php
function getEmail($param1, $idMarchand)
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


    curl_setopt($link, CURLOPT_URL, "https://core.diool.me/core/api/v1/useraccount/getBusinessEntityInfo");
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

        $email = $data1['result']['primaryOwnerInfo']['email'];
        $bename = $data1['result']['businessName'];
        $mar=substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        $req00 = "UPDATE marchand set bename='$bename', tokenAll='$param1', mail='$email', marchandCode='$mar' WHERE id ='$idMarchand'";
        $base->exec($req00);
        require_once('mailOtp.php');
	    $r = mailOtp($email, $idMarchand);

        $reply = ("votre nom marchand est: <b>" . $bename . "</b> votre code marchand est: <b>".$mar."</b> \n ".$r);

    } else {
        $reply = "Token erroné ";
    }

    return $reply;
    //return "My name is ".$param1;
}

/*
$d1=strtotime("July 04 2022");
$d2=ceil(($d1-time())/60/60/24);
echo "There are " . $d1 ." days until 4th of July.";*/
