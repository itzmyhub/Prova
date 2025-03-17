<?php

namespace App\Http\Enums;

enum MetodoPagamento: string
{
    case PIX = 'Pix';
    case CARTAO_BLACK = 'Cartão Black';
    case CARTAO_AMAZON = 'Cartão Amazon';
    case CARTAO_INTER = 'Cartão Inter';

}
