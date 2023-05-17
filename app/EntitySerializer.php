<?php

namespace App;

use App\Entity\Income;

class EntitySerializer
{
    public static function serializeIncomeArray(array $array): array
    {
        $result = [];
        foreach ($array as $income) {
            $result[] = self::serializeToArray($income);
        }
        return $result;
    }

    public static function serializeToArray(Income $income): array
    {
        return [
            Income::ID_LABEL => $income->id,
            Income::AMOUNT_IN_LABEL => $income->amountIn,
            Income::AMOUNT_OUT_LABEL => $income->amountOut,
            Income::DATE_LABEL => date('Y-m-d', $income->date),
        ];
    }

    public static function serializeIncomesFromArray(?array $array): array
    {
        $result = [];
        if ($array) {
            foreach ($array as $item) {
                $result[] = self::serializeIncomeFromArray($item);
            }
        }
        return $result;
    }

    public static function serializeIncomeFromArray(array $array): Income
    {
        $result = new Income();
        $result->id = $array[Income::ID_LABEL];
        $result->amountIn = $array[Income::AMOUNT_IN_LABEL];
        $result->amountOut = $array[Income::AMOUNT_OUT_LABEL];
        $result->date = $array[Income::DATE_LABEL];
        return $result;
    }

    public static function serializeIncomeSegments(array $incomes, array $params): array
    {
        foreach ($incomes as &$row) {
            $startPeriod = &$row[$params['segmentationVariable']];
            $startPeriod *= $params['periodHash'];
            $startPeriod = sprintf(
                "%s - %s",
                date($params['dataFormat'], $startPeriod),
                date($params['dataFormat'], $startPeriod + $params['periodHash']),
            );
        }
        return $incomes;
    }
}