<?php

declare(strict_types=1);

namespace Escuela\Curso\Servicio;

use Escuela\Curso\Contrato\CursoRepository;
use Escuela\Curso\Excepcion\CursoException;
use Escuela\Curso\Modelo\{Curso, EstadoCurso};
use Escuela\Curso\Repositorio\ArrayCursoRepository;

final class CatalogoService
{
    public function __construct(private CursoRepository $repository) {}

    public function filtrar(
        string $texto = '',
        ?EstadoCurso $estado = null,
        bool $soloConPlazas = false
    ): array {
        $texto = mb_strtolower(trim($texto), 'UTF-8');

        // TODO F1: filtra los cursos mediante array_filter.

        $filtrado = array_filter(
            $this->repository->todos(),
            // No sé bien qué lio has montado. No haces return, no mezclas las comparaciones
            function (Curso $curso) use ($texto, $estado, $soloConPlazas): bool {
                return str_contains($curso->nombreNormalizado(), $texto) &&
                    ($estado === null || $curso->estado() === $estado) &&
                    (!$soloConPlazas || ($curso->plazasLibres() > 0 && $curso->estado() === EstadoCurso::Abierto));
            }
        );
        return array_values($filtrado);
    }

    public function ordenar(array $cursos): array
    {
        // TODO F2: ordena una copia mediante usort y un callback.
        $cursosOrdenados = $cursos;
        // usort devuelve true, pero modifica el array
        usort(
            $cursosOrdenados,
            // Si usas function recuerda que tienes que poner el return
            function (Curso $a, Curso $b): int {
                // Estaban descendentes
                return $a->precioPlaza() <=> $b->precioPlaza() ?: $a->id() <=> $b->id();
            }
        );
        return $cursosOrdenados;
    }

    public function etiquetas(array $cursos, string $prefijo = 'Curso: '): array
    {
        // TODO F3: array_map y arrow function.
        return array_map(
            // El prefijo ya lo tienes y la sintaxis al revés
            fn(Curso $curso): string => $curso->etiqueta($prefijo),
            $cursos,
        );
    }

    public function resumen(array $cursos): array
    {
        // TODO F4: calcula las tres cifras mediante array_reduce.


        return array_reduce(
            $cursos,
            // Falta definir el acumulador
            function (array $acumulador, Curso $curso): array {
                $acumulador['cantidad'] += 1;
                $acumulador['libres'] += $curso->plazasLibres();
                $acumulador['importeCentimos'] += ($curso->precioPlaza() * $curso->ocupadas());

                return $acumulador;
            },
            [
                // es => en lugar de =
                "cantidad" => 0,
                "libres" => 0,
                "importeCentimos" => 0
            ]
        );
    }

    public function buscarOpciones(int $plazas, int $presupuestoCentimos): array
    {
        // TODO D1: repara las etapas de esta búsqueda sin utilizar bucles.
        if ($plazas <= 0 || $presupuestoCentimos < 0) {
            // Si no pones el \ debes poner el use
            throw new \InvalidArgumentException('Plazas o presupuesto no válidos');
        }

        $candidatos = array_filter(
            $this->repository->todos(),
            fn(Curso $curso): bool =>
            $curso->estado() === EstadoCurso::Abierto
                // Conidicón incorrecta
                && $curso->plazasLibres() >= $plazas
        );

        $propuestas = array_map(
            fn(Curso $curso): array => [
                'id' => $curso->id(),
                'importeCentimos' => $curso->precioPlaza() * $plazas,
                'libresDespues' => $curso->plazasLibres() - $plazas
            ],
            $candidatos
        );

        $resultado = array_reduce(
            $propuestas,
            function (array $acumulado, array $propuesta) use ($presupuestoCentimos): array {
                if ($propuesta['importeCentimos'] <= $presupuestoCentimos) {
                    $acumulado[] = $propuesta;
                }

                return $acumulado;
            },
            []
        );

        usort(
            $propuestas,
            fn(array $a, array $b): int => (($a['importeCentimos'] <=> $b['importeCentimos']) !== 0)
                ? ($a['importeCentimos'] <=> $b['importeCentimos'])
                : ($a['id'] <=> $b['id'])
        );

        return $resultado;
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
