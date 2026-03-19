@isset($this->selectedPaintDescription)
    <button
        type="button"
        class="w-full px-4 py-3 text-white bg-rose-500 rounded hover:bg-rose-600 sm:hidden"
        onclick="document.getElementById('paint-details').scrollIntoView({ behavior: 'smooth' })"
    >
        Részletek megtekintése
    </button>
@endisset

@if ($this->data['area'] !== null)
    <div class="flex space-x-4">
        <button type="button" class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600"
            wire:click="downloadPdf">{{ __('Anyaglista nyomtatása') }}
        </button>
        <button type="button" class="px-4 py-2 text-white bg-gold-500 rounded hover:bg-gold-600"
            wire:click="sendOnlyToSelf">{{ __('Elküldöm E-mailben') }}
        </button>
    </div>
@endif
