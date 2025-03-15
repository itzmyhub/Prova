<?php

namespace App\BowlingCalc;
class BowlingPontuationCalc
{
    private array $partidaDeBoliche;

    private int $lance = 0;

    private int $score = 0;

    public function __construct(array $partidaDeBoliche)
    {
        $this->partidaDeBoliche = $partidaDeBoliche;
    }

    public function contabilizarLance(): int
    {
        return $this->lance += 1;
    }

    public function jogarRodada() {
        if($this->partidaDeBoliche[$this->lance] == 10) //strike
            $this->strike();
        else if($this->partidaDeBoliche[$this->lance] + $this->partidaDeBoliche[$this->lance + 1] == 10) // spare
            $this->spare();
        else
            $this->somarPinosDerrubados();
    }

    public function score()
    {
        return $this->score;
    }

    public function strike()
    {
        $this->score += 10 + $this->partidaDeBoliche[$this->lance + 1] + $this->partidaDeBoliche[$this->lance + 2];
        $this->contabilizarLance();
    }

    public function spare()
    {
        $this->score += 10 + $this->partidaDeBoliche[$this->lance + 2];
        $this->contabilizarLance();
        $this->contabilizarLance();
    }

    public function somarPinosDerrubados()
    {
        $this->score += $this->partidaDeBoliche[$this->lance] + $this->partidaDeBoliche[$this->lance + 1];
        $this->contabilizarLance();
        $this->contabilizarLance();
    }

}
