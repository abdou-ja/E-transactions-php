<?php
include_once 'config/client.php';
include_once 'utils/error-handler.php';
// Function de traitement de la chaine montant
// Renvoie le montant de la transaction convertit en centimes
// Retourne FALSE si le montant est strictement inférieur à 1€
function amountToCentimes( $montant_query) {
  global $debug;
  if ( $debug ) { echo 'Processing checking amount... '.$montant_query.'<br>'; }
  $temp = str_replace(",", ".", $montant_query); // replace , par .
  if ( $debug ) { echo 'Replace , par . : '.$temp.'<br>'; }
  $temp = floatval( $temp ); // convert to float
  if ( $debug ) { echo 'Convert to float: '.$temp.'<br>'; }
  $temp = round($temp, 2); // arrondi supérieur avec 2 décimales
  if ( $debug ) { echo 'Round 2 decimals: '.$temp.'<br>'; }
  $temp = $temp * 100;
  if ( $debug ) { echo 'Multiply by 100: '.$temp.'<br>'; }
  $temp = str_replace(".", "", $temp);
  if ( $debug ) { echo 'Replace . by nothing in case of: '.$temp.'<br>'; }
  if ($temp > 99) {
    return $temp; // Retourne le montant formatté si > 1€
  } else {
    return false;
  }
}

function convertDate($string, $insert) {
  if ($string) {
    $arr = str_split($string, 2); // convertir en tableau composé de 2 caractères par entrée
    $day = array_slice($arr, 0, 1); // Récupérer le jour
    $month = array_slice($arr, 1, 1); // Récupérer le Mois
    $year = array_slice($arr, 2, 2); // Récupérer l'année

    return $day[0].$insert.$month[0].$insert.$year[0].$year[1];
  } else {
    return $string;
  }
}

function verifBeforePrintOut($query, $class = '') {
  global $debug,
         $client_pbx_montant,
         $client_pbx_ref,
         $client_prv_email,
         $client_prv_ddn,
         $client_pbx_cb,
         $client_pbx_type_paiement,
         $client_pbx_autorisation,
         $client_pbx_transaction,
         $client_pbx_date,
         $client_pbx_heure,
         $client_pbx_error;
  if ( isset($_GET[$query]) ) {
    $temp = $_GET[$query];
    switch ($query) {
      case $client_pbx_montant:
        $temp = $temp/100;
        return '<p class="'.$class.'">Montant de la transaction : '.$temp.'€</p>';
        break;
      case $client_pbx_ref:
        return '<p class="'.$class.'">Numéro d\'examen : '.$temp.'</p>';
        break;
      case $client_prv_email:
        return '<p class="'.$class.'">Email renseigné : '.$temp.'</p>';
        break;
      case $client_prv_ddn:
        return '<p class="'.$class.'">Date de naissance renseignée : '.$temp.'</p>';
        break;
      case $client_pbx_cb:
        return '<p class="'.$class.'">Numéro de carte bancaire : XXXX XXXX XXXX '.$temp.'</p>';
        break;
      case $client_pbx_type_paiement:
        return '<p class="'.$class.'">Type de paiement choisi : '.$temp.'</p>';
        break;
      case $client_pbx_autorisation:
        return '<p class="'.$class.'">Numéro d\'autorisation bancaire : '.$temp.'</p>';
        break;
      case $client_pbx_transaction:
        return '<p class="'.$class.'">Numéro de transaction bancaire : '.$temp.'</p>';
        break;
      case $client_pbx_date:
        $temp = convertDate($temp, '/');
        return '<p class="'.$class.'">Date de l\'opération : '.$temp.'</p>';
        break;
      case $client_pbx_heure:
        return '<p class="'.$class.'">Heure de l\'opération : '.$temp.'</p>';
        break;
      case $client_pbx_error:
        $temp = errorHandler($temp);
        return '<p class="'.$class.'">Statut de l\'opération : '.$temp.'</p>';
        break;
    }
  } else {
    if ($debug) { return $query.' est absent de la requète<br>';}
  }
}

function verifBeforeGetQuery($query) {
  if ( isset($_GET[$query]) ) {
    return $_GET[$query];
  } else {
    return null;
  }
}

function getUrlPath() {
  return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

function isPage($page) {
  return strpos(getUrlPath(), $page);
}

function customLog($message, $message_type = 3) {
  $ip = "IP: ".$_SERVER['REMOTE_ADDR'];
  $qs = "Query: ".$_SERVER['QUERY_STRING'];
  $cp = "File: ".getUrlPath();
  $date = date("d/m/Y G:i:s");
  $new_line = " \r\n";
  $log = $date." -> ".$ip." -> ".$qs." -> ".$cp." -> ".$message.$new_line;
  return error_log($log, 3, "log-server.log");
}
?>
