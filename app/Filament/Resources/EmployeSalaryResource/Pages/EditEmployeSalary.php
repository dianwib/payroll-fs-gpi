<?php

namespace App\Filament\Resources\EmployeSalaryResource\Pages;

use App\Filament\Resources\EmployeSalaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeSalary extends EditRecord
{
    protected static string $resource = EmployeSalaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
