<?php

namespace App\Providers;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // TextInput::configureUsing(function (TextInput $textInput) {
        //     $textInput->inlineLabel();
        // });

        // Radio::configureUsing(function (Radio $radio) {
        //     $radio->inlineLabel();
        // });

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['id','en', 'fr']); // also accepts a closure
        });
    }
}
