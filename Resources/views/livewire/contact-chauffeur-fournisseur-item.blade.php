<tr>
    <td class="py-4 text-sm text-center">
        {{ $fournisseur->formatName }}
    </td>
    <td class="py-4 whitespace-nowrap text-sm text-center">
        {{ $contact->name }}
    </td>
    <td class="py-4 whitespace-nowrap text-sm text-center">
        {{ $contact->phone }}
    </td>
    <td class="whitespace-nowrap text-sm text-right">
        <span>
            <button wire:click="removeContact()">
                @icon('delete', null, 'mr-2')
            </button>
        </span>
    </td>
</tr>
