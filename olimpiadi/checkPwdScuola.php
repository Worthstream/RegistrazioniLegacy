<?php
require_once('config.php');
if (empty($_REQUEST['id']) || empty($_REQUEST['hash'])){
    die();
}
$codiceistitutoriferimento = strtoupper($_REQUEST['id']);

 
    try {
        $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $stmt = $db->prepare("SELECT * FROM scuole_master WHERE codiceistitutoriferimento=?");
        $stmt->execute(array($codiceistitutoriferimento));
        $scuola = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $ex) {
        echo $ex->getMessage();
    }

if (empty($scuola)){
    echo "<label class='error'>Nessuna scuola corrisponde al codice: " .$codiceistitutoriferimento . "</label>";
    die();
}

if ($scuola['PASSWORD'] == $_REQUEST['hash']){
    echo "true";
}
