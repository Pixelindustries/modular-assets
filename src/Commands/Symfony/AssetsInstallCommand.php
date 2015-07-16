<?php

namespace Pixelindustries\ModularAssets\Commands\Symfony;


use Pixelindustries\ModularAssets\Support\HandlesAssetInstall;
use Pixelindustries\ModularAssets\Contracts\InstallerInterface;
use Pixelindustries\ModularAssets\Repositories\DirectoriesRepository;
use Pixelindustries\ModularAssets\Repositories\FindersRepository;
use Pixelindustries\ModularAssets\Repositories\InstallersRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AssetsInstallCommand extends Command
{

    use HandlesAssetInstall;

    /**
     * Constructor.
     *
     * @param string|null $name The name of the command; passing null means it must be set in configure()
     *
     * @throws \LogicException When the command name is empty
     *
     * @api
     */
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->finders     = new FindersRepository;
        $this->directories = new DirectoriesRepository;
        $this->installers =  new InstallersRepository;
    }


    protected function configure()
    {
        $this->setName('install')
             ->setDescription('Install assets')
             ->addArgument(
                 'directory',
                 InputArgument::REQUIRED,
                 'Directory to process'
             )
             ->addArgument(
                 'installer',
                 InputArgument::REQUIRED,
                 'Installer to use'
             )
             ->addOption(
                 'production',
                 'p',
                 InputOption::VALUE_NONE,
                 'If set, only production assets will be installed'
             );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->handle();
    }
}
