<?php

namespace Pixelindustries\ModularAssets\Support;


use Pixelindustries\ModularAssets\Repositories\DirectoriesRepository;
use Pixelindustries\ModularAssets\Repositories\FindersRepository;
use Pixelindustries\ModularAssets\Repositories\InstallersRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait HandlesAssetInstall
{

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var InstallersRepository
     */
    protected $installers;

    /**
     * @var DirectoriesRepository
     */
    protected $directories;

    /**
     * @var FindersRepository
     */
    protected $finders;

    public function handle()
    {
        $installerName = $this->input->getArgument('installer');
        $installer   = $this->installers->getForName($installerName);
        $production  = $this->input->getOption('production');
        $directory   = $this->directories->getFromInput($this->input);
        $finder      = $this->finders->getForDirectory($directory);

        if (!$installer->isAvailable()) {
            return $this->output->writeLn("Installer '$installerName' not available");
        }

        $this->output->writeLn("Running installer '$installerName'");
        $installer->run($finder, $production);
    }
}