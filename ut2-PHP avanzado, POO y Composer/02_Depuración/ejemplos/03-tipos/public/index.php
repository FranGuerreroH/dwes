<?php
$diasTexto = $_GET['dias'] ?? '0';
var_dump($diasTexto);
var_dump($diasTexto === 0);
$dias = (int) $diasTexto;
var_dump($dias === 0);
