<?php
/**
 * Created by PhpStorm.
 * User: che
 * Date: 12.09.2017
 * Time: 17:29
 */

namespace app\EDI;


class Document
{

    private $segments = array();
    public  $seg = array();
    private  $val = array();

    public function __construct($segments)
    {
        $this->segments = $segments;
        $this->parse();
    }

    public function parse() {
    $this->segments = explode('~', $this->segments);
    foreach ($this->segments as $values) {
        $this->val = explode('*', $values);
        foreach ($this->val as $v => $k){
            $this->val[$v] = trim($k);
            $val2[$v]['VALUE'] = trim($k);
        }
        $this->seg[] = $val2;
        unset($val2);
    }
    unset($this->seg[count($this->seg)-1]);
    return $this->seg;
}

}