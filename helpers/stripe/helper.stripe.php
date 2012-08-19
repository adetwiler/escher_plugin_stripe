<?php Load::lib(array('stripe','Stripe.php'));

class Plugin_stripe_Helper_stripe extends Helper {

    function __construct() {
        $CFG = Load::CFG();
        if (!isset($CFG['stripe_secret'])) { return false; }
        Stripe::setApiKey($CFG['stripe_secret']);
    }
}