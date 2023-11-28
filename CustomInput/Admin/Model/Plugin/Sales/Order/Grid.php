<?php
namespace Custominput\Admin\Model\Plugin\Sales\Order;

class Grid
{
    public static $table = 'sales_order_grid';
    public static $leftJoinTable = 'custom_order';

    public function afterSearch($intercepter, $collection)
    {
        if ($collection->getMainTable() === $collection->getConnection()->getTableName(self::$table)) {
            $leftJoinTableName = $collection->getConnection()->getTableName(self::$leftJoinTable);
            $collection
                ->getSelect()
                ->joinLeft(
                    ['co' => $leftJoinTableName],
                    "co.order_id = main_table.entity_id",
                    [
                        'short_name' => 'co.short_name'
                    ]
                );
            $where = $collection->getSelect()->getPart(\Magento\Framework\DB\Select::WHERE);
            $collection->getSelect()->setPart(\Magento\Framework\DB\Select::WHERE, $where);
        }
        return $collection;
    }
}
