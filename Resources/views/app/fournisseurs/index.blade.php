<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Fournisseurs</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <h2 class="text-lg font-medium mt-10">Fournisseurs Centrale Autocar</h2>
        <div class="flex flex-wrap justify-between sm:flex-nowrap items-center mt-2">
            <a href="{{route('fournisseurs.create')}}" class="btn btn-primary shadow-md mr-2">
                @icon('addCircle', null, 'mr-2') Ajouter un fournisseur
            </a>
        </div>
        <div class="overflow-auto lg:overflow-visible mt-8 sm:mt-0">
            <table class="table table-report sm:mt-2">
                <thead>
                <tr>
                    <th class="whitespace-nowrap"></th>
                    <th class="text-center whitespace-nowrap">Company</th>
                    <th class="text-center whitespace-nowrap">Nom</th>
                    <th class="text-center whitespace-nowrap">N° Astreinte</th>
                    <th class="text-center whitespace-nowrap">tags</th>
                    <th class="text-center whitespace-nowrap">Activé</th>
                    <th class="text-center whitespace-nowrap"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($fournisseurs as $fournisseur)
                    <tr>
                        <td class="text-center">
                            #{{$fournisseur->id}}
                        </td>
                        <td class="text-center">
                            {{$fournisseur->company}}
                        </td>
                        <td class="text-center">
                            {{$fournisseur->format_name}}
                        </td>
                        <td class="text-center">
                            {{$fournisseur->astreinte}}
                        </td>
                        <td class="text-center">
                            {{$fournisseur->tagfournisseurs->pluck('name')->implode(', ')}}
                        </td>
                        <td>
                            <livewire:basecore::user-switch :user="$fournisseur"/>
                        </td>
                        <td>
                            <a href="{{route('fournisseurs.edit', $fournisseur)}}">
                                @icon('edit', null, 'mr-2')
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-basecore::layout.panel-full>

</x-basecore::app-layout>
