<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Mail\CalculationFormSendToAdmin;
use App\Mail\CalculationFormSendToUser;
use App\Models\PaintCategory;
use App\Models\Region;
use App\Models\TilePaint;
use App\Models\TilePaintDescription;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\View as FilamentView;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Url;
use Livewire\Component;

class CalculateForm extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ?array $data = [];

    public ?TilePaintDescription $selectedPaintDescription = null;

    public ?TilePaint $selectedTilePaint = null;

    #[Url(as: 'kategoria')]
    public ?string $urlCategory = null;

    #[Url(as: 'csomag')]
    public ?string $urlPaint = null;

    #[Url(as: 'terulet')]
    public ?string $urlArea = null;

    #[Url(as: 'nev')]
    public ?string $urlName = null;

    #[Url(as: 'email')]
    public ?string $urlEmail = null;

    public function mount(): void
    {
        if ($this->urlCategory && ! PaintCategory::active()->where('id', $this->urlCategory)->exists()) {
            $this->urlCategory = null;
            $this->urlPaint = null;
        }

        $this->form->fill(array_filter([
            'area' => $this->urlArea,
            'selectedPaintCategory' => $this->urlCategory,
            'selectedPaint' => $this->urlPaint,
            'selectedPaintMobile' => $this->urlPaint,
            'full_name' => $this->urlName,
            'email' => $this->urlEmail,
        ]));

        if ($this->urlPaint) {
            $this->handlePaintSelection($this->urlPaint);
        }
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('area')
                    ->numeric()
                    ->required()
                    ->label('Írd be a festés felületének területét (m2)')
                    ->live()
                    ->afterStateUpdated(function (?string $state) {
                        $this->urlArea = $state;
                        $this->handlePaintSelection($this->data['selectedPaint'] ?? null);
                    })
                    ->validationMessages([
                        'required' => 'A festés felületének területének megadása kötelező',
                        'numeric' => 'A festés felületének területét számokkal kell megadni',
                    ]),
                Select::make('selectedPaintCategory')
                    ->required()
                    ->options(PaintCategory::active()->pluck('name', 'id'))
                    ->label('Válaszd ki, hogy milyen munkát szeretnél elvégezni')
                    ->placeholder('Válassz ki egy kategóriát')
                    ->validationMessages([
                        'required' => 'A festés típusának kiválasztása kötelező',
                    ])
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('selectedPaint', null);
                        $set('selectedPaintMobile', null);
                        $this->urlCategory = $state;
                        $this->urlPaint = null;
                        $this->selectedPaintDescription = null;
                        $this->selectedTilePaint = null;
                    })
                    ->live(),
                Select::make('selectedPaintMobile')
                    ->options(fn (Get $get) => $get('selectedPaintCategory')
                        ? TilePaint::query()->where('paint_category_id', $get('selectedPaintCategory'))->pluck('name', 'id')
                        : [])
                    ->visible(fn (Get $get) => $get('selectedPaintCategory'))
                    ->label('Válaszd ki, a számodra megfelelő csomagot')
                    ->placeholder('Válassz egy csomagot')
                    ->extraFieldWrapperAttributes(['class' => 'sm:hidden'])
                    ->dehydrated(false)
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('selectedPaint', $state);
                        $this->urlPaint = $state;
                        $this->handlePaintSelection($state);
                    }),
                Radio::make('selectedPaint')
                    ->required()
                    ->options(fn (Get $get) => $get('selectedPaintCategory')
                        ? TilePaint::query()->where('paint_category_id', $get('selectedPaintCategory'))->pluck('name', 'id')
                        : [])
                    ->descriptions(fn (Get $get) => $this->getPaintDescriptions($get))
                    ->visible(fn (Get $get) => $get('selectedPaintCategory'))
                    ->label('Válaszd ki, a számodra megfelelő csomagot')
                    ->validationMessages([
                        'required' => 'A festék csomag kiválasztása kötelező',
                    ])
                    ->extraFieldWrapperAttributes(['class' => 'hidden sm:block'])
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $set('selectedPaintMobile', $state);
                        $this->urlPaint = $state;
                        $this->handlePaintSelection($state);
                    }),

                FilamentView::make('forms.components.form-buttons')
                    ->visible(fn (Get $get) => $get('selectedPaint')),

                TextInput::make('email')
                    ->validationAttribute('email')
                    ->email()
                    ->required()
                    ->validationMessages([
                        'required' => 'Az email cím megadása kötelező',
                    ])
                    ->label('Amennyiben E-mailben szeretnéd elküldeni magadnak a listát, írd be az E-mail címed')
                    ->helperText('Kérlek ellenőrizd a Levélszemét/Spam mappádat, mert előfordulhat, hogy az üzenetünk oda kerül!')
                    ->visible(fn (Get $get) => $get('area'))
                    ->live(),
                TextInput::make('full_name')->validationAttribute('full_name')
                    ->required()
                    ->label('Kérlek, írd be a neved, minimum a keresztneved')
                    ->validationMessages([
                        'required' => 'A név megadása kötelező',
                    ])
                    ->visible(fn (Get $get) => $get('area'))
                    ->live(),
                /*  Select::make('region')->visible(fn (Get $get) => $get('area'))
                    ->label('Válaszd ki a települést, ahol vásárolni szeretnél')
                    ->options(Region::all()->pluck('name', 'id'))
                    ->live(),
                Select::make('store')->visible(fn (Get $get) => $get('region'))
                    ->options(fn (Get $get) => $get('region') ? Region::find($get('region'))->stores()->get()->pluck('name', 'id') : [])
                    ->label('Válaszd ki a festékboltot')
                    ->live(), */
            ])
            ->statePath('data');
    }

    private function handlePaintSelection(?string $paintId): void
    {
        if (! $paintId) {
            $this->selectedPaintDescription = null;
            $this->selectedTilePaint = null;

            return;
        }

        $area = (float) ($this->data['area'] ?? 0);

        $this->selectedPaintDescription = TilePaintDescription::where('tile_paint_id', $paintId)
            ->where('min', '<=', $area)
            ->where('max', '>=', $area)
            ->first();

        $this->selectedTilePaint = $this->selectedPaintDescription
            ? TilePaint::find($paintId)
            : null;
    }

    /**
     * @return array<int, HtmlString>
     */
    private function getPaintDescriptions(Get $get): array
    {
        if (! $get('selectedPaintCategory')) {
            return [];
        }

        $paints = TilePaint::query()->where('paint_category_id', $get('selectedPaintCategory'))->get();

        return $paints->mapWithKeys(function (TilePaint $paint) {
            $html = $paint->description ?? '';

            if (! empty($paint->images)) {
                $imageUrls = collect($paint->images)
                    ->map(fn (string $path): string => asset('storage/' . $path))
                    ->values()
                    ->toArray();

                $firstImage = $imageUrls[0];
                $jsonImages = htmlspecialchars(json_encode($imageUrls), ENT_QUOTES, 'UTF-8');

                $html .= '<div class="mt-2">'
                    . '<p class="text-xs text-gray-500 mb-1">Kattints a képre a nagyításhoz</p>'
                    . '<img src="' . $firstImage . '" alt="' . e($paint->name) . '"'
                    . ' class="w-20 h-20 object-cover rounded cursor-pointer border border-gray-200 hover:border-rose-400 transition"'
                    . ' onclick="event.stopPropagation(); window.dispatchEvent(new CustomEvent(\'open-lightbox\', { detail: { images: JSON.parse(this.dataset.images), index: 0 } }))"'
                    . ' data-images="' . $jsonImages . '"'
                    . ' />'
                    . '</div>';
            }

            return [$paint->id => new HtmlString($html)];
        })->toArray();
    }

    public function submit(): void
    {
        try {
            $data = $this->form->getState();
            $area = (float) ($data['area'] ?? 0);
            $data['selectedPaintDescription'] = TilePaintDescription::query()
                ->where('tile_paint_id', $data['selectedPaint'])
                ->where('min', '<=', $area)
                ->where('max', '>=', $area)
                ->first();
            $data['selectedPaintCategory'] = PaintCategory::find($data['selectedPaintCategory']);
            $data['tilePaint'] = TilePaint::find($data['selectedPaint']);

            /** @var Region|null $region */
            $region = isset($data['region']) ? Region::query()->find($data['region']) : null;

            if ($region) {
                $data['region'] = $region;
                $data['store'] = $region->stores()->find($data['store'] ?? null);
            } else {
                unset($data['region'], $data['store']);
            }
            // Generate PDF
            $pdf = PDF::loadView('pdf.calculation', ['data' => $data]);
            $pdfPath = storage_path('app/public/calculation.pdf');
            $pdf->save($pdfPath);

            // Email the data to admin, 2 others and form email to the user
            Mail::to($data['email'])->send(new CalculationFormSendToUser($data, $pdfPath));
            // üzlet
            if (isset($data['region']) && isset($data['store'])) {
                Mail::to($data['store']->email)->send(new CalculationFormSendToUser($data, $pdfPath));
            }
            // admin
            Mail::to(env('HARZO_ADMIN_EMAIL'))->send(new CalculationFormSendToAdmin($data, $pdfPath));
        } catch (\Exception $e) {
            // Handle the exception (e.g., log the error, show an error message)
            session()->flash('error', 'There was an error processing your request. Please try again later.');
        }

        redirect()->to('/siker');
    }

    public function sendOnlyToSelf(): void
    {
        $data = $this->form->getState();
        $area = (float) ($data['area'] ?? 0);
        $data['selectedPaintDescription'] = TilePaintDescription::query()
            ->where('tile_paint_id', $data['selectedPaint'])
            ->where('min', '<=', $area)
            ->where('max', '>=', $area)
            ->first();
        $data['selectedPaintCategory'] = PaintCategory::find($data['selectedPaintCategory']);
        $data['tilePaint'] = TilePaint::find($data['selectedPaint']);

        /** @var Region|null $region */
        $region = isset($data['region']) ? Region::query()->find($data['region']) : null;

        if ($region) {
            $data['region'] = $region;
            $data['store'] = $region->stores()->find($data['store'] ?? null);
        } else {
            unset($data['region'], $data['store']);
        }

        // Generate PDF
        $pdf = PDF::loadView('pdf.calculation', ['data' => $data]);
        $pdfPath = storage_path('app/public/calculation.pdf');
        $pdf->save($pdfPath);

        // Email the data to admin, 2 others and form email to the user
        Mail::to($data['email'])->send(new CalculationFormSendToUser($data, $pdfPath));

        redirect()->to('/siker');
    }

    public function downloadPdf()
    {
        $data = [
            'selectedPaintDescription' => $this->selectedPaintDescription,
            'selectedPaintCategory' => PaintCategory::find($this->data['selectedPaintCategory']),
            'tilePaint' => $this->selectedTilePaint,
            'area' => $this->data['area'],
            'full_name' => $this->data['full_name'] ?? '',
            'email' => $this->data['email'] ?? '',
        ];

        $pdf = PDF::loadView('pdf.calculation', ['data' => $data]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'kalkulacio.pdf');
    }

    public function render(): View
    {
        return view('livewire.calculate-form');
    }
}
