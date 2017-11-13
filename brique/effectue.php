<?php
include_once 'config/client.php';
include_once 'utils/functions.php';
include_once 'utils/auth.php';

// Force HTTPS only if force_https = true (cf config/client.php)
if ( $force_https ) { include 'utils/force-https.php'; }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Règlement accepté | Centre de Pathologie</title>
  <meta name="description" content="Votre paiement a été accepté !">
  <meta name="robots" content="noindex, nofollow, noodp">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo $client_dir_ui_js ?>/static/favicon-anapath-amiens.png" />
</head>
<?php include 'assets/style.css.php'; ?>
<body>
  <?php
  // Vérification RSA de la requète - Securité !
  $IS_AUTH_REQUEST = IsAuthRequest('all');

  if ( $IS_AUTH_REQUEST === 1 ) { // Si le corps de la requète n'est pas modifié et provient bien de e-transactions

    // Si toutes les variables necessaires existent
    if ( isset($_GET[$client_pbx_ref]) && isset($_GET[$client_prv_email]) && isset($_GET[$client_prv_ddn]) && isset($_GET[$client_pbx_montant]) ) {
  ?>
      <div class="entete">
        <a href="<?php echo $client_url_server ?>" title="retour sur le site du Centre de Pathologie Haut de France"><img src="<?php echo $client_file_logo ?>" alt="Logo Laboratoire Anapathologie Amiens"></a>
        <h1>Transaction effectuée avec succès</h1>
      </div>
      <div class="info">
        <p class="alert" style="font-size: 20px;"><strong>Vous recevrez prochainement la feuille de soins ou la facture acquittée pour obtenir le remboursement de ces frais.</strong></p>
        <?php
          echo verifBeforePrintOut($client_prv_email);
          echo verifBeforePrintOut($client_prv_ddn);
          echo verifBeforePrintOut($client_pbx_ref);
          echo verifBeforePrintOut($client_pbx_montant);
          echo verifBeforePrintOut($client_pbx_type_paiement);
          echo verifBeforePrintOut($client_pbx_cb);
          echo verifBeforePrintOut($client_pbx_transaction);
          echo verifBeforePrintOut($client_pbx_date);
          echo verifBeforePrintOut($client_pbx_heure);
          echo verifBeforePrintOut($client_pbx_autorisation);
          echo verifBeforePrintOut($client_pbx_error);
         ?>
        <?php include 'template/button-website.php'; ?>
        <?php include 'template/button-form-vuejs.php'; ?>
        <?php include 'template/button-print.php'; ?>
      </div>
    <?php
    } else { // Il manque des variables importantes et nécessaires
        include 'template/query-missing.php';
        customLog('Variables manquantes dans la query string.');
    }
  } else if ( $IS_AUTH_REQUEST === 0 ) { // Requète non sécurisée.
      include 'template/query-not-sign.php';
      customLog('Query string non signée.');
  } else { // Problème interne (dépendances, ouverture clé, etc ...)
      include 'template/query-sign-intern-error.php';
      customLog('Problème interne de décodage signature.');
  }
  ?>
</body>
</html>
