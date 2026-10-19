<?php
namespace App\Model;
class Libro extends Recurso
{
 public function __construct(
 private string $titulo
 ) {}
 public function titulo(): string
 {
 return $this->titulo;
 }
}
