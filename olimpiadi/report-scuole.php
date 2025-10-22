<?php
require_once('config.php');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $whiteList = [
        'registrazioni.sviluppo.istat.it',
        'registrazioni.collaudo.istat.it',
    ];
    if (!in_array($_SERVER['SERVER_NAME'], $whiteList, true)) {
        $msgHeader = ' 403 Forbidden';
        $codeHttp = 403;
        header($_SERVER["SERVER_PROTOCOL"] . $msgHeader, true, $codeHttp);
        exit($_SERVER["SERVER_PROTOCOL"] . $msgHeader);
    }

    try{
        $db = new PDO($config['string'], $config['dbname'], $config['dbpass'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch(PDOException $ex) {
        echo $ex->getMessage();
    }

    header('Content-type: text/csv');
    header('Content-Disposition: attachment; filename="Report-Scuole-'. date("Y.m.d") .'.csv"');

    try {
    $stmt = $db->prepare("
        SELECT 
            DENOMINAZIONESCUOLA AS 'Nome Scuola',
            REGIONE AS 'Regione',
            PROVINCIA AS Provincia,
            DESCRIZIONECOMUNE AS Comune,
            CONCAT(COGNOMEREFERENTE, ' ', NOMEREFERENTE) AS Referente,
            MAILREFERENTE AS Email,
            CELLULAREREFERENTE AS Cellulare,
            CONCAT('https://registrazioni.istat.it/olimpiadi/modulo-studenti.php?id=', sm.codicescuola) AS 'Link al modulo'
        FROM scuole_master
        WHERE PASSWORD IS NOT NULL AND codicescuola NOT LIKE 'TEST0000__'
    ");
        $stmt->execute();
        $output = fopen('php://output', 'w');
        $header = true;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($header) {
                fputcsv($output, array_keys($row));
                $header = false;
            }
            fputcsv($output, $row);
        }
        fclose($output);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

?>
