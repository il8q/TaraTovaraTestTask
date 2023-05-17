<?php

namespace App;

use Simplon\Mysql\MysqlException;

class PageDirector
{
    public function __construct(
        private readonly PageBuilder $builder,
    )
    {
    }

    /**
     * @throws MysqlException
     */
    public function construct(string $title, int $currentDayTime): string
    {
        $this->builder->resetVariables();
        $this->builder->setCurrentDayTime($currentDayTime);

        $this->builder->addStartTag();
        $this->builder->addStartHtmlTag();
        $this->builder->addHeader($title);

        $this->builder->addMonthTable();
        $this->builder->addDividerToBody();

        $this->builder->addWeekTableToBody();
        $this->builder->addDividerToBody();

        $this->builder->addDayTableToBody();
        $this->builder->addDividerToBody();

        $this->builder->generateAndAddBody($title);

        $this->builder->addEndHtmlTag();
        return $this->builder->getResult();
    }
}