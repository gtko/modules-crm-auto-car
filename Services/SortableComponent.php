<?php

namespace Modules\CrmAutoCar\Services;

trait SortableComponent
{

    public $order = 'created_at';
    public $direction = 'asc';

    public function sort($order, $direction = null){
        if($this->order !== $order){
            $this->direction = '--';
        }

        $this->order = $order;
        switch($this->direction){
            case 'asc' :
                $this->direction = 'desc';
                break;
            case 'desc' :
                $this->direction = '--';
                break;
            case '--' :
            default :
                $this->direction = 'asc';
                break;
        }
    }


    protected function querySort($query, $colsQuery){

        if(($colsQuery[$this->order] ?? false) && is_callable($colsQuery[$this->order])) {

            $direction = $this->direction;
            if($direction !== '--'){
                $colsQuery[$this->order]($query, $direction);
            }
        }
    }

}
