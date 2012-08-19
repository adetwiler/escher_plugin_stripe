<?php Load::Model('stripe');

    class Plugin_stripe_Model_customer extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Customer';

        protected $_schemaFields = array(
            'customer_id' => array('type' => 'string', 'length' => 64),
            'customer_created_at' => 'datetime',
            'customer_created_from' => 'resource',
            'customer_created_by' => 'id',
            'customer_modified_at' => 'datetime',
            'customer_modified_from' => 'resource',
            'customer_modified_by' => 'id',
            'customer_deleted' => array('type' => 'int','range' => 1),
        );
    }