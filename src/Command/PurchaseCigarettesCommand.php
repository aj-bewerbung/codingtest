<?php

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\CigarettePurchaseRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function str_replace;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $itemCount = (int)$input->getArgument('packs');
        $amount = (float)str_replace(',', '.', $input->getArgument('amount'));

        $purchase = new CigarettePurchaseRequest($itemCount, $amount);

        $cigaretteMachine = new CigaretteMachine();

        $res = $cigaretteMachine->execute($purchase);


        $output->writeln(
            sprintf(
                'You bought <info>%d</info> packs of cigarettes for <info>-%.02f€</info>, each for <info>-%.02f€</info>. ',
                $res->getItemQuantity(),
                $res->getTotalAmount(),
                CigaretteMachine::ITEM_PRICE
            )
        );
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows($res->getChange());
        $table->render();
    }
}