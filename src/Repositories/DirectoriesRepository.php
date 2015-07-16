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
        return getcwd() . '/' . $input->getArgument('directory');
    }
}
