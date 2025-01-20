<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Models\Salary;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\IsDeleteScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    //
                    Select::make('department_id')
                        ->label('Department')
                        ->relationship('department', 'name')
                        ->required(),

                    Select::make('role_id')
                        ->label('Role')
                        ->relationship('role', 'name')
                        ->required(),

                    TextInput::make('basic_salary')
                        ->label('Basic Salary')
                        ->placeholder('Input Basic Salary')
                        ->required()
                        ->reactive() // Agar responsif terhadap perubahan
                        ->afterStateUpdated(fn ($state, callable $set) => $set('basic_salary', 'Rp '.preg_replace('/[^0-9]/', '', $state))),

                    TextInput::make('meal_allowances')
                        ->label('Meal Allowances')
                        ->placeholder('Input Meal Allowances')
                        ->required()
                        // ->integer()
                        ->reactive() // Agar responsif terhadap perubahan
                        ->afterStateUpdated(fn ($state, callable $set) => $set('meal_allowances', 'Rp '.preg_replace('/[^0-9]/', '', $state))
                        ),

                    TextInput::make('transport_allowances')
                        ->label('Transport Allowances')
                        ->placeholder('Input Transport Allowances')
                        ->required()
                        ->reactive() // Agar responsif terhadap perubahan
                        ->afterStateUpdated(fn ($state, callable $set) => $set('transport_allowances', 'Rp '.preg_replace('/[^0-9]/', '', $state))),

                    TextInput::make('position_allowances')
                        ->label('Position Allowances')
                        ->placeholder('Input Position Allowances')
                        ->required()
                        ->reactive() // Agar responsif terhadap perubahan
                        ->afterStateUpdated(fn ($state, callable $set) => $set('position_allowances', 'Rp '.preg_replace('/[^0-9]/', '', $state))),

                    Toggle::make('is_active')
                        ->label('Is Active?')
                        ->required()
                        ->default(true)
                        ->columnSpan(2),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn () => self::$model::query()->withoutGlobalScope(IsDeleteScope::class)->withoutGlobalScope(ActiveScope::class))
            ->columns([
                TextColumn::make('role.name')
                    ->sortable()
                    ->searchable()
                    ->label('Role'),
                TextColumn::make('department.name')
                    ->sortable()
                    ->searchable()
                    ->label('Departement'),
                TextColumn::make('basic_salary')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->searchable()
                    ->label('Basic Salary'),
                TextColumn::make('meal_allowances')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->label('Meal Allowances'),
                TextColumn::make('position_allowances')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->searchable()
                    ->label('Position Allowances'),
                TextColumn::make('transport_allowances')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->searchable()
                    ->label('Transport Allowances'),
                BooleanColumn::make('is_active')
                    ->label('Active'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->dateTime('d M Y, H:i'),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable()
                    ->dateTime('d M Y, H:i'),
                TextColumn::make('deleted_at')
                    ->label('Deleted At')
                    ->dateTime('d M Y, H:i') // Tampilkan "-" jika null
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        true => 'Active',
                        false => 'Inactive',
                    ]),
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('restore')
                    ->label('Restore')
                    ->icon('heroicon-s-arrow-path')
                    ->action(function ($record) {
                        $record->restore(); // Restore the soft-deleted record
                    })
                    ->visible(fn ($record) => $record->trashed()), // Only show if the record is trashed

            ])
            ->bulkActions([

                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => true]); // Set is_active to true for selected records
                            }
                        })
                        ->icon('heroicon-s-check'),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['is_active' => false]); // Set is_active to false for selected records
                            }
                        })
                        ->icon('heroicon-s-x-circle'),
                    Tables\Actions\DeleteBulkAction::make(),

                ]),

            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListSalaries::route('/'),
            // 'create' => Pages\CreateSalary::route('/create'),
            // 'edit' => Pages\EditSalary::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
