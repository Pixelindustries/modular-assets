<?php

namespace Pixelindustries\ModularAssets\Commands\Laravel;

use Illuminate\Console\Command;
use Pixelindustries\ModularAssets\Support\HandlesAssetInstall;
use Pixelindustries\ModularAssets\Repositories\FindersRepository;
use Pixelindustries\ModularAssets\Repositories\InstallersRepository;
use Pixelindustries\ModularAssets\Repositories\DirectoriesRepository;

class AssetsInstallCommand extends Command
{

    use HandlesAssetInstall;

    /**
     * @var string
     */
    protected $signature = 'assets:install {directory} {installer} {--production}';

    /**
     * @var string
     */
    protected $description = 'Runs various installers';

    /**
     * AssetsInstallCommand constructor.
     * @param DirectoriesRepository $directories
     * @param FindersRepository $finders
     * @param InstallersRepository $installers
     */
    public function __construct(DirectoriesRepository $directories, FindersRepository $finders, InstallersRepository $installers)
    {
        parent::__construct();

        $this->directories = $directories;
        $this->finders = $finders;
        $this->installers = $installers;
    }
}
