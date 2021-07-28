<?php
require_once __DIR__ . '/vendor/autoload.php';
include("class/db.php");
include("class/fasadaPDF.php");
include("class/faktura.php");
session_start();



$mysqlAdapter = new Adapter();
$fasadaMPDF = new Facade();



function gr2zl($gr){
   $zl = $gr/100; 
   return number_format($zl, 2, ",", " ");
}



function get_current_file_url($Protocol='http://') {
    return "http://localhost/wsiz/wzorce_projektowe/projekt/"; 
 }

function redirect($url){
    header('Location: '.get_current_file_url().$url);
}

if(isset($_POST)){

    if(isset($_POST['typ_formularza'])){

        $typ = $_POST['typ_formularza'];

        if($typ == "nowyProduktDoFaktury"){


            $produktTemp = $mysqlAdapter->pobierzProdukty($_POST['wybranyProdukt']);

            $nazwaKlasy = $produktTemp[0]['class'];
            $produkt =create(new $nazwaKlasy());
            $produkt->ustawNazwe($produktTemp[0]['nazwa']);
            $produkt->ustawCeneJednostkowa($produktTemp[0]['cenaJednostkowa']);
            $produkt->ustawIlosc($_POST['ilosc']);
            $produkt->obliczCeny();


            /*var_dump($produkt);
die();
*/
            $_SESSION['aktualnaFaktura']->dodajProdukt($produkt);


            redirect('index.php');
        }


    }


}




if(isset($_GET)){
    if(isset($_GET['kasuj']) && $_GET['kasuj'] == "1"){
        $_SESSION['aktualnaFaktura'] = new faktura();
        redirect('index.php');
    }


    if(isset($_GET['generuj']) && $_GET['generuj'] == "1" && isset($_SESSION['aktualnaFaktura'])){



        
        $fasadaMPDF->subsystemMPDF->generuj($_SESSION['aktualnaFaktura']->zwrocHTML());



        /*
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML();
        $mpdf->Output();*/
    }

}

?>