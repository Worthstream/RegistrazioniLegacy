<html>
    <head>

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
            Iscrizione a Il Censimento permanente sui banchi di scuola 2025
        </title>
    <style>
        .image-container {
            width: 100%;
            overflow: hidden;
        }
        .image-container img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
    </head>
<?php
require_once('config.php');
if ($date > $chiusuraModulo) {
    echo "<body>";
    echo "<p>{$messaggioChiusura}</p>";
//    echo "<!-- " . $_SERVER['REMOTE_ADDR'] . "-->";
    echo "</body>";
}else{

?>
    <body style="font-family: 'Open Sans', sans-serif;">
    <div class="image-container">
        <img src="banner.jpg" alt="Banner">
    </div>
        <div class="container">
            <div class="col-xs-12">
                <form action="salvaModuloScuola.php" id="mainmodule" method="post" class="form-horizontal">
                    <fieldset>
                        <!--img src="banner.png" style="width:1000px"/ -->
                    <div style="padding:25px">
                        <p>Gentile Docente,</p>
                        <p>benvenuta/o nel modulo per l'iscrizione della sua classe alla sesta edizione dell'iniziativa Il Censimento permanente sui banchi di scuola.</p>
                        <p>La invitiamo a compilare tutti i campi sottostanti. Al termine, confermi, premendo il tasto "Invia modulo".</p>
                        <p>A OGNI CLASSE DEVE CORRISPONDERE UNA DIFFERENTE ISCRIZIONE.</p>
                        <p>La ringraziamo per la collaborazione!</p>
                        <hr>
                        <div style="max-width:800px">
                            <div class="control-group col-xs-12">
                                <label class="control-label name" for="scuola-input-1">Codice scuola</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="codicescuola" id="school-input-1" required=""/>
                                </div>

                            </div>
                            <div class="uneditable" id="datiscuola">
                            </div>
                            <div class="control-group col-xs-12">
                                <label class="control-label name" for="scuola-input-2">Indirizzo di posta elettronica</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="email" name="indirizzoemailscuola" id="indirizzoemailscuola" required=""/>
                                </div>
                            </div>
                            <div class="control-group col-xs-4">
                                <label class="control-label name" for="scuola-input-6">Classe</label>
                                <div class="controls">
                                        <select id="CLASSE" name="CLASSE" class="form-control" required="" autocomplete="off">
                        <option></option>
                                                <option>III (scuola primaria)</option>
                                                <option>IV (scuola primaria)</option>
                                                <option>V (scuola primaria)</option>
                                                <option>I (scuola secondaria I grado)</option>
                                                <option>II (scuola secondaria I grado)</option>
                                                <option>III (scuola secondaria I grado)</option>
                                         </select>
                                </div>
                            </div>
                            <div class="control-group col-xs-4">
                                <label class="control-label name" for="scuola-input-7">Sezione</label>
                                <div class="controls">
                                    <select id="SEZIONE" name="SEZIONE" class="form-control" required="" autocomplete="off">
                                    <option></option>
                                    <option>UNICA</option>
                                    <option>A</option>
                                    <option>B</option>
                                    <option>C</option>
                                    <option>D</option>
                                    <option>E</option>
                                    <option>F</option>
                                    <option>G</option>
                                    <option>H</option>
                                    <option>I</option>
                                    <option>J</option>
                                    <option>K</option>
                                    <option>L</option>
                                    <option>M</option>
                                    <option>N</option>
                                    <option>O</option>
                                    <option>P</option>
                                    <option>Q</option>
                                    <option>R</option>
                                    <option>S</option>
                                    <option>T</option>
                                    <option>U</option>
                                    <option>V</option>
                                    <option>W</option>
                                    <option>X</option>
                                    <option>Y</option>
                                    <option>Z</option>
                                </select>
                                </div>
                            </div>
                            <div class="control-group col-xs-4">
                                <label class="control-label name" for="scuola-input-8">Numero di alunni</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="number" name="NUMEROALUNNI" id="NUMEROALUNNI" required="true" min="0"/>
                                </div>
                            </div>

                            <div class="col-xs-12">
                            <hr>
                                Dati del docente referente
                            </div>
                            <div class="control-group col-xs-6">
                                <label class="control-label name" for="COGNOMEREFERENTE">Cognome</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="COGNOMEREFERENTE" id="COGNOMEREFERENTE" required="true"/>
                                </div>
                            </div>
                            <div class="control-group col-xs-6">
                                <label class="control-label name" for="NOMEREFERENTE">Nome</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="NOMEREFERENTE" id="NOMEREFERENTE" required="true"/>
                                </div>
                            </div>
                            <div class="control-group col-xs-4">
                                <label class="control-label name" for="SESSO">Sesso</label>
                                <div class="controls">
                                    <select id="SESSO" name="SESSO" class="form-control" required="" autocomplete="off">
                                          <option>F</option>
                                          <option>M</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group col-xs-4">
                                <label class="control-label name" for="DATADINASCITA">Data di Nascita</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="date" min="1940-01-01" max="2003-31-12" value="1985-01-01" name="DATADINASCITA" id="DATADINASCITA" required="true"/>
                                </div>
                            </div>
                            <div class="control-group col-xs-4">
                                <label class="control-label name" for="MATERIAINSEGNATA">Materia Insegnata</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="MATERIAINSEGNATA" id="MATERIAINSEGNATA" required="true"/>
                                </div>
                            </div>
                            <div class="control-group col-xs-12" style="padding-top:10px">
                                Contatti eletti ai fini della comunicazione:
                            </div>
                            <div class="control-group col-xs-6">
                                <label class="control-label name" for="MAILREFERENTE">Indirizzo di posta elettronica</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="email" name="MAILREFERENTE" id="MAILREFERENTE" required="true"/>
                                </div>
                            </div>
                            <div class="control-group col-xs-6">
                                <label class="control-label name" for="CELLULAREREFERENTE">Numero di cellulare</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="digits" name="CELLULAREREFERENTE" id="CELLULAREREFERENTE" required="true"/>
                                </div>
                            </div>
                            <div class="col-xs-12">
                            <hr>
                                Dati di eventuali altri docenti:
                            </div>
<?php $snippet=<<<EOD
    <div class="control-group col-xs-12">
                                 <span class="btn btn-primary" style="margin-top:12px;padding:6px 12px" onclick="$('#docente#NUM#').show()"><span  class="glyphicon glyphicon-plus"></span> Aggiungi altro Docente</span>
                 </div>
</div>
<div id="docente#NUM#" style="display:none">
                            <div class="col-xs-12">
                            <hr>
                                Docente #NUM#:
                            </div>

                            <div class="control-group col-xs-6">
                                <label class="control-label name" for="COGNOME#NUM#">Cognome</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="COGNOME#NUM#" id="COGNOME#NUM#" required=""/>
                                </div>
                            </div>
                            <div class="control-group col-xs-6">
                                <label class="control-label name" for="NOME#NUM#">Nome</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="NOME#NUM#" id="NOME#NUM#" required=""/>
                                </div>
                            </div>
                            <div class="control-group col-xs-6">
                                <label class="control-label name" for="MATERIA#NUM#">Materia Insegnata</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="text" name="MATERIA#NUM#" id="MATERIA#NUM#" required=""/>
                                </div>
                            </div>
                            <div class="control-group col-xs-6">
                                <label class="control-label name" for="EMAIL#NUM#">Indirizzo di posta elettronica</label>
                                <div class="controls">
                                    <input class="form-control gui-input" type="email" name="EMAIL#NUM#" id="EMAIL#NUM#" required=""/>
                                </div>
                            </div>
EOD;
for($i=2;$i<=9;$i++) { echo str_replace('#NUM#',$i,$snippet); }; ?>
</div>

                            <div class="col-xs-12">
                            <hr>
                                <label class="radio">
                                    <input value="Ok" name="informativa" required="true" aria-required="true" type="radio" id="informativaradio">
                                    Dichiaro di aver ricevuto da parte del Dirigente scolastico il consenso a partecipare.
                                </label>
                                <label class="radio">
                                    <input value="Ok" name="informativa2" required="true" aria-required="true" type="radio" id="informativaradio2">
                                    Dichiaro di aver raccolto in formato cartaceo o digitale le <a href="Autorizzazione_partecipazione_2024-25.pdf">Autorizzazioni</a> dei genitori o di chi esercita la responsabilità genitoriale a far partecipare la/il proprio/a figlia/o all’iniziativa.
                                </label>
                                <label class="radio">
                                    <input value="Ok" name="informativa3" required="true" aria-required="true" type="radio" id="informativaradio3">
                                    Dichiaro di aver letto il presente <a href="Regolamento_iniziativa_2024-25.pdf">Regolamento</a> e accettato le modalità di svolgimento dell’iniziativa.
                                </label>
                                <label class="radio">
                                    <input value="Ok" name="informativa4" required="true" aria-required="true" type="radio" id="informativaradio4">
                                    Dichiaro di aver letto e accettato l'<a href="Informativa_docente_2024-25.pdf">Informativa</a> sul trattamento dei dati personali.
                                </label>
                                <label class="radio">
                                    <input value="Ok" name="informativa5"  type="radio" id="informativaradio5">
                                    Dichiaro di aver letto e accettato l'<a href="Informativa_uso_mail_2024-25.pdf">Informativa</a> per l'invio delle comunicazioni.
                                </label>
                                <hr>
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
                <p></p>
            </div>
        </div>
<script>
    $(document).ready(function () {
            $("#school-input-0").on('change keyup paste mouseup', function() {
                if ($(this).val().length >= 10) {
                    console.log('Fetching school data');
                    $.post( "datiScuola.php", { id: $(this).val() } ,function( data ) {
                        $( "#datiscuola" ).html( data );
                        // Attach the click event handler to the loaded .dati-wrapper elements
                        $('.dati-wrapper').off('click').on('click', function() {
                            // Find the radio button within the clicked div
                            var radio = $(this).find('input[type="radio"]');

                            // Check the radio button if it's not already checked
                            if (!radio.prop('checked')) {
                                radio.prop('checked', true);
                            }
                        });
                    });
                }
            });


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
