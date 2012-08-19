<?php Load::Model('stripe');

    class Plugin_stripe_Model_transaction extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Charge';

        protected $_schemaFields = array(
            'transaction_id' => array('type' => 'string', 'length' => 64),
            'customer_id' => array('type' => 'string', 'length' => 64),
            'card_id' => array('type' => 'string', 'length' => 32),
            'transaction_amount' => array('type' => 'float'),
            'transaction_fee' => array('type' => 'float'),
            'transaction_currency' => array('type' => 'string', 'length' => '3'),
            'transaction_created_at' => 'datetime',
            'transaction_created_from' => 'resource',
            'transaction_created_by' => 'id',
            'transaction_modified_at' => 'datetime',
            'transaction_modified_from' => 'resource',
            'transaction_modified_by' => 'id',
            'transaction_disputed' => array('type' => 'int', 'range' => 1),
            'transaction_refunded' => array('type' => 'int', 'range' => 1),
            // Content
            'transaction_description' => 'content',
        );
    }