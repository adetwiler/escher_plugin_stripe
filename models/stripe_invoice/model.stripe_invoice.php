<?php Load::Model('stripe');

    class Plugin_stripe_Model_stripe_invoice extends Plugin_stripe_Model_stripe {
        protected $stripe_class='Stripe_Invoice';
    }