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

    function __construct(){
        $this->reader = IOFactory::createReader('Xlsx');
        $this->spreadsheet = $this->reader->load('./Excel/FAQS.xlsx');
        $this->worksheet = $this->spreadsheet->getActiveSheet();
        $this->nb = 2;
    }
    
    function Buscar(){
        $busqueda = $_POST['sugerencia'];
        if (!empty($busqueda)) {
        foreach ($this->worksheet->getRowIterator() as $row) {
    
            if (stristr($this->worksheet->getCell("A$this->nb")->getValue(),$busqueda)) {
                echo "<div class='preg'>".$this->worksheet->getCell("A$this->nb")->getValue();
                echo "<div class='respuesta'>".$this->worksheet->getCell("B$this->nb")->getValue()."</div>";
                echo "</div>";
            }
            
            $this->nb++;
        }
    }else{
        $this->CargarPreguntas();
    }
    }

    function CargarPreguntas(){
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
    $objClase->CargarPreguntas();
}

?>