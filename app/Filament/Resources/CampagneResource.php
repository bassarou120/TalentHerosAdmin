<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampagneResource\Pages;
use App\Filament\Resources\CampagneResource\RelationManagers;
use App\Models\Adherant;
use App\Models\Campagne;
use App\Models\Pays;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
class CampagneResource extends Resource
{
    protected static ?string $model = Campagne::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort=1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('date_debut')
                    ->required(),
                Forms\Components\DatePicker::make('date_fin')
                    ->required(),

                FileUpload::make('image')
//                    ->columnSpan('full')
//                    ->directory('/adherant_photo_id')
                    ->fetchFileInformation(false)
                    ->directory(function ($record) {
                        $lastid= Campagne::latest()->first();
                        $lid= $lastid? $lastid->id+1: 1;

                        return '/campagne_image/' . ($record ? $record->id : $lid);
                    })
                    ->required(),

//                Forms\Components\FileUpload::make('image')
//                    ->image(),


                Forms\Components\Select::make('visibilite')
                    ->label('Visibilité')
                    ->options([
                        'TOUT LE MONDE' => 'TOUT LE MONDE',
                        "GROUPE D'ABONNES"=> "GROUPE D'ABONNES",
                        "ABONNES PAYS"=> "ABONNES PAYS",
                        "HOMME"=> "HOMME",
                        "FEMME"=> "FEMME",

                    ]) ->default('EN COURS')
                    ->reactive(),

                // Display additional form when visibilite is "GROUPE D'ABONNES"
                Forms\Components\Select::make('abonnes')
                    ->label('Sélectionner les abonnés')
                    ->multiple() // Allow selecting multiple abonnees
                    ->options(User::all()->pluck('name', 'id')) // Assuming `User` is the model for abonnees
                    ->visible(fn (callable $get) => $get('visibilite') === "GROUPE D'ABONNES") // Show only if visibilite is "GROUPE D'ABONNES"
                     ->required(),

                // Display additional form when visibilite is "GROUPE D'ABONNES"
                Forms\Components\Select::make('pays')
                    ->label('Sélectionner les abonnés')
                    ->multiple() // Allow selecting multiple abonnees
                    ->options(Pays::all()->pluck('nom', 'id')) // Assuming `pays` is the model for abonnees
                    ->visible(fn (callable $get) => $get('visibilite') === "ABONNES PAYS") // Show only if visibilite is "GROUPE D'ABONNES"
                    ->required(),


                Forms\Components\Select::make('status')
                    ->label('status')
                    ->options([
                        'EN COURS' => 'EN COURS',
                        'Clôturée' => 'Clôturée',
                    ]) ->default('EN COURS'),




//                Forms\Components\TextInput::make('status')
//                    ->required()
//                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn ::make('image')
                    ->label("Carte")
                    ->defaultImageUrl(url('/images/logo.png'))
                    ->width(90)
                    ->height(90)
                ,
                Tables\Columns\TextColumn::make('titre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_debut')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_fin')
                    ->date()
                    ->sortable(),
//                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('visibilite')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
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
            'index' => Pages\ListCampagnes::route('/'),
            'create' => Pages\CreateCampagne::route('/create'),
            'view' => Pages\ViewCampagne::route('/{record}'),
            'edit' => Pages\EditCampagne::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return  $infolist
            ->schema([
                Section::make('Infos Campagne 1')
                    ->schema([
                        TextEntry::make('titre'),
                        TextEntry::make('date_debut'),
                        TextEntry::make('date_fin'),
                        TextEntry::make( 'visibilite'   ),

                    ])->columns(4),

                Section::make('Infos Campagne 2')
                    ->schema([
                        TextEntry::make('description'),
                    ])->columns(1),
                Section::make('Infos Campagne 2')
                    ->schema([
                        ImageEntry::make('image'),
                    ])->columns(1),
            ]);
    }



}
