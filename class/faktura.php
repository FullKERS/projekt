<?php

class faktura
{
    protected $listaProduktow;

    public function dodajProdukt($produkt)
    {
        $this->listaProduktow[] = $produkt;
    }

    public function pobierzListeProduktow()
    {
        return $this->listaProduktow;
    }

    public function zwrocHTML()
    {

        $html = '
        <!DOCTYPE html>
        <html lang="en">

        <head>



            <!-- Custom fonts for this template-->
            <style>
                td, th{
                    border:1px solid black;
                }
            </style>


        </head>
        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">LP</th>
                                    <th scope="col">Nazwa usługi / towaru</th>
                                    <th scope="col">Jm</th>
                                    <th scope="col">Ilość</th>
                                    <th scope="col">Cena netto</th>
                                    <th scope="col">VAT</th>
                                    <th scope="col">Wartość netto</th>
                                    <th scope="col">Wartość VAT</th>
                                    <th scope="col">Wartość brutto</th>


                                </tr>
                            </thead>
                            <tbody>
                               ';

        foreach ($_SESSION['aktualnaFaktura']->pobierzListeProduktow() as $p) {
            $html .= '
                                    <tr>
                                    <th scope="row">1</th>
                                    <td>' . $p->nazwaProduktu . '</td>
                                    <td>' . $p->jednostkaMiary . '</td>
                                    <td>' . $p->ilosc . '</td>
                                    <td>' . gr2zl($p->cenaJednostkowa) . '</td>
                                    <td>' . $p->vat . '</td>
                                    <td>' . gr2zl($p->wartoscNetto) . '</td>
                                    <td>' . gr2zl($p->wartoscVat) . '</td>
                                    <td>' . gr2zl($p->wartoscBrutto) . '</td>


                                </tr>';
        }

        $html .= '

                            </tbody>
                        </table>

        ';

        return $html;

    }




}