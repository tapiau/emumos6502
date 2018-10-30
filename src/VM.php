<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 20:53
 */

class VM
{
    /** @var Memory */
    private $memory;

    /** @var CPU */
    private $cpu;


    public function setMemory(MemoryInterface $memory)
    {
        $this->memory = $memory;
    }

    public function setCPU(CPUInterface $cpu)
    {
        $this->cpu = $cpu;
        $this->cpu->setMemory($this->memory);
        $this->cpu->init();
    }

    public function loadFileToMemory($file,$addr)
    {
        $file = fopen($file,"r");

        while(!feof($file))
        {
            $byte = ord(fread($file,1));

            $this->memory->write($addr,$byte);
            $addr++;
        }

        return $this;
    }

    public function run($pc = null)
    {
        $this->cpu->reset();
        !is_null($pc) && $this->cpu->setPC($pc);

        $run = true;

        while($run)
        {
            try
            {
                $this->cpu->executeOne();
            }
            catch(Exception $e)
            {
                printr("Something gone wrong: ".$e->getMessage());
                $run = false;
            }
//            $this->cpu->printRegs();
        }
    }

    public function testSP()
    {
        $this->cpu->setSP(1);
        $this->cpu->printRegs();
        $this->cpu->setSP(257);
        $this->cpu->printRegs();
        $this->cpu->setSP(513);
        $this->cpu->printRegs();
        $this->cpu->setSP(511);
        $this->cpu->printRegs();
        $this->cpu->moveSP(1);
        $this->cpu->printRegs();
    }
}
