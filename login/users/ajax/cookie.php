<?php 
  setcookie('popup', 'form', time() + 3600 * 24 * 30 * 12, '/');
  
  var_dump($_COOKIE);