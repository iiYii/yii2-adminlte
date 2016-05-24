<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2015/12/29 15:33
 * description:
 */

namespace common\components;

use yii\base\InvalidParamException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;


/**
 *
 * 使用 demo
 *
 * $searchModel = new SearchModel([
 *     'defaultOrder' => ['id' => SORT_DESC],
 *     'model' => Post::className(),
 *     'scenario' => 'default',
 * ]);
 *
 * return $this->render('index', [
 *     'dataProvider' => $searchModel->search(Yii::$app->getRequest()->get()),
 * ]);
 * Class SearchModel
 * @package common\components
 */
class SearchModel extends Model
{
    private $attributes;
    private $internalRelations;
    private $model;
    private $modelClassName;
    private $relationAttributes = [];
    private $rules;
    private $scenarios;
    public $defaultOrder;
    public $groupBy;
    public $pageSize = 20;
    public $partialMatchAttributes = []; // 模糊查询
    public $relations = [];

    /**
     * @param ActiveQuery $query
     * @param string $attribute
     * @param bool $partialMath
     */
    private function addCondition($query, $attribute, $partialMath = false)
    {
        if (isset($this->relationAttributes[$attribute])) {
            $attributeName = $this->relationAttributes[$attribute];
        } else {
            $attributeName = call_user_func([$this->modelClassName, 'tableName']) . '.' . $attribute;
        }
        $value = $this->$attribute;
        if ($value === '') {
            return;
        }
        if ($partialMath) {
            $query->andWhere(['like', $attributeName, trim($value)]);
        } else {
            $query->andWhere($this->conditionTrans($attributeName, $value));
        }
    }

    /**
     * 可以查询大于小于
     * @param $attributeName
     * @param $value
     * @return array
     */
    private function conditionTrans($attributeName, $value)
    {
        switch (true) {
            case is_array($value):
                return [$attributeName => $value];
            case stripos($value, '>=') !== false:
                return ['>=', $attributeName, substr($value, 2)];
                break;
            case stripos($value, '<=') !== false:
                return ['<=', $attributeName, substr($value, 2)];
                break;
            case stripos($value, '<') !== false:
                return ['<', $attributeName, substr($value, 1)];
                break;
            case stripos($value, '>') !== false:
                return ['>', $attributeName, substr($value, 1)];
                break;
            default:
                return [$attributeName => $value];
                break;
        }
    }

    /**
     * @param array $params
     * @throws \yii\base\InvalidParamException
     */
    public function __construct($params)
    {
        $this->scenario = 'search';
        parent::__construct($params);
        if ($this->model === null) {
            throw new InvalidParamException('Param "model" cannot be empty');
        }
        $this->rules = $this->model->rules();
        $this->scenarios = $this->model->scenarios();
        foreach ($this->safeAttributes() as $attribute) {
            $this->attributes[$attribute] = '';
        }
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        return parent::__get($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (isset($this->attributes[$name])) {
            $this->attributes[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $value
     */
    public function setModel($value)
    {
        if ($value instanceof Model) {
            $this->model = $value;
            $this->scenario = $this->model->scenario;
            $this->modelClassName = get_class($value);
        } else {
            $this->model = new $value;
            $this->modelClassName = $value;
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        return $this->scenarios;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = call_user_func([$this->modelClassName, 'find']);
        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => new Pagination(
                    [
                        'forcePageParam' => false,
                        'pageSize' => $this->pageSize,
                    ]
                ),
            ]
        );
        if (is_array($this->relations)) {
            foreach ($this->relations as $relation => $attributes) {
                $pieces = explode('.', $relation);
                $path = '';
                $parentPath = '';
                foreach ($pieces as $i => $piece) {
                    if ($i == 0) {
                        $path = $piece;
                    } else {
                        $parentPath = $path;
                        $path .= '.' . $piece;
                    }
                    if (!isset($this->internalRelations[$path])) {
                        if ($i == 0) {
                            $relationClass = call_user_func([$this->model, 'get' . $piece]);
                        } else {
                            $className = $this->internalRelations[$parentPath]['className'];
                            $relationClass = call_user_func([new $className, 'get' . $piece]);
                        }
                        $this->internalRelations[$path] = [
                            'className' => $relationClass->modelClass,
                            'tableName' => call_user_func([$relationClass->modelClass, 'tableName']),
                        ];
                    }
                }
                foreach ((array)$attributes as $attribute) {
                    $attributeName = str_replace('.', '_', $relation) . '_' . $attribute;
                    $tableAttribute = $this->internalRelations[$relation]['tableName'] . '.' . $attribute;
                    $this->rules[] = [$attributeName, 'safe'];
                    $this->scenarios[$this->scenario][] = $attributeName;
                    $this->attributes[$attributeName] = '';
                    $this->relationAttributes[$attributeName] = $tableAttribute;
                    $dataProvider->sort->attributes[$attributeName] = [
                        'asc' => [$tableAttribute => SORT_ASC],
                        'desc' => [$tableAttribute => SORT_DESC],
                    ];
                }
            }
            $query->joinWith(array_keys($this->relations));
        }
        if (is_array($this->defaultOrder)) {
            $dataProvider->sort->defaultOrder = $this->defaultOrder;
        }
        if (is_array($this->groupBy)) {
            $query->addGroupBy($this->groupBy);
        }
        $this->load($params);
        foreach ($this->attributes as $name => $value) {
            $this->addCondition($query, $name, in_array($name, $this->partialMatchAttributes));
        }
        return $dataProvider;
    }
}