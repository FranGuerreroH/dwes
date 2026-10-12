- Saber si aparece una palabra: str_contains()
  Justificación: Devuelve un booleano directo y es más expresiva y rápida cuando solo se requiere comprobar existencia.

- Conocer su posición: strpos()
  Justificación: Retorna el índice entero de la primera ocurrencia de la subcadena dentro del texto.

- Comprobar un prefijo: str_starts_with()
  Justificación: Evalúa si la cadena comienza exactamente con la subcadena especificada de forma directa.

- Comprobar un sufijo: str_ends_with()
  Justificación: Evalúa si la cadena finaliza exactamente con la subcadena indicada.

- Validar un formato con patrón: preg_match()
  Justificación: Permite aplicar expresiones regulares para validar estructuras complejas de texto.

- Sustituir espacios repetidos: preg_replace()
  Justificación: Soporta patrones de expresiones regulares como '/\s+/' para reemplazar secuencias repetidas de espacio en blanco.

- Trabajar con texto UTF-8: Funciones 'mb_' (mb_strlen, mb_substr, mb_strtolower, etc.)
  Justificación: Tratan correctamente los caracteres multibyte sin romper secuencias codificadas en UTF-8.