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
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class CalculateForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?TilePaintDescription $selectedPaintDescription = null;

    public ?TilePaint $selectedTilePaint = null;

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('selectedPaintCategory')
                    ->required()
                    ->options(PaintCategory::all()->pluck('name', 'id'))
                    ->label('Válaszd ki, hogy milyen munkát szeretnél elvégezni')
                    ->placeholder('Válassz ki egy kategóriát')
                    ->validationMessages([
                        'required' => 'A festés típusának kiválasztása kötelező',
                    ])
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                        $set('selectedPaint', null);
                        $set('area', null);
                        $this->selectedTilePaint = null;
                        $this->selectedPaintDescription = null;
                    })
                    ->live(),
                Radio::make('selectedPaint')
                    ->required()
                    ->options(fn (Get $get) => $get('selectedPaintCategory') ? PaintCategory::find($get('selectedPaintCategory'))->paints()->get()->pluck('name', 'id') : [])
                    ->descriptions(fn (Get $get) => $get('selectedPaintCategory') ? PaintCategory::find($get('selectedPaintCategory'))->paints()->get()->pluck('description', 'id')->map(fn ($desc) => new HtmlString($desc)) : [])
                    ->visible(fn (Get $get) => $get('selectedPaintCategory'))
                    ->label('Válaszd ki, a számodra megfelelő csomagot')
                    ->validationMessages([
                        'required' => 'A festék csomag kiválasztása kötelező',
                    ])
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                        $this->selectedTilePaint = TilePaint::find($get('selectedPaint'));
                        $set('area', null);
                    }),
                TextInput::make('area')
                    ->numeric()
                    ->required()
                    ->label('Írd be a festés felületének területét (m2)')
                    ->visible(fn (Get $get) => $get('selectedPaint'))
                    ->live()
                    ->validationMessages([
                        'required' => 'A festés felületének területének megadása kötelező',
                        'numeric' => 'A festés felületének területét számokkal kell megadni',
                    ])
                    ->afterStateUpdated(function (Get $get, ?string $state) {
                        if (! $state) {
                            $this->selectedPaintDescription = null;

                            return;
                        }
                        $this->selectedPaintDescription = TilePaintDescription::where('tile_paint_id', $get('selectedPaint'))
                            ->where('min', '<=', $state)->where('max', '>=', $state)->first();
                        $this->selectedTilePaint = TilePaint::find($get('selectedPaint'));
                    }),
                TextInput::make('email')->validationAttribute('email')
                    ->email()
                    ->required()
                    ->validationMessages([
                        'required' => 'Az email cím megadása kötelező',
                    ])
                    ->label('Amennyiben E-mailben szeretnéd elküldeni magadnak a listát, írd be az E-mail címed')
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

    public function submit(): void
    {
        try {
            $data = $this->form->getState();
            $data['selectedPaintDescription'] = TilePaintDescription::find($data['selectedPaint']);
            $data['selectedPaintCategory'] = PaintCategory::find($data['selectedPaintCategory']);
            $data['tilePaint'] = TilePaint::find($data['selectedPaint']);

            if (isset($data['region']) && $data['region']) {
                $data['region'] = Region::find($data['region']);
                $data['store'] = $data['region']?->stores()->find($data['store'] ?? null);
            } else {
                unset($data['region']);
                unset($data['store']);
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
        $data['selectedPaintDescription'] = TilePaintDescription::find($data['selectedPaint']);
        $data['selectedPaintCategory'] = PaintCategory::find($data['selectedPaintCategory']);
        $data['tilePaint'] = TilePaint::find($data['selectedPaint']);

        if (isset($data['region']) && $data['region']) {
            $data['region'] = Region::find($data['region']);
            $data['store'] = $data['region']?->stores()->find($data['store'] ?? null);
        } else {
            unset($data['region']);
            unset($data['store']);
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
