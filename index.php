<?php
require 'vendor/autoload.php';
$slugify = new \Cocur\Slugify\Slugify();

// Todo para mostrar en el shell
$directorio = "./excel";
$directorioEscaneado = scandir($directorio);
$directorioFiltrado = array_values(
    array_filter($directorioEscaneado, function ($val) {
        if (!is_dir($val) && $val != ".gitignore") {
            return $val;
        }
    })
);

echo "Actuales archivos excel: " . PHP_EOL;
foreach ($directorioFiltrado as $index => $filtrado) {
    $num = $index + 1;
    echo "{$num}- {$filtrado}" . PHP_EOL;
}

$input = readline("Seleccione un archivo: ");
echo PHP_EOL . "Se está procesando el excel" . PHP_EOL;

$archivo = (explode(".", $directorioFiltrado[($input-1)]))[0];

// Toda la parte de creación de excel
try {
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load("{$directorio}/{$archivo}.xlsx");
    $worksheet  = $spreadsheet->getActiveSheet();

    $isHeader = true; // contador de filas
    $headers = array(); // Array que va a contener los headers
    $arr = array(); // Array master

    // Foreach que recorre las filas
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE);

        $index = 0;
        $aux = [];

        // Foreach que recorre cada celda de esta fila
        foreach ($cellIterator as $cell) {
            // Si el contador está , es el header, lo guardamos en el array
            if ($isHeader) {
                array_push($headers, $cell->getValue());
            } else {
                $aux[$headers[$index]] = $cell->getValue();
            }
            $index++;
        }

        if (!$isHeader) {
            array_push($arr, $aux);
        }
        
        $isHeader = false;
    }

    // Cargamos el texto
    $texto = "";
    foreach ($arr as $fila) {
        $texto .= "[" . PHP_EOL;
        foreach ($fila as $index => $cell) {
            $texto .= "\t '{$index}' => '{$cell}', " . PHP_EOL;
        }
        $texto .= "]," . PHP_EOL;
    }

    // Guardamos en un text
    $nombreTxt = $slugify->slugify($archivo);
    $txt = fopen("./result/{$nombreTxt}.txt", "w");
    fwrite($txt, $texto);

    echo "Se ha finalizado el proceso..." . PHP_EOL;
    exit;
} catch (\Exception $e) {
    echo "Ha ocurrido un error" . PHP_EOL;
    echo $e->getMessage();
}