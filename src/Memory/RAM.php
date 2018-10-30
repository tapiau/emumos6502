<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 20:51
 */

class Memory_RAM extends Memory  implements MemoryModuleInterface
{
    public function write($addr,$byte)
    {
        return $this->mem[$addr] = $byte;
    }
}
