<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2019 Amasty (https://www.amasty.com)
 * @package Amasty_Xnotif
 */


namespace Amasty\Xnotif\Ui\DataProvider\Listing\Subscription;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Amasty\Xnotif\Model\ResourceModel\Stock\Subscription\Collection;
use Magento\Framework\Api\Filter;

/**
 * Class DataProvider
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    private $mappedFields = [
        'product_name' => ['product_name_by_store.value', 'product_name_default.value'],
        'product_sku' => ['product.sku'],
        'last_name' => ['customer.lastname'],
        'first_name' => ['customer.firstname'],
        'store_name' => ['store_name.store_id', 'customer.store_id'],
        'email' => ['main_table.email', 'customer.email']
    ];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;
    }

    /**
     * @param Filter $filter
     * @return mixed|void
     */
    public function addFilter(Filter $filter)
    {
        $condition = [$filter->getConditionType() => $filter->getValue()];

        if (array_key_exists($filter->getField(), $this->mappedFields)) {
            $mappedFields = $this->mappedFields[$filter->getField()];
            $condition = array_fill(0, count($mappedFields), $condition);
            $filter->setField($mappedFields);
        }

        $this->getCollection()->addFieldToFilter(
            $filter->getField(),
            $condition
        );
    }

    /**
     * @return \int[]
     */
    public function getAllIds()
    {
        /** @var Collection $collection */
        $collection = $this->getCollection();
        $collection->_renderFiltersBefore();

        return parent::getAllIds();
    }
}
