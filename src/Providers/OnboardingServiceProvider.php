<?php

namespace BamboleeDigital\OnboardingPackage\Providers;

use Illuminate\Support\ServiceProvider;

class OnboardingServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registre quaisquer bindings de serviço aqui
    }

    public function boot()
    {
        // Publicação de arquivos de configuração
        $this->publishes([
            __DIR__.'/../../config/onboarding.php' => config_path('onboarding.php'),
        ], 'config');

        // Publicação de migrações
        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Carregar rotas
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');

        // Carregar views, caso tenha
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'onboarding-package');

        // lang 
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'onboarding-package');
    }
}
