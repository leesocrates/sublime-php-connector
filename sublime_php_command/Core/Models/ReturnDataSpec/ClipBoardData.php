<?php

/*
 * Copyright 2014 郷.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Chigi\Sublime\Models\ReturnDataSpec;

use Chigi\Sublime\Enums\ReturnDataLevel;
use Chigi\Sublime\Models\BaseReturnData;

/**
 * 发送至系统剪贴板的数据
 *
 * @author 郷
 */
class ClipBoardData extends BaseReturnData {

    private $dataLevel = ReturnDataLevel::SUCCESS;

    public function getDataLevel() {
        return $this->dataLevel;
    }

    public function setDataLevel($dataLevel) {
        $this->dataLevel = $dataLevel;
        return $this;
    }

}
