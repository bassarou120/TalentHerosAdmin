<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaysResource\Pages;
use App\Filament\Resources\PaysResource\RelationManagers;
use App\Models\Pays;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaysResource extends Resource
{
    protected static ?string $model = Pays::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('code_iso_alpha2')
                    ->required()
                    ->maxLength(2),
                Forms\Components\TextInput::make('code_iso_alpha3')
                    ->required()
                    ->maxLength(3),
                Forms\Components\TextInput::make('code_iso_num')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code_iso_alpha2')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code_iso_alpha3')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code_iso_num')
                    ->numeric()
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
            'index' => Pages\ListPays::route('/'),
            'create' => Pages\CreatePays::route('/create'),
            'view' => Pages\ViewPays::route('/{record}'),
            'edit' => Pages\EditPays::route('/{record}/edit'),
        ];
    }
}
