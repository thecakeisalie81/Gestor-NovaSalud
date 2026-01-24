<?php
session_start();
session_unset();
session_destroy();
header("Location: Pages/login-registro.php");
exit();
