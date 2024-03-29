#!/usr/bin/env php
<?php

require dirname(__DIR__, 2).'/vendor/autoload.php';

use bariscodefx\NextCordovaExporter\exporter\Exporter;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;

$application = new Application();

$application->setName('NextCordovaExporter');
$application->setVersion('1.0.0');

$application->register('export')
    ->addArgument('dir', InputArgument::REQUIRED, 'Directory of next.js export directory (ex: out, dist etc.).')
    ->setCode(function (InputInterface $input, OutputInterface $output): int {
        (new Exporter($input->getArgument('dir')));

        return Command::SUCCESS;
    });

$application->run();