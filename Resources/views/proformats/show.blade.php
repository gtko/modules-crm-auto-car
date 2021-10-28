<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>INVO - Invoice HTML5 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="/crmautocar/assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href=/crmautocar/assets/fonts/font-awesome/css/font-awesome.min.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href=/crmautocar/assets/img/favicon.ico" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="/crmautocar/assets/css/style.css">
</head>
<body>

<!-- Invoice 3 start -->
<div class="invoice-3 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner">
                    <div class="invoice-info" id="invoice_wrapper">
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice">
                                        <h4 class="inv-header-1 color-white">Facture proformat: {{$proformat->number}}</h4>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-name text-end">
                                        <div class="logo">
                                            <img class="logo" src="https://www.centrale-autocars.fr/images/logo-centrale-autocar.png" alt="logo">
                                        </div>
                                        <p>Cecilia Chapman, 711-2880 Nulla St, Mankato</p>
                                        <p class="mb-0">Mississippi 96522</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="informeshon">
                                        <p class="inv-title-1">Date</p>
                                        <p>Invoice Data: Aug 27, 2020</p>
                                        <p>Due Data: Aug 27, 2020</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="informeshon">
                                        <p class="inv-title-1">Invoice To.</p>
                                        <p class="invo-addr-1">
                                            Theme Vessel <br/>
                                            info@themevessel.com <br/>
                                            21-12 Green Street, Meherpur, Bangladesh <br/>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="informeshon text-end">
                                        <p class="inv-title-1">Bill To.</p>
                                        <p class="invo-addr-1">
                                            Apexo Inc  <br/>
                                            billing@apexo.com <br/>
                                            169 Teroghoria, Bangladesh <br/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="table-section table-responsive clearfix">
                                <table class="table caption-top invoice-table">
                                    <thead class="bg-active">
                                    <tr>
                                        <th>Item Item</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="item-desc-1">
                                                <span>BS-200</span>
                                                <small>Customize web application</small>
                                            </div>
                                        </td>
                                        <td class="text-center">$10.99</td>
                                        <td class="text-center">1</td>
                                        <td class="text-right">$10.99</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="item-desc-1">
                                                <span>BS-201</span>
                                                <small>Website development and customization for themevessel</small>
                                            </div>
                                        </td>
                                        <td class="text-center">$20.00</td>
                                        <td class="text-center">3</td>
                                        <td class="text-right">$60.00</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="item-desc-1">
                                                <span>BS-233</span>
                                                <small>Website SEO improvement of themevessel.com</small>
                                            </div>
                                        </td>
                                        <td class="text-center">$640.00</td>
                                        <td class="text-center">1</td>
                                        <td class="text-right">$640.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">SubTotal</td>
                                        <td class="text-right">$710.99</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Tax</td>
                                        <td class="text-right">$85.99</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Grand Total</td>
                                        <td class="text-right fw-bold">$795.99</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-bottom">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="bank-transfer">
                                        <h3 class="inv-title-1">  Modalités et conditions de règlement :</h3>
                                        <ul class="bank-transfer-list-1">
                                            <li> Par carte bancaire ou par virement bancaire</li>
                                            <li><strong>Rib:</strong>FR76 3000 4015 9600 0101 0820 195</li>
                                            <li><strong>BIC:</strong>BNPAFRPPXXX</li>
                                            <li>
                                                30% à la réservation<br>
                                                Le solde 45 jours avant votre départ
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="amount text-end">
                                        <h3 class="inv-title-1">Total Amount</h3>
                                        <h1>$795.99</h1>
                                        <p class="mb-0">Taxes Included</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <p>Pour rappel la validation en ligne implique une acceptation totale de nos conditions générales de ventes et donc des conditions d'annulations ci dessous:</p>
                                <p>
                                    - 30 % du prix du service si l’annulation intervient à plus de 30 jours avant le départ<br>
                                    - 50 % du prix du service si l’annulation intervient entre 30 et 14 jours avant le départ<br>
                                    - 70 % du prix du service si l’annulation intervient entre 13 et 7 jours avant le départ<br>
                                    - 100 % du prix du service si l’annulation intervient moins de 7 jours avant le départ.<br>
                                </p>
                            </div>

                            <div class="note mt-3">
                                <p class="text-muted text-center">
                                    Centrale Autocar - Société par Actions Simplifiées<br>
                                    N° Siret : 853 867 703 00011 - R.C.S. Paris 853 867 703 - Code APE : 6312Z<br>
                                    57 Rue Clisson 75013 Paris - Tel 01 87 21 14 76<br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> Imprimer
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download">
                            <i class="fa fa-download"></i> Télécharge le PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
