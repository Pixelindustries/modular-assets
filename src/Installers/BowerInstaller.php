<?php

namespace Pixelindustries\ModularAssets\Installers;

use SplFileInfo;

class BowerInstaller extends AbstractInstaller
{

    protected function getCommandName()
    {
        return 'bower';
    }

    protected function getMetaFileName()
    {
        return 'bower.json';
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
