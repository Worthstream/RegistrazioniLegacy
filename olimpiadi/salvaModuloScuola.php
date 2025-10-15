<?php
require_once('config.php');
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

$_POST['codicescuola'] = strtoupper(explode(' ', $_POST['codicescuola'])[0]);

try {
    $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $stmt = $db->prepare("SELECT * FROM scuole_master WHERE CODICESCUOLA=?");
    $stmt->execute(array($_POST['codicescuola']));
    $scuola = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo $ex->getMessage();
}

if (!empty($scuola['PASSWORD'])){
    die("La scuola " . ucwords($scuola['DENOMINAZIONESCUOLA']) . " risulta già iscritta alle olimpiadi di statistica.");
}

try {
    $stmt = $db->prepare("UPDATE `scuole_master` SET 
                        `NOMEREFERENTE` = :nomeReferente,
                        `COGNOMEREFERENTE` = :cognomeReferente,
                        `MAILREFERENTE` = :mailReferente,
                        `CELLULAREREFERENTE` = :cellulareReferente,
                        `PASSWORD` = :password 
                        WHERE `CODICESCUOLA` = :codicescuola");
    $stmt->execute(
                array(
                    ':nomeReferente' => $_POST['nomeReferente'],
                    ':cognomeReferente' => $_POST['cognomeReferente'],
                    ':mailReferente' => $_POST['indirizzoReferente'],
                    ':cellulareReferente' => $_POST['numeroReferente'],
                    ':password' => md5($_POST['password'] . 'SaltOlimpiadi2018' . $_POST['codicescuola']),
                    ':codicescuola' => $_POST['codicescuola']
                )
            );
    $affected_rows = $stmt->rowCount();
} catch(PDOException $ex) {
    echo $ex->getMessage();
}

if ($affected_rows !== 1){ 
    die('Errore nel salvataggio del modulo, si prega di riprovare e di verificare che il codice inserito (' . $_POST['codicescuola'] . ') sia corretto.');
}

$urlModuloStudenti = "https://registrazioni" . 
    ($config['ambiente'] === 'sviluppo' ? '.sviluppo' : 
     ($config['ambiente'] === 'collaudo' ? '.collaudo' : '')) .
    ".istat.it/olimpiadi/modulo-studenti.php?id={$_POST['codicescuola']}";


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
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <title>
            Modulo di iscrizione alle Olimpiadi italiane di statistica 2026
        </title>
    </head>
    <body style="font-family: 'Open Sans', sans-serif;">
    <h2>Registrazione avvenuta con successo</h2>
    <p>Per iscrivere gli studenti che intendono partecipare alla competizione può visitare il seguente indirizzo:</p>
    <p><a href="<?php echo $urlModuloStudenti ?>"> <?php echo $urlModuloStudenti ?> </a></p>
    <p>Abbiamo inviato questo link anche all'indirizzo di posta elettronica da Lei indicato.</p>
    <p>Le verrà richiesto di inserire la password da Lei scelta.</p>
<?php
echo "</body></html>";

if (empty($_POST['indirizzoReferente'])) die('Errore: nessuna email inserita.');

$text = <<<EOD
<body style="font-family: 'Open Sans', sans-serif">
<p>Gentile {$_POST['nomeReferente']} {$_POST['cognomeReferente']}, </p>
<p>grazie per aver iscritto la Sua scuola alle Olimpiadi italiane di statistica 2026.</p>
<p>Per completare l'iscrizione deve inserire i nomi degli alunni partecipanti al seguente indirizzo:</p>
<p><a href="{$urlModuloStudenti}"> {$urlModuloStudenti} </a></p>
<p>Le verrà richiesto di inserire la password da Lei scelta.</p>
<p>Le ricordiamo che per l'iscrizione degli studenti i referenti devono
acquisire e conservare l'autorizzazione dei genitori o di chi esercita l'autorità genitoriale
a far partecipare il/la proprio/a figlio/a alle Olimpiadi italiane di statistica</p>
EOD;

$headers =  'From: "Olimpiadi italiane di statistica" <olimpiadi-statistica@istat.it>' . "\r\n";
$headers .= 'Reply-To: olimpiadi-statistica@istat.it' . "\r\n" ;
$headers .= 'X-Mailer: PHP/' . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

mail($_POST['indirizzoReferente'],"Registrazione alle Olimpiadi italiane di statistica 2026","<html>".$text."</body></html>",$headers);
