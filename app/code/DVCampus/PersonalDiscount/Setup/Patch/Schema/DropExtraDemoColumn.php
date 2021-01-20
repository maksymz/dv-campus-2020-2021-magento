<?php
declare(strict_types=1);

namespace DVCampus\PersonalDiscount\Setup\Patch\Schema;

class DropExtraDemoColumn implements \Magento\Framework\Setup\Patch\SchemaPatchInterface
{
    private \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup;

    /**
     * RemoveOldForeignKeys constructor.
     * @param \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
     */
    public function __construct(
        \Magento\Framework\Setup\SchemaSetupInterface $schemaSetup
    ) {
        $this->schemaSetup = $schemaSetup;
    }

    /**
     * @inheritDoc
     */
    public function apply(): void
    {
        $this->schemaSetup->getConnection()
            ->dropColumn(
                $this->schemaSetup->getTable('dv_campus_personal_discount_request'),
                'extra_demo_column'
            );
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases(): array
    {
        return [];
    }
}