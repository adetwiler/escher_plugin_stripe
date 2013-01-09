<?php Load::Model(array('stripe','stripe'));

    class Plugin_stripe_Model_stripe_customer extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Customer';

        protected $_schemaFields = array(
            'stripe_customer_id' => array('type' => 'string', 'length' => 64),
            'stripe_plan_id' => array('type' => 'string', 'length' => 64),
            'created_at' => 'datetime',
            'created_from' => 'resource',
            'created_by' => 'id',
            'modified_at' => 'datetime',
            'modified_from' => 'resource',
            'modified_by' => 'id',
            'stripe_customer_deleted' => array('type' => 'int','range' => 1),
        );

        function subscribe($plan_id,$update=FALSE) {
            if (empty($this->stripe_customer_id)) { return false; }
            if (!$update) {
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
        function unsubscribe($at_period_end = TRUE) {
            unset($this->stripe_plan_id);
            if (empty($this->stripe_customer_id)) { return false; }
            $this->call('cancelSubscription',array("at_period_end" => $at_period_end));
            $this->save();
        }

        function delete() {
            $this->stripe_customer_deleted = 1;
            $this->call('delete');
            $this->save();
        }
    }