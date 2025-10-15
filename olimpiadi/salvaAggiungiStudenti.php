<?php
require_once('config.php');

if (empty($_REQUEST['id_scuola']) || empty($_REQUEST['password'])){
    die();
}

$codicescuola = strtoupper($_REQUEST['id_scuola']);

    try {
        $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $stmt = $db->prepare("SELECT * FROM scuole_master WHERE codicescuola=?");
        $stmt->execute(array($codicescuola));
        $scuola = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $ex) {
        echo $ex->getMessage();
    }

if (empty($scuola)){
    echo "<p>Nessun istituto corrisponde al codice: " .$codicescuola . "</p>";
    die();
}

if ($scuola['PASSWORD'] !== md5($_REQUEST['password'] . 'SaltOlimpiadi2018' . $codicescuola)){
    echo "La password inserita non è corretta.";
}

//Prepare insert for new students
try {
    $stmt = $db->prepare("INSERT INTO `studenti` ( `id_scuola`, `nome`, `cognome`, `classe`, `sesso`, `email`) VALUES (:id_scuola, :nome, :cognome, :classe, :sesso, :email);");
    $stmt->bindParam(':id_scuola', $codicescuola, PDO::PARAM_STR);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':cognome', $cognome, PDO::PARAM_STR);
    $stmt->bindParam(':classe', $classe, PDO::PARAM_STR);
    $stmt->bindParam(':sesso', $sesso, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
} catch(PDOException $ex) {
    echo $ex->getMessage();
}
//Insert new students
foreach($_POST['studenti'] as $studente){
    $nome = htmlspecialchars($studente['nome'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $cognome = htmlspecialchars($studente['cognome'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $classe = $studente['classe'];
    $sesso = $studente['genere'];
    $email = substr(str_shuffle(str_repeat('23456789abcdefghjkmnpqrstuvwxyz', 8)), 0, 8);
    try {
        $stmt->execute();
    } catch(PDOException $ex) {
        echo "<!-- " . $ex->getMessage() . " -->";
    }
}

//Fetch all the students
try {
    $stmt = $db->prepare("SELECT * FROM studenti WHERE id_scuola=? and deleted=?");
    $stmt->execute(array(strtoupper($_REQUEST['id']),false));
    $studenti = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo $ex->getMessage();
}

//Prepare table with all the students
$table = '<table><tr><th>Nome</th><th>Cognome</th><th>Classe</th><th>Genere</th></tr>';

//Fill table with all the students
foreach($studenti as $studente){
    $nome = $studente['nome'];
    $cognome = $studente['cognome'];
    $classe = $studente['classe'];
    $sesso = $studente['sesso'];

    $table .= "<tr><td>$nome</td><td>$cognome</td><td>$classe</td><td>$sesso</td></tr>";
    try {
        $stmt->execute();
    } catch(PDOException $ex) {
        echo $ex->getMessage();
    }
}

$table .= '</table>';

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
        <h2> Elenco degli alunni iscritti per le Olimpiadi italiane di statistica 2026: </h2>

<?php        echo $table; 

?>
<?php        
$urlModuloStudenti = "https://registrazioni" . 
    ($config['ambiente'] === 'sviluppo' ? '.sviluppo' : 
     ($config['ambiente'] === 'collaudo' ? '.collaudo' : '')) .
    ".istat.it/olimpiadi/modulo-studenti.php?id={$codicescuola}";

echo "<p> Se avesse bisogno di correggere o aggiornare questa lista può visitare l'indirizzo: <a href=" . $urlModuloStudenti . "> " . $urlModuloStudenti . " </a></p>";

    $headers =  'From: "Olimpiadi italiane di statistica" <olimpiadi-statistica@istat.it>';
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $subject = "Registrazione alle Olimpiadi italiane di statistica 2026";
    $body = "<html><h2> Elenco degli alunni iscritti per le Olimpiadi italiane di statistica 2026: </h2>";
    $body .= "<p>Questo è l'elenco aggiornato di tutti gli studenti iscritti dalla Sua scuola alle Olimpiadi italiane di statistica 2026</p>";
    $body .= "<p>La preghiamo di verificarne la completezza e accuratezza dei dati.<p>";
    $body .= "Se avesse bisogno di correggere o aggiornare questa lista può visitare l'indirizzo: <a href=" . $urlModuloStudenti . "> " . $urlModuloStudenti . " </a></p>";
    $body .= $table."</body></html>";

    mail($scuola['MAILREFERENTE'], $subject,$body,$headers);

?>
