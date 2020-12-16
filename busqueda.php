<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./PHPSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Busqueda{
    private $reader;
    private $spreadsheet;
    private $worksheet;
    private $nb;
    private $datos;

    function __construct(){
        $this->reader = IOFactory::createReader('Xlsx');
        $this->nb = 2;
    }
    
    function Buscar($nombre = "Cliente.xlsx",$rep = 0){
        $this->nb = 2;
        $encontrado = false;
        $busqueda = $_POST['sugerencia'];
        $datosLocal = "";

        if (!empty($busqueda)) {
            $this->spreadsheet = $this->reader->load('./Excel/'.$nombre.'');
            $this->worksheet = $this->spreadsheet->getActiveSheet();

            foreach ($this->worksheet->getRowIterator() as $row) {
        
                if (stristr($this->worksheet->getCell("A$this->nb")->getValue(),$busqueda)) {
                    $datosLocal .= "<div class='preg'>".$this->worksheet->getCell("A$this->nb")->getValue();
                    $datosLocal .= "<div class='respuesta'>".$this->worksheet->getCell("B$this->nb")->getValue()."</div>";
                    $datosLocal .= "</div>";
                    $encontrado = true;
                }
                
                $this->nb++;
            }

            if ($encontrado) {
                $datosLocal = "<h3>".explode('.',$nombre,2)[0]."</h3>" . $datosLocal;
                $this->datos .= $datosLocal;
            }

            if ($rep == 0) {
                $this->Buscar("Conductor.xlsx",1);
            }else{
                if (!empty($this->datos)) {
                    echo $this->datos;
                }else{
                    echo "No se han encontrado preguntas que coincidan con la busqueda";
                }
            }
        }else{
            $this->CargarPreguntasCliente();
            $this->CargarPreguntasConductor();
        }
    }

    function CargarPreguntasCliente(){
        $this->spreadsheet = $this->reader->load('./Excel/Cliente.xlsx');
        $this->worksheet = $this->spreadsheet->getActiveSheet();
        echo "<h3>Cliente</h3>";
        foreach ($this->worksheet->getRowIterator() as $row) {
            echo "<div class='preg'>".$this->worksheet->getCell("A$this->nb")->getValue();
            echo "<div class='respuesta'>".$this->worksheet->getCell("B$this->nb")->getValue()."</div>";
            echo "</div>";
            $this->nb++;
    }
}

function CargarPreguntasConductor(){
    $this->spreadsheet = $this->reader->load('./Excel/Conductor.xlsx');
    $this->worksheet = $this->spreadsheet->getActiveSheet();
    $this->nb = 2;
    echo "<h3>Conductor</h3>";
    foreach ($this->worksheet->getRowIterator() as $row) {
        echo "<div class='preg'>".$this->worksheet->getCell("A$this->nb")->getValue();
        echo "<div class='respuesta'>".$this->worksheet->getCell("B$this->nb")->getValue()."</div>";
        echo "</div>";
        $this->nb++;
}
}



}

$objClase = new Busqueda();

if (isset($_POST['sugerencia'])) {
    $objClase->Buscar();
}else{
    $objClase->CargarPreguntasCliente();
    $objClase->CargarPreguntasConductor();
}

?>