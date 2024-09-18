<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisibilitePaysResource\Pages;
use App\Filament\Resources\VisibilitePaysResource\RelationManagers;
use App\Models\VisibilitePays;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisibilitePaysResource extends Resource
{
    protected static ?string $model = VisibilitePays::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('campagne_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pay_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('campagne_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pay_id')
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
            'index' => Pages\ListVisibilitePays::route('/'),
            'create' => Pages\CreateVisibilitePays::route('/create'),
            'view' => Pages\ViewVisibilitePays::route('/{record}'),
            'edit' => Pages\EditVisibilitePays::route('/{record}/edit'),
        ];
    }
}
