<?php

    class Plugin_stripe_Model_product extends Model {
        protected $_schemaFields = array(
            'product_id' => array('type' => 'string', 'length' => 64),
            'product_name' => 'string',
            'product_cost' => array('type' => 'decimal'),
            'product_created_at' => 'datetime',
            'product_created_from' => 'resource',
            'product_created_by' => 'id',
            'product_modified_at' => 'datetime',
            'product_modified_from' => 'resource',
            'product_modified_by' => 'id',
        );
    }