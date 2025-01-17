<?php

namespace App\Filament\Resources\EmployeTypeResource\Pages;

use App\Filament\Resources\EmployeTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeType extends EditRecord
{
    protected static string $resource = EmployeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
