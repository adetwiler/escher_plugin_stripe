<?php

class Plugin_stripe extends Plugin {
    protected $models = array(
        'payments' => array(
            'stripe','transaction','customer','product','card',
        ),
    );
}