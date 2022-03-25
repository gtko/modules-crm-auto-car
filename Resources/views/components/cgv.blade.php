@extends('basecore::layout.main')

@section('content')

    <style>
        @page {
            size: 1400px 1980px !important;
            /* this affects the margin in the printer settings */
            margin: 0px 0px 0px 0px;
        }

        @media print {
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


    <div class="bg-white border border-2 border-gray-400  lg:mb-6 mb-0 mt-6 p-4 lg:order-5 max-w-7xl mx-auto">

        @include('crmautocar::cgl')
    </div>




{{--    <x-crmautocar::devis-client.footer class="h-32"/>/--}}


@endsection
