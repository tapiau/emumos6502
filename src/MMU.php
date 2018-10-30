<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 20:51
 */

class MMU implements MemoryInterface
{
    private $moduleList = [];
    /** @var MemoryModuleInterface[] */
    private $addressSpace = [];
    private $addressSpaceSize = 0x10000;
    private $addressSpaceMask = 0xFFFF;

    public function getSize()
    {
        return array_reduce($this->moduleList,
            function($prev,MemoryModuleInterface $module)
            {
                return $prev+$module->getSize();
            },
            0
        );
    }

    public function addNamedModule($name,MemoryModuleInterface $memoryModule)
    {
        if(array_key_exists($name,$this->moduleList))
        {
            throw new Exception("Memory module named '$name' already exists.");
        }
        $this->moduleList[$name] = $memoryModule;
    }
    public function mapModuleByNameToAddressSpace($name,$addr)
    {
        $this->addressSpace[$addr] = $this->getModuleByName($name);

        ksort($this->addressSpace);
    }
    public function getModuleByName($name)
    {
        $this->moduleList[$name];
    }

    public function getBaseAddress($address)
    {
        $baseAddressList = array_keys($this->addressSpace);

        return array_reduce(
            $baseAddressList,
            function($prev,$baseAddress) use ($address)
            {
                return ($baseAddress<=$address)?
                    $baseAddress:
                    $prev
                    ;
            },
            min($baseAddressList)
        );
    }

    public function getModuleByAddress($address)
    {
        $baseAddressList = array_keys($this->addressSpace);

        if($address<min($baseAddressList))
        {
            throw new Exception("Cannot map module by address - address to low");
        }

        $baseAddress = $this->getBaseAddress($address);

        $module = $this->addressSpace[$baseAddress];

        if(($baseAddress+$module->getSize())<$address)
        {
            throw new Exception("Cannot map module by address - address to high");
        }

        return $module;
    }

    public function getRelativeAddress($address)
    {
        return $address->$this->getBaseAddress($address);
    }


    public function write($address,$byte)
    {
        $address &= $this->addressSpaceMask;

        $module = $this->getModuleByAddress($address);
        $module->write($this->getRelativeAddress($address),$byte);

        return $this;
    }
    public function read($address)
    {
        $address &= $this->addressSpaceMask;

        $module = $this->getModuleByAddress($address);
        return $module->read($this->getRelativeAddress($address));
    }
}
