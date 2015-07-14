<?php

namespace Pixelindustries\ModularAssets\Installers;

use SplFileInfo;

class NpmInstaller extends AbstractInstaller
{
    /**
     * @return string
     */
    protected function getCommandName()
    {
        return 'npm';
    }

    /**
     * @return string
     */
    protected function getMetaFileName()
    {
        return 'package.json';
    }

    /**
     * @param SplFileInfo $file
     * @param $production
     * @return string
     */
    protected function getExecCommand(SplFileInfo $file, $production)
    {
        $dir = dirname($file->getRealPath());
        return "cd {$dir} && " . $this->getCommandName() . ' install' .($production ? ' --production' : '');
    }


}
