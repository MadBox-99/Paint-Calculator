<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TilePaintResource\Pages;
use App\Models\TilePaint;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TilePaintResource extends Resource
{
    protected static ?string $model = TilePaint::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('paint_category_id')
                    ->relationship('paintCategory', 'name')
                    ->required(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('name'),
                RichEditor::make('description')
                    ->columnSpanFull(),
                RichEditor::make('paint_order')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paintCategory.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
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
            'index' => Pages\ListTilePaints::route('/'),
            'create' => Pages\CreateTilePaint::route('/create'),
            'view' => Pages\ViewTilePaint::route('/{record}'),
            'edit' => Pages\EditTilePaint::route('/{record}/edit'),
        ];
    }
}
