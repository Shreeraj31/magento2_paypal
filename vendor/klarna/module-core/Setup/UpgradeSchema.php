<?php
/**
 * This file is part of the Klarna Core module
 *
 * (c) Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */

namespace Klarna\Core\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

/**
 * Class UpgradeSchema
 *
 * @package Klarna\Core\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.1.0', '<') && $installer->tableExists('klarna_kco_order')) {
            $newTable = 'klarna_core_order';
            $this->renameKlarnaKcoOrderTable($installer, $newTable);
            $this->updateColumnsInKlarnaOrderTable($installer, $newTable);
        }
        if (version_compare($context->getVersion(), '4.5.3', '<')) {
            $this->addAcknowledgedIndex($installer);
        }
        if (version_compare($context->getVersion(), '4.5.4', '<')) {
            $this->removeFKConstraintFromOrderTable(
                $installer,
                'klarna_core_order',
                'order_id',
                'sales_order',
                'entity_id'
            );
            $this->removeFKConstraintFromOrderTable(
                $installer,
                'klarna_kco_order',
                'order_id',
                'sales_order',
                'entity_id'
            );
        }
        $installer->endSetup();
    }

    /**
     * Updating the columns from the Klarna order table
     *
     * @param SchemaSetupInterface $installer
     * @param string $tableName
     */
    private function updateColumnsInKlarnaOrderTable(SchemaSetupInterface $installer, $tableName)
    {
        $installer->getConnection()
            ->addColumn(
                $tableName,
                'session_id',
                [
                    'type'    => Table::TYPE_TEXT,
                    'length'  => 255,
                    'comment' => 'Session Id',
                    'after'   => 'klarna_checkout_id'
                ]
            );
        $installer->getConnection()
            ->changeColumn(
                $tableName,
                'kco_order_id',
                'id',
                [
                    'type'     => Table::TYPE_INTEGER,
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'comment'  => 'Entity Id'
                ]
            );
        $installer->getConnection()
            ->changeColumn(
                $tableName,
                'klarna_checkout_id',
                'klarna_order_id',
                [
                    'type'    => Table::TYPE_TEXT,
                    'length'  => 255,
                    'comment' => 'Klarna Order Id'
                ]
            );
        $installer->getConnection()
            ->changeColumn(
                $tableName,
                'klarna_reservation_id',
                'reservation_id',
                [
                    'type'    => Table::TYPE_TEXT,
                    'length'  => 255,
                    'comment' => 'Reservation Id'
                ]
            );
    }

    /**
     * Renaming the Klarna kco order table
     *
     * @param SchemaSetupInterface $installer
     * @param string               $newTableName
     */
    private function renameKlarnaKcoOrderTable(SchemaSetupInterface $installer, $newTableName)
    {
        $oldTable = $installer->getTable('klarna_kco_order');
        $newTable = $installer->getTable($newTableName);

        $installer->getConnection()->renameTable($oldTable, $newTable);
    }

    /**
     * Adding a index to the acknowledged column in the Klarna order table
     *
     * @param SchemaSetupInterface $installer
     */
    private function addAcknowledgedIndex(SchemaSetupInterface $installer)
    {
        $table = $installer->getTable('klarna_core_order');
        $index_list = $installer->getConnection()->getIndexList($table);
        $index_name = $installer->getIdxName($table, 'is_acknowledged');
        if (!isset($index_list[$index_name])) {
            $installer->getConnection()->addIndex($table, $index_name, 'is_acknowledged');
        }
    }

    /**
     * Remove FK constraint from `klarna_core_order` table
     *
     * @param SchemaSetupInterface $installer
     * @param string               $myTable
     * @param string               $myColumn
     * @param string               $foriegnTable
     * @param string               $foriegnColumn
     */
    private function removeFKConstraintFromOrderTable(
        SchemaSetupInterface $installer,
        $myTable,
        $myColumn,
        $foriegnTable,
        $foriegnColumn
    ) {
        $targetTable = $installer->getTable('klarna_core_order');
        $foreignKeyConstraints = $installer->getConnection()->getForeignKeys($targetTable);
        $targetConstraintName = $installer->getConnection()->getForeignKeyName(
            $installer->getTable($myTable),
            $myColumn,
            $installer->getTable($foriegnTable),
            $foriegnColumn
        );

        if (isset($foreignKeyConstraints[$targetConstraintName])) {
            $installer->getConnection()->dropForeignKey(
                $installer->getTable('klarna_core_order'),
                $installer->getFkName(
                    $installer->getTable($myTable),
                    $myColumn,
                    $installer->getTable($foriegnTable),
                    $foriegnColumn
                )
            );
        }
    }
}
