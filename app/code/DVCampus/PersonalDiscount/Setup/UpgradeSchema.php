<?php
declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements \Magento\Framework\Setup\UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Exception
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        throw new \Exception('Demo install scripts that will not work');

        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $connection = $setup->getConnection();

            $connection->addColumn(
                $setup->getTable('dv_campus_personal_discount_request'),
                'created_at',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'nullable' => false,
                    'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
                    'comment'  => 'Created At'
                ]
            );

            $connection->addColumn(
                $setup->getTable('dv_campus_personal_discount_request'),
                'updated_at',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'nullable' => false,
                    'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_UPDATE,
                    'comment'  => 'Updated At'
                ]
            );
        }

        $setup->endSetup();
    }
}
