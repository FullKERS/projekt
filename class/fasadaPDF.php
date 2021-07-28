<?php
require_once __DIR__ . '/../vendor/autoload.php';


class Facade
{
    public $subsystemMPDF;



    public function __construct() {
        $this->subsystemMPDF = new subsystemMPDF();
    }


}


class subsystemMPDF
{

    public $mpdf;

    public function __construct()
    {
        $this->mpdf = new \Mpdf\Mpdf();   
    }

    public function generuj($html)
    {

        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
    }

}
