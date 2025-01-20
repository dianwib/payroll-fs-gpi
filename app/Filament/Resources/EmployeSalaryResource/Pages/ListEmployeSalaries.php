<?php

namespace App\Filament\Resources\EmployeSalaryResource\Pages;

use App\Filament\Resources\EmployeSalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeSalaries extends ListRecords
{
    protected static string $resource = EmployeSalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
