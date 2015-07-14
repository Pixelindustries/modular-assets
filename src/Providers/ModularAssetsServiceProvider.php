<?php

namespace Pixelindustries\ModularAssets\Providers;

use Illuminate\Support\ServiceProvider;
use Pixelindustries\ModularAssets\Commands\Laravel\AssetsInstallCommand;

class ModularAssetsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->commands(AssetsInstallCommand::class);
    }
}