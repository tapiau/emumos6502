<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 20:57
 */

require_once('src/func.php');

if($argc!=2)
{
    die("Usage: emu6502.php FILENAME".PHP_EOL);
}

$fileName = $argv[1];

if(!file_exists($fileName))
{
    die("File '{$fileName}' not exists!".PHP_EOL);
}

$vm = new VM();

$mmu = new MMU();
$mmu->addNamedModule('ROM0',new Memory_ROM(16384));
$mmu->addNamedModule('RAM0',new Memory_RAM(16384));
$mmu->addNamedModule('RAM1',new Memory_RAM(16384));
$mmu->addNamedModule('RAM2',new Memory_RAM(16384));
$mmu->addNamedModule('RAM3',new Memory_RAM(16384));
$mmu->mapModuleByNameToAddressSpace('RAM0',0);
$mmu->mapModuleByNameToAddressSpace('ROM0',0);
$mmu->mapModuleByNameToAddressSpace('RAM2',0);
$mmu->mapModuleByNameToAddressSpace('RAM3',0);

$vm->setMemory($mmu);
$vm->setCPU(new CPU_6502());
$vm->loadFileToRam($fileName,0xC000);

$vm->run(0xC000);
