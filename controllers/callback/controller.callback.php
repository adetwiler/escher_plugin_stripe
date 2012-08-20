<?php

class Plugin_stripe_Controller_callback extends Controller {
    function action_index($args) {
        $body = @file_get_contents('php://input');
        $event_json = json_decode($body);
        $object = $event_json->data->object;

        switch($event_json->type) {
            case 'charge.refunded':
                $charge = Load::Model('stripe_charge',$object->id);
                if (empty($charge)) { return false; }
                $charge->stripe_charge_refunded = 1;
                $charge->save();
                break;
            case 'charge.disputed':
                $charge = Load::Model('stripe_charge',$object->id);
                if (empty($charge)) { return false; }
                $charge->stripe_charge_disputed = 1;
                $charge->save();
                break;
            case 'customer.subscription.deleted':
                $customer = Load::Model('stripe_customer',$object->id);
                if (empty($customer)) { return false; }
                $customer->unsubscribe();
                break;
        }

        $event = Load::Model('stripe_event');
        $event->stripe_event_id = $event_json->id;
        $event->stripe_event_type = $event_json->type;
        $event->stripe_event_parent_type = 'stripe_'.$object->object;
        $event->stripe_event_parent_id = $object->id;
        $event->stripe_event_created_from = "webhook";
        $event->save();
    }
}