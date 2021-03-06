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
namespace Chigi\Sublime\Models\Interfaces;
/**
 * Sublime 指令调用实现接口<br/>
 * 即针对于直接调用 Sublime 自身所提供的 python 指令脚本，而无需再在 PHP 和 PYTHON 双边封装响应。<br/>
 * 主要针对 EditorAction 具有操作性的 ReturnData
 * @author 郷
 */
interface ISublimeCmd {
    /**
     * 获取 Sublime 指令名称
     * @return string 
     */
    public function getSublimeCmdName();
    
    /**
     * 获取调用 Sublime 指令的 参数数组
     * @return array
     */
    public function getSublimeCmdArgs();
}
