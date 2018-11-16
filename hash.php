<?php
$password = "pac2";
$hash_password = password_hash($password, PASSWORD_DEFAULT);
echo $hash_password;
?> 