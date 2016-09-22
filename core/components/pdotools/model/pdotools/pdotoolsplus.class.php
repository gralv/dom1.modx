<?php
require_once 'pdotools.class.php';
class pdoToolsPlus extends pdoTools
{
    /**
     * Loads template engine
     *
     * @return bool|Fenom
     */
    public function getFenom()
    {
        if (!$this->fenom) {
            try {
                if (!class_exists('FenomPlus')) {
                    require '_fenomplus.php';
                }
                $this->fenom = new FenomPlus($this);
            } catch (Exception $e) {
                $this->modx->log(xPDO::LOG_LEVEL_ERROR, $e->getMessage());
                return false;
            }
        }
        return $this->fenom;
    }
    public function includeSnippet($name = '', array $scriptProperties = array())
    {
        $pdoTools = $this;
        $modx =& $this->modx;
        $name = trim($name);
        $path = isset($this->config['tplPath'])
            ? $this->config['tplPath'] . '/'
            : MODX_CORE_PATH . 'elements/snippets/';
        if (strpos($path, MODX_BASE_PATH) === false) {
            $path = MODX_BASE_PATH . $path;
        }
        $file = preg_replace('#/+#', '/', $path . $name);
        if (!preg_match('/(.php)$/i', $file)) {
            $file .= '.php';
        }
        $output = '';
        if (!is_readable($file)) {
            $this->addTime('Could not load the snippet from the file "' . str_replace(MODX_BASE_PATH, '', $file) . '".');
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[pdoTools] Could not load snippet from file "' . str_replace(MODX_BASE_PATH, '', $file) . '"');
        } else {
            ob_start();
            if ($scriptProperties) extract($scriptProperties, EXTR_SKIP);
            $includeResult = include $file;
            $includeResult = ($includeResult === null ? '' : $includeResult);
            if (ob_get_length()) {
                $output = ob_get_contents() . $includeResult;
            } else {
                $output = $includeResult;
            }
            ob_end_clean();
            $this->addTime('Loaded snippet from "' . str_replace(MODX_BASE_PATH, '', $path) . '"');
        }
        return $output;
    }
}