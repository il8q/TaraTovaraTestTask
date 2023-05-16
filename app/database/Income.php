<?php

namespace App\database;

class Income
{
    const TABLE_NAME = 'income';
    const ID_LABEL = 'id';
    const DATE_LABEL = 'date';
    const AMOUNT_IN_LABEL = 'amount_in';
    const AMOUNT_OUT_LABEL = 'amount_out';

    public int $id;
    public int $date;
    public int $amountIn;
    public int $amountOut;
}