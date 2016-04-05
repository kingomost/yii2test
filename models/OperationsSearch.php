<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Operations;
/**
 * OperationsSearch represents the model behind the search form about `app\models\Operations`.
 */
class OperationsSearch extends Operations
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'start_time', 'finish_time', 'status'], 'integer'],
            [['ip_first', 'ip_second', 'valute', 'tip', 'secret'], 'safe'],
            [['summa'], 'number'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Operations::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'start_time' => $this->start_time,
            'finish_time' => $this->finish_time,
            'status' => $this->status,
            'summa' => $this->summa,
        ]);
        $query->andFilterWhere(['like', 'ip_first', $this->ip_first])
            ->andFilterWhere(['like', 'ip_second', $this->ip_second])
            ->andFilterWhere(['like', 'valute', $this->valute])
            ->andFilterWhere(['like', 'tip', $this->tip])
            ->andFilterWhere(['like', 'secret', $this->secret]);
        return $dataProvider;
    }
}