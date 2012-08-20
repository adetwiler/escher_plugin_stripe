<?php

class Plugin_stripe extends Plugin {
    protected $models = array(
        'stripe' => array(
            'stripe','stripe_card','stripe_charge','stripe_customer','stripe_event','stripe_invoice','stripe_plan',
        ),
    );
}