<?php

namespace app\helpers;

use app\forms\OrderFilterForm;
use yii\helpers\Html;

class OrderFilterHelper
{
    public static function renderFilterMenu(OrderFilterForm $form): string
    {
        $menu = '';
        foreach ($form->periods as $year => $period) {
            $menu .= Html::a(
                    $year . ' (' . array_sum(array_column($period, 'total')) . ')',
                    ['order/index'],
                    [
                        'data' => [
                            'data-pjax' => 1,
                            'method'    => 'get',
                            'params'    => [
                                'year' => $year,
                            ],
                        ],
                    ]
                ) . '<br/>';
            
            foreach ($period as $month) {
                $menu .= Html::tag('span', '--- ') . Html::a(
                        static::getMonthName($month['m_date']) . ' (' . $month['total'] . ')',
                        ['order/index'],
                        [
                            'data' => [
                                'data-pjax' => 1,
                                'method'    => 'get',
                                'params'    => [
                                    'year' => $year,
                                    'month' => (int) $month['m_date'],
                                ],
                            ],
                        ]
                    ) . '<br/>';
            }
        }
        
        return $menu;
    }
    
    public static function getMonthName(int $number): ?string
    {
        switch ($number) {
            case 1:
                return 'январь';
            case 2:
                return 'февраль';
            case 3:
                return 'март';
            case 4:
                return 'апрель';
            case 5:
                return 'май';
            case 6:
                return 'июнь';
            case 7:
                return 'июль';
            case 8:
                return 'август';
            case 9:
                return 'сентябрь';
            case 10:
                return 'октябрь';
            case 11:
                return 'ноябрь';
            case 12:
                return 'декабрь';
        }
        
        return null;
    }
}