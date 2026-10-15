<?php
declare(strict_types=1);
require_once __DIR__ . '/Autor.php';
require_once __DIR__ . '/Categoria.php';

final class Libro
{
    // Fase 2: constructor con promoción de propiedades públicas tipadas.
    public function __construct(
        public int $id, 
        public string $titulo , 
        public int $paginas, 
        public Autor $autor, 
        public Categoria $categoria, 
        public bool $disponible = true
        ){
            $titulo === null|| $titulo === ''? $this->titulo = 'Sin título' : $this->titulo = trim($titulo);
            $paginas<=0 ? $this->paginas = 1 : $this->paginas = $paginas;            
        }
    
    // Fase 3: título sin espacios en los extremos y valores por defecto si no es válido o las páginas no son positivas.
    // Fase 5: prestar(), devolver() y ficha().
}
