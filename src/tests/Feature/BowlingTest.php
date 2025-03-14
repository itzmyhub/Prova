<?php

use \App\BowlingCalc\BowlingPontuationCalc;

beforeEach(function () {
   $this->bowlingPontuationCalc = new BowlingPontuationCalc([10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10]);
});


it('deve contabilizar um lance', function () {
    $result = $this->bowlingPontuationCalc->contabilizarLance();

    expect($result)->toBeInt(1);
});

it('deve contabilizar uma rodada', function () {
    $result = $this->bowlingPontuationCalc->contabilizarRodada();

    expect($result)->toBeInt(2);
});

it('deve verificar se uma rodada acabou (true case)', function() {
   $result = $this->bowlingPontuationCalc->verificarTerminoDaRodada();

   expect($result)->toBeTrue();
});

it('deve acrescentar o valor do lance ao score', function () {
    $result = $this->bowlingPontuationCalc->somaScoreTotal();

    expect($result)->toBeInt(10);
});

it('verifica strike no lance', function () {
   $result = $this->bowlingPontuationCalc->verificaStrike();

   expect($result)->toBeTrue();
});

it('verifica spare na rodada', function () {
   $bowling = new BowlingPontuationCalc([7, 3, 10]);
   $bowling->contabilizarLance();
   $result = $bowling->verificaSpare();

   expect($result)->toBeTrue();
});

it('verifica pontuação completa em um jogo perfeito', function () {
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();
    $this->bowlingPontuationCalc->contabilizarLance();

    $result = $this->bowlingPontuationCalc->valorTotalDoJogo();

    expect($result)->toBeInt(300);
});

it('verifica pontuação de jogo com um strike', function () {
   $bowling = new BowlingPontuationCalc([0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 10, 2,3, 0,0]);

   $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();

    $result = $bowling->valorTotalDoJogo();

    expect($result)->toBeInt(20);
});

it('verifica pontuação de jogo com um spare', function () {
    $bowling = new BowlingPontuationCalc([0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 0,0, 2,8, 2,3, 0,0]);

    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();

    $result = $bowling->valorTotalDoJogo();

    expect($result)->toBeInt(17);
});

it('verifica pontuação de jogo com com spare e strike', function () {
    $bowling = new BowlingPontuationCalc([1,4, 4,5, 6,4, 5,5, 10, 0,1, 7,3, 6,4, 10, 2,8, 6]);

    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();
    $bowling->contabilizarLance();

    $result = $bowling->valorTotalDoJogo();

    expect($result)->toBeInt(133);
});
