<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TilePaintDescriptionResource\Pages;
use App\Models\TilePaintDescription;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TilePaintDescriptionResource extends Resource
{
    protected static ?string $model = TilePaintDescription::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('tile_paint_id')
                    ->relationship('tilePaint', 'name')
                    ->required(),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('min')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('max')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->postfix('Ft.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tilePaint.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('min')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('HUF')
                    ->sortable(),
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
            'index' => Pages\ListTilePaintDescriptions::route('/'),
            'create' => Pages\CreateTilePaintDescription::route('/create'),
            'view' => Pages\ViewTilePaintDescription::route('/{record}'),
            'edit' => Pages\EditTilePaintDescription::route('/{record}/edit'),
        ];
    }
}
