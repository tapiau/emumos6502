<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 20:53
 */

class CPU
{
    /** @var Memory */
    private $memory;

    /* REGISTERS */
    private $A = 0;
    private $SP = 0x0100;
    private $PC = 0x0000;

    /* FLAGS */
    /** @var bool */
    private $N = false;
    /** @var bool */
    private $V = false;
    /** @var bool */
    private $B = false;
    /** @var bool */
    private $D = false;
    /** @var bool */
    private $I = false;
    /** @var bool */
    private $Z = false;
    /** @var bool */
    private $C = false;

    /* INTERNAL STATUS */
    private $ticks = 0;
    /** @var opCodeList */
    private $opCodeDecoder;

    public function __construct($opCodeDecoder)
    {
        $self = get_called_class();
        $this->PC = $this->readWord($self::VECTOR_RESET);

        $this->opCodeDecoder = $opCodeDecoder;
    }

    public function reset()
    {
        $self = get_called_class();

        $this->PC = $this->readWord($self::VECTOR_RESET);

        $this->A = 0;
        $this->X = 0;
        $this->SP = self::CONST_SP;

        $this->N = false;
        $this->V = false;
        $this->B = false;
        $this->D = false;
        $this->I = false;
        $this->Z = false;
        $this->C = false;

        $this->ticks = 0;
    }

    public function setPC($address)
    {
        $this->PC = $address & 0xFFFF;
    }
    public function movePC($bytes)
    {
        $this->setPC($this->PC+$bytes);
    }
    public function setSP($address)
    {
        $this->SP = $address;
    }
    public function moveSP($bytes)
    {
        $this->setSP($this->SP+$bytes);
    }

    public function executeOne()
    {
        $byte = $this->ram->read($this->PC);

        try
        {
            $op = $this->opCodeDecoder->decode($byte);
        }
        catch(Exception $e)
        {
            printr($this->printRegs());
            die("FATAL ERROR: ".$e->getMessage());
        }

        $this->disasm($this->PC);

        $this->{$op->call}($op);
    }

    public function getRam()
    {
        return $this->memory;
    }

    public function printRegs()
    {
        printr(
            "A: {$this->A}".PHP_EOL.
            "X: {$this->X}".PHP_EOL.
            "Y: {$this->Y}".PHP_EOL.
            "SP: {$this->SP}".PHP_EOL.
            "PC: {$this->PC}".PHP_EOL.
            "MEM: {$this->memory->read($this->PC)}"
        );
    }

    public function memoryRead($mode,$addr)
	{
		switch($mode)
		{
			case 'imm':
				$value = $this->memory->read($addr);
				break;
			case 'zp':
				$addr = $this->memory->read($addr);
				$value = $this->memory->read($addr);
				break;
		}

		return $value;
	}

	public function read($addr)
	{
		return $this->memory->read($addr);
	}

	public function write($addr,$value)
	{
		$this->memory->write($addr,$value);
	}
	public function writeWord($addr,$word)
	{
		$this->write($addr,$word & 0xFF);
		$this->write($addr+1,$word >> 8);

		return $this;
	}
	public function readWord($addr)
	{
		return $this->read($addr)+$this->read($addr+1)<<8;
	}


	public function memoryWrite($mode,$addr,$value)
	{
		switch($mode)
		{
			case 'zp':
				$addr = $this->memory->read($addr);
				break;
		}

		$this->memory->write($addr,$value);
	}

    public function loadRegister(opCode $op)
    {
        $reg = substr($op->mnemonic,-1);

        $this->{$reg} = $this->memoryRead($op->mode,$this->PC+1);

        $this->movePC($op->bytes);
    }

    public function saveRegister(opCode $op)
    {
        $reg = substr($op->mnemonic,-1);

        $this->memoryWrite($op->mode,$this->PC+1,$this->{$reg});

        $this->movePC($op->bytes);
    }

    public function disasm($addr)
    {
        $byte = $this->memory->read($addr);
        $op = $this->opCodeDecoder->decode($byte);

        $line = $op->mnemonic;
        $line .= ' ';

        switch($op->mode)
        {
            case 'zp':
                    $value = $this->memory->read($this->PC+1);
                break;
            case 'imm':
                    $line .='#';
                    $value = $this->memory->read($this->PC+1);
                break;
        }

        $line .= '$';
        $line .= dechex($value);

        printr($line);
    }

}