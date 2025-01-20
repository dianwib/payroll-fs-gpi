<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeResource\Pages;
use App\Models\Employe;
use App\Models\Scopes\ActiveScope;
use App\Models\Scopes\IsDeleteScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
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

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    // Grup menu
    protected static ?string $navigationGroup = 'Employe';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Card::make([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Employe')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Employe Name')
                                    ->placeholder('Input Employe Name')
                                    ->minLength(2)
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),

                                Select::make('employe_type_id')
                                    ->label('Employe Type')
                                    ->relationship('employeType', 'name')
                                    ->required(),

                                Select::make('department_id')
                                    ->label('Department')
                                    ->relationship('department', 'name')
                                    ->required(),

                                DatePicker::make('join_date')
                                    ->required()
                                    ->label('Join Date')
                                    ->placeholder('Select join date'),

                                Select::make('gender')
                                    ->required()
                                    ->label('Gender')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                    ])
                                    ->placeholder('Select Gender'),

                                Toggle::make('is_active')
                                    ->label('Is Active?')
                                    ->required()
                                    ->default(true)
                                    ->columnSpan(2),
                            ]),
                        Tab::make('Job Experiences')
                            ->schema([
                                Repeater::make('jobHistories')
                                    ->relationship('jobHistories')
                                    ->schema([
                                        TextInput::make('vendor_name')
                                            ->required(),

                                        TextInput::make('job_title')
                                            ->required(),
                                        DatePicker::make('start_date')
                                            ->required(),
                                        DatePicker::make('end_date')
                                            ->required(),
                                        Textarea::make('remarks')
                                            ->columnSpan(2),
                                    ])
                                    ->columns(2)
                                    ->createItemButtonLabel('Add Experience')
                                    ->deletable(),
                            ]),

                            Tab::make('License Experiences')
                            ->schema([
                                Repeater::make('licenseHistories')
                                    ->relationship('licenseHistories')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required(),
                                        DatePicker::make('start_date')
                                            ->required(),
                                        DatePicker::make('end_date')
                                            ->required(),
                                        Textarea::make('remarks')
                                            ->columnSpan(2),
                                    ])
                                    ->columns(2)
                                    ->createItemButtonLabel('Add License')
                                    ->deletable(),
                            ]),

                            Tab::make('Certificate Histories')
                            ->schema([
                                Repeater::make('certificateHistories')
                                    ->relationship('certificateHistories')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required(),
                                        DatePicker::make('start_date')
                                            ->required(),
                                        DatePicker::make('end_date')
                                            ->required(),
                                        Textarea::make('remarks')
                                            ->columnSpan(2),
                                    ])
                                    ->columns(2)
                                    ->createItemButtonLabel('Add Certificate')
                                    ->deletable(),
                            ]),
                    ]),
                ]),


                // TextInput::make('name')
                //     ->label('Employe Name')
                //     ->placeholder('Input Employe Name')
                //     ->minLength(2)
                //     ->required()
                //     ->maxLength(255)
                //     ->columnSpan(2),

                // Select::make('employe_type_id')
                //     ->label('Employe Type')
                //     ->relationship('employeType', 'name')
                //     ->required(),

                // Select::make('department_id')
                //     ->label('Department')
                //     ->relationship('department', 'name')
                //     ->required(),

                // DatePicker::make('join_date')
                //     ->required()
                //     ->label('Join Date')
                //     ->placeholder('Select join date'),

                // Select::make('gender')
                //     ->required()
                //     ->label('Gender')
                //     ->options([
                //         'male' => 'Male',
                //         'female' => 'Female',
                //     ])
                //     ->placeholder('Select Gender'),

                // Toggle::make('is_active')
                //     ->label('Is Active?')
                //     ->required()
                //     ->default(true)
                //     ->columnSpan(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(fn () => self::$model::query()->withoutGlobalScope(IsDeleteScope::class)->withoutGlobalScope(ActiveScope::class))
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('department.name')
                    ->sortable()
                    ->searchable()
                    ->label('Departement'),
                TextColumn::make('employeType.name')
                    ->sortable()
                    ->searchable()
                    ->label('Type'),
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
            'index' => Pages\ListEmployes::route('/'),
            'create' => Pages\CreateEmploye::route('/create'),
            'edit' => Pages\EditEmploye::route('/{record}/edit'),
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
