<?php Load::Model('stripe');

    class Plugin_stripe_Model_stripe_transaction extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Charge';

        protected $_schemaFields = array(
            'stripe_transaction_id' => array('type' => 'string', 'length' => 64),
            'stripe_customer_id' => array('type' => 'string', 'length' => 64),
            'stripe_card_id' => array('type' => 'string', 'length' => 32),
            'stripe_transaction_amount' => 'currency',
            'stripe_transaction_currency' => array('type' => 'string', 'length' => '3'),
            'stripe_transaction_created_at' => 'datetime',
            'stripe_transaction_created_from' => 'resource',
            'stripe_transaction_created_by' => 'id',
            'stripe_transaction_modified_at' => 'datetime',
            'stripe_transaction_modified_from' => 'resource',
            'stripe_transaction_modified_by' => 'id',
            'stripe_transaction_disputed' => array('type' => 'int', 'range' => 1),
            'stripe_transaction_refunded' => array('type' => 'int', 'range' => 1),
            // Content
            'stripe_transaction_description' => 'content',
        );

        function refund() {
            if (empty($this->stripe_transaction_id)) { return false; }
            $this->call('refund');
            $this->stripe_transaction_refunded = 1;
            $this->save(array(),FALSE);
        }
    }