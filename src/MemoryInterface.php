<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 20:51
 */

Interface MemoryInterface
{
    public function write($addr,$byte);
    public function read($addr);
    public function getSize();
}
