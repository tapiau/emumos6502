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
$vm->loadFileToRam($argv[1],0xC000);

$vm->run(0xC000);
