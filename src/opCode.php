<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 22:14
 */

class opCode
{
    public $mnemonic;
    public $call;
    public $mode;
    public $bytes;
    public $ticks;
    public $code;

    public function __construct($code,$opCode)
    {
        $this->code = $code;
        foreach($opCode as $key=>$value)
        {
            $this->{$key} = $value;
        }
    }
    public function getAAA()
    {
        return ($this->code & 0b11100000)>>5;
    }
    public function getBBB()
    {
        return ($this->code & 0b00011100)>>2;
    }
    public function getCC()
    {
        return $this->code & 0b00000011;
    }
}
