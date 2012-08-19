<?php

class Plugin_stripe_Model_card extends Model {
    protected $_schemaFields = array(
        'card_id' => 'string',
        'customer_id' => 'string',
        'card_name' => 'string',
        'card_pin' => 'string',
        'card_currency' => 'resource',
        'card_fingerprint' => 'string',
        'card_last_status' => 'resource',
        'card_created_at' => 'datetime',
        'card_created_from' => 'resource',
        'card_created_by' => 'id',
        'card_modified_at' => 'datetime',
        'card_modified_from' => 'resource',
        'card_modified_by' => 'id',
    );
}