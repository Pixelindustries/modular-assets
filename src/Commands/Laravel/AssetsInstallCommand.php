<?php

namespace Pixelindustries\ModularAssets\Commands\Laravel;

use Illuminate\Console\Command;
use Pixelindustries\ModularAssets\Repositories\DirectoriesRepository;
use Pixelindustries\ModularAssets\Repositories\FindersRepository;
use Pixelindustries\ModularAssets\Repositories\InstallersRepository;

class AssetsInstallCommand extends Command
{

    /**
     * @var string
     */
    protected $signature = 'assets:install {--installer?} {--directory} {--production}';

    /**
     * @var string
     */
    protected $description = 'Runs various installers';

    /**
     * @var DirectoriesRepository
     */
    protected $directories;

    /**
     * @var FindersRepository
     */
    protected $finders;

    /**
     * @var InstallersRepository
     */
    protected $installers;

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

    public function handle()
    {
        $installers  = $this->input->getOption('installer');
        $production  = $this->input->getOption('production');
        $directories = $this->directories->getFromInput($this->input);
        $finder      = $this->finders->getForDirectories($directories);

        foreach($installers as $installerName) {
            $installer = $this->installers->getForName($installerName);

            if (!$installer->isAvailable()) {
                $this->error("Installer '$installerName' not available");
                return;
            }

            $this->info("Running installer '$installerName'");
            $installer->run($finder, $production);
        }
    }
}
