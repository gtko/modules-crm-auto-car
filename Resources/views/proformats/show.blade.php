<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Facture proformat: {{$proformat->number}}</title>
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
    <style>
        @page {
            size: 1400px 1980px!important;
            /* this affects the margin in the printer settings */
            margin: 0px 0px 0px 0px;
        }
        @media print {
            body, .invoice-content {
                position:relative;
                max-width:100%!important;
                width:100% !important;
                margin:0;
            }
            .container, .row {
                padding: 0px;
                width: 100%!important;
                max-width: 100%!important;
            }
        }
    </style>
</head>
<body>

<div class="invoice-4 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner" id="invoice_wrapper">
                    <div class="invoice-info">
                        <div class="invoice-top">
                            <div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="logo-name">
                                            <div class="info">
                                                <img class='mb-3' src="https://www.centrale-autocars.fr/images/logo-centrale-autocar.png" alt="logo">
                                                <p><a href="mailto:{{$proformat->devis->dossier->commercial->email ?? '--'}}">{{$proformat->devis->dossier->commercial->email ?? '--'}}</a>
                                                <p class="mb-0"><a href="tel:{{$proformat->devis->dossier->commercial->format_phone ?? '--'}}">{{$proformat->devis->dossier->commercial->format_phone ?? '--'}}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="invoice-name text-end">
                                            <h4 class="name color-white inv-header-1">Facture proformat <br>n°{{$proformat->number}}</h4>
                                            <p class="mb-0">Date d'émission: {{$proformat->created_at->format('d/m/Y')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="client-name mb-30">
                                        <div class="info">
                                            <p class="inv-title-1">A l'attention de :</p>
                                            <p class="invo-addr-1">
                                                {{$proformat->devis->dossier->client->format_name}} <br/>
                                                {{$proformat->devis->dossier->client->full_address}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="project-description mb-30 text-end">
                                        <h5 class="inv-title-1">Description</h5>
                                        <p class="mb-0">
                                         Organisation d'un trajet en autocar
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-section clearfix">
                                    <div class="table-responsive">
                                        <table class="table invoice-table">
                                            <thead class="bg-active">
                                            <tr>
                                                <th>Description</th>
                                                <th class="text-center">Qtité</th>
                                                <th class="text-center">Prix</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(($proformat->devis->data['trajets'] ?? []) as $idTrajet => $trajet)
                                                <tr>
                                                    <td>
                                                       <livewire:crmautocar::devis-client.voyage :devis="$proformat->devis" :trajet-id="$idTrajet" :brand="$brand" :proformat='true'/>
                                                    </td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-center text-nowrap">@marge($price->getPriceHT())€</td>
                                                    <td class="text-right text-nowrap">@marge($price->getPriceHT())€</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-end">Montant total (HT)</td>
                                                <td class="text-right text-nowrap">@marge($price->getPriceHT())€</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end">TVA 10 %</td>
                                                <td class="text-right text-nowrap">@marge($price->getPriceTVA())</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold">Montant Total (TTC)</td>
                                                <td class="text-right fw-bold text-nowrap">@marge($price->getPriceTTC())</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end">Déjà Réglé</td>
                                                <td class="text-right text-nowrap">@marge($price->paid())€</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end">Reste à Régler</td>
                                                <td class="text-right text-nowrap">@marge($price->remains())€</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center ic2">
                            <div class="d-flex justify-content-between">
                                <div class="">
                                    <div class="payment-info text-start mb-30" style="max-width:600px;">
                                        <h3 class="inv-title-1">Conditions de règlement :</h3>
                                        <p class="mb-0">
                                            Pour rappel la validation en ligne implique une acceptation totale <br>
                                            de nos conditions générales de ventes et donc des conditions d'annulations ci dessous:
                                        </p>
                                        <ul class="mb-0 important-notes-list-1">
                                            <li>30 % du prix du service si l’annulation intervient à plus de 30 jours avant le départ</li>
                                            <li>50 % du prix du service si l’annulation intervient entre 30 et 14 jours avant le départ</li>
                                            <li>70 % du prix du service si l’annulation intervient entre 13 et 7 jours avant le départ</li>
                                            <li>100 % du prix du service si l’annulation intervient moins de 7 jours avant le départ.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="mb-30 ">
                                        <h3 class="inv-title-1">Modalités de règlement :</h3>
                                        <ul class="mb-0 important-notes-list-1">
                                            <li> Par carte bancaire ou par virement bancaire</li>
                                            <li><strong>Rib:</strong>FR76 3000 4015 9600 0101 0820 195</li>
                                            <li><strong>BIC:</strong>BNPAFRPPXXX</li>
                                            <li>
                                                <p class="mb-0">
                                                    30% à la réservation<br>
                                                    Le solde 45 jours avant votre départ
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
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
                </div>
                <div class="invoice-btn-section clearfix d-print-none">
                    <a href="javascript:window.print()" class="btn btn-lg btn-print">
                        <i class="fa fa-print"></i> Imprimer la proformat
                    </a>
                    <a id="invoice_download_btn" class="btn btn-lg btn-download" href="{{route('proformats.pdf', $proformat->id)}}">
                        <i class="fa fa-download"></i> Télécharger la proformat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice 4 end -->

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jspdf.min.js"></script>
<script src="assets/js/html2canvas.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
