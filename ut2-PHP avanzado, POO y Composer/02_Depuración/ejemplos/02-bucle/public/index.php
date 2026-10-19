<?php
$retrasos = [2, 4, 3];
$totalDias = 0;
for ($i = 0; $i < count($retrasos) - 1; $i++) {
    $dias = $retrasos[$i];
    $totalDias += $dias;
}
echo "Total: $totalDias días";
