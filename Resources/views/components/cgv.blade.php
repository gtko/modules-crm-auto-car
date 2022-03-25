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

            .break{
                page-break-after: always;
            }

            .break-margin-top{
                margin-top:50px;
            }
        }
    </style>
        @include('crmautocar::cgl')
@endsection
