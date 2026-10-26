<?php
namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use App\Modelo\EnvioNormal;
use App\Modelo\EnvioUrgente;
use App\Modelo\EstadoEnvio;
use App\Excepcion\EnvioException;
use App\Repositorio\RepositorioEnviosMemoria;
use App\Servicio\ServicioEnvios;

$envios = [
    new EnvioNormal(101, 'Librería Órbita', 1000, EstadoEnvio::Pendiente),
    new EnvioUrgente(102, 'Taller Norte', 1500, EstadoEnvio::Enviado),
    new EnvioNormal(103, 'Café Álamo', 2500, EstadoEnvio::Entregado),
    new EnvioUrgente(104, 'Estudio Prisma', 500, EstadoEnvio::Cancelado),
    new EnvioNormal(105, 'Papelería Sol', 2000, EstadoEnvio::Pendiente),
    new EnvioUrgente(106, 'Órbita Creativa', 1001, EstadoEnvio::Pendiente),
];

$repositorio = new RepositorioEnviosMemoria();
foreach ($envios as $envio) {
    $repositorio->registrar($envio);
}

$servicio = new ServicioEnvios($repositorio);

$etiquetasIniciales = $servicio->etiquetas($repositorio->todos());
$resumenInicial = $servicio->resumir($repositorio->todos());

?>


<table border="1">

    <thead>
        <tr>
            <th>ID</th>
            <th>Tarifa en céntimos</th>
            <th>Tarifa en Euros</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($envios as $envio): ?>
            <tr>
                <td><?php echo htmlspecialchars($envio->id()); ?></td>
                <td><?php echo htmlspecialchars($envio->tarifa()); ?></td>
                <td><?php echo htmlspecialchars($envio->tarifa()/100); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<br>

<table border="1">

    <thead>
        <tr>
            <th>Filtros en orden</th>
            <th>IDs en el orden esperado</th>
        </tr>
    </thead>

    <tbody>
            <tr>
                <td>Sin filtros</td>
                <td><?php foreach ($servicio->consultar() as $envio) { echo htmlspecialchars((string) $envio->id()) . ' '; } ?></td>
            </tr>

            <tr>
                <td>Texto << ÓRBITA >></td>
                <td><?php foreach ($servicio->consultar('ÓRBITA') as $envio) { echo htmlspecialchars((string) $envio->id()) . ' '; } ?></td>
            </tr>

            <tr>
                <td>Modalidad urgente</td>
                <td><?php foreach ($servicio->consultar('', 'urgente') as $envio) { echo htmlspecialchars((string) $envio->id()) . ' '; } ?></td>
            </tr>

            <tr>
                <td>Estado pendiente</td>
                <td><?php foreach ($servicio->consultar('', null, EstadoEnvio::Pendiente) as $envio) { echo htmlspecialchars((string) $envio->id()) . ' '; } ?></td>
            </tr>

            <tr>
                <td>Texto ÓRBITA, urgente y pendiente</td>
                <td><?php foreach ($servicio->consultar('ÓRBITA', 'urgente', EstadoEnvio::Pendiente) as $envio) { echo htmlspecialchars((string) $envio->id()) . ' '; } ?></td>
            </tr>

            <tr>
                <td>Texto « ÓRBITA CREATIVA »</td>
                <td><?php foreach ($servicio->consultar('ÓRBITA CREATIVA') as $envio) { echo htmlspecialchars((string) $envio->id()) . ' '; } ?></td>
            </tr>

            <tr>
                <td>Texto xyz</td>
                <td><?php foreach ($servicio->consultar('xyz') as $envio) { echo htmlspecialchars((string) $envio->id()) . ' '; } ?></td>
            </tr>

            <tr>
                <td>Sin filtros y orden por peso</td>
                <td><?php foreach ($servicio->consultar('', null, null, 'peso') as $envio) { echo htmlspecialchars((string) $envio->id()) . ' '; } ?></td>
            </tr>
    </tbody>
</table>

<br>

<table border="1">

    <thead>
        <tr>
            <th>Paso</th>
            <th>Operación</th>
            <th>Resultado</th>
        </tr>
    </thead>

    <tbody>
            <tr>
                <td>1</td>
                <td>Enviar 101</td>
                <td><?php try { $servicio->enviar(101); echo htmlspecialchars($repositorio->buscar(101)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>2</td>
                <td>Cancelar 101</td>
                <td><?php try { $servicio->cancelar(101); echo htmlspecialchars($repositorio->buscar(101)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>3</td>
                <td>Entregar 101</td>
                <td><?php try { $servicio->entregar(101); echo htmlspecialchars($repositorio->buscar(101)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>4</td>
                <td>Enviar 101</td>
                <td><?php try { $servicio->enviar(101); echo htmlspecialchars($repositorio->buscar(101)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>5</td>
                <td>Cancelar 105</td>
                <td><?php try { $servicio->cancelar(105); echo htmlspecialchars($repositorio->buscar(105)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>6</td>
                <td>Enviar 105</td>
                <td><?php try { $servicio->enviar(105); echo htmlspecialchars($repositorio->buscar(105)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>7</td>
                <td>Entregar 102</td>
                <td><?php try { $servicio->entregar(102); echo htmlspecialchars($repositorio->buscar(102)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>8</td>
                <td>Cancelar 104</td>
                <td><?php try { $servicio->cancelar(104); echo htmlspecialchars($repositorio->buscar(104)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>9</td>
                <td>Entregar 106</td>
                <td><?php try { $servicio->entregar(106); echo htmlspecialchars($repositorio->buscar(106)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>

            <tr>
                <td>10</td>
                <td>Enviar 999</td>
                <td><?php try { $servicio->enviar(999); echo htmlspecialchars($repositorio->buscar(999)->estado()->value); } catch (EnvioException $e) { echo htmlspecialchars($e->getMessage()); } ?></td>
            </tr>
    </tbody>
</table>