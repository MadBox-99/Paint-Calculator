<div class="container mx-auto">
    <div class="grid grid-cols-1 gap-6 p-6 bg-white rounded-lg shadow-md sm:grid-cols-2">
        <div class="flex flex-col space-y-4">
            <form wire:submit="submit" class="w-full space-y-4">
                {{ $this->form }}
            </form>

            @if (
                $this->data['area'] !== null &&
                    $this->data['area'] !== '' &&
                    ((float) $this->data['area'] < 3 || (float) $this->data['area'] > 102))
                <div class="p-4 text-sm text-amber-800 bg-amber-50 border border-amber-200 rounded-lg">
                    <p class="font-semibold">A kalkulátor 3–102 m² közötti felületre készít számítást.</p>
                    <p>Kérjük, adj meg legalább 3 m²-t a kalkulációhoz.</p>
                    <p class="mt-2">Nagyobb projekt esetén vedd fel velünk a kapcsolatot, kollégáink készséggel
                        segítenek:</p>
                    <p>📞 <a href="tel:+36706237610" class="underline hover:text-amber-900">+36 70 623 7610</a></p>
                    <p>✉️ <a href="mailto:info@harzo.hu" class="underline hover:text-amber-900">info@harzo.hu</a></p>
                </div>
            @endif

            @if ($this->data['area'] !== null)
                <div class="flex flex-col gap-2 sm:flex-row sm:gap-4">
                    <button type="button"
                        class="w-full px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600 sm:w-auto"
                        wire:click="downloadPdf">{{ __('Anyaglista nyomtatása') }}
                    </button>
                    <button type="button"
                        class="w-full px-4 py-2 text-white bg-gold-500 rounded hover:bg-gold-600 sm:w-auto"
                        wire:click="sendOnlyToSelf">{{ __('Elküldöm E-mailben') }}
                    </button>
                </div>
            @endif
        </div>

        @isset($selectedPaintDescription)
            <div id="paint-details" class="space-y-4 description" x-data x-init="$el.querySelectorAll('a').forEach(a => { a.setAttribute('target', '_blank');
                a.setAttribute('rel', 'noopener noreferrer'); })">

                {{-- Anyaglista - mindig látható --}}
                <div class="p-6 bg-gray-100 rounded-lg">
                    <h2 class="mb-4 text-lg font-semibold">
                        {{ $selectedPaintDescription->min }} - {{ $selectedPaintDescription->max }} m2 felületre az alább
                        felsorolt anyagokat szükséges megvásárolni
                    </h2>
                    <div class="prose prose-sm max-w-none">{!! $selectedPaintDescription->description !!}</div>
                </div>

                @isset($selectedTilePaint)
                    {{-- Mobil képgaléria - csak mobilon látható --}}
                    @if (!empty($selectedTilePaint->images) || $selectedTilePaint->inspiration_video)
                        <div class="sm:hidden space-y-0 rounded-lg overflow-hidden">
                            <div class="bg-[#CC0000] px-6 py-3">
                                <h3 class="text-lg font-semibold text-white">Felületek és részletek</h3>
                            </div>

                            @if (!empty($selectedTilePaint->images))
                                <div class="p-4 bg-gray-100" x-data>
                                    <div class="flex items-center gap-2 mb-2">
                                        <i class="fa-solid fa-camera text-gray-500"></i>
                                        <span class="text-sm text-gray-600">Képek a felület részleteiről</span>
                                    </div>
                                    @php
                                        $galleryImages = collect($selectedTilePaint->images)
                                            ->map(fn(string $path) => asset('storage/' . $path))
                                            ->values()
                                            ->toArray();
                                    @endphp
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach ($galleryImages as $index => $imageUrl)
                                            <img src="{{ $imageUrl }}"
                                                alt="{{ $selectedTilePaint->name }} - {{ $index + 1 }}"
                                                class="w-full h-20 object-cover rounded cursor-pointer border border-gray-200 hover:border-rose-400 transition"
                                                onclick="event.stopPropagation(); window.dispatchEvent(new CustomEvent('open-lightbox', { detail: { images: {{ Js::from($galleryImages) }}, index: {{ $index }} } }))" />
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($selectedTilePaint->inspiration_video)
                                <a href="#video-section"
                                    class="flex items-center gap-2 p-4 bg-gray-100 border-t border-gray-200 hover:bg-gray-200 transition-colors">
                                    <i class="fa-solid fa-video text-gray-500"></i>
                                    <span class="text-sm text-gray-600">Nézd meg a kész felületet</span>
                                </a>
                            @endif
                        </div>
                    @endif

                    {{-- Videó szekció --}}
                    @if ($selectedTilePaint->inspiration_video)
                        <div id="video-section" class="p-6 bg-[#CC0000] rounded-lg text-white">
                            <h3 class="mb-3 text-lg font-semibold">Nézd meg a kész felületet</h3>
                            <div class="prose prose-sm prose-invert max-w-none">{!! $selectedTilePaint->inspiration_video !!}</div>
                        </div>
                    @endif

                    {{-- Kivitelezés röviden - mindig látható --}}
                    @if ($selectedTilePaint->brief_implementation)
                        <div class="p-6 bg-gray-100 rounded-lg">
                            <h3 class="mb-3 text-lg font-semibold">Kivitelezés röviden</h3>
                            <div class="prose prose-sm max-w-none">{!! $selectedTilePaint->brief_implementation !!}</div>
                        </div>
                    @endif

                    {{-- Hol vásárolható meg - mindig látható --}}
                    @if ($selectedTilePaint->where_to_buy)
                        <div class="p-6 bg-gray-100 rounded-lg">
                            <h3 class="mb-3 text-lg font-semibold">Hol vásárolható meg</h3>
                            <div class="prose prose-sm max-w-none">{!! $selectedTilePaint->where_to_buy !!}</div>
                        </div>
                    @endif

                    {{-- Részletes kivitelezési útmutató - LENYÍLÓ --}}
                    @if ($selectedTilePaint->paint_order)
                        <div x-data="{ open: false }" class="bg-gray-100 rounded-lg overflow-hidden">
                            <button x-on:click="open = !open"
                                class="flex items-center justify-between w-full p-6 text-left hover:bg-gray-200 transition-colors">
                                <h3 class="text-lg font-semibold">Részletes kivitelezési útmutató</h3>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200"
                                    x-bind:class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-collapse>
                                <div class="px-6 pb-6 prose prose-sm max-w-none">{!! $selectedTilePaint->paint_order !!}</div>
                            </div>
                        </div>
                    @endif

                    {{-- Fontos tudnivalók - LENYÍLÓ --}}
                    @if ($selectedTilePaint->important_info)
                        <div x-data="{ open: false }" class="bg-gray-100 rounded-lg overflow-hidden">
                            <button x-on:click="open = !open"
                                class="flex items-center justify-between w-full p-6 text-left hover:bg-gray-200 transition-colors">
                                <h3 class="text-lg font-semibold">Fontos tudnivalók</h3>
                                <svg class="w-5 h-5 text-gray-500 transition-transform duration-200"
                                    x-bind:class="{ 'rotate-180': open }" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-collapse>
                                <div class="px-6 pb-6 prose prose-sm max-w-none">{!! $selectedTilePaint->important_info !!}</div>
                            </div>
                        </div>
                    @endif

                    {{-- Szakértői segítség - mindig látható, NEM lenyíló --}}
                    @if ($selectedTilePaint->expert_help)
                        <div class="p-6 bg-gray-100 rounded-lg">
                            <h3 class="mb-3 text-lg font-semibold">Szakértői segítség</h3>
                            <div class="prose prose-sm max-w-none">{!! $selectedTilePaint->expert_help !!}</div>
                        </div>
                    @endif
                @endisset
            </div>
        @endisset

        <x-filament-actions::modals />
    </div>

    <x-lightbox />
</div>
