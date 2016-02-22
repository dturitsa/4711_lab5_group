<?php

/**
 * Data access wrapper for "orders" table.
 *
 * @author jim
 */
class Orders extends MY_Model
{

    // constructor
    public function __construct()
    {
        parent::__construct('orders', 'num');
    }

    // add an item to an order
    public function add_item($num, $code)
    {
        $CI = &get_instance();
        if ($CI->orderitems->exists($num, $code)) {
            $record = $CI->orderitems->get($num, $code);
            $record->quantity++;
            $CI->orderitems->update($record);
        } else {
            $record           = $CI->orderitems->create();
            $record->order    = $num;
            $record->item     = $code;
            $record->quantity = 1;
            $CI->orderitems->add($record);
        }
    }

    // calculate the total for an order
    public function total($num)
    {
        $CI     = &get_instance();
        $items  = $CI->orderitems->group($num);
        $result = 0;
        if (count($items) > 0) {
            foreach ($items as $item) {
                $menu = $CI->menu->get($item->item);
                $result += $item->quantity * $menu->price;
            }
        }

        return $result;
    }

    // retrieve the details for an order
    public function details($num)
    {
        
    }

    // cancel an order
    public function flush($num)
    {

    }

    // validate an order
    // it must have at least one item from each category
    public function validate($num)
    {
        return false;
    }

}
