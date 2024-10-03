<?php

namespace App\Filament\Widgets;

use App\Models\Adherant;
use App\Models\Campagne;
use App\Models\Paiement;
use App\Models\Participation;
use App\Models\RoleCommune;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class Stats extends BaseWidget
{
    protected function getStats(): array
    {

        $user = Auth::user();
        $currentYear = Carbon::now()->year;
        return [

            Stat::make('Utilisateurs', User::query()->where('role','=',"user")->count())
                ->description("Nombre d'Utilisateurs ")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Campagne en Cours', Campagne::query()->where('status','=',"EN COURS")->count())
                ->description('Nombre de campagne en cours')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make('Campagne en Cours', Campagne::query()->where('status','!=',"EN COURS")->count())
                ->description('Nombre de campagne en cours')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),

      Stat::make('Nombre Publication', Participation::query()->count())
                ->description('Nombre Publication')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

     Stat::make('Publications Gagnantes', Participation::query()->where('status','=',"GAGNANTE")->count())
                ->description('Publications Gagnantes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('secondary'),

    Stat::make('Publications non Gagnantes', Participation::query()->where('status','!=',"GAGNANTE")->count())
                ->description('Publications non Gagnantes')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),


//
//            Stat::make('Total de payements cette Année', Paiement::query()
//                    ->whereYear('created_at', $currentYear)
//                    ->sum('montant')."FCFA"),
//            Stat::make('Employees', Employee::query()->count())
//                ->description('All employees from the database')
//                ->descriptionIcon('heroicon-m-arrow-trending-up')
//                ->color('success'),
        ];

    }
}
