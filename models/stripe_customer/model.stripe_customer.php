<?php Load::Model('stripe');

    class Plugin_stripe_Model_stripe_customer extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Customer';

        protected $_schemaFields = array(
            'stripe_customer_id' => array('type' => 'string', 'length' => 64),
            'stripe_customer_created_at' => 'datetime',
            'stripe_customer_created_from' => 'resource',
            'stripe_customer_created_by' => 'id',
            'stripe_customer_modified_at' => 'datetime',
            'stripe_customer_modified_from' => 'resource',
            'stripe_customer_modified_by' => 'id',
            'stripe_customer_deleted' => array('type' => 'int','range' => 1),
        );

        function delete() {
            $this->stripe_customer_deleted = 1;
            $this->call('delete');
            $this->save(array(), FALSE);
        }
    }