<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipationResource\Pages;
use App\Filament\Resources\ParticipationResource\RelationManagers;
use App\Models\Participation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;



class ParticipationResource extends Resource
{
    protected static ?string $model = Participation::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?int $navigationSort=2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('campagne_id')
                    ->required()

                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('video')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('campagne.titre')
                    ->sortable()
                ,
                Tables\Columns\TextColumn::make('user.name')
                    ->label("Nom")
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.first_name')
                    ->label("Prenom")
                    ->sortable(),
                Tables\Columns\TextColumn::make('video')
                    ->label('Vidéo')
                    ->formatStateUsing(function ($state) {

                        return view('components.video-player', ['url' => env('APP_URL')."/storage/".$state]);
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label("Status"),

                Tables\Columns\TextColumn::make('description')
                    ->label("Description")
                    ->toggleable(isToggledHiddenByDefault: true),
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

                Tables\Filters\SelectFilter::make("campagne")
                    ->preload()
                    ->searchable()
                    ->relationship('campagne','titre'),
                Tables\Filters\SelectFilter::make("status")
                    ->options([

                        "EN COURS D'EXAMEN" => "EN COURS D'EXAMEN",
                        'GAGNANTE' => 'GAGNANTE',
                        'REJETER' => 'REJETER',
                    ])
                    ->preload()

            ]  ,layout:FiltersLayout:: AboveContentCollapsible)
            ->actions([
//                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\Action::make('Accepter')
//                    ->requiresConfirmation()
//                    ->color('success')
            ],position: ActionsPosition::BeforeColumns)
            ->bulkActions([

                Tables\Actions\BulkAction::make('Accepter')
                    ->label('Accepter')
                    ->icon('heroicon-m-check-circle')
                    ->requiresConfirmation()
                    ->color('success')

                    ->openUrlInNewTab()
                    ->deselectRecordsAfterCompletion()
                    ->action(function (\Illuminate\Database\Eloquent\Collection $records) {

                        foreach ($records as $record) {
                            $record->status = "GAGNANTE";
                            $record->save();
                        }
                    }),



                Tables\Actions\BulkAction::make('Rejeter')
                    ->label('Accepter')
                    ->icon('heroicon-m-x-circle')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->openUrlInNewTab()
                    ->deselectRecordsAfterCompletion()
                    ->action(function (\Illuminate\Database\Eloquent\Collection $records) {

                        foreach ($records as $record) {
                            $record->status = "REJETER";
                            $record->save();
                        }
                    }),

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
            'index' => Pages\ListParticipations::route('/'),
            'create' => Pages\CreateParticipation::route('/create'),
            'view' => Pages\ViewParticipation::route('/{record}'),
            'edit' => Pages\EditParticipation::route('/{record}/edit'),
        ];
    }
}
