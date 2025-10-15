<html>
    <head>
        <base target="_parent" />
 	<link href="/css/google-fonts.css?family=Open+Sans" rel="stylesheet"> 
        <link type="text/css" rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css" />

        <link type="text/css" rel="stylesheet" href="/css/bootstrap-istat.css" />
        <link type="text/css" rel="stylesheet" href="/css/bootstrap/css/docs.min.css" />
        <link type="text/css" rel="stylesheet" href="/css/modulopubblicazioni.css" />        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery.validate.js"></script>
        <script type="text/javascript" src="/js/jquery.repeater.js"></script>
        <script type="text/javascript" src="olimpiadi.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <title>
            Modulo di iscrizione alle Olimpiadi italiane di statistica 2026
        </title>
    </head>
<?php

require_once('config.php');

if ($date > $chiusuraModulo) {
    echo "<body>";
    echo "<p>{$messaggioChiusura}</p>";
    echo "</body>";
}else{


    if (empty($_REQUEST['indirizzoReferente'])){
    ?>
    <body style="font-family: 'Open Sans', sans-serif;">
        <div class="container">
            <div class="col-xs-12">
                <form action="recuperaPassword.php" id="mainmodule" method="post" class="form-horizontal">
                    <fieldset>
                        <h2 style="float:left;clear:none">Recupero della password</h2>
                        <img src="logoSis.png" style="height:70px;float:right;padding:2em 1em 0 1em"/>
                        <img src="marchio-1.gif" style="height:70px;float:right;padding:2em 1em 0 1em"/>
                        <hr style="clear:both">
                        <div style="padding:25px">
                            <p>Gentile referente scolastico,</p>
                            <p>Per recuperare la Sua password La invitiamo a compilare tutti i campi sottostanti e a selezionare, al termine, "Invia modulo".</p>
                            <p>All´indirizzo di posta elettronica che avrà indicato Le invieremo una mail per verificare la Sua identità e continuare con la procedura.</p>
                            <p>Grazie per la collaborazione!</p>
                            <hr>
                            <div style="max-width:600px">
                                <div class="control-group col-xs-12">
                                    <label class="control-label name" for="scuola-input-4">Indirizzo di posta elettronica del referente scolastico</label>
                                    <div class="controls">
                                        <input class="form-control gui-input" type="email" name="indirizzoReferente" id="school-input-4" required=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group col-xs-12">
                                <div class="form-actions col-xs-12">
                                    <input type="submit" value="Invia modulo" name="Invia" style="width:107px;margin-top:1em;float:right" class="btn btn-primary" id="school-input-37" />
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
<?php
    }else{
        try {
            $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $stmt = $db->prepare("SELECT * FROM scuole_master WHERE MAILREFERENTE=?");
            $stmt->execute(array($_POST['indirizzoReferente']));
            $scuola = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $ex) {
            echo $ex->getMessage();
        }
        if (!$scuola){
            echo "<body>";
            echo "<p>Spiacenti, nessuna scuola risulta registrata con l'indirizzo email inserito.</p>";
            echo "</body>";
            die();
        }else{
            echo "<body>";
            echo "<p>Grazie, Le è stata inviata una mail al Suo indirizzo di posta elettronica.</p>";
            echo "<p>Segua il link lì presente per continuare la procedura.</p>";
            echo "</body>";

            $token = md5($_POST['indirizzoReferente'] . 'Salt2021' . date("Y/m/d"));
            $text = <<<EOD
<body style="font-family: 'Open Sans', sans-serif">
<p>Gentile Professore, </p>
<p>Riceve questa mail perché è stato chiesto il reset della sua password.</p>
<p>Se vuole reimpostare la Sua password Le basterà seguire questo link entro la giornata di oggi:</p>
<p><a href="https://{$_SERVER['SERVER_NAME']}/olimpiadi-registrazione/modificaPassword.php?token={$token}&mail={$_POST['indirizzoReferente']}"> http://{$_SERVER['SERVER_NAME']}/olimpiadi-registrazione/modificaPassword.php?token={$token}&mail={$_POST['indirizzoReferente']} </a></p>
EOD;

            $headers =  'From: "Olimpiadi italiane di statistica" <olimpiadi-statistica@istat.it>' . "\r\n";
            $headers .= 'Reply-To: olimpiadi-statistica@istat.it' . "\r\n" ;
            $headers .= 'X-Mailer: PHP/' . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            mail($_POST['indirizzoReferente'],"Registrazione alle Olimpiadi italiane di statistica 2026","<html>".$text."</body></html>",$headers);
        };
    };
};                                      