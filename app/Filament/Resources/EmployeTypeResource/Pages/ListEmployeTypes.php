<?php

namespace App\Filament\Resources\EmployeTypeResource\Pages;

use App\Filament\Resources\EmployeTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeTypes extends ListRecords
{
    protected static string $resource = EmployeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
