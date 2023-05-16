<?php

namespace App\database;

use Simplon\Mysql\Crud\CrudModel;

class IncomeTableRow extends CrudModel
{
    const TABLE_NAME = 'income';
    const COLUMN_ID = 'id';
    const COLUMN_DATE = 'date';
    const COLUMN_AMOUNT_IN = 'amount_in';
    const COLUMN_AMOUNT_OUT = 'amount_out';

    protected int $id;
    protected int $date;
    protected int $amountIn;
    protected int $amountOut;

    /**
     * @return int
     */
    public function getId(): int
    {
        return (int)$this->id;
    }

    /**
     * @param int $id
     *
     * @return IncomeTableRow
     */
    public function setId(int $id): IncomeTableRow
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param int $date
     * @return IncomeTableRow
     */
    public function setDate(int $date): IncomeTableRow
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmountIn(): int
    {
        return (int)$this->amountIn;
    }

    /**
     * @param int $amountIn
     * @return IncomeTableRow
     */
    public function setAmountIn(int $amountIn): IncomeTableRow
    {
        $this->amountIn = $amountIn;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmountOut(): int
    {
        return (int)$this->amountOut;
    }

    /**
     * @param int $amountOut
     * @return IncomeTableRow
     */
    public function setAmountOut(int $amountOut): IncomeTableRow
    {
        $this->amountOut = $amountOut;
        return $this;
    }
}