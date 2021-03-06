<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Chigi\Sublime\Models\ReturnDataSpec;

use ArrayIterator;
use Chigi\Sublime\Enums\ReturnDataLevel;
use Chigi\Sublime\Models\BaseCommand;
use Chigi\Sublime\Models\BaseModel;
use Chigi\Sublime\Models\BaseReturnData;
use Chigi\Sublime\Models\Factory\ModelsFactory;

/**
 * QuickPanel 列表显示返回数据
 *
 * @author 郷
 */
class QuickPanelData extends BaseReturnData {

    /**
     *
     * @var ArrayIterator
     */
    private $itemCollection;

    public function __initial() {
        $this->itemCollection = new ArrayIterator();
        parent::__initial();
    }

    public function getItemCollection() {
        return $this->itemCollection;
    }

    public function pushItem(BaseModel $item) {
        $this->itemCollection->append($item);
        return $this;
    }

    /**
     * array
     */
    public function getData() {
        $item_list = array();
        foreach ($this->itemCollection as $model) {
            $item = array();
            try {
                if ($model instanceof BaseCommand && $model->isVisible()) {
                    // Panel 中展示用的文字
                    $item[0] = array(
                        $model->getTitle() ? $model->getTitle() : "UNKNOWN"
                    );
                    // 将真实数据本身存入
                    $item[1] = ModelsFactory::pushFormatter($model);
                    array_push($item[1][2], array());
                }
            } catch (Exception $exc) {
                executePush($exc);
                continue;
            }
            array_push($item_list, $item);
        }
        return $item_list;
    }

    public function setData($data) {
        unset($data);
        return $this;
    }
    public function getDataLevel() {
        return ReturnDataLevel::INFO;
    }

}
