<x-layouts.app>
    @vite(['resources/css/form.css'])
    <x-slot name="title">Megoldásválasztó & Anyagkalkulátor</x-slot>
    <div class="text-center w-4/5 mx-auto">
        <p class="mb-4">
            Válaszd ki a problémádhoz illő megoldást, add meg a felület méretét,<br>
            mi pedig megmutatjuk:
        </p>
        <ul class="inline-block text-left mb-4">
            <li>· milyen anyagokra lesz szükséged</li>
            <li>· milyen rétegrenddel érdemes dolgoznod</li>
            <li>· és hogyan csináld lépésről lépésre</li>
        </ul>
        <p class="text-sm text-gray-600">
            💡 Az árakat nem itt számoljuk.<br>
            A pontos árakat a kiszámolt bevásárlólista alapján a festékboltban vagy az online vásárlási ponton kapod meg.
        </p>
    </div>

    @livewire('calculate-form')

</x-layouts.app>
