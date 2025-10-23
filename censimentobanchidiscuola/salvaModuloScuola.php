<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
require_once('config.php');

if (empty($_POST['codicescuola'])) die('Errore: nessun codice scuola fornito Si prega di scegliere una scuola fra quelle proposte dopo aver inserito il codice istituto.');
if (empty($_POST['MAILREFERENTE'])) die('Errore: nessuna email inserita per il docente referente.');
if (empty($_POST['NOMEREFERENTE'])) die('Errore: inserire il nome del docente referente.');
if (empty($_POST['COGNOMEREFERENTE'])) die('Errore: inserire il cognome del docente referente');
if (empty($_POST['CELLULAREREFERENTE'])) die('Errore: inserire il cellulare del docente referente');
if (empty($_POST['MATERIAINSEGNATA'])) die('Errore: inserire la materia insegnata dal docente referente');
if (empty($_POST['NUMEROALUNNI'])) die('Errore: inserire il numero di alunni nella classe');
if (empty($_POST['CLASSE'])) die('Errore: inserire la classe');
if (empty($_POST['SEZIONE'])) die('Errore: scegliere la sezione');

$_POST['codicescuola'] = strtoupper(explode(' ', $_POST['codicescuola'])[0]);

try {
    $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $stmt = $db->prepare("SELECT * FROM scuole_master WHERE codicescuola=?");
    $stmt->execute(array($_POST['codicescuola']));
    $scuola = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo $ex->getMessage();
    die();
}

try {
    $stmt = $db->prepare("INSERT INTO `scuole_registrate_censimento`
    (`annoscolastico`, `areageografica`, `regione`, `provincia`, `codiceistitutoriferimento`, `denominazioneistitutoriferimento`, `codicescuola`, `denominazionescuola`, `indirizzoscuola`, `capscuola`, `codicecomunescuola`, `descrizionecomune`, `descrizionecaratteristicascuola`, `descrizionetipologiagradoistruzionescuola`, `indicazionesededirettivo`, `indicazionesedeomnicomprensivo`, `indirizzoemailscuola`, `indirizzopecscuola`, `sitowebscuola`, `sedescolastica`, `CLASSE`, `SEZIONE`, `NUMEROALUNNI`, `NOMEREFERENTE`, `COGNOMEREFERENTE`, `CELLULAREREFERENTE`, `SESSO`, `DATADINASCITA`, `MATERIAINSEGNATA`, `MAILREFERENTE`, `informativa5`, `COGNOME2`, `NOME2`, `MATERIA2`, `EMAIL2`, `COGNOME3`, `NOME3`, `MATERIA3`, `EMAIL3`, `COGNOME4`, `NOME4`, `MATERIA4`, `EMAIL4`, `COGNOME5`, `NOME5`, `MATERIA5`, `EMAIL5`, `COGNOME6`, `NOME6`, `MATERIA6`, `EMAIL6`, `COGNOME7`, `NOME7`, `MATERIA7`, `EMAIL7`, `COGNOME8`, `NOME8`, `MATERIA8`, `EMAIL8`, `COGNOME9`, `NOME9`, `MATERIA9`, `EMAIL9`)
    VALUES
    (:annoscolastico, :areageografica, :regione, :provincia, :codiceistitutoriferimento, :denominazioneistitutoriferimento, :codicescuola, :denominazionescuola, :indirizzoscuola, :capscuola, :codicecomunescuola, :descrizionecomune, :descrizionecaratteristicascuola, :descrizionetipologiagradoistruzionescuola, :indicazionesededirettivo, :indicazionesedeomnicomprensivo, :indirizzoemailscuola, :indirizzopecscuola, :sitowebscuola, :sedescolastica, :CLASSE, :SEZIONE, :NUMEROALUNNI, :NOMEREFERENTE, :COGNOMEREFERENTE, :CELLULAREREFERENTE, :SESSO, :DATADINASCITA, :MATERIAINSEGNATA, :MAILREFERENTE, :informativa5, :COGNOME2, :NOME2, :MATERIA2, :EMAIL2, :COGNOME3, :NOME3, :MATERIA3, :EMAIL3, :COGNOME4, :NOME4, :MATERIA4, :EMAIL4, :COGNOME5, :NOME5, :MATERIA5, :EMAIL5, :COGNOME6, :NOME6, :MATERIA6, :EMAIL6, :COGNOME7, :NOME7, :MATERIA7, :EMAIL7, :COGNOME8, :NOME8, :MATERIA8, :EMAIL8, :COGNOME9, :NOME9, :MATERIA9, :EMAIL9)
    ON DUPLICATE KEY UPDATE
    `indirizzoemailscuola` = :indirizzoemailscuola,
    `NUMEROALUNNI` = :NUMEROALUNNI,
    `NOMEREFERENTE` = :NOMEREFERENTE,
    `COGNOMEREFERENTE` = :COGNOMEREFERENTE,
    `CELLULAREREFERENTE` = :CELLULAREREFERENTE,
    `DATADINASCITA` = :DATADINASCITA,
    `MATERIAINSEGNATA` = :MATERIAINSEGNATA,
    `MAILREFERENTE` = :MAILREFERENTE,
    `SESSO` = :SESSO,
    `COGNOME2` = :COGNOME2,
    `NOME2` = :NOME2,
    `MATERIA2` = :MATERIA2,
    `EMAIL2` = :EMAIL2,
    `COGNOME3` = :COGNOME3,
    `NOME3` = :NOME3,
    `MATERIA3` = :MATERIA3,
    `EMAIL3` = :EMAIL3,
    `COGNOME4` = :COGNOME4,
    `NOME4` = :NOME4,
    `MATERIA4` = :MATERIA4,
    `EMAIL4` = :EMAIL4,
    `COGNOME5` = :COGNOME5,
    `NOME5` = :NOME5,
    `MATERIA5` = :MATERIA5,
    `EMAIL5` = :EMAIL5,
    `COGNOME6` = :COGNOME6,
    `NOME6` = :NOME6,
    `MATERIA6` = :MATERIA6,
    `EMAIL6` = :EMAIL6,
    `COGNOME7` = :COGNOME7,
    `NOME7` = :NOME7,
    `MATERIA7` = :MATERIA7,
    `EMAIL7` = :EMAIL7,
    `COGNOME8` = :COGNOME8,
    `NOME8` = :NOME8,
    `MATERIA8` = :MATERIA8,
    `EMAIL8` = :EMAIL8,
    `COGNOME9` = :COGNOME9,
    `NOME9` = :NOME9,
    `MATERIA9` = :MATERIA9,
    `EMAIL9` = :EMAIL9,
    `informativa5` = :informativa5
 ");
    $stmt->execute(
                array(
                    ':annoscolastico' => $scuola['ANNOSCOLASTICO'],
                    ':areageografica' => $scuola['AREAGEOGRAFICA'],
                    ':regione' => $scuola['REGIONE'],
                    ':provincia' => $scuola['PROVINCIA'],
                    ':codiceistitutoriferimento' => $scuola['CODICEISTITUTORIFERIMENTO'],
                    ':denominazioneistitutoriferimento' => $scuola['DENOMINAZIONEISTITUTORIFERIMENTO'],
                    ':codicescuola' => $_POST['codicescuola'],
                    ':denominazionescuola' => $scuola['DENOMINAZIONESCUOLA'],
                    ':indirizzoscuola' => $scuola['INDIRIZZOSCUOLA'],
                    ':capscuola' => $scuola['CAPSCUOLA'],
                    ':codicecomunescuola' => $scuola['CODICECOMUNESCUOLA'],
                    ':descrizionecomune' => $scuola['DESCRIZIONECOMUNE'],
                    ':descrizionecaratteristicascuola' => $scuola['DESCRIZIONECARATTERISTICASCUOLA'],
                    ':descrizionetipologiagradoistruzionescuola' => $scuola['DESCRIZIONETIPOLOGIAGRADOISTRUZIONESCUOLA'],
                    ':indicazionesededirettivo' => $scuola['INDICAZIONESEDEDIRETTIVO'],
                    ':indicazionesedeomnicomprensivo' => $scuola['INDICAZIONESEDEOMNICOMPRENSIVO'],
                    ':indirizzoemailscuola' => $_POST['indirizzoemailscuola'],
                    ':indirizzopecscuola' => $scuola['INDIRIZZOPECSCUOLA'],
                    ':sitowebscuola' => $scuola['SITOWEBSCUOLA'],
                    ':sedescolastica' => $scuola['SEDESCOLASTICA'],
                    ':CLASSE' => $_POST['CLASSE'],
                    ':SEZIONE' => $_POST['SEZIONE'],
                    ':NUMEROALUNNI' => $_POST['NUMEROALUNNI'],
                    ':NOMEREFERENTE' => $_POST['NOMEREFERENTE'],
                    ':COGNOMEREFERENTE' => $_POST['COGNOMEREFERENTE'],
                    ':CELLULAREREFERENTE' => $_POST['CELLULAREREFERENTE'],
                    ':DATADINASCITA' => $_POST['DATADINASCITA'],
                    ':MATERIAINSEGNATA' => $_POST['MATERIAINSEGNATA'],
                    ':MAILREFERENTE' => $_POST['MAILREFERENTE'],
                    ':SESSO' => $_POST['SESSO'],
                    ':COGNOME2' => $_POST['COGNOME2'],
                    ':NOME2' => $_POST['NOME2'],
                    ':MATERIA2' => $_POST['MATERIA2'],
                    ':EMAIL2' => $_POST['EMAIL2'],
                    ':COGNOME3' => $_POST['COGNOME3'],
                    ':NOME3' => $_POST['NOME3'],
                    ':MATERIA3' => $_POST['MATERIA3'],
                    ':EMAIL3' => $_POST['EMAIL3'],
                    ':COGNOME4' => $_POST['COGNOME4'],
                    ':NOME4' => $_POST['NOME4'],
                    ':MATERIA4' => $_POST['MATERIA4'],
                    ':EMAIL4' => $_POST['EMAIL4'],
                    ':COGNOME5' => $_POST['COGNOME5'],
                    ':NOME5' => $_POST['NOME5'],
                    ':MATERIA5' => $_POST['MATERIA5'],
                    ':EMAIL5' => $_POST['EMAIL5'],
                    ':COGNOME6' => $_POST['COGNOME6'],
                    ':NOME6' => $_POST['NOME6'],
                    ':MATERIA6' => $_POST['MATERIA6'],
                    ':EMAIL6' => $_POST['EMAIL6'],
                    ':COGNOME7' => $_POST['COGNOME7'],
                    ':NOME7' => $_POST['NOME7'],
                    ':MATERIA7' => $_POST['MATERIA7'],
                    ':EMAIL7' => $_POST['EMAIL7'],
                    ':COGNOME8' => $_POST['COGNOME8'],
                    ':NOME8' => $_POST['NOME8'],
                    ':MATERIA8' => $_POST['MATERIA8'],
                    ':EMAIL8' => $_POST['EMAIL8'],
                    ':COGNOME9' => $_POST['COGNOME9'],
                    ':NOME9' => $_POST['NOME9'],
                    ':MATERIA9' => $_POST['MATERIA9'],
                    ':EMAIL9' => $_POST['EMAIL9'],
                    ':informativa5' => $_POST['informativa5']
                )
            );
    $affected_rows = $stmt->rowCount();
} catch(PDOException $ex) {
    echo $ex->getMessage();
    die();
}

if ($affected_rows > 2){
    echo "Errore nel salvataggio del modulo, si prega di riprovare. Se l'errore persiste contattare l'amministratore con queste informazioni: ";
    echo "\n";
    die(var_dump($_POST));
}

if ($affected_rows == 0){
    echo "Le informazioni per la classe {$_POST['CLASSE']} {$_POST['SEZIONE']} sono già presenti nel database;";
    die();
}

?>

<html>
    <head>
        <link href="/css/google-fonts.css?family=Open+Sans" media="all" rel="stylesheet" type="text/css">
        <link type="text/css" rel="stylesheet" href="/css/bootstrap/css/bootstrap.min.css" />

        <link type="text/css" rel="stylesheet" href="/css/bootstrap-istat.css" />
        <link type="text/css" rel="stylesheet" href="/css/bootstrap/css/docs.min.css" />
        <link type="text/css" rel="stylesheet" href="/css/modulopubblicazioni.css" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery.repeater.js"></script>
        <script type="text/javascript" src="/js/pubblicazioni.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    </head>
    <body style="font-family: 'Open Sans', sans-serif;">
    <h2>Complimenti!</h2>
<?php   if ($affected_rows==1) echo "<p>L’iscrizione della classe {$_POST['CLASSE']} {$_POST['SEZIONE']} alla ottava edizione dell’iniziativa “Il Censimento permanente sui banchi di scuola” è andata a buon fine.</p>";
        if ($affected_rows==2) echo "<p>L’aggiornamento delle informazioni relative alla classe {$_POST['CLASSE']} {$_POST['SEZIONE']} per la ottava edizione dell’iniziativa “Il Censimento permanente sui banchi di scuola” è andata a buon fine.</p>";
?>
    <p>Invieremo una conferma anche all'indirizzo di posta elettronica da Lei indicato.</p>
<?php
echo "</body></html>";



$text = <<<EOD
<body style="font-family: 'Open Sans', sans-serif">
<h2>Complimenti!</h2>
<p>L’iscrizione della sua classe alla ottava edizione dell’iniziativa “Il Censimento permanente sui banchi di scuola” è andata a buon fine.</p>
<p>&nbsp;</p>
<p><b>I dati da Lei inseriti sono:</b></p>
<p>Codice scuola: <b>{$_POST['codicescuola']}</b></p>
<p>Indirizzo di posta elettronica dell'Istituto: <b>{$_POST['indirizzoemailscuola']}</b></p>
<p>Classe: <b>{$_POST['CLASSE']}</b></p>
<p>Sezione: <b>{$_POST['SEZIONE']}</b></p>
<p>Numero di alunni: <b>{$_POST['NUMEROALUNNI']}</b></p>

<p>&nbsp;</p>
<p><b>Dati del docente referente:</b></p>
<p>Cognome: <b>{$_POST['COGNOMEREFERENTE']}</b></p>
<p>Nome: <b>{$_POST['NOMEREFERENTE']}</b></p>
<p>Sesso: <b>{$_POST['SESSO']}</b></p>
<p>Data di Nascita: <b>{$_POST['DATADINASCITA']}</b></p>
<p>Materia Insegnata: <b>{$_POST['MATERIAINSEGNATA']}</b></p>
<p>Indirizzo di posta elettronica: <b>{$_POST['MAILREFERENTE']}</b></p>
<p>&nbsp;</p>
EOD;

for($i=2;$i<=9;$i++) {
    if($_POST['COGNOME'.$i] !== ""){
        $cognome = $_POST['COGNOME'.$i];
        $nome = $_POST['NOME'.$i];
        $materia = $_POST['MATERIA'.$i];
        $email = $_POST['EMAIL'.$i];

        $additionalText =<<<EOD
<p>        <b>Docente {$i}:</b></p>
<p>        Cognome: <b>{$cognome}</b></p>
<p>        Nome: <b>{$nome}</b></p>
<p>        Materia Insegnata: <b>{$materia}</b></p>
<p>        Indirizzo di posta elettronica: <b>{$email}</b></p>
<p>        &nbsp;</p>
EOD;

        $text .= $additionalText;
    }
}

$headers =  'From: "Censimento permanente sui banchi di scuola" <censimento.scuola@istat.it>' . "\r\n";
$headers .= 'Reply-To: censimento.scuola@istat.it' . "\r\n" ;
$headers .= 'X-Mailer: PHP/' . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "Bcc: decamillis@istat.it";

mail($_POST['MAILREFERENTE'],"Registrazione al Censimento permanente sui banchi di scuola 2025","<html>".$text."</body></html>",$headers);
