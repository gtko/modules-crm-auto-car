@extends('basecore::layout.main')

@section('content')

    <style>
        @page {
            size: 1400px 1980px !important;
            /* this affects the margin in the printer settings */
            margin: 0px 0px 0px 0px;
        }

        @media print {

            .print-col-span-3 {
                grid-column: span 3 / span 3 !important;
            }

            .notcut {
                position: relative;
                break-inside: avoid;
                page-break-inside: avoid;
                -webkit-region-break-inside: avoid;
            }


            body, .invoice-content {
                position: relative;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0;
            }

            .container, .row {
                padding: 0px;
                width: 100% !important;
                max-width: 100% !important;
            }

            .no-print {
                display: none;
            }

        }
    </style>
    <div class="bg-white h-full w-full h-screen flex flex-col justify-between" style="font-family: 'Lato', sans-serif;">
        <div class="max-w-7xl w-full mx-auto pt-32 bg-gray-200 px-8 h-screen">

            <div class="grid grid-cols-3 gap-2">
                <div class="col-start-3 flex-col flex">
                    <span class="font-bold">CENTRALE AUTOCAR</span>
                    <span class="font-bold">Madame GARCIN</span>
                    <span class="uppercase">57 RUE DE CLISSON</span>
                    <span class="uppercase">75013 PARIS</span>
                </div>
            </div>

            <div class="grid-cols-3 grid gap-2">
                <div class="flex flex-col">
                    <span class="mb-4">Devis n° <span class="text-xl font-bold">37070</span></span>
                    <span>Dossier suivi par: Sylvain Maitre</span>
                    <span>Tel: 09 71 07 53 95</span>
                    <span class="text-sm">Mail : contact@louerunbus.fr</span>
                </div>
                <div class="my-auto col-start-3">
                    <span>Paris, le mardi 18 août 2020</span>
                </div>
            </div>

            <div class="flex flex-col mt-12">
                <span class="mb-4">Bonjour NOM DU CLIENT,</span>
                <span>Nous avons le plaisir de vous communiquer nos conditions de prix pour votre projet de voyage <span class="text-xs">(Aller et Retour)</span>:</span>
                <div class="flex-col flex justify-center items-center font mx-auto my-6 font-black text-lg">
                    <span>Le samedi 28 novembre 2020 </span>
                    <span>Pour STRASBOURG</span>
                </div>
                <span>Afin de vous réserver le véhicule nécessaire, nous vous remercions de nous faire connaître votre décision dès que possible en nous retournant ce devis signé à l’adresse ci-dessus.</span>
                <span class="mt-4">Descriptif du Séjour :</span>
            </div>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Odd row -->
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Jane Cooper
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Regional Paradigm Technician
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        jane.cooper@example.com
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Admin
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>

                                <!-- Even row -->
                                <tr class="bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Cody Fisher
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Product Directives Officer
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        cody.fisher@example.com
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Owner
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>

                                <!-- More people... -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
