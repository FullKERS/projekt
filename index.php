<?php 

require_once __DIR__ . '/vendor/autoload.php';



    include("call.php");

    if(!isset($_SESSION['aktualnaFaktura']) || $_SESSION['aktualnaFaktura'] == null ){
        $_SESSION['aktualnaFaktura'] = new faktura();
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Projekt - generowanie faktur</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css?v=1" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                
                <div class="sidebar-brand-text mx-3">Faktury</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Strona główna</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Faktury
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="call.php?kasuj=1">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Utworz nową</span></a>
            </li>








            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Nowa faktura</h1>

                    </div>
                    

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Nowa pozycja</button>
                    <a href="call.php?kasuj=1" class="btn btn-primary">KASUJ</a>

                    <a href="call.php?generuj=1" class="btn btn-primary" target="_blank">PDF</a>

                    <p style="margin-top:1em;"> </p>

                    <!-- Modal -->
                    <div  class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form  action="call.php" method="POST">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h3>Produkt</h3>
                                    
                                        <input type="hidden" value="nowyProduktDoFaktury" name="typ_formularza"/>
                                        <select name="wybranyProdukt">
                                            <?php 
                                                foreach($mysqlAdapter->pobierzProdukty() as $produkt){
                                                    echo "<option value='".$produkt['idProduktu']."'>".$produkt['nazwa']."</option>";    

                                                }                                        
                                                
                                                ?>
                                        </select>
                                        
                                        <h3 style="margin-top:1em;">Ilość</h3>
                                        <input type="number" value="1" name="ilosc"/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                                    <button type="submit" class="btn btn-primary">Wyślij</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <!-- Content Row -->
                    <?php if(!is_array($_SESSION['aktualnaFaktura']->pobierzListeProduktow())): ?>
                        <h3 style="color:red; text-align:center;">BRAK PRODUKTÓW NA FAKTURZE</h3>
                    <?php else: ?>
                    <div class="row">

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
                                    <th scope="col"></th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                foreach($_SESSION['aktualnaFaktura']->pobierzListeProduktow() as $p):?>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><?=$p->nazwaProduktu ?></td>
                                    <td><?=$p->jednostkaMiary ?></td>
                                    <td><?=$p->ilosc ?></td>
                                    <td><?=gr2zl($p->cenaJednostkowa) ?></td>
                                    <td><?=$p->vat ?></td>
                                    <td><?=gr2zl($p->wartoscNetto) ?></td>
                                    <td><?=gr2zl($p->wartoscVat) ?></td>
                                    <td><?=gr2zl($p->wartoscBrutto) ?></td>
                                    <td>-</td>

                                </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>




                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Krzysztof Stanek - w57129 - WSIZ</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>