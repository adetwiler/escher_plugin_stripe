<?php

    class Plugin_stripe_Model_customer extends Model {
        protected $_schemaFields = array(
            'customer_id' => 'string',
            'user_id' => 'id',
            'customer_deleted' => array('type' => 'int','range' => 1),
            'customer_created_at' => 'datetime',
            'customer_created_from' => 'resouce',
            'customer_created_by' => 'id',
            'customer_modified_at' => 'datetime',
            'customer_modified_from' => 'resource',
            'customer_modified_by' => 'id',
        );
    }