@extends('basecore::layout.main')

@section('content')

    <livewire:crmautocar::validation-information-voyage :devis="$devis"/>

@endsection
