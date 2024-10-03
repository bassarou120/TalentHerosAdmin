<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Support\Carbon;

class UserResource extends Resource
{
    protected static ?string $model = User::class;



//    protected static ?string $navigationGroup = 'Gestion des Utilisateurs';

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel="Utilisateurs";
    protected static ?int $navigationSort=4 ;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telephone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('photo')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sexe')
                    ->maxLength(255),
                Forms\Components\TextInput::make('adresse')
                    ->maxLength(255),
                Forms\Components\TextInput::make('role')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pay_id')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->circular()

                    ->defaultImageUrl(url('/images/placeholder.png')),
//                Tables\Columns\TextColumn::make('photo')
//                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label("Nom")
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label("Prenom")
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label("Rôle")
                    ->searchable(),
                Tables\Columns\TextColumn::make('pay.nom')
                    ->label("Pays")

                    ->sortable(),

                Tables\Columns\TextColumn::make('sexe')
                    ->searchable(),


                Tables\Columns\TextColumn::make('adresse')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
                Tables\Filters\SelectFilter::make("pays")
                    ->preload()
                    ->searchable()
                    ->relationship('pay','nom'),

                Tables\Filters\SelectFilter::make("sexe")
                    ->options([

                        "HOMME" => "HOMME",
                        'FEMME' => 'FEMME',

                    ])
                    ->preload()
                ,
                Filter::make('created_at')
                    ->label("Periode")
                    ->form([
                        DatePicker::make('created_from')->label('Date debut'),
                        DatePicker::make('created_until')->label('Date fin'),
                    ])
                    ->query(function (\Illuminate\Contracts\Database\Eloquent\Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Date debut ' . Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Date fin ' . Carbon::parse($data['created_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    })->columnSpan(2)->columns(2),


            ],layout:FiltersLayout:: AboveContentCollapsible)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
