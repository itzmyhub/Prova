<?php

use \App\BowlingCalc\BowlingPontuationCalc;

beforeEach(function () {
   $this->bowlingPontuationCalc = new BowlingPontuationCalc([10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10]);
});


it('deve contabilizar um lance', function () {
    $result = $this->bowlingPontuationCalc->contabilizarLance();

    expect($result)->toBe(1);
});

it('deve retornar o score total do jogo', function () {
    $result = $this->bowlingPontuationCalc->score();

    expect($result)->toBe(0);
});

it('strike deve somar 10 + as duas próximas rodadas ao score', function () {
    $this->bowlingPontuationCalc->strike();

    $result = $this->bowlingPontuationCalc->score();

    expect($result)->toBe(30);
});

it('spare deve somar 10 (da rodada) + o próximo lance ao score total', function () {
    $bowling = new BowlingPontuationCalc([7,3, 5]);

    $bowling->spare();

    $result = $bowling->score();

    expect($result)->toBe(15);
});

it('rodada sem bonus deve somar a quantidade de pinos derrubados', function (){
    $bowling = new BowlingPontuationCalc([7,1, 5,3]);

    $bowling->somarPinosDerrubados();

    $result = $bowling->score();

    expect($result)->toBe(8);
});

it('deve pontuar 300 em um jogo perfeito', function () {
    for ($i = 0; $i < 10; $i++)
        $this->bowlingPontuationCalc->jogarRodada();

    $result = $this->bowlingPontuationCalc->score();
    expect($result)->toBe(300);
});

it('deve pontuar 133 em um jogo com spare e strike.', function () {
    $bowling = new BowlingPontuationCalc([1,4, 4,5, 6,4, 5,5, 10, 0,1, 7,3, 6,4, 10, 2,8, 6]);
    for ($i = 0; $i < 10; $i++)
        $bowling->jogarRodada();

    $result = $bowling->score();
    expect($result)->toBe(133);
});

it('deve pontuar 20 em um Jogo com um strike.', function () {
    $bowling = new BowlingPontuationCalc([0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 10, 2,3, 0,0 ]);
    for ($i = 0; $i < 10; $i++)
        $bowling->jogarRodada();

    $result = $bowling->score();
    expect($result)->toBe(20);
});

it('deve pontuar 17 em um Jogo com um spare.', function () {
    $bowling = new BowlingPontuationCalc([0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 2,8, 2,3, 0,0 ]);
    for ($i = 0; $i < 10; $i++)
        $bowling->jogarRodada();

    $result = $bowling->score();
    expect($result)->toBe(17);
});
