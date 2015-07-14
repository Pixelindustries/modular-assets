<?php

namespace Pixelindustries\ModularAssets\Repositories;


use Pixelindustries\ModularAssets\Contracts\InstallerInterface;

class InstallersRepository
{

    /**
     * @param $installerName
     * @return InstallerInterface
     */
    public function getForName($installerName)
    {
        $installerClass = $this->getInstallerClassName($installerName);

        return new $installerClass;
    }

    protected function getInstallerClassName($installerName)
    {
        return "Pixelindustries\\ModularAssets\\Installers\\" . ucfirst($installerName) . "Installer";
    }
}
