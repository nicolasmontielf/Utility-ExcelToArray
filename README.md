## ExcelToArray
#### Descripción
Convierte un archivo en Excel a un array de PHP.

#### A tener en cuenta.
El Excel no debe contener espacios al comienzo de la fila ni de la columna. En la primera fila, deben ir los nombres de los campos, este nombre, será la key de cada elemento del array, así que como convención, mantener todo en minúsculas y separados por guiones bajos. Ejemplo: Precio del producto -> **precio_producto**

#### Pasos para utilizar
1. Instalar composer con `composer install`.
2. Para evitar problemas con permisos, crear dos carpetas vacías en el root del producto:
    - excel: Donde se almacenarán los excels a convertir.
    - result: Donde se guardarán los txt generados.
  
3. Abrir un shell y correr `php index.php`.
