<?php
require_once ('./../../private/initialize.inc.php');

unset($_SESSION['username']);

redirect(url_for('/admin/login.php'));