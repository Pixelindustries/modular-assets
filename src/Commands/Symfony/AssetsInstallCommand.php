<?php

namespace Pixelindustries\ModularAssets\Commands\Symfony;


use Pixelindustries\ModularAssets\Contracts\InstallerInterface;
use Pixelindustries\ModularAssets\Repositories\DirectoriesRepository;
use Pixelindustries\ModularAssets\Repositories\FindersRepository;
use Pixelindustries\ModularAssets\Repositories\InstallersRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AssetsInstallCommand extends Command
{

    /**
     * @var FindersRepository
     */
    protected $finders;

    /**
     * @var DirectoriesRepository
     */
    protected $directories;

    /**
     * @var InstallersRepository
     */
    protected $installers;

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
        $this->setName('assets:install')
             ->setDescription('Install assets')
             ->addOption(
                 'installer',
                 null,
                 InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
                 'One or more installers that will be used (e.g. bower, npm)',
                 ['npm', 'bower']
             )
             ->addOption(
                 'directory',
                 'd',
                 InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                 'One or more directories to process'
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
        $installers  = $input->getOption('installer');
        $production  = $input->getOption('production');
        $directories = $this->directories->getFromInput($input);
        $finder      = $this->finders->getForDirectories($directories);

        foreach($installers as $installerName) {
            $installer = $this->installers->getForName($installerName);

            if (!$installer->isAvailable()) {
                return $output->writeLn("Installer '$installerName' not available");
            }

            $output->writeLn("Running installer '$installerName'");
            $installer->run($finder, $production);
        }
    }
}
