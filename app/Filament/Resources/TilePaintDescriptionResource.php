<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TilePaintDescriptionResource\Pages;
use App\Models\TilePaintDescription;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TilePaintDescriptionResource extends Resource
{
    protected static ?string $model = TilePaintDescription::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('tile_paint_id')
                    ->relationship('tilePaint', 'name')
                    ->required(),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('min')
                    ->required()
                    ->numeric(),
                TextInput::make('max')
                    ->required()
                    ->numeric(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->postfix('Ft.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tilePaint.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('min')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('price')
                    ->money('HUF')
                    ->sortable(),
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
            'index' => Pages\ListTilePaintDescriptions::route('/'),
            'create' => Pages\CreateTilePaintDescription::route('/create'),
            'view' => Pages\ViewTilePaintDescription::route('/{record}'),
            'edit' => Pages\EditTilePaintDescription::route('/{record}/edit'),
        ];
    }
}
