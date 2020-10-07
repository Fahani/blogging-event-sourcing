<?php

declare(strict_types=1);


namespace App\Infrastructure\Ui\Cli;


use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateEventStoreCommand extends Command
{

    private Connection $connection;


    private DBALEventStore $eventStore;

    public function __construct(EntityManager $entityManager, DBALEventStore $eventStore)
    {
        $this->connection = $entityManager->getConnection();
        $this->eventStore = $eventStore;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('broadway:event-store:create')
            ->setDescription('Creates the event store schema')
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> command creates the schema in the default
connections database:
<info>php app/console %command.name%</info>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaManager = $this->connection->getSchemaManager();

        if ($table = $this->eventStore->configureSchema($schemaManager->createSchema())) {
            $schemaManager->createTable($table);
            $output->writeln('<info>Created Broadway event store schema</info>');
        } else {
            $output->writeln('<info>Broadway event store schema already exists</info>');
        }

        return 0;
    }
}
