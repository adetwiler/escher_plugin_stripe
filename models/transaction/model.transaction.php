<?php

    class Plugin_stripe_Model_transaction extends Model {
        protected $_schemaFields = array(
            'transaction_id' => 'string',
            'customer_id' => 'string',
            'product_id' => 'string',
            'card_id' => 'string',
            'transaction_amount' => array('type' => 'decimal'),
            'transaction_refunded' => array('type' => 'int', 'range' => 1),
            'transaction_created_at' => 'datetime',
            'transaction_created_from' => 'resource',
            'transaction_created_by' => 'id',
            'transaction_modified_at' => 'datetime',
            'transaction_modified_from' => 'resource',
            'transaction_modified_by' => 'id',
        );
    }