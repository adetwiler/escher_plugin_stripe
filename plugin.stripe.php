<?php

class Plugin_stripe extends Plugin {
    protected $models = array(
        'payments' => array(
            'transaction','customer','product','card',
        ),
    );
}