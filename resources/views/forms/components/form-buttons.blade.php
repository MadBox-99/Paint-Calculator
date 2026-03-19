@isset($this->selectedPaintDescription)
    <button
        type="button"
        class="w-full px-4 py-3 text-white bg-rose-500 rounded hover:bg-rose-600 sm:hidden"
        onclick="document.getElementById('paint-details').scrollIntoView({ behavior: 'smooth' })"
    >
        Részletek megtekintése
    </button>
@endisset
