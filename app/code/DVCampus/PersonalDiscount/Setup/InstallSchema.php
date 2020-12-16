<?php

declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context): void
    {
        throw new \Exception('Demo install scripts that will not work');

        $setup->startSetup();

        /**
         * Create table 'dv_campus_personal_discount_request'
         */
        $table = $setup->getConnection()
            ->newTable(
                $setup->getTable('dv_campus_personal_discount_request')
            )->addColumn(
                'discount_request_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'Discount Request ID'
            )->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                'Customer Id'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false],
                'Name'
            )->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['unsigned' => true, 'nullable' => false],
                'Email'
            )->addColumn(
                'message',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                4096,
                ['unsigned' => true, 'nullable' => false],
                'Message'
            )->addColumn(
                'website_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => true],
                'Website Id'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Website Id'
            )->addIndex(
                $setup->getIdxName('dv_campus_personal_discount_request', ['website_id']),
                ['website_id']
            )->addIndex(
                $setup->getIdxName(
                    'dv_campus_personal_discount_request',
                    ['email', 'website_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['email', 'website_id'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addForeignKey(
                $setup->getFkName('dv_campus_personal_discount_request', 'website_id', 'store_website', 'website_id'),
                'website_id',
                $setup->getTable('store_website'),
                'website_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_SET_NULL
            )->addIndex(
                $setup->getIdxName('dv_campus_personal_discount_request', ['customer_id']),
                ['customer_id']
            )->addForeignKey(
                $setup->getFkName('dv_campus_personal_discount_request', 'customer_id', 'customer_entity', 'entity_id'),
                'customer_id',
                $setup->getTable('customer_entity'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_SET_NULL
            )->setComment(
                'Personal Discount'
            );

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
