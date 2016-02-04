<?php

namespace kotchuprik\sortable\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;

class Sortable extends Behavior
{
    /** @var Query */
    public $query;

    /**
     * @var array $where
     */
    public $where = null;

    /** @var string */
    public $orderAttribute = 'order';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ];
    }

    public function beforeInsert()
    {
        if (!is_null($this->where)) {
            if (!is_array($this->where)) {
                $this->where = array($this->where);
            }
            foreach ($this->where as $where) {
                $this->query->andWhere([$where => $this->owner->{$where}]);
            }
        }
        $last = $this->query->orderBy([$this->orderAttribute => SORT_DESC])->limit(1)->one();
        if ($last === null) {
            $this->owner->{$this->orderAttribute} = 1;
        } else {
            $this->owner->{$this->orderAttribute} = $last->{$this->orderAttribute} + 1;
        }
    }
}
