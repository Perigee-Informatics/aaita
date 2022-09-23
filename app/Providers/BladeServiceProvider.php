<?php
namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Base\Helpers\BladeFunctionHelper;
use ImLiam\BladeHelper\Facades\BladeHelper;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Eng to nepali digit without decimal value
        BladeHelper::directive('englishToNepaliDigits', function($value, $decimalPlaces = 0) {
            return \App\Base\Helpers\BladeFunctionHelper::englishToNepali($value, $decimalPlaces);
        });

         // Eng to nepali digit with decimal value
         BladeHelper::directive('englishToNepali', function($value, $decimalPlaces = 0) {
            return \App\Base\Helpers\BladeFunctionHelper::currencyFormatNepaliDigits($value, $decimalPlaces);
        });

    

      
      
      
    }
}