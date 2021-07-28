<?php


abstract class Creator
{

    abstract public function factoryMethod(): Produkt;

    public function create()
    {
        $produkt = $this->factoryMethod();
        return $produkt;
    }
}


class CreatorProduktSpozywczy extends Creator
{

    public function factoryMethod(): Produkt
    {
        return new ProduktSpozywczy();
    }
}

class CreatorProduktArtykulyHigieniczne extends Creator
{

    public function factoryMethod(): Produkt
    {
        return new ProduktArtykulyHigieniczne();
    }
}

class CreatorProduktWyrobyMedyczne extends Creator
{

    public function factoryMethod(): Produkt
    {
        return new ProduktWyrobyMedyczne();
    }
}

class CreatorProduktPrzyprawy extends Creator
{

    public function factoryMethod(): Produkt
    {
        return new ProduktPrzyprawy();
    }
}


abstract class Produkt
{
    public $nazwaProduktu;
    public $cenaJednostkowa;

    public $ilosc;
    public $wartoscNetto;
    public $wartoscVat;
    public $wartoscBrutto;



    

    public function ustawNazwe($nazwa){
        $this->nazwaProduktu = $nazwa;  
    }

    public function ustawJednostkeMiary($nazwa){
        $this->jednostkaMiary = $nazwa;  
    }

    public function ustawCeneJednostkowa($cena){
        $this->cenaJednostkowa = $cena;  
    }

    public function ustawIlosc($ilosc){
        $this->ilosc = $ilosc;
    }

    public function obliczCeny(){
        $this->wartoscNetto = $this->cenaJednostkowa*$this->ilosc;
        $this->wartoscBrutto = $this->wartoscNetto*(1+($this->vat/100));
        $this->wartoscVat = $this->wartoscBrutto-$this->wartoscNetto;

    }

}


class ProduktSpozywczy extends Produkt
{
    public $vat = 5; //przykladowy parametr rozny w klasach
    public $jednostkaMiary = "szt.";
}

class ProduktArtykulyHigieniczne extends Produkt
{
    public $vat = 5; //przykladowy parametr rozny w klasach
    public $jednostkaMiary = "szt.";
}

class ProduktWyrobyMedyczne extends Produkt
{
    public $vat = 8; //przykladowy parametr rozny w klasach
    public $jednostkaMiary = "szt.";
}

class ProduktPrzyprawy extends Produkt
{
    public $vat = 8; //przykladowy parametr rozny w klasach
    public $jednostkaMiary = "szt.";
}


function create(Creator $creator)
{
    return $creator->create();
}

?>