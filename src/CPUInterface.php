<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 20:53
 */

interface CPUInterface
{
    const VECTOR_NMI = 0xFFFA;
    const VECTOR_RESET = 0xFFFC;
    const VECTOR_IRQ = 0xFFFE;

    public function __construct();

    public function setMemory();
    public function init();

    public function reset();


    public function setPC($address);
    public function movePC($bytes);
    public function setSP($address);
    public function moveSP($bytes);
    public function executeOne();
    public function getRam();

    public function printRegs();

    public function memoryRead($mode,$addr);
	public function read($addr);

	public function write($addr,$value);
	public function writeWord($addr,$word);
	public function readWord($addr);

	public function memoryWrite($mode,$addr,$value);

    public function loadRegister(opCode $op);
    public function saveRegister(opCode $op);

    public function disasm($addr);
}