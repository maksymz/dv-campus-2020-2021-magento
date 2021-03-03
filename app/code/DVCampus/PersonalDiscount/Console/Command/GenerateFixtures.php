<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Console\Command;

use Magento\Framework\Console\Cli;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFixtures extends \Symfony\Component\Console\Command\Command
{
    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('dvcampus:personal-discount:generate-fixtures')
            ->setDescription('{DV.Campus} Generate Fixtures')
            ->addOption(
                'amount-per-user',
                'a',
                InputOption::VALUE_OPTIONAL,
                'Amount of requests per user and requests without user. Random product IDs of the visible products are used.',
                10
            )
            ->setHelp(<<<'EOF'
                Generate fixtures (test data) for the module testing.
                Command: <info>%command.full_name% -n=100</info>
                EOF);
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return Cli::RETURN_SUCCESS;
    }
}
