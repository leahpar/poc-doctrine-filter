<?php

namespace App\Command;

use App\Entity\Truc;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitCommand extends Command
{
    protected static $defaultName = 'app:init';

    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->em = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setDescription('Init db');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        for ($i="A"; $i<="C"; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $truc = new Truc();
                $truc->filter = "filter_$i";
                $truc->data = "random_data_".md5(rand());
                $this->em->persist($truc);
            }
        }
        $this->em->flush();

        $io->success("OK");

        return Command::SUCCESS;
    }

}