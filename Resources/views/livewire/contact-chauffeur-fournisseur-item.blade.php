<tr>
<div >
    <td class="py-4 text-sm text-center cursor-pointer">
        {{ $fournisseur->formatName ?? ''}}
    </td>
    <td class="py-4 whitespace-nowrap text-sm text-center">
{{--        @dd($contact)--}}
        #{{ $contact->devi->ref ?? ''}}
    </td>
    <td class="py-4 whitespace-nowrap text-sm text-center">
        {{ $contact->phone ?? ''}}
    </td>
    <td class="whitespace-nowrap text-sm text-right">
        <span>
            <button wire:click="removeContact()" title="delete">
                @icon('delete', null, 'mr-1')
            </button>
            <button wire:click="sencContactChauffeur()" title="envoyer le contact chauffeur">
                @icon('mail', null, 'mr-2')
            </button>
        </span>
    </td>
</div>

</tr>
