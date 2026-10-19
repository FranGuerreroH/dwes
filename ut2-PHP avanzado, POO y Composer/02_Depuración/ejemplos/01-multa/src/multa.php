<?php
function calcularMulta(int $dias, float $tarifa): float
{
    $total = $dias * $tarifa;
    return $total;
}
