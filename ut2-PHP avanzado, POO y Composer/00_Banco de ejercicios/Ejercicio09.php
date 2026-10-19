<?php 
// Ejercicio 9. array_find_key
// Dado un array asociativo titulo => ejemplares, usa array_find_key para obtener la clave del primer
// libro con 0 ejemplares. Comprueba también qué devuelve cuando ningún valor cumple la condición.

$libros = [
        [
            "id" => 01,
            "titulo" => 
            "Profesores de enseñanza secundaria Geografía e Historia", 
            "autor" => "Autores Varios", 
            "genero" => "Didáctico", 
            "paginas"=> 722, 
            "disponible" => false, 
            "fechaAlta" =>"2021-03-21"
        ],
        [
            "id" => 02,
            "titulo" => "LOVE", 
            "autor" => "Wada Arco", 
            "genero" => "Arte", 
            "paginas"=> 308, 
            "disponible" => true, 
            "fechaAlta" =>"2022-07-28"
        ],
        [
            "id" => 03,
            "titulo" => "El color de la magia", 
            "autor" => "Terry Pratchet", 
            "genero" => "Fantasía", 
            "paginas"=> 288, 
            "disponible" => true, 
            "fechaAlta" =>"2015-10-10"
        ],
        [
            "id" => 04,
            "titulo" => "Bakemonogatari", 
            "autor" => "NISIOISIN", 
            "genero" => "Terror", 
            "paginas"=> 240, 
            "disponible" => true, 
            "fechaAlta" =>"2021-03-21"
        ],
        [
            "id" => 05,
            "titulo" => "The Legend of Zelda Twiligth Princess Vol.11", 
            "autor" => "Akira Himekawa", 
            "genero" => "Fantasía", 
            "paginas"=> 192, 
            "disponible" => true, 
            "fechaAlta" =>"2020-02-22"
        ],
        [
            "id" => 06,
            "titulo" => "Juliano el apóstata", 
            "autor" => "Gore Vidal", 
            "genero" => "Histórico", 
            "paginas"=> 770, 
            "disponible" => false, 
            "fechaAlta" =>"2009-02-02"
        ],
        [
            "id" => 07,
            "titulo" => "La leyenda dorada", 
            "autor" => "Santiago de la Vorágine", 
            "genero" => "Hagiografía", 
            "paginas"=> 504, 
            "disponible" => false, 
            "fechaAlta" =>"2010-09-26"
        ],
        [
            "id" => 8,
            "titulo" => "El puente de la visión", 
            "autor" => "Eugene Delacroix", 
            "genero" => "Didáctico", 
            "paginas"=> 184, 
            "disponible" => false, 
            "fechaAlta" =>"2010-03-29"
        ],
    ];

$libro = array_find_key(
    $libros,
    fn($ejemplares) => $ejemplares === 0
);

if ($libro !== null) {
    echo $libro; // 1984
} else {
    echo 'No encontrado';
}

// Si ningún valor cumple la condición, array_find_key devuelve null.

?>