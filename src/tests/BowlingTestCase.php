<?php

namespace Tests;

use App\BowlingCalc\BowlingPontuationCalc;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class BowlingTestCase extends BaseTestCase
{
    private BowlingPontuationCalc $bowlingPontuationCalc;
}
