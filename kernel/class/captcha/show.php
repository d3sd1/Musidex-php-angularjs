<?php
require_once('../../core.php');
$img = new Securimage();
if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);
$img->show();