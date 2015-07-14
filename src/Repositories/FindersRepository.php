<?php

namespace Pixelindustries\ModularAssets\Repositories;

use Symfony\Component\Finder\Finder;

class FindersRepository
{

    /**
     * @param array $directories
     * @return Finder
     */
    public function getForDirectories(array $directories)
    {
        if (empty($directories)) throw new \InvalidArgumentException('No directories found');

        return (new Finder)->depth(1)->in($directories);
    }
}
