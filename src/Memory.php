<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 20:51
 */

abstract class Memory implements MemoryInterface
{
    protected $size;
    protected $mem = [];

    public function __construct($size)
    {
        $this->size = $size;
        $this->mem = array_fill(0,$size,0);
    }
    public function getSize()
    {
        return $this->size;
    }
    public function read($addr)
    {
        return $this->mem[$addr];
    }
    abstract function write($addr,$byte);
}
