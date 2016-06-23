<?php
  require_once('../private/initialize.php');
?>
<?php $page_title = 'Cookie Set'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<?php include(SHARED_PATH . '/public_menu.php'); ?>

<?php require_once('../private/cookie_functions.php'); ?>

<?php
  $value = 'I have a secret to tell.';
  $key = rand_md5(32);
  $_SESSION['magic_key'] = $key;
  $encrypted_val = encrypt($value, $key);
  $signed_val = sign_string($encrypted_val);
  setcookie('scrt', $signed_val);
?>

<div id="main-content">

  <div id="cookie-test">
    <h1>Cookie Testing</h1>

    <p style="width: 500px;">
      Currently setting cookie.
    </p>
  </div>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
