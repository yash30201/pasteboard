<?php
require_once('../Private/initialize.php');

session_unset();

// destroy the session
session_destroy();

redirect_to(url_for('index.php'));
