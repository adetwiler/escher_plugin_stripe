<?php

class Plugin_stripe_Model_stripe extends Model {
    protected $stripe, $stripe_class, $object, $_saved = false;

    function __construct($key=null) {
        parent::__construct($key);
        $this->stripe = Load::Helper(array('stripe','stripe'));

        if (!empty($this->{$this->_m().'_id'})) {
            $this->get();
        }
    }

    function getAll() {
        return call_user_func(array($this->stripe_class, 'all'));
    }

    protected function get($id=null) {
        if ($id == null) {
            return call_user_func(array($this->stripe_class, 'retrieve'),$this->id());
        }
        return call_user_func(array($this->stripe_class, 'retrieve'),$id);
    }

    protected function set($args=array()) {
        if (!is_array($args)) { return false; }
        if (!empty($this->{$this->_m().'_id'})) {
            $this->object = $obj = $this->get();
        }
        if (empty($obj)) {
            $this->object = $obj = call_user_func(array($this->stripe_class, 'create'),$args);
            $this->{$this->_m().'_id'} = $obj->id;
        }
        if (!empty($args)) {
            foreach ($args as $k => $v) {
                $obj->$k = $v;
            }
        }
        if (method_exists($obj,'save')) {
            $obj->save();
        }
    }
    
    function save($args=array(), $save=FALSE) {
        if (!$this->_saved && $save) {
            $this->set($args);
        }
        $this->_saved = true;
        $this->touch();
        parent::save();
    }

    function call($method,$args=array()) {
        if (empty($this->object)) {
            $obj = $this->get();
        } else {
            $obj = $this->object;
        }
        $obj->$method($args);
    }

    function delete() {
        $this->call('delete');
        parent::delete();
    }
}