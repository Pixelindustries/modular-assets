<?php

namespace Pixelindustries\ModularAssets\Contracts;

use Symfony\Component\Finder\Finder;

interface InstallerInterface
{

    /**
     * @return bool
     */
    public function isAvailable();

    /**
     * @param Finder $finder
     * @param bool|false $production
     * @param bool|true $passthru
     * @return void|string[]
     */
    public function run(Finder $finder, $production = false, $passthru = true);
}
