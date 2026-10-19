<?php

abstract class RecursoBiblioteca
{
    abstract public function tipo(): string;
}

$recurso = new RecursoBiblioteca();
