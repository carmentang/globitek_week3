<?php

  ### Encrypting Cookies using AES ###
  
  // "Rijndael" is AES
  const CIPHER_TYPE = MCRYPT_RIJNDAEL_256;
  const CIPHER_MODE = MCRYPT_MODE_CBC;

  // Returns the correct size of an initialization vector for this
  // cipher type and mode. The initialization vector randomizes the
  // initial settings of the algorithm, making it harder to decrypt.
  function cipher_iv_size() {
    return mcrypt_get_iv_size(CIPHER_TYPE, CIPHER_MODE);
  }

  function encrypt_string($string, $key="") {
    // Create an initialization vector (more secure)
    $iv = mcrypt_create_iv(cipher_iv_size(), MCRYPT_RAND);
    // Needs a key of length 16, 24, or 32
    $key = str_pad($key, 32, '*');

    // Encrypt
    $encrypted = mcrypt_encrypt(CIPHER_TYPE, $key, $string, CIPHER_MODE, $iv);

    // Return $iv at front of string, need it for decoding
    return $iv . $encrypted;
  }

  function decrypt_string($iv_with_string, $key="") {
    // Separate initialization vector and encrypted string
    $iv = substr($iv_with_string, 0, cipher_iv_size());
    $encrypted = substr($iv_with_string, cipher_iv_size());
    // Needs a key of length 16, 24, or 32
    $key = str_pad($key, 32, '*');

    // Decrypt
    return mcrypt_decrypt(CIPHER_TYPE, $key, $encrypted, CIPHER_MODE, $iv);
  }

  function encrypt($string, $key="") {
    // Encode just ensures encrypted characters are savable
    return base64_encode(encrypt_string($string, $key));
  }

  function decrypt($string, $key="") {
    return decrypt_string(base64_decode($string), $key);
  }


  function rand_md5($length) {
    $max = ceil($length / 32);
    $random = '';
    for ($i = 0; $i < $max; $i ++) {
      $random .= md5(microtime(true).mt_rand(10000,90000));
    }
    return substr($random, 0, $length);
  }


  ### Sign Cookies ###

  function signing_checksum($string) {
    $salt = "qi02BcXzp639"; // makes process hard to guess
    return hash('sha1', $string . $salt);
  }

  function sign_string($string) {
    return $string . '--' . signing_checksum($string);
  }

  function signed_string_is_valid($signed_string) {
    $array = explode('--', $signed_string);
    // if not 2 parts it is malformed or not signed
    if(count($array) != 2) { return false; }

    $new_checksum = signing_checksum($array[0]);
    return ($new_checksum === $array[1]);
  }

?>
