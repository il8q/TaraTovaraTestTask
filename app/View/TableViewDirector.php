<?php

namespace App\View;

class TableViewDirector
{
    public function __construct(
        private readonly TableViewBuilder $builder = new TableViewBuilder()
    )
    {
    }

    public function generate(string $title, array $table): string
    {
        $this->builder->resetResult();
        $this->builder->generateTitle($title);

        $this->builder->generateStartTableTag();
        $this->builder->generateHeaders($table['headers']);
        $this->builder->generateRows($table['rows']);
        $this->builder->generateEndTableTag();
        return $this->builder->getResult();
    }

}