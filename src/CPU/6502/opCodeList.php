<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 22:14
 */

class CPU_6502_opCodeList
{
    private $map = [
        0x00=>[
            'mnemonic'=>'BRK',
            'call'=>'interrupt',
            'mode'=>'',
            'bytes'=>1,
            'ticks'=>7
        ],
        0x01=>[
            'mnemonic'=>'ORA',
            'call'=>'math',
            'mode'=>'izx',
            'bytes'=>2,
            'ticks'=>6
        ],
        0x02=>[ // 65C816
            'mnemonic'=>'KIL',
            'call'=>'interrupt',
            'mode'=>'',
            'bytes'=>1,
            'ticks'=>0
        ],
        0x03=>[ // 65C816
            'mnemonic'=>'KIL',
            'call'=>'interrupt',
            'mode'=>'izx',
            'bytes'=>1,
            'ticks'=>0
        ],
        0x04=>[ // 65C816
            'mnemonic'=>'NOP',
            'call'=>'interrupt',
            'mode'=>'imm',
            'bytes'=>1,
            'ticks'=>0
        ],




        0xA9=>[
            'mnemonic'=>'LDA',
            'call'=>'loadRegister',
            'mode'=>'imm',
            'bytes'=>2
        ],
        0xA2=>[
            'mnemonic'=>'LDX',
            'call'=>'loadRegister',
            'mode'=>'imm',
            'bytes'=>2
        ],
        0xA0=>[
            'mnemonic'=>'LDY',
            'call'=>'loadRegister',
            'mode'=>'imm',
            'bytes'=>2
        ],
        0xA5=>[
            'mnemonic'=>'LDA',
            'call'=>'loadRegister',
            'mode'=>'zp',
            'bytes'=>2
        ],
        0xA6=>[
            'mnemonic'=>'LDX',
            'call'=>'loadRegister',
            'mode'=>'zp',
            'bytes'=>2
        ],
        0xA4=>[
            'mnemonic'=>'LDY',
            'call'=>'loadRegister',
            'mode'=>'zp',
            'bytes'=>2
        ],
        0x85=>[
            'mnemonic'=>'STA',
            'call'=>'saveRegister',
            'mode'=>'zp',
            'bytes'=>2
        ],
        0x86=>[
            'mnemonic'=>'STX',
            'call'=>'saveRegister',
            'mode'=>'zp',
            'bytes'=>2
        ],
        0x84=>[
            'mnemonic'=>'STY',
            'call'=>'saveRegister',
            'mode'=>'zp',
            'bytes'=>2
        ]
    ];

    public function decode($opCode)
    {
        if(!array_key_exists($opCode,$this->map))
        {
            throw new Exception("NONEXISTENT OPCODE!");
        }

        return new opCode($opCode,$this->map[$opCode]);
    }
}
