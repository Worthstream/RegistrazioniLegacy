<?php
require_once('config.php');
if (empty($_REQUEST['id'])){
    die();
}
$codiceistitutoriferimento = strtoupper($_REQUEST['id']);

$scuola = array("REGIONE" => "",
    "PROVINCIA" => "",
    "DESCRIZIONECOMUNE" => "",
    "DENOMINAZIONEISTITUTORIFERIMENTO" => "",
    "DENOMINAZIONEISTITUTORIFERIMENTO" => "",);

 
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
    echo "<script>$('#school-input-1')[0].value = '';</script>";
    die();
}

$htmlsnippet= <<<EOD
<div class="control-group col-xs-4">
<label class="control-label">Regione:</label>
<span class="control" id="nomeRegione">{$scuola['REGIONE']}</span>
</div>
<div class="control-group col-xs-4">
<label class="control-label">Provincia:</label>
<span class="control" id="nomeProvincia">{$scuola['PROVINCIA']}</span>
</div>
<div class="control-group col-xs-4">
<label class="control-label">Comune:</label>
<span class="control" id="nomeComune">{$scuola['DESCRIZIONECOMUNE']}</span>
</div>
<div class="control-group col-xs-6">
<label class="control-label">Istituto:</label>
<span class="control" id="nomeIstituto">{$scuola['DENOMINAZIONEISTITUTORIFERIMENTO']}</span>
</div>
<div class="control-group col-xs-6">
<label class="control-label">Scuola:</label>
<span class="control" id="nomeScuola">{$scuola['DENOMINAZIONEISTITUTORIFERIMENTO']}</span>
</div>     
EOD;

echo $htmlsnippet;
