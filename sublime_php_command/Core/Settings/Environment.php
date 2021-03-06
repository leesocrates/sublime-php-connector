<?php

namespace Chigi\Sublime\Settings;

use Chigi\Sublime\Commands\CommandsEntrancePanel;
use Chigi\Sublime\Exception\FileSystemEncodingException;
use Chigi\Sublime\Manager\CommandManager;
use Chigi\Sublime\Manager\ModelsManager;
use Chigi\Sublime\Manager\ViewManager;
use Chigi\Sublime\Models\BaseProject;
use Composer\Autoload\ClassLoader;

/**
 * 运行环境类
 */
class Environment {

    private static $sInstance = null;

    /**
     * Envirionment 对象构造器
     * @param array $params_arr
     */
    private function __construct() {
        $this->corePath = dirname(dirname(__FILE__));
        $this->fileSystemEncoding = "UTF-8";
        $this->CommandsManager = new CommandManager();
        $this->ModelsManager = new ModelsManager();
        $this->viewsManager = new ViewManager();
        $this->isDebug = FALSE;
    }

    /**
     * 全局运行环境单例
     * @return Environment
     * @throws FileSystemEncodingException
     */
    public static function getInstance() {
        if (is_null(self::$sInstance)) {
            self::$sInstance = new Environment();
        }
        return self::$sInstance;
    }

    private $corePath;

    public function getCorePath() {
        return iconv($this->fileSystemEncoding, "utf-8", $this->corePath);
    }

    private $fileSystemEncoding = "UTF-8";

    public function getFileSystemEncoding() {
        return $this->fileSystemEncoding;
    }

    public function setFileSystemEncoding($fileSystemEncoding) {
        $this->fileSystemEncoding = $fileSystemEncoding;
        return $this;
    }

    private $namespacesMap = array();

    /**
     * Get the current namespace map for paths.
     * @return array<namespace=>path>
     */
    public function getNamespacesMap() {
        return $this->namespacesMap;
    }

    public function setNamespacesMap($namespacesMap) {
        CommandsEntrancePanel::$COMMANDS_LIST = array();
        foreach ($namespacesMap as $key => $value) {
            $dir_to_search = $namespacesMap[$key] = str_replace('${entryDir}', dirname($this->getCorePath()), $value);
            if (!in_array(substr($dir_to_search, -1), array('/', '\\'), TRUE)) {
                $dir_to_search .= DIRECTORY_SEPARATOR;
            }
            if (file_exists(iconv('utf-8', $this->getFileSystemEncoding(), $dir_to_search . 'phpconnector.commands'))) {
                $propers = json_decode(file_get_contents(iconv('utf-8', $this->getFileSystemEncoding(), $dir_to_search . 'phpconnector.commands')), TRUE);
                foreach ($propers as $item) {
                    if (!isset($item['class'])) {
                        continue;
                    }
                    if (!isset($item['args'])) {
                        $item['args'] = array();
                    }
                    if (substr($item['class'], 0, 1) !== '\\') {
                        $item['class'] = '\\' . $item['class'];
                    }
                    array_push(CommandsEntrancePanel::$COMMANDS_LIST
                            , array($item['class'], $item['args'])
                    );
                }
            }
        }
        $this->namespacesMap = $namespacesMap;
        return $this;
    }

    /**
     *
     * @var CommandManager
     */
    private $CommandsManager;

    public function getCommandsManager() {
        return $this->CommandsManager;
    }

    /**
     *
     * @var ModelsManager
     */
    private $ModelsManager;

    public function getModelsManager() {
        return $this->ModelsManager;
    }

    /**
     *
     * @var ViewManager
     */
    private $viewsManager;

    public function getViewsManager() {
        return $this->viewsManager;
    }

    private $isDebug = FALSE;

    public function debugOn() {
        $this->isDebug = TRUE;
        return $this;
    }

    public function debugOff() {
        $this->isDebug = FALSE;
        return $this;
    }

    /**
     * Check Current Environment is in Debug.
     * @return boolean
     */
    public function isDebug() {
        return $this->isDebug;
    }
    
    /**
     * The third class loader from composer
     * @var ClassLoader
     */
    private $composerLoader = null;
    
    public function getComposerLoader() {
        return $this->composerLoader;
    }

    public function setComposerLoader(ClassLoader $composerLoader) {
        $this->composerLoader = $composerLoader;
        return $this;
    }
    
    /**
     * 当前全局项目环境
     * @var BaseProject
     */
    private $contextProject = null;

    public function getContextProject() {
        return $this->contextProject;
    }

    public function setContextProject(BaseProject $contextProject) {
        $this->contextProject = $contextProject;
        return $this;
    }


}

?>