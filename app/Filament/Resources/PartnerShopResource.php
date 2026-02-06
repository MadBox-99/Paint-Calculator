<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Exports\PartnerShopExporter;
use App\Filament\Imports\PartnerShopImporter;
use App\Filament\Resources\PartnerShopResource\Pages;
use App\Models\PartnerShop;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PartnerShopResource extends Resource
{
    protected static ?string $model = PartnerShop::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('region_id')
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
                TextColumn::make('region.name')
                    ->sortable(),
                TextColumn::make('company_name')
                    ->label('Név')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Cég név')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->headerActions([
                ImportAction::make()->importer(PartnerShopImporter::class),
                ExportAction::make()->exporter(PartnerShopExporter::class),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
