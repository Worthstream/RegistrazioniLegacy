<?php
require_once('config.php');

if ($date > $chiusuraModulo) {
    echo "<body>";
    echo "<p>{$messaggioChiusura}</p>";
    echo "<!-- " . $_SERVER['REMOTE_ADDR'] . "-->";
    echo "</body>";
} else {
    if (empty($_REQUEST['id'])) {
        die('Nessun codice scuola inserito');
    }

    try {
        $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $stmt = $db->prepare("SELECT * FROM scuole_master WHERE CODICESCUOLA = ?");
        $stmt->execute(array(strtoupper($_REQUEST['id'])));
        $scuola = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $ex) {
        echo $ex->getMessage();
    }
    if (!$scuola){
        die('Non è stata trovata nessun istituto con codice: ' . $_REQUEST['id'] );    
    }
    if(empty($scuola['PASSWORD'])){
        die("La scuola " . ucwords($scuola['DENOMINAZIONESCUOLA']) . " non è ancora registrata alle Olimpiadi di statistica.");
    }
?>
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
        <script type="text/javascript" src="js/jquery.md5.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <style type="text/css">
            div.informativatitle{font-family:"Candara Bold",serif;font-size:12.1px;font-weight:bold;font-style:normal;text-decoration: none;padding:2px;}
            div.informativatext{font-family:"Candara",serif;font-size:12.1px;font-weight:normal;font-style:normal;text-decoration: none;padding:3px}
            div.informativalist{font-family:"Calibri",serif;font-size:12.1px;font-weight:normal;font-style:normal;text-decoration: none; padding:3px 3px 3px 5px}
            div#datiscuola{margin-bottom:15px;border-bottom:1px solid #eee;}
        </style>
        <title>
            Modulo iscrizione studenti alle Olimpiadi italiane di statistica 2026
        </title>
    </head>
<body style="font-family: 'Open Sans', sans-serif;">
    <div class="container">
        <div class="col-xs-12">
            <form action="salvaAggiungiStudenti.php?id=<?php echo $_REQUEST['id']; ?>" id="mainmodule" method="post" class="form-horizontal">
                <fieldset>
                    <h2 style="float:left;clear:none">Iscrizione studenti alle olimpiadi italiane di statistica 2026</h2>
                    <img src="logoSis.png" style="width:100px;float:right;padding:2em 1em 0 1em"/>
                    <img src="marchio-1.gif" style="width:100px;float:right;padding:2em 1em 0 1em"/>
                    <hr style="clear:both">
                    <div style="padding:25px">
                        <div class="col-xs-12 uneditable" id="datiscuola">
                            <div class="control-group col-xs-12">
                                <label class="control-label">Scuola:</label>
                                <span class="control" id="nomeScuola"><?php echo $scuola['DENOMINAZIONESCUOLA'];?></span>
                            </div>  
                            <div class="control-group col-xs-4">
                                <label class="control-label">Regione:</label>
                                <span class="control" id="nomeRegione"><?php echo $scuola['REGIONE'];?></span>
                            </div>
                            <div class="control-group col-xs-4">
                                <label class="control-label">Provincia:</label>
                                <span class="control" id="nomeProvincia"><?php echo $scuola['PROVINCIA'];?></span>
                            </div>
                            <div class="control-group col-xs-4">
                                <label class="control-label">Comune:</label>
                                <span class="control" id="nomeComune"><?php echo $scuola['DESCRIZIONECOMUNE'];?></span>
                            </div>   
                        </div>
                        <div class="col-xs-12">
                            <p>Gentile referente scolastico,</p>
                            <p>La invitiamo a riempire i campi sottostanti con i dati degli studenti che intendono partecipare alle Olimpiadi. Al termine, selezioni "Invia modulo".</p>
                            <p>All'indirizzo di posta elettronica che avrà indicato Le invieremo la conferma dell’avvenuta registrazione.</p>
                            <span class="col-xs-6 btn btn-default">Aggiungi Studenti</span>
                            <a href="modifica-studenti.php?id=<?php echo $_REQUEST['id']; ?>"><span class="col-xs-6 btn btn-primary">Modifica Studenti</span></a>
                        </div>
                        <div class="control-group col-xs-12">
                            <label class="control-label name" for="scuola-input-1">Password scelta al momento dell'iscrizione:</label><a href="recuperaPassword.php"> (Recupera password)</a>
                            <div class="controls">
                                <input autocomplete="off" class="form-control gui-input" type="password" name="password" id="school-input-1" required=""/>
                            </div>
                        </div>
                        <div id="formStudentiContainer">
                            <!-- formStudenti will be loaded here after password validation -->
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

<script>
    $(document).ready(function () {
        $('#informativaradio').prop('checked', false);
        $('#informativalink').click( function() {
            $('#informativapdf').toggle();
        });

        $("#school-input-1").on('change keyup paste mouseup', function() {
            if ($(this).val().length > 7) {
                var hash = $.md5($(this).val() + 'SaltOlimpiadi2018' + '<?php echo strtoupper($_REQUEST['id']);?>');
                console.log('Checking pwd: ' + hash);
                $.post( "checkPwdScuola.php", { 
                    hash: hash, 
                    id: '<?php echo strtoupper($_REQUEST['id']);?>',
                    action: 'getFormStudenti',
                    page: 'aggiungi'
                }, function(data) {
                    console.log(data);
                    if(data && data !== 'false' && data.indexOf('error') === -1){
                        $('#formStudentiContainer').html(data);
                        // Reinitialize repeater after content is loaded
                        $('.repeater').repeater({
                            show: function () {
                                $(this).slideDown(200);
                            },
                            hide: function (deleteElement) {
                                $(this).slideUp(deleteElement);
                            },
                            isFirstItemUndeletable: false
                        });
                    } else {
                        $('#formStudentiContainer').empty();
                    }
                });
            }
        });

        $("#mainmodule").validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                genere: {
                    required: true
                }
            }
        });
    });
</script>
</body>
</html>
<?php
}
?>