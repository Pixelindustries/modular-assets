<?php

namespace Pixelindustries\ModularAssets\Repositories;


use Symfony\Component\Console\Input\InputInterface;

class DirectoriesRepository
{

    /**
     * @param InputInterface $input
     * @return string[]
     * @throws \Exception
     */
    public function getFromInput(InputInterface $input)
    {
        $directories = $input->getOption('directory');

        if (empty($directories)) {
            throw new \Exception('No directory argument');
        }

        if (!is_array($directories)) {
            $directories = [$directories];
        }

        foreach($directories as &$dir) {
            $dir = getcwd() . '/' . $dir;
        }
        unset($dir);

        return $directories;
    }
}
