<?php

namespace FoodMeUp\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\EventDispatcher\GenericEvent;

class ImportCiqualCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('foodmeup:importCiqual')
        	->setDescription('import ciqual\'s data from csv')
        	->addArgument('path', InputArgument::REQUIRED, 'csv\'s path');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $now = new \DateTime();

        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
        $importCiqual = $this->getApplication()->getKernel()->getContainer()->get('foodmeup.import_ciqual');

        if  ($importCiqual->initData($path)) {
            // progress bar event
            $dispatcher = $this->getApplication()->getKernel()->getContainer()->get('event_dispatcher');
            $progress = new ProgressBar($output, count($importCiqual->getData()));
            $dispatcher->addListener(
                'import.ciqual.progress.bar',
                function () use ($progress) {
                    $progress->advance();
                }
            );

            $output->writeln('<comment>Traitement en cours : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
            $infos = $importCiqual->run($path);
            $progress->finish();
        } else {
            $output->writeln('<alert>Traitement échoué : ' . $now->format('d-m-Y G:i:s') . ' ---</alert>');
        }
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }
}
