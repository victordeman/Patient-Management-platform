<?php
session_start();
session_destroy();
header('Location: ?route=login');
exit;
?>
