<?php
$input = file_get_contents('php://input');
$update = json_decode($input, true);


$token = '5688170347:AAF3cH99O2k_mqlWlPWrqZxuXOFzSKmY4y4';
$message = $update["message"]["text"];
$datee = $update["message"]["date"];
$messageId = $update["message"]["message_id"];
$chatId = $update["message"]["chat"]["id"];

//$message = $update["message"]["text"];
//$datee = $update["message"]["date"];
$messageId = $update["message"]["message_id"];
//$chatId = 5735188621;
$reply = "Diool vous remercie";

require("connexion.php");

$base->exec("SET CHARACTER SET utf8");

$query1 = $base->prepare("SELECT * FROM encour WHERE chatId = '$chatId'");
//$query1->bindparam(':chat', $chatId);
$query1->execute();
$userTG = $query1->fetch();
$id = $userTG['id'];
if ($query1->rowCount() == 1) {
    if ($userTG['servicee'] == 1) {
        switch ($message) {
            case 10:
                $req3 = "DELETE FROM encour WHERE chatId =" . $chatId;
                $base->exec($req3);
                $reply = urlencode("Diool vous remercie<b>... </b> ");
                break;
            case 99:
                $req3 = "DELETE FROM encour WHERE chatId =" . $chatId;
                $base->exec($req3);
                $reply = urlencode("Bienvenue dans le processus d'inscription \n entrez votre token Diool publique \n 99. pour retourner \n 10. pour annuler ");
                break;
            default:
            $q1 = $base->prepare("SELECT * FROM marchand WHERE chatId = '$chatId' AND statut='verify'");
            $q1->execute();
            $marchandTG = $q1->fetch();
            $idmarchand = $marchandTG['id'];
            if ($q1->rowCount() == 0) {
                $req3 = "DELETE FROM encour WHERE chatId ='$chatId'";
                $base->exec($req3);
                $reply = urlencode(" Compte inexistant ou non vérifier \n \n 1. get balance \n 2. create a bill / link \n 3. buy airtime \n 4. addfund \n 5. refer to  an ohter BE \n 6. get my average \n 7. Pour s'incrire ");
            } else {
    
    
                //$passeHash = password_hash($message, PASSWORD_DEFAULT);
                file_get_contents("https://api.telegram.org/bot$token/deletemessage?chat_id=$chatId&message_id=$messageId");
                if (password_verify($message, $marchandTG['passe1'])) {
    
                    require_once('getSolde.php');
                    $r = getSolde($marchandTG['token'], $id);
                    /*
                        $req3 = "UPDATE encour set methode=1 WHERE id =" . $id;
                        $base->exec($req3);*/
                    $reply = urlencode($r);
                } else {
                    $reply = urlencode(" Mot de passe erroné, saisissez à nouveau \n 10. pour Sortir");
                }
            }
            
        }
    } elseif ($userTG['servicee'] == 2) {
        switch ($message) {
            case 10:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode(" Diool Paiement facture vous remercie...");
                break;
            case 99:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode("Bienvenue chez <b> Diool </b> , choisissez \n 1. pour paiement marchand \n 2. pour paiement de facture \n 3. For contact support \n 4. For user experience");
                break;
            default:
                $reply = urlencode(" Choix(1) érroné veuillez resaisir votre choix");
        }
    } elseif ($userTG['servicee'] == 3) {
        switch ($message) {
            case 10:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode(" Diool user support vous remercie...");
                break;
            case 99:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode("Bienvenue chez <b> Diool </b> , choisissez \n 1. pour paiement marchand \n 2. pour paiement de facture \n 3. For contact support \n 4. For user experience");
                break;
            default:
                $reply = urlencode(" Choix (2) érroné veuillez resaisir votre choix");
        }
    } elseif ($userTG['servicee'] == 7) {
        $q1 = $base->prepare("SELECT * FROM marchand WHERE chatId = '$chatId'");
        $q1->execute();
        $marchandTG = $q1->fetch();
        $idMarchand = $marchandTG['id'];
        if ($marchandTG['token'] == "--") {
            switch ($message) {
                case 10:
                    $req3 = "DELETE FROM encour WHERE chatId =" . $chatId;
                    $base->exec($req3);
                    $reply = urlencode("Bienvenuee chez <b> Diool Marchand </b> , choisissez \n 1. get balance \n 2. create a bill / link \n 3. buy airtime \n 4. addfund \n 5. refer to  an ohter BE \n 6. get my average \n 7. Pour s'incrire ");
                    break;
                case 99:

                    $req3 = "DELETE FROM encour WHERE chatId =" . $chatId;
                    $base->exec($req3);
                    $reply = urlencode("Bienvenuee chez <b> Diool Marchand </b> , choisissez \n 1. get balance \n 2. create a bill / link \n 3. buy airtime \n 4. addfund \n 5. refer to  an ohter BE \n 6. get my average \n 7. Pour s'incrire ");
                    break;
                default:
                    file_get_contents("https://api.telegram.org/bot$token/deletemessage?chat_id=$chatId&message_id=$messageId");
                    $req2 = "UPDATE marchand set token='$message' WHERE id =" . $idMarchand;
                    $base->exec($req2);

                    $reply = urlencode(" entrez votre token Diool privé \n 99. pour retourner \n 10. pour annuler ");
            }
        } else {
            if ($marchandTG['tokenAll'] == "--") {
                switch ($message) {
                    case 10:
                        $req3 = "DELETE FROM encour WHERE chatId =" . $chatId;
                        $base->exec($req3);
                        $reply = urlencode("Diool vous remercie<b>... </b> ");
                        break;
                    case 99:
                        $req3 = "UPDATE marchand set token='--' WHERE id =" . $idMarchand;
                        $base->exec($req3);
                        $reply = urlencode("Bienvenue dans le processus d'inscription \n entrez votre token Diool publique \n 99. pour retourner \n 10. pour annuler ");
                        break;
                    default:
                    file_get_contents("https://api.telegram.org/bot$token/deletemessage?chat_id=$chatId&message_id=$messageId");
    
                    require_once('getEmail.php');
                    $r = getEmail($message, $idMarchand);
    
                    //$req2 = "UPDATE marchand set tokenAll='$message' WHERE id =" . $idMarchand;
                    //$base->exec($req2);
                    $reply = urlencode($r . " \n 99. pour retourner \n 10. pour annuler ");
                }
            } else {
                if ($marchandTG['otpMail'] != 1) {
                    if ($marchandTG['otpMail'] == $message) {
                        $req3 = "UPDATE marchand set otpMail=1 WHERE id =" . $idMarchand;
                        $base->exec($req3);
                        $reply = urlencode("Email vérifié \n entrez votre mot de passe de connexion qui sera demandé avant certaines opérations \n 99. pour retourner \ 10. pour annuler ");
                    } else {
                        $reply = urlencode(" Code non correspondant saisissez a nouveau \n \n 99. pour retourner \n 10. pour annuler ");
                    }
                } else {
                    if ($marchandTG['passe1'] == NULL) {
                        file_get_contents("https://api.telegram.org/bot$token/deletemessage?chat_id=$chatId&message_id=$messageId");

                        $passeHash = password_hash($message, PASSWORD_DEFAULT);
                        $req3 = "UPDATE marchand set passe1='$passeHash' WHERE id =" . $idMarchand;
                        $base->exec($req3);

                        $reply = urlencode(" confirmez votre mot de passe à nouveau \n \n 99. pour retourner \n 10. pour annuler ");
                    } else {
                        if ($marchandTG['passe'] == NULL) {
                            file_get_contents("https://api.telegram.org/bot$token/deletemessage?chat_id=$chatId&message_id=$messageId");

                            $passeHash = password_hash($message, PASSWORD_DEFAULT);
                            if (password_verify($message, $marchandTG['passe1'])) {
                                $req3 = "UPDATE marchand set passe='$passeHash', statut='verify' WHERE id =" . $idMarchand;
                                $base->exec($req3);


                                $req3 = "DELETE FROM encour WHERE chatId ='$chatId' AND servicee=7";
                                $base->exec($req3);
                                $reply = urlencode(" Compte activé avec susccès \n 9. accéder au menu \n \n 10. pour annuler ");
                            } else {
                                $reply = urlencode(" Les mots de passe ne sont pas identique saisisez à nouveau \n 10. pour Sortir");
                            }
                        } else {
                            $reply = urlencode(" Compte Déja activé \n \n 1. Accéder au menu \n 10. Sortir ");
                        }
                    }
                }
            }
        }
    } else {
        $reply = urlencode(" encour de conception !!!");
    }
} else {
    /*if ($message == 7) {
        $q1 = $base->prepare("SELECT * FROM marchand WHERE chatId = '$chatId'");
        
        $q1->execute();
        $marchandTG = $q1->fetch();
        $idmarchand = $marchandTG['id'];
        if ($q1->rowCount() == 0) {
        $query1 = $base->prepare('INSERT INTO marchand (token, tokenAll, chatId, marchandCode, mail, bename)VALUES(:token, :tokenAll, :chatId, :marchandCode, :mail, :bename)');
        $query1->execute(array(
            'token' => '--',
            'tokenAll' => '--',
            'chatId' => $chatId,
            'marchandCode' => 0,
            'mail' => '--',
            'bename' => '--',
        ));
    }
    }*/
    switch ($message) {
        case 1:
            $query2 = $base->prepare('INSERT INTO encour (chatId, servicee)VALUES(:chatId, :servicee)');
            $query2->execute(array(
                'chatId' => $chatId,
                'servicee' => 1,
            ));
            $reply = urlencode("Entrez votre mot de passe pour avoir votre solde \n 99. pour retourner \n 10. pour annuler ");

            break;
        case 2:
            $reply = urlencode("Paiement de facture encour de conception \n 99.pour retour \n 10.pour annuler ");
            break;
        case 3:
            $reply = urlencode("Prepaid topups incoming \n 99.pour retour \n 10.pour annuler ");
            break;

        case 4:
            $reply = urlencode("Pour inviter un ami à utiliser l'application, utiliser le lien suivant http://t.me/dioolPayment_bot ");
            break;

        case 5:
            $reply = urlencode("Support contact en developpement \n 99.pour retour \n 10.pour annuler ");
            break;
        case 7:
            $q1 = $base->prepare("SELECT * FROM marchand WHERE chatId = '$chatId' AND statut='verify'");

            $q1->execute();
            $marchandTG = $q1->fetch();
            $idmarchand = $marchandTG['id'];
            if ($q1->rowCount() == 0) {
                $req3 = "DELETE FROM marchand WHERE chatId =" . $chatId;
                $base->exec($req3);
                $query1 = $base->prepare('INSERT INTO marchand (token, tokenAll, chatId, marchandCode, mail, bename)VALUES(:token, :tokenAll, :chatId, :marchandCode, :mail, :bename)');
                $query1->execute(array(
                    'token' => '--',
                    'tokenAll' => '--',
                    'chatId' => $chatId,
                    'marchandCode' => 0,
                    'mail' => '--',
                    'bename' => '--',
                ));
                $query2 = $base->prepare('INSERT INTO encour (chatId, servicee)VALUES(:chatId, :servicee)');
                $query2->execute(array(
                    'chatId' => $chatId,
                    'servicee' => 7,
                ));
                $reply = urlencode("Bienvenue dans le processus d'inscription \n entrez votre token Diool publique \n 99. pour retourner \n 10. pour annuler ");
            } else {
                $reply = urlencode("le compte existe \n 99. pour retourner ");
            }
            break;
        default:
            $reply = urlencode("Bienvenuee chez <b> Diool Marchand </b> , choisissez \n 1. get balance \n 2. create a bill  \n 3. buy airtime \n 4. add Fund \n 5. refer to  an ohter BE \n 6. get my average \n 7. Pour s'incrire ");
    }
}


$bon = file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$chatId&text=$reply&parse_mode=html");
/*$envoi = json_decode($bon, true);
echo $bon;
echo "\n";
//echo $envoi;
$message1 = $envoi['result']['text'];
$datee1 = $envoi['result']['date'];
$messageId1 = $envoi['result']['message_id'];
$chatId1 = $envoi['result']['chat']['id'];
echo $message1."\n";
echo $datee1."\n";
echo $messageId1."\n";
echo $chatId1."\n";
$reply1 = "Diool vous remercie beaucouppp ppp".$messageId1." et ".$message1 ;/*

file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$chatId&text=$reply1&parse_mode=html");

file_get_contents("https://api.telegram.org/bot$token/deletemessage?chat_id=$chatId&message_id=$messageId");
*/
