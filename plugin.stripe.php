<?php

class Plugin_stripe extends Plugin {
    protected $models = array(
        'payments' => array(
            'stripe','stripe_transaction','stripe_customer','stripe_card','stripe_plan'
        ),
    );
}