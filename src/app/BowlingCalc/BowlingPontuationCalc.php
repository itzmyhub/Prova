<?php

namespace App\BowlingCalc;
class BowlingPontuationCalc
{
    private array $partidaDeBoliche;

    private int $lance = 0;

    private int $rodada = 1;

    private int $score = 0;

    private bool $striked = false;

    private bool $spared = false;

    public function __construct(array $partidaDeBoliche)
    {
        $this->partidaDeBoliche = $partidaDeBoliche;
    }

    public function contabilizarLance(): int
    {
        $this->verificaStrike();
        $this->verificarTerminoDaRodada();
        $this->somaScoreTotal();
        $this->spared = false;
        return $this->lance++;
    }

    public function contabilizarRodada(): int
    {
        return $this->rodada++;
    }

    public function verificarTerminoDaRodada(): bool
    {
        if($this->lance % 2 == 0 && $this->lance != 0){
            $this->verificaSpare();
            $this->striked = false;
            $this->rodada++;
            return true;
        }
        if($this->verificaStrike()) {
            $this->rodada++;
            return true;
        }
        return false;
    }

    public function somaScoreTotal(): int
    {
        if($this->spared || $this -> striked)
            $this->score += $this->partidaDeBoliche[$this->lance] * 2;
        return $this->score += $this->partidaDeBoliche[$this->lance];
    }

    public function verificaStrike(): bool
    {
        if ($this->partidaDeBoliche[$this->lance] == 10) {
            return $this->striked = true;
        }
        return false;
    }

    public function verificaSpare()
    {
        if (($this->partidaDeBoliche[$this->lance] + $this->partidaDeBoliche[$this->lance-1] == 10)) {
            return $this->spared = true;
        }
        return false;
    }

    public function valorTotalDoJogo()
    {
        return $this->score;
    }


}
