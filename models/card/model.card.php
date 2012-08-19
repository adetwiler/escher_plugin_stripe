<?php

class Plugin_stripe_Model_card extends Model {
    protected $_useCVC = TRUE;
    protected $_useAddress = FALSE;
    protected $_schemaFields = array(
        'card_id' => array('type' => 'string', 'length' => 32),
        'customer_id' => 'string',
        'card_name' => 'string',
        'card_pin' => 'string',
        'card_last_status' => 'resource',
        'card_created_at' => 'datetime',
        'card_created_from' => 'resource',
        'card_created_by' => 'id',
        'card_modified_at' => 'datetime',
        'card_modified_from' => 'resource',
        'card_modified_by' => 'id',
    );

    // The card will create the customer
    function save($args=array()) {
        if (empty($this->card_id)) {
            $this->touch();
            // Create a random 64 character id.
            $this->card_id = $this->getGUID();
            $customer = Load::Model('customer');

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
            if ($this->_useAddress) {
                $card['card']['address_line1'] = $args['address'];
                if (!empty($args['address2'])) {
                    $card['card']['address_line2'] = $args['address2'];
                }
                $card['card']['address_zip'] = $args['zip'];
                $card['card']['address_state'] = $args['state'];
                $card['card']['address_country'] = $args['country'];
            }
            $customer->save($card);
            $this->customer_id = $customer->id();
        }
        parent::save();
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