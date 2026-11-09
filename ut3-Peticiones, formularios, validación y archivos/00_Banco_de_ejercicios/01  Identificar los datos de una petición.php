<?php
$datosGet = ['q' => 'Dune'];
$metodoGet = 'GET';
$datosUrlPost = ['id' => '3'];
$datosPost = ['titulo' => 'Solaris'];

// Analiza la petición GET /libros.php?q=Dune. Escribe qué claves y valores contiene $_GET y qué valor tiene $_SERVER["REQUEST_METHOD"].
// Después analiza una petición POST a /libro-editar.php?id=3 cuyo cuerpo contiene titulo=Solaris. Indica dónde recibe PHP el identificador 
// y dónde recibe el título. Explica por qué una petición POST también puede llevar parámetros en la URL.


// $_GET recibe la clave q con el valor Dune,
// $_SERVER["REQUEST_METHOD"] recibe el GET

// $_GET["id"] = "3" El identificador recibido que se encuentra en la URL tras la interrogación.

// $_POST["titulo"] = "Solaris" es el título recibido en el cuerpo que se encontraría en en la base de datos.

// $_SERVER["REQUEST_METHOD"] aquí sería "POST". El método POST también puede llevar parámetros en la URL porque
// la URL puede contener información adicional que no se envía en el cuerpo de la solicitud.