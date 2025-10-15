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
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
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


    if (empty($_REQUEST['mail']) && empty($_REQUEST['token'])){
        echo "<body>";
        echo "<p>Per reimpostare la password La preghiamo di seguire il link contenuto nella mail che Le è stata inviata.</p>";
        echo "</body>";
        die();
    }else if ($_REQUEST['token']!= md5($_REQUEST['mail'] . 'Salt2021' . date("Y/m/d"))){
        echo "<body>";
        echo "<p>Errore di validazione. Per reimpostare la password La preghiamo di seguire il link contenuto nella mail che Le è stata inviata.</p>";
        echo "</body>";
        die();
    }else if (!empty($_POST['password'])){
        $_POST['codiceistitutoriferimento'] = strtoupper(explode(' ', $_POST['codiceistitutoriferimento'])[0]);
        try {
            $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $stmt = $db->prepare("UPDATE `scuole_master` SET 
            `PASSWORD` = :password 
            WHERE `MAILREFERENTE` = :mailReferente
            AND `codiceistitutoriferimento` = :codiceistitutoriferimento");

            $stmt->execute(
                array(
                    ':mailReferente' => $_REQUEST['mail'],
                    ':password' => md5($_POST['password'] . 'SaltOlimpiadi2018' . $_POST['codiceistitutoriferimento']),
                    ':codiceistitutoriferimento' => $_POST['codiceistitutoriferimento']
                )
            );
            $affected_rows = $stmt->rowCount();
        } catch(PDOException $ex) {
        echo $ex->getMessage();
        }

        //if ($affected_rows !== 1){ die('Errore nel ripristino della password, si prega di riprovare.');}

        echo "<body>";
        echo "<p>La Sua password stata modificata, può proseguire con l'<a href='modulo-studenti.php?id={$_POST['codiceistitutoriferimento']}'> iscrizione degli studenti </a></p>";
        echo "</body>";
        die();
    }else{
        ?>
    <body style="font-family: 'Open Sans', sans-serif;">
        <div class="container">
            <div class="col-xs-12">
                <form action="modificaPassword.php?token=<?php echo $_REQUEST['token']?>&mail=<?php echo $_REQUEST['mail']?>" id="mainmodule" method="post" class="form-horizontal">
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
                        </div>
                        <div class="control-group col-xs-12">
                            <label class="control-label name" for="scuola-input-1">Codice istituto</label>
                            <div class="controls">
                                <input class="form-control gui-input" type="text" name="codiceistitutoriferimento" id="school-input-1" required=""/>
                            </div>
                        </div>
                        <div class="uneditable" id="datiscuola">
                        </div>
                        <div class="control-group col-xs-12">
                            <label class="control-label name" for="scuola-input-4">Scegliere una password per completare la registrazione</label>
                            <div class="controls">
                                <input class="form-control gui-input" type="password" name="password" id="school-input-6" required=""/>
                            </div>
                        </div>
                        <div class="control-group col-xs-12">
                            <label class="control-label name" for="scuola-input-5">Ripetere password</label>
                            <div class="controls">
                                <input class="form-control gui-input" type="password" name="password_again" id="school-input-7" required=""/>
                            </div>
                        </div>
                        <div class="control-group col-xs-12">
                        <div class="form-actions col-xs-12">
                            <input type="submit" value="Invia modulo" name="Invia" style="width:107px;margin-top:1em;float:right" class="btn btn-primary" id="school-input-37" />
                        </div>
                    </div>
<script>
    $(document).ready(function () {
        $("#school-input-1").autocomplete({
            source: "AutocompleteData.php",
        });

    });
</script>     
</body>
</html>       
<?php
    };
};
