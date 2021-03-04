<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Console\Command;

use DVCampus\PersonalDiscount\Model\DiscountRequest;
use Magento\Framework\Console\Cli;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DB\Select;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateFixtures extends \Symfony\Component\Console\Command\Command
{
    private \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory;

    private \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory;

    private \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory;

    private \Magento\Framework\DB\TransactionFactory $transactionFactory;

    private array $idsByCollection = [];

    /**
     * GenerateFixtures constructor.
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
     * @param \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param string|null $name
     */
    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \DVCampus\PersonalDiscount\Model\DiscountRequestFactory $discountRequestFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        string $name = null
    ) {
        parent::__construct($name);
        $this->productCollectionFactory = $productCollectionFactory;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->discountRequestFactory = $discountRequestFactory;
        $this->transactionFactory = $transactionFactory;
    }

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
            ->setHelp(
                <<<'EOF'
                Generate fixtures (test data) for the module testing.
                Command: <info>%command.full_name% -n=100</info>
                EOF
            );
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $amount = (int) $input->getOption('amount-per-user');
        $customerIds = $this->getIdsFromCollection($this->customerCollectionFactory->create());
        // Create requests for the guest customer as well
        $customerIds[] = null;

        foreach ($customerIds as $customerId) {
            $this->generateRequests($customerId, $amount);
        }

        return Cli::RETURN_SUCCESS;
    }

    /**
     * @param AbstractDb $collection
     * @return array
     */
    private function getIdsFromCollection(AbstractDb $collection): array
    {
        $collectionClass = get_class($collection);

        if (!isset($this->idsByCollection[$collectionClass])) {
            $select = $collection->getSelect();
            $select->reset(Select::COLUMNS)
                ->columns($collection->getIdFieldName());
            $this->idsByCollection[$collectionClass]
                = array_map('intval', $collection->getConnection()->fetchCol($select));
        }

        return $this->idsByCollection[$collectionClass];
    }

    /**
     * @param int|null $customerId
     * @param int $amountPerCustomer
     * @throws \Exception
     */
    private function generateRequests(?int $customerId, int $amountPerCustomer): void
    {
        $productIds = $this->getIdsFromCollection($this->productCollectionFactory->create());
        $productIdsRandomKeys = array_rand($productIds, $amountPerCustomer);
        static $statuses = [
            DiscountRequest::STATUS_PENDING,
            DiscountRequest::STATUS_APPROVED,
            DiscountRequest::STATUS_DECLINED
        ];
        $transaction = $this->transactionFactory->create();

        foreach ($productIdsRandomKeys as $productIdsRandomKey) {
            /** @var DiscountRequest $discountRequest */
            $discountRequest = $this->discountRequestFactory->create();
            // @TODO: hardcoded because we work with the Sample Data and we are sure that this website exists
            // This may not be true for the real project
            $discountRequest->setWebsiteId(1)
                ->setProductId($productIds[$productIdsRandomKey])
                ->setCustomerId($customerId)
                ->setEmail($customerId ? null : 'john-doe@example.com')
                ->setName($customerId ? null : 'John Doe')
                ->setMessage('Lorem ipsum dolor sit amet')
                ->setStatus($statuses[array_rand($statuses)]);
            $transaction->addObject($discountRequest);
        }

        $transaction->save();
    }
}
