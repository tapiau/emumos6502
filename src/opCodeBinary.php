<?php
/**
 * Created by PhpStorm.
 * User: goha
 * Date: 08.03.2018
 * Time: 22:14
 */

class opCodeBinary
{
    public $mnemonic = [
        0b01 => [
            0b000=>'ORA',
            0b001=>'AND',
            0b010=>'EOR',
            0b011=>'ADC',
            0b100=>'STA',
            0b101=>'LDA',
            0b110=>'CMP',
            0b111=>'SBC'
        ],
        0b10 =>[
            0b000=>'ASL',
            0b001=>'ROL',
            0b010=>'LSR',
            0b011=>'ROR',
            0b100=>'STX',
            0b101=>'LDX',
            0b110=>'DEC',
            0b111=>'INC'
        ],
        0b00 =>[
            0b001=>'BIT',
            0b010=>'JMP',
            0b011=>'JMP (abs)',
            0b100=>'STY',
            0b101=>'LDY',
            0b110=>'CPY',
            0b111=>'CPX'
        ]
    ];
    public $mode =[
        0b01 => [
            0b000=>'izx', // (zero page,X)
            0b001=>'zp',  // zero page
            0b010=>'imm', // #immediate
            0b011=>'abs', // absolute
            0b100=>'izy', // (zero page),Y
            0b101=>'zpx', // zero page,X
            0b110=>'aby', // absolute,Y
            0b111=>'abx'  // absolute,X
        ],
        0b10 =>[
            0b000=>'imm', // #immediate
            0b001=>'zp',  // zero page
            0b010=>'acc', // accumulator
            0b011=>'abs', // absolute
            0b101=>'zpx', // zero page,X
            0b111=>'abx'  // absolute,X
        ],
        0b00 =>[
            0b000=>'imm', // #immediate
            0b001=>'zp',  // zero page
            0b011=>'abs', // absolute
            0b101=>'zpx', // zero page,X
            0b111=>'abx'  // absolute,X
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
