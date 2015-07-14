<?php

namespace Pixelindustries\ModularAssets\Installers;

use SplFileInfo;
use Pixelindustries\ModularAssets\Contracts\InstallerInterface;
use Pixelindustries\ModularAssets\Exceptions\CommandErrorException;
use Pixelindustries\ModularAssets\Exceptions\CommandNotFoundException;
use Symfony\Component\Finder\Finder;

abstract class AbstractInstaller implements InstallerInterface
{

    const EXIT_COMMAND_NOT_FOUND = 127;
    const EXIT_SUCCESS = 0;

    /**
     * @return bool
     */
    public function isAvailable()
    {
        try {
            $this->runCommand($this->getCommandName() . ' -v', false);
            return true;
        } catch (CommandNotFoundException $e) {
            return false;
        }
    }

    /**
     * @param Finder $finder
     * @param bool|false $production
     * @param bool|true $passthru
     * @return void|string[]
     */
    public function run(Finder $finder, $production = false, $passthru = true)
    {
        $finder = clone $finder;
        $finder->name($this->getMetaFileName());

        foreach($finder->files() as $file) {
            $cwd = getcwd();
            $this->runCommand($this->getExecCommand($file, $production));
            chdir($cwd);
        }
    }


    protected function checkResult($result, $output = null)
    {
        switch($result) {
            case self::EXIT_SUCCESS:
                break;

            case self::EXIT_COMMAND_NOT_FOUND:
                throw new CommandNotFoundException($output, $result);

            default:
                throw new CommandErrorException($output, $result);
        }
    }

    protected function runCommand($command, $passthru = true, $restoreWd = null)
    {
        $result = null;
        $output = [];

        if ($passthru) {
            passthru($command, $result);
        } else {
            exec($command, $output, $result);
        }

        if (!is_null($restoreWd)) {
            chdir($restoreWd);
        }

        $this->checkResult($result, implode(PHP_EOL, $output));
    }

    /**
     * @return string
     */
    abstract protected function getCommandName();

    /**
     * @return string
     */
    abstract protected function getMetaFileName();

    /**
     * @param SplFileInfo $file
     * @param $production
     * @return string
     */
    abstract protected function getExecCommand(SplFileInfo $file, $production);
}