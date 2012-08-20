<?php Load::Model('stripe');

    class Plugin_stripe_Model_stripe_customer extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Customer';

        protected $_schemaFields = array(
            'stripe_customer_id' => array('type' => 'string', 'length' => 64),
            'stripe_plan_id' => array('type' => 'string', 'length' => 64),
            'stripe_customer_created_at' => 'datetime',
            'stripe_customer_created_from' => 'resource',
            'stripe_customer_created_by' => 'id',
            'stripe_customer_modified_at' => 'datetime',
            'stripe_customer_modified_from' => 'resource',
            'stripe_customer_modified_by' => 'id',
            'stripe_customer_deleted' => array('type' => 'int','range' => 1),
        );

        function subscribe($plan_id) {
            if (empty($this->stripe_customer_id)) { return false; }
            if (empty($this->stripe_plan_id)) {
                $this->stripe_plan_id = $plan_id;
                $this->save(
                    array(
                        'plan' => $plan_id,
                    )
                ,TRUE);
            } else {
                $this->stripe_plan_id = $plan_id;
                $this->call('updateSubscription',
                    array(
                        'plan' => $plan_id,
                    )
                );
                $this->save();
            }
        }
        function unsubscribe() {
            unset($this->stripe_plan_id);
            if (empty($this->stripe_customer_id)) { return false; }
            $this->call('cancelSubscription');
            $this->save();
        }

        function delete() {
            $this->stripe_customer_deleted = 1;
            $this->call('delete');
            $this->save();
        }
    }