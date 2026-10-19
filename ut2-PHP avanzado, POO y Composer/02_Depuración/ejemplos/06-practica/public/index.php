<?php
function puedePrestar(bool $disponible): string
{
    if ($disponible = true) {
        return 'Préstamo permitido';
    }
    return 'Préstamo rechazado';
}
echo puedePrestar(false);
