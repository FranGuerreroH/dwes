<?php

declare(strict_types=1);

namespace Escuela\Curso\Servicio;

use Escuela\Curso\Contrato\CursoRepository;
use Escuela\Curso\Excepcion\CursoException;
use Escuela\Curso\Modelo\{Curso, EstadoCurso};
use Escuela\Curso\Repositorio\ArrayCursoRepository;

final class CatalogoService
{
    public function __construct(private CursoRepository $repository)
    {
    }

    public function filtrar(
        string $texto = '',
        ?EstadoCurso $estado = null,
        bool $soloConPlazas = false
    ): array
    {
        $texto = mb_strtolower(trim($texto), 'UTF-8');

        // TODO F1: filtra los cursos mediante array_filter.
        
        $filtrado = array_filter($this->repository->todos(), 
                    function (Curso $curso):bool{ str_contains($curso->nombreNormalizado(), $texto)   
                                                ?: $estado === $curso::cases()
                                                ?: $soloConPlazas && EstadoCurso::Abierto && $curso->plazasLibres()>0;
                                                }
                    );
        return array_values($filtrado);        
    }

    public function ordenar(array $cursos): array
    {
        // TODO F2: ordena una copia mediante usort y un callback.
        $cursosOrdenados= $cursos;
        $cursosOrdenados= usort($cursos,
                                function (Curso $a, Curso $b): int{
                                    $b->precioPlaza() <=> $a->precioPlaza()
                                    ?: $b->id() <=> $a->id()
                                    ; 
                                    }
                                );
        return $cursosOrdenados;
    }

    public function etiquetas(array $cursos, string $prefijo = 'Curso: '): array
    {
        // TODO F3: array_map y arrow function.
        return array_map($cursos,
                         fn (string $prefijo, Curso $curso): string => $curso->etiqueta($prefijo)
        );
    }

    public function resumen(array $cursos): array
    {
        // TODO F4: calcula las tres cifras mediante array_reduce.


        return array_reduce($cursos,
                            function(Curso $curso):array{
                                $cantidad += 1;
                                $libres += $curso->plazasLibres();
                                $importeCentimos += $curso->precioPlaza();

                                return $solución = ["cantidad"= $cantidad,
                                "libres" = $libres,
                                "importeCentimos"=$importeCentimos];
                                
                            },
                            [
                                "cantidad"= 0,
                                "libres" = 0,
                                "importeCentimos"=0
                            ]
                            )
    }

    public function buscarOpciones(int $plazas, int $presupuestoCentimos): array
    {
        // TODO D1: repara las etapas de esta búsqueda sin utilizar bucles.
        if ($plazas <= 0 || $presupuestoCentimos < 0) {
            throw new InvalidArgumentException('Plazas o presupuesto no válidos');
        }

        $candidatos = array_filter(
            $this->repository->todos(),
            fn (Curso $curso): bool =>
                $curso->estado() === EstadoCurso::Abierto
                || $curso->plazasLibres() >= $plazas
        );

        $propuestas = array_map(
            fn (Curso $curso): array => [
                'id' => $curso->id(),
                'importeCentimos' => $curso->precioPlaza() * $plazas,
                'libresDespues' => $curso->plazasLibres() - $plazas
            ],
            $candidatos
        );

        $resultado = array_reduce(
            $propuestas,
            function (array $acumulado, array $propuesta) use ($presupuestoCentimos):array {
                if ($propuesta['importeCentimos'] <= $presupuestoCentimos) {
                    $acumulado[] = $propuesta;
                }

                return $acumulado;
            },
            ['opciones' => [], 'importeAcumulado' => 0]
        );

        usort(
            $propuestas,
            fn (array $a, array $b): int =>
                (($a['importeCentimos'] <=> $b['importeCentimos']) !== 0)
                    ? ($a['importeCentimos'] <=> $b['importeCentimos'])
                    : ($a['id'] <=> $b['id'])
        );

        return $resultado['opciones'];
    }

    private function requerido(int $id): Curso
    {
        return $this->repository->buscarPorId($id)
            ?? throw new CursoException('El curso no existe');
    }

    public function reservar(int $id, int $cantidad): void
    {
        $this->requerido($id)->reservar($cantidad);
    }

    public function cancelar(int $id, int $cantidad): void
    {
        $this->requerido($id)->cancelar($cantidad);
    }
}
