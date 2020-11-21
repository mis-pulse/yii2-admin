<?php

namespace mdm\admin\models\searchs;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class User extends Model
{
    public $id;
    public $username;
    public $status;
    public $worker_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status','worker_id'], 'integer'],
            [['username'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        /* @var $query \yii\db\ActiveQuery */
        $class = Yii::$app->getUser()->identityClass ? : 'mdm\admin\models\User';
        $query = $class::find()->joinWith('worker');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['status' => SORT_DESC,'username'=>SORT_ASC]],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user.id' => $this->id,
            'status' => $this->status,
            'worker.id' => $this->worker_id,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
