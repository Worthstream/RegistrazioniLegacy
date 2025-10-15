<html>
    <head>
        <base target="_parent" />
 	    <link href="css/google-fonts.css?family=Open+Sans" rel="stylesheet"> 
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="css/bootstrap-istat.css" />
        <link type="text/css" rel="stylesheet" href="css/docs.min.css" />
        <link type="text/css" rel="stylesheet" href="css/modulopubblicazioni.css" />        
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/jquery.repeater.js"></script>
        <script type="text/javascript" src="js/olimpiadi.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
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
    echo "<!-- " . $_SERVER['REMOTE_ADDR'] . "-->";
    echo "</body>";
}else{
?>
    <body style="font-family: 'Open Sans', sans-serif;">
        <div class="container">
            <div class="col-xs-12">
                <form action="salvaModuloScuola.php" id="mainmodule" method="post" class="form-horizontal">
                    <fieldset>
                    <h2 style="float:left;clear:none">Iscrizione alle Olimpiadi italiane di Statistica 2026</h2>
                        <img src="logoSis.png" style="height:70px;float:right;padding:2em 1em 0 1em"/>
                        <img src="marchio-1.gif" style="height:70px;float:right;padding:2em 1em 0 1em"/>
                        <hr style="clear:both">
                    <div style="padding:25px">
                        <p>Gentile referente scolastico,</p>
                        <p>benvenuto/a nel modulo di iscrizione alle Olimpiadi italiane di statistica.</p>
                        <p>La invitiamo a compilare tutti i campi sottostanti e a selezionare, al termine, "Invia modulo".</p>
                        <p>All'indirizzo di posta elettronica che avrà indicato Le invieremo il link al modulo con il quale potrà iscrivere gli studenti che intendono partecipare alla competizione.</p>
                        <p>Grazie per la collaborazione!</p>
                        <hr>
                        <div style="max-width:600px">
                            <div class="control-group col-xs-12">
                                <label class="control-label name" for="scuola-input-1">Codice scuola</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="codicescuola" id="school-input-0" required=""/>
                                </div>
                            </div>
                            <div class="uneditable" id="datiscuola">
                            </div>
                            <div class="control-group col-xs-12">
                                <label class="control-label name" for="scuola-input-2">Cognome referente scolastico</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="cognomeReferente" id="school-input-2" required=""/>
                                </div>
                            </div>
                            <div class="control-group col-xs-12">
                                <label class="control-label name" for="scuola-input-3">Nome referente scolastico</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="nomeReferente" id="school-input-3" required=""/>
                                </div>
                            </div>
                            <div class="control-group col-xs-12">
                                <label class="control-label name" for="scuola-input-4">Indirizzo di posta elettronica del referente scolastico</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="email" name="indirizzoReferente" id="school-input-4" required=""/>
                                </div>
                            </div>
                            <div class="control-group col-xs-12">
                                <label class="control-label name" for="scuola-input-5">Numero telefono cellulare del referente scolastico</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="number" name="numeroReferente" id="school-input-5" required=""/>
                                </div>
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
                        </div>
                    </fieldset>
                    </div>
                </form>
                <div>
		<p>Leggi l'<a href="InformativaDocenti.pdf" download="InformativaDocenti.pdf">informativa per i docenti</a>.</p>
		<p>Leggi il <a href="Bando.pdf" download="Bando.pdf">Bando</a> e il <a href="RegolamentoOlimpiadi.pdf">Regolamento</a>.</p>
		<p>L'Istituto nazionale di statistica e la Società italiana di statistica organizzano la dodicesima edizione delle Olimpiadi italiane di statistica, rivolte agli studenti che frequentano le classi I, II, III e IV degli istituti di istruzione secondaria di secondo grado. Gli obiettivi sono di suscitare l'interesse degli studenti verso l'analisi dei dati e di metterli in condizione di cogliere correttamente il significato delle informazioni quantitative che ricevono nell'esperienza di ogni giorno.</p>

                <p>Ulteriori informazioni sono disponibili nella pagina dedicata alle <a href="https://www.istat.it/?s=Olimpiadi+italiane+di+statistica">Olimpiadi italiane di statistica</a></p>
            </div>
        </div>
<script>
    $(document).ready(function () {
        $("#school-input-0").autocomplete({
            source: "AutocompleteData.php",
        });

    });
</script>
    </body>
</html>
<?php 
}
?>
