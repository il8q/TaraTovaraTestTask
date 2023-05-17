<?php

namespace App;

use App\View\TableViewDirector;
use Simplon\Mysql\MysqlException;

class PageBuilder
{
    public function __construct(
        private readonly TableGenerator    $tableGenerator = new TableGenerator(),
        private readonly TableViewDirector $tableViewGenerator = new TableViewDirector(),
        private string                     $result = '',
        private string                     $bodyContent = '',
        private ?int                       $currentDayTime = null,
    )
    {
    }

    public function resetVariables(): void
    {
        $this->result = '';
        $this->bodyContent = '';
        $this->currentDayTime = null;
    }

    public function addStartTag(): void
    {
        $this->result .= "<!DOCTYPE HTML>";
    }

    /**
     * @param string|null $title
     * @return void
     */
    public function addHeader(?string $title): void
    {
        $header = '<head>';
        if ($title) {
            $header .= "<title>$title</title>";
        }
        $header .= '</head>';

        $this->result .= $header;
    }

    /**
     * @param string|null $title
     * @return void
     */
    public function generateAndAddBody(?string $title): void
    {
        $bodyTag = "<body>";
        if ($title) {
            $bodyTag .= "<h1>$title</h1><p>";
        }
        if ($this->bodyContent) {
            $bodyTag .= $this->bodyContent;
        }
        $bodyTag .= "</body>";

        $this->result .= $bodyTag;
        $this->bodyContent = '';
    }

    public function addStartHtmlTag(): void
    {
        $this->result .= "<html lang=\"ru\">";
    }

    public function addEndHtmlTag(): void
    {
        $this->result .= "</html>";
    }

    /**
     * @throws MysqlException
     */
    public function addDayTableToBody(): void
    {
        $currentDayTable = $this->tableViewGenerator->generate(
            'За день',
            $this->tableGenerator->generateForCurrentDay($this->currentDayTime)
        );

        $this->bodyContent .= $currentDayTable;
    }

    public function addDividerToBody(): void
    {
        $this->bodyContent .= "<p>";
    }

    /**
     * @throws MysqlException
     */
    public function addWeekTableToBody(): void
    {
        $currentWeekTable = $this->tableViewGenerator->generate(
            'За неделю',
            $this->tableGenerator->generateForCurrentWeek($this->currentDayTime)
        );

        $this->bodyContent .= $currentWeekTable;
    }

    /**
     * @throws MysqlException
     */
    public function addMonthTable(): void
    {
        $currentMonthTable =  $this->tableViewGenerator->generate(
            'За месяц',
            $this->tableGenerator->generateForCurrentMonth($this->currentDayTime)
        );

        $this->bodyContent .= $currentMonthTable;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function setCurrentDayTime(int $currentDayTime): void
    {
        $this->currentDayTime = $currentDayTime;
    }
}