<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TilePaintResource\Pages;
use App\Models\TilePaint;
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

class TilePaintResource extends Resource
{
    protected static ?string $model = TilePaint::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                TextColumn::make('paintCategory.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('name')
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
            'index' => Pages\ListTilePaints::route('/'),
            'create' => Pages\CreateTilePaint::route('/create'),
            'view' => Pages\ViewTilePaint::route('/{record}'),
            'edit' => Pages\EditTilePaint::route('/{record}/edit'),
        ];
    }
}
