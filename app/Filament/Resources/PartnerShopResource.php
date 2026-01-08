<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Exports\PartnerShopExporter;
use App\Filament\Imports\PartnerShopImporter;
use App\Filament\Resources\PartnerShopResource\Pages;
use App\Models\PartnerShop;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;

class PartnerShopResource extends Resource
{
    protected static ?string $model = PartnerShop::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('region_id')
                    ->relationship('region', 'name')
                    ->preload()
                    ->nullable()
                    ->createOptionForm([
                        TextInput::make('name')->label('Region Name')->required(),
                    ]),
                TextInput::make('company_name')->label('Név'),
                TextInput::make('name')->label('Cég név'),
                TextInput::make('address'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('email')
                    ->email(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('region.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->label('Név')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Cég név')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

            ])->headerActions([
                ImportAction::make()->importer(PartnerShopImporter::class),
                ExportAction::make()->exporter(PartnerShopExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartnerShops::route('/'),
            'create' => Pages\CreatePartnerShop::route('/create'),
            'view' => Pages\ViewPartnerShop::route('/{record}'),
            'edit' => Pages\EditPartnerShop::route('/{record}/edit'),
        ];
    }
}
