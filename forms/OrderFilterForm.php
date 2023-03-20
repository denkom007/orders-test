<?php


namespace app\forms;

use app\models\Order;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class OrderFilterForm extends Model
{
    private array $_preparedData;
    public array $years;
    public array $periods;
    
    public $year = null;
    public $month = null;
    public $page = null;
    
    public function __construct($className = Order::class, $config = [])
    {
        parent::__construct($config);
        
        $this->_preparedData = $className::find()->getFilterData();
        $this->periods = ArrayHelper::index($this->_preparedData, 'm_date', 'y_date');
        $this->years = array_keys($this->periods);
    }
    
    public function rules(): array
    {
        return [
            [['year', 'month', 'page'], 'integer', 'skipOnEmpty' => true],
            [['year', 'month'], 'filterValidator'],
        ];
    }
    
    /**
     * @throws InvalidConfigException
     */
    public function getDataProvider()
    {
        return Yii::createObject(
            [
                'class'      => ActiveDataProvider::class,
                'query'      => $this->getQuery(),
                'pagination' => [
                    'pageSize' => 10,
                    'page'     => (!empty($this->page) && ($this->page > 0)) ? $this->page - 1 : 0,
                ],
                'sort'       => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ],
                ],
            ]
        );
    }
    
    private function getQuery(): ActiveQuery
    {
        $query = Order::find()
            ->andFilterWhere(['extract(year from created_at)' => $this->year]);
        
        if (!empty($this->month)) {
            $query->andFilterWhere(['extract(month from created_at)' => $this->month]);
        }
        
        return $query;
    }
    
    public function filterValidator()
    {
        if (!empty($this->year) && !in_array($this->year, $this->years)) {
            $this->addError($this->year, Yii::t('app', 'По данному году нет статистики'));
        }
        
        if (!empty($this->month) && empty($this->periods[$this->year][$this->month])) {
            $this->addError($this->month, Yii::t('app', 'По месяцу нет статистики'));
        }
    }
    
    public function formName(): string
    {
        return '';
    }
}