<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Order]].
 *
 * @see Order
 */
class OrderQuery extends ActiveQuery
{
    public function getFilterData(): array
    {
        return $this->select([
                'extract(year from created_at) as y_date',
                'extract(month from created_at) as m_date',
                'count(*) as total'
            ])
            ->orderBy('y_date DESC, m_date DESC')
            ->groupBy('y_date, m_date')->asArray()->all();
    }
    
    /**
     * {@inheritdoc}
     * @return Order[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
