<div class="container mx-auto">
    <div class="grid grid-cols-1 gap-6 p-6 bg-white rounded-lg shadow-md sm:grid-cols-2">
        <div class="flex flex-col space-y-4">
            <form wire:submit="submit" class="w-full space-y-4">
                {{ $this->form }}
            </form>

            <div class="flex space-x-4">
                @if ($this->data['area'] !== null)
                    <button type="button" class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600"
                        wire:click="downloadPdf">{{ __('Anyaglista nyomtatása') }}
                    </button>
                    <button type="button" class="px-4 py-2 text-white bg-gold-500 rounded hover:bg-gold-600"
                        wire:click="sendOnlyToSelf">{{ __('Elküldöm E-mailben') }}
                    </button>
                @endif
                {{--  @if ($this->data['region'] !== null && $this->data['area'] !== null)
                    <button type="submit" wire:click="submit"
                        class="px-4 py-2 text-white bg-rose-500 rounded hover:bg-rose-600">{{ __('filament-actions::modal.actions.submit.label') }}
                        az üzletnek
                    </button>
                @endif --}}
            </div>
        </div>

        @isset($selectedPaintDescription)
            <div class="space-y-4 description" x-data x-init="$el.querySelectorAll('a').forEach(a => { a.setAttribute('target', '_blank'); a.setAttribute('rel', 'noopener noreferrer'); })">

                {{-- Anyaglista - mindig látható --}}
                <div class="p-6 bg-gray-100 rounded-lg">
                    <h2 class="mb-4 text-lg font-semibold">
                        {{ $selectedPaintDescription->min }} - {{ $selectedPaintDescription->max }} m2 felületre az alább
                        felsorolt anyagokat szükséges megvásárolni
                    </h2>
                    <div class="prose prose-sm max-w-none">{!! $selectedPaintDescription->description !!}</div>
                </div>

                @isset($selectedTilePaint)
                    {{-- Inspirációs videó - mindig látható --}}
                    @if($selectedTilePaint->inspiration_video)
                        <div class="p-6 bg-gray-100 rounded-lg">
                            <h3 class="mb-3 text-lg font-semibold">Inspirációs videó</h3>
                            <div class="prose prose-sm max-w-none">{!! $selectedTilePaint->inspiration_video !!}</div>
                        </div>
                    @endif

                    {{-- Kivitelezés röviden - mindig látható --}}
                    @if($selectedTilePaint->brief_implementation)
                        <div class="p-6 bg-gray-100 rounded-lg">
                            <h3 class="mb-3 text-lg font-semibold">Kivitelezés röviden</h3>
                            <div class="prose prose-sm max-w-none">{!! $selectedTilePaint->brief_implementation !!}</div>
                        </div>
                    @endif

                    {{-- Hol vásárolható meg - mindig látható --}}
                    @if($selectedTilePaint->where_to_buy)
                        <div class="p-6 bg-gray-100 rounded-lg">
                            <h3 class="mb-3 text-lg font-semibold">Hol vásárolható meg</h3>
                            <div class="prose prose-sm max-w-none">{!! $selectedTilePaint->where_to_buy !!}</div>
                        </div>
                    @endif

                    {{-- Részletes kivitelezési útmutató - LENYÍLÓ --}}
                    @if($selectedTilePaint->paint_order)
                        <div x-data="{ open: false }" class="bg-gray-100 rounded-lg overflow-hidden">
                            <button
                                x-on:click="open = !open"
                                class="flex items-center justify-between w-full p-6 text-left hover:bg-gray-200 transition-colors"
                            >
                                <h3 class="text-lg font-semibold">Részletes kivitelezési útmutató</h3>
                                <svg
                                    class="w-5 h-5 text-gray-500 transition-transform duration-200"
                                    x-bind:class="{ 'rotate-180': open }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-collapse>
                                <div class="px-6 pb-6 prose prose-sm max-w-none">{!! $selectedTilePaint->paint_order !!}</div>
                            </div>
                        </div>
                    @endif

                    {{-- Fontos tudnivalók - LENYÍLÓ --}}
                    @if($selectedTilePaint->important_info)
                        <div x-data="{ open: false }" class="bg-gray-100 rounded-lg overflow-hidden">
                            <button
                                x-on:click="open = !open"
                                class="flex items-center justify-between w-full p-6 text-left hover:bg-gray-200 transition-colors"
                            >
                                <h3 class="text-lg font-semibold">Fontos tudnivalók</h3>
                                <svg
                                    class="w-5 h-5 text-gray-500 transition-transform duration-200"
                                    x-bind:class="{ 'rotate-180': open }"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-collapse>
                                <div class="px-6 pb-6 prose prose-sm max-w-none">{!! $selectedTilePaint->important_info !!}</div>
                            </div>
                        </div>
                    @endif

                    {{-- Szakértői segítség - mindig látható, NEM lenyíló --}}
                    @if($selectedTilePaint->expert_help)
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
