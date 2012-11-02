<?php Load::Model('stripe');

    class Plugin_stripe_Model_stripe_event extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Event';

        protected $_schemaFields = array(
            'stripe_event_id' => array('type' => 'string', 'length' => 64),
            'stripe_event_type' => 'resource',
            'stripe_event_parent_type' => 'resource',
            'stripe_event_parent_id' => array('type' => 'string', 'length' => 64),
            'created_at' => 'datetime',
            'created_from' => 'resource',
            'created_by' => 'id',
        );
    }