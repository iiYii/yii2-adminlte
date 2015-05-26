<?php

namespace backend\modules\srbac\models;

use Yii;
use yii\base\Exception;
use yii\base\InvalidValueException;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 */
class AuthItem extends \yii\db\ActiveRecord
{
    /**
     * Auth type
     */
    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            ['name', 'validatePermission'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    public function validatePermission()
    {
        if (!$this->hasErrors()) {
            $auth = Yii::$app->getAuthManager();
            if ($this->isNewRecord && $auth->getPermission($this->name)) {
                $this->addError('name', Yii::t('auth', 'This name already exists.'));
            }
            if ($this->isNewRecord && $auth->getRole($this->name)) {
                $this->addError('name', Yii::t('auth', 'This name already exists.'));
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Keyword'),
            'type' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Role Name'),
            'rule_name' => Yii::t('app', 'Rule Name'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * 添加角色
     * @return bool
     * @throws Exception
     */
    public function createRole()
    {
        if ($this->validate()) {
            $auth = Yii::$app->getAuthManager();
            $role = $auth->createRole($this->name);
            $role->description = $this->description;
            $role->ruleName = $this->rule_name;
            $role->data = $this->data;

            if ($auth->add($role)) {
                return true;
            }
        }

        throw new InvalidValueException(array_values($this->getFirstErrors())[0]);
    }

    /**
     * 更新角色
     * @param $name
     * @return bool
     * @throws Exception
     */
    public function updateRole($name)
    {
        if ($this->validate()) {
            $auth = Yii::$app->getAuthManager();
            $role = $auth->getRole($name);
            $role->description = $this->description;
            $role->ruleName = $this->rule_name;
            $role->data = $this->data;

            if ($auth->update($name, $role)) {
                return true;
            }
        }
        throw new InvalidValueException(array_values($this->getFirstErrors())[0]);
    }
}
