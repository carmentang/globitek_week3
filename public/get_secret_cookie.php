<?php
  require_once('../private/initialize.php');
?>
<?php $page_title = 'Cookie Reveal'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<?php include(SHARED_PATH . '/public_menu.php'); ?>

<?php require_once('../private/cookie_functions.php'); ?>

<?php
  $signed_val = $_COOKIE['scrt'];
  if(signed_string_is_valid($signed_val)) {
    $encrypted_val = explode('--', $signed_val)[0];
    $key = $_SESSION['magic_key'];
    $decrypted_value = decrypt($encrypted_val, $key);
  } else {
    echo "Error: request invalid";
  }

?>

<div id="main-content">

  <div id="cookie-test">
    <h1>Cookie Testing</h1>

    <p style="width: 500px;">
      <?php
        if(isset($decrypted_value)) {
          echo "Retrieving cookie: " . $decrypted_value;
        } else {
          echo "No cookie retrieved.";
        }
      ?>
    </p>
  </div>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
