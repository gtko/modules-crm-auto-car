<div class="{{$class}} mb-4">
    <div class="flex justify-between items-start mt-4">
        <label class="inline-flex items-center pr-2">
            <input type="checkbox" wire:model="accepte" class="form-checkbox h-6 w-6 bg-gray-200">
        </label>
        <span>J'ai lu et j'accepte les Conditions Générales de Vente. Je m'engage à payer 30 % à la réservation, le solde 45 jours avant votre départ et à transférer ce montant sur le compte mentionné sur la facture.</span>
    </div>
    <span class="btn btn-danger-soft mt-4 w-full text-white text-2xl" style="background-color: #ffa500;" wire:click="open()">
                Réserver le Trajet en Autocar
            </span>
    @error('accepte') <span class="text-red-600 py-2">{{ $message }}</span> @enderror
</div>
