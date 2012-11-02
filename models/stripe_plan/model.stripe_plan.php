<?php Load::Model('stripe');

    class Plugin_stripe_Model_stripe_plan extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Plan';

        protected $_schemaFields = array(
            'stripe_plan_id' => array('type' => 'string', 'length' => 64),
            'stripe_plan_name' => 'string',
            'stripe_plan_interval' => 'resource',
            'stripe_plan_amount' => 'currency',
            'stripe_plan_currency' => array('type' => 'string', 'length' => 3),
            'created_at' => 'datetime',
            'created_from' => 'resource',
            'created_by' => 'id',
            'modified_at' => 'datetime',
            'modified_from' => 'resource',
            'modified_by' => 'id',
        );

        function save($args=array()) {
            if (empty($args['interval'])
                    || $args['interval'] != "month"
                    || $args['interval'] != "year"
            ){
                $args['interval'] = "month";
            }
            if (empty($args['currency'])
                    || $args['currency'] != "usd"
            ){
                $args['currency'] = "usd";
            }

            $this->stripe_plan_name = $args['name'];
            $this->stripe_plan_interval = $args['interval'];
            $this->stripe_plan_amount = $args['amount'];
            $this->stripe_plan_currency = $args['currency'];

            $args['amount'] = $args['amount'] * 100;
            parent::save($args,TRUE);
        }
    }