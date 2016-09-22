<?php
require_once '_fenom.php';
class FenomPlus extends FenomX
{
    /**
     * @inheritdoc
     */
    protected function _addDefaultModifiers()
    {
        parent::_addDefaultModifiers();
        $modx = $this->modx;
        /** @var pdoToolsPlus $pdo */
        $pdo = $this->pdoTools;
        $fenom = $this;
        // Get chunk from file
        $this->_modifiers['chunk'] = function ($input, $options = array()) use ($modx, $pdo) {
            $input = str_replace(array('../','./'),'',$input);
            $pdo->config['tplPath'] = isset($options['tplPath']) ? $options['tplPath'] : MODX_CORE_PATH . 'elements/chunks';
            if (!preg_match('/(.html|.tpl)$/i', $input)) {
                $input .= '.tpl';
            }
            $content = $pdo->parseChunk('@FILE '. $input, $options);
            unset($pdo->config['tplPath']);
            return $content ? $content : $input;
        };
        // Get snippet from file
        $this->_modifiers['snippet'] = function ($input, $options = array()) use ($modx, $pdo) {
            $input = str_replace(array('../','./'),'',$input);
            $pdo->config['tplPath'] = isset($options['tplPath']) ? $options['tplPath'] : NULL;
            $output = $pdo->includeSnippet($input, $options);
            unset($pdo->config['tplPath']);
            return $output ? $output : $input;
        };
    }
}