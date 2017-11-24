<?php
include_once 'config/client.php';
?>
<div class="entete">
  <a href="<?php echo $client_url_server ?>" title="Retour sur le site du Centre de Pathologie des Hauts-de-France"><img src="//www.anapath.fr/wp-content/uploads/2017/06/logo-300px.png" alt="Logo Laboratoire Anapathologie Amiens"></a>
  <h1>requête non signée</h1>
</div>
<div class="info">
  <p class="alert">Les données envoyées n'ont pas pu être vérifiées, ou il s'agit d'une tentative de pishing ou de fraude.</p>
  <p class="alert">Une vérification de la clé publique est nécessaire.</p>
  <p class="alert">Merci de contacter votre Centre de Pathologie des Hauts-de-France pour signaler ce problème ou sur <a href="mailto:<?php echo $client_email_contact; ?>" title="Envoyer un e-mail au Centre de Pathologie des Hauts-de-France"><?php echo $client_email_contact; ?></a></p>
  <?php include 'template/button-form-vuejs.php'; ?>
  <?php include 'template/button-print.php'; ?>
</div>
