<?php
require_once('config.php');
if (empty($_GET['term'])) {
    die();
}
$codicescuola = strtoupper($_GET['term']) . '%';

$scuola = array(
    "codicescuola" => "",
    "regione" => "",
    "provincia" => "",
    "descrizionecomune" => "",
    "denominazionescuola" => "",
    "DENOMINAZIONESCUOLA" => "",
    "descrizionetipologiagradoistruzionescuola" => "",
    "indirizzoscuola" => "",
);

try {
    $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $stmt = $db->prepare("SELECT DISTINCT codicescuola, denominazionescuola FROM scuole_master WHERE codicescuola LIKE :codicescuola AND regione <> ''");
    $stmt->bindParam(':codicescuola', $codicescuola);
    $stmt->execute();
} catch(PDOException $ex) {
    echo $ex->getMessage();
}

// Generate array with schools data 
$schoolData = array();
while ($scuola = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data['id'] = $scuola["codicescuola"];
    $data['value'] = $scuola["codicescuola"] . ' - ' . $scuola["denominazionescuola"];
    array_push($schoolData, $data);
}

// Return results as json encoded array 
echo json_encode($schoolData);
?>
