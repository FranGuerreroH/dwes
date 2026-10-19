<?php

abstract class RecursoBiblioteca
{
    final public function origen(): string
    {
        return 'Biblioteca';
    }
}

class RecursoHijo extends RecursoBiblioteca
{
    public function origen(): string
    {
        return 'Otro origen';
    }
}
