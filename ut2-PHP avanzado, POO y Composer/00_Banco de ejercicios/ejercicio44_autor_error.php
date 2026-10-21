<?php

class Autor
{
    public function __construct(
        public readonly string $nombre,
        public readonly string $codigo
    ) {
    }
}

$autor = new Autor('Frank Herbert', 'AUT-01');
$autor->nombre = 'Otro autor';
