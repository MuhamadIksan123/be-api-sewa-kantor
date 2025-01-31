<?php

namespace App\Filament\Widgets;

use App\Models\{OfficeSpace, City, ApiKey, BookingTransaction};
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ModelCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Office Spaces', OfficeSpace::count())
                ->icon('heroicon-o-building-office-2'),
            Stat::make('Cities', City::count())
                ->icon('heroicon-o-globe-americas'),
            Stat::make('API Keys', ApiKey::count())
                ->icon('heroicon-o-key'),
            Stat::make('Transaction', BookingTransaction::count())
                ->icon('heroicon-o-rectangle-stack'),
        ];
    }
}
