#!/usr/bin/env php
<?php

require dirname(__DIR__).'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Pixelindustries\ModularAssets\Commands\Symfony\AssetsInstallCommand;

$application = new Application();
$application->add(new AssetsInstallCommand);
$application->run();
