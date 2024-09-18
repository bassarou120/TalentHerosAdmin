<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampagneResource\Pages;
use App\Filament\Resources\CampagneResource\RelationManagers;
use App\Models\Adherant;
use App\Models\Campagne;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CampagneResource extends Resource
{
    protected static ?string $model = Campagne::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->columnSpan('full')
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



                    ]) ->default('EN COURS'),
//                Forms\Components\TextInput::make('visibilite')
//                    ->required()
//                    ->maxLength(255),

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
            'index' => Pages\ListCampagnes::route('/'),
            'create' => Pages\CreateCampagne::route('/create'),
            'view' => Pages\ViewCampagne::route('/{record}'),
            'edit' => Pages\EditCampagne::route('/{record}/edit'),
        ];
    }
}
