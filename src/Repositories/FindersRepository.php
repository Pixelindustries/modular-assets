<?php

namespace Pixelindustries\ModularAssets\Repositories;

use Symfony\Component\Finder\Finder;

class FindersRepository
{

    /**
     * @param string $directory
     * @return Finder
     */
    public function getForDirectory($directory)
    {
        return (new Finder)->depth(1)->in($directory);
    }
}
