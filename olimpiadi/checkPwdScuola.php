<?php
require_once('config.php');

if (empty($_REQUEST['id']) || empty($_REQUEST['hash'])){
    die();
}

$codicescuola = strtoupper($_REQUEST['id']);

try {
    $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $stmt = $db->prepare("SELECT * FROM scuole_master WHERE CODICESCUOLA=?");
    $stmt->execute(array($codicescuola));
    $scuola = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
    echo $ex->getMessage();
    die();
}

if (empty($scuola)){
    echo "<label class='error'>Nessuna scuola corrisponde al codice: " .$codicescuola . "</label>";
    die();
}

if ($scuola['PASSWORD'] != $_REQUEST['hash']){
    echo "false";
    die();
}

// Password is correct, check if we need to return form HTML
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'getFormStudenti') {
    $page = $_REQUEST['page'] ?? 'aggiungi';
    
    if ($page === 'modifica') {
        // Get existing students for modifica page
        try {
            $stmt = $db->prepare("SELECT * FROM studenti WHERE id_scuola=? and deleted=?");
            $stmt->execute(array($codicescuola, false));
            $studenti = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $ex) {
            echo $ex->getMessage();
            die();
        }
        
        if(empty($studenti)){ 
            $studenti = array (
                0 => array (
                  'id' => '',
                  'id_scuola' => '',
                  'nome' => '',
                  'cognome' => '',
                  'classe' => '',
                  'sesso' => 'm',
                ),
            );           
        }
    } else {
        // Default empty student for aggiungi page
        $studenti = array (
            0 => array (
              'id' => '',
              'id_scuola' => '',
              'nome' => '',
              'cognome' => '',
              'classe' => '',
              'sesso' => 'm',
            ),
        );
    }
    
    // Generate and return the formStudenti HTML
    echo generateFormStudentiHTML($studenti, $codicescuola);
} else {
    // Original behavior - just return "true"
    echo "true";
}

function generateFormStudentiHTML($studenti, $codicescuola) {
    ob_start();
    ?>
    <div id="formStudenti" class="uneditable">
        <div class="control-group col-xs-12 repeater">
            <div class="col-xs-1">
                <div class="form-group">
                    <label>Classe</label> 
                </div>
            </div>                                
            <div class="col-xs-4">
                <div class="form-group">
                    <label>Cognome</label> 
                </div>
            </div>                                
            <div class="col-xs-4">
                <div class="form-group">
                    <label>Nome</label> 
                </div>
            </div>                                                         
            <div class="col-xs-3">
                <div class="form-group">
                    <label>Genere</label> 
                </div>
            </div>                                                      
        </div>
        <div class="control-group col-xs-12 repeater uneditable">
            <div data-repeater-list="studenti">
<?php
foreach($studenti as $studente){
    $text = <<<EOD
                <div data-repeater-item>
                    <div class="col-xs-1">
                        <div class="form-group">
                            <label for="classe"></label> 
                            <select id="classe" name="studenti[0][classe]" class="form-control" required="" autocomplete="off">
EOD;

    $text .= $studente['classe'] == "Prima"   ? "<option selected>Prima</option>"   : "<option>Prima</option>";
    $text .= $studente['classe'] == "Seconda" ? "<option selected>Seconda</option>" : "<option>Seconda</option>";
    $text .= $studente['classe'] == "Terza"   ? "<option selected>Terza</option>"   : "<option>Terza</option>";
    $text .= $studente['classe'] == "Quarta"  ? "<option selected>Quarta</option>"  : "<option>Quarta</option>";

    $text .= <<<EOD
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="cognome"></label>
                            <input autocomplete="off" id="cognome" name="studenti[0][cognome]" size="30" class="form-control gui-input" placeholder="Cognome" required="" type="text" value="{$studente['cognome']}"/>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group">
                            <label for="nome"></label>
                            <input autocomplete="off" id="nome" name="studenti[0][nome]" size="30" class="form-control gui-input" placeholder="Nome" required="" type="text" value="{$studente['nome']}"/>
                        </div>
                    </div>                                    
                    <div class="col-xs-3">
                        <div class="form-group">
                            <div class="input-group" style="padding-left: 10px;padding-top: 5px;">
                                <label for="studenti[0][genere]"></label>
EOD;

    $text .= '<label class="radio-inline"><input type="radio" value="m" name="studenti[0][genere]" required="" ' . ($studente['sesso']=='m'?'checked':'') . '>M</label>';
    $text .= '<label class="radio-inline"><input type="radio" value="f" name="studenti[0][genere]" required="" ' . ($studente['sesso']=='f'?'checked':'') . '>F</label>';

    $text .= <<<EOD
                                <span class="input-group-btn pad-l10">
                                    <span class="btn btn-danger" style="padding:6px 12px" data-repeater-delete=""><span class="glyphicon glyphicon-remove"></span> 
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12"></div>
                </div>
EOD;
    echo $text;
}
?>
            </div>
            <p style="float:right;"><span data-repeater-create class="btn btn-primary" style="padding:6px 12px"><span  class="glyphicon glyphicon-plus"></span></span></p>
        </div>
        <div class="col-xs-12" style="text-align: right;">
            <label class="radio-inline">
                <input value="Ok" name="informativa" required="true" aria-required="true" type="radio" id="informativaradio">
                     Ho ricevuto le <a href="AutorizzazioneGenitori.pdf" download="AutorizzazioneGenitori.pdf">autorizzazioni per l'iscrizione dei ragazzi</a>
            </label>
        </div>
        <div class="control-group col-xs-12">
            <div class="form-actions col-xs-12">
                <input type="hidden" name="id_scuola" value="<?php echo $codicescuola; ?>">
                <input type="submit" value="Invia modulo" name="Invia" style="width:107px;margin-top:1em;float:right" class="btn btn-primary" id="school-input-37" />
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>
