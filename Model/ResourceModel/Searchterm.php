<?php

namespace Sourabh\Autocomplete\Model\ResourceModel;

class Searchterm extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * 
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param type $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $connectionName = null
    ) {
        parent::__construct($context, $connectionName);
    }

    protected function _construct() {
        
    }

    public function getProductData($params)
    {
        $stmt = $this->getConnection()->query("SELECT entity_id FROM " . $this->getTable('catalog_product_entity_varchar') . " as cpev WHERE cpev.value LIKE '%".$params['searchterm']."%'  ANd cpev.attribute_id = 73");
        $result = $stmt->fetchAll();
        return $result;
    }
}
