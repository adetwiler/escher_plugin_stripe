<?php

class Plugin_stripe_Model_stripe_card extends Model {
    protected $_createCC = FALSE;
    protected $_useCVC = TRUE;
    protected $_useName = TRUE;
    protected $_useAddress = TRUE;
    protected $_schemaFields = array(
        'stripe_card_id' => array('type' => 'string', 'length' => 32),
        'stripe_customer_id' => array('type' => 'string', 'length' => 64),
        'stripe_card_last_status' => 'resource',
        'stripe_card_created_at' => 'datetime',
        'stripe_card_created_from' => 'resource',
        'stripe_card_created_by' => 'id',
        'stripe_card_modified_at' => 'datetime',
        'stripe_card_modified_from' => 'resource',
        'stripe_card_modified_by' => 'id',
    );

    // Charge the credit card
    function charge($amount, $currency='usd', $options=array()) {
        if (empty($this->stripe_customer_id)) { return false; }

        $opts = array('amount' => $amount*100, 'currency' => $currency, 'customer' => $this->stripe_customer_id);
        $options = array_merge($opts,$options);

        $charge = Load::Model('stripe_charge');
        $charge->stripe_customer_id = $this->stripe_customer_id;
        $charge->stripe_card_id = $this->stripe_card_id;
        $charge->stripe_charge_currency = $currency;
        $charge->stripe_charge_amount = $amount;
        if (!empty($options['description'])) {
            $charge->stripe_charge_description = $options['description'];
        }
        $charge->save($options,TRUE);
    }

    // The card will create the customer
    function save($args=array()) {
        if (empty($this->stripe_card_id)) {
            $this->touch();
            // Create a random 32 character id.
            $this->stripe_card_id = $this->getGUID();
            $customer = Load::Model('stripe_customer');

            if ($this->_createCC) {
                // create the card in stripe.
                $card = array('card' =>
                    array(
                        'number' => $args['number'],
                        'exp_month' => $args['exp_month'],
                        'exp_year' => $args['exp_year'],
                    )
                );
                if ($this->_useCVC) {
                    $card['card']['cvc'] = $args['cvc'];
                }
                if ($this->_useName) {
                    $card['card']['name'] = $args['name'];
                }
                if ($this->_useAddress) {
                    $card['card']['address_line1'] = $args['address'];
                    if (!empty($args['address2'])) {
                        $card['card']['address_line2'] = $args['address2'];
                    }
                    $card['card']['address_zip'] = $args['zip'];
                    $card['card']['address_city'] = $args['city'];
                    $card['card']['address_state'] = $args['state'];
                    $card['card']['address_country'] = $args['country'];
                }
                $customer->save($card,TRUE);
            } else {
                $card = array('card' => $args['token']);
                $customer->save($card,TRUE);
            }
            $args=array();
            $this->stripe_customer_id = $customer->id();
        } else {
            $customer = Load::Model('stripe_customer',$this->stripe_customer_id);
            if (empty($customer)) { return false; }
            if (!empty($args)) {
                $customer->save($args,TRUE);
            }
        }
        parent::save();
    }

    function delete() {
        if (!empty($this->stripe_customer_id)) {
            $customer = Load::Model('stripe_customer');
            $customer->save(array('card' => null), TRUE);
        }
        parent::delete();
    }

    function getGUID(){
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8)
                .substr($charid, 8, 4)
                .substr($charid,12, 4)
                .substr($charid,16, 4)
                .substr($charid,20,12);
        return $uuid;
    }
}