<?php  return array (
  'config' => 
  array (
    'allow_tags_in_post' => '1',
    'modRequest.class' => 'modManagerRequest',
  ),
  'aliasMap' => 
  array (
  ),
  'webLinkMap' => 
  array (
  ),
  'eventMap' => 
  array (
    'msOnChangeOrderStatus' => 
    array (
      6 => '6',
    ),
    'OnBeforeDocFormSave' => 
    array (
      3 => '3',
    ),
    'OnChunkFormPrerender' => 
    array (
      2 => '2',
    ),
    'OnDocFormPrerender' => 
    array (
      2 => '2',
    ),
    'OnDocFormSave' => 
    array (
      3 => '3',
    ),
    'OnFileCreateFormPrerender' => 
    array (
      2 => '2',
    ),
    'OnFileEditFormPrerender' => 
    array (
      2 => '2',
    ),
    'OnHandleRequest' => 
    array (
      4 => '4',
      6 => '6',
    ),
    'OnLoadWebDocument' => 
    array (
      1 => '1',
      6 => '6',
    ),
    'OnLoadWebPageCache' => 
    array (
      4 => '4',
    ),
    'OnManagerPageBeforeRender' => 
    array (
      6 => '6',
      2 => '2',
      8 => '8',
    ),
    'OnManagerPageInit' => 
    array (
      3 => '3',
    ),
    'OnMODXInit' => 
    array (
      9 => '9',
    ),
    'OnPageNotFound' => 
    array (
      3 => '3',
    ),
    'OnPluginFormPrerender' => 
    array (
      2 => '2',
    ),
    'OnResourceBeforeSort' => 
    array (
      3 => '3',
    ),
    'OnResourceSort' => 
    array (
      3 => '3',
    ),
    'OnRichTextBrowserInit' => 
    array (
      8 => '8',
    ),
    'OnRichTextEditorInit' => 
    array (
      8 => '8',
    ),
    'OnRichTextEditorRegister' => 
    array (
      2 => '2',
      8 => '8',
    ),
    'OnSiteRefresh' => 
    array (
      9 => '9',
      5 => '5',
    ),
    'OnSnipFormPrerender' => 
    array (
      2 => '2',
    ),
    'OnTempFormPrerender' => 
    array (
      2 => '2',
    ),
    'OnWebPageInit' => 
    array (
      4 => '4',
      6 => '6',
    ),
    'OnWebPagePrerender' => 
    array (
      4 => '4',
      5 => '5',
    ),
  ),
  'pluginCache' => 
  array (
    1 => 
    array (
      'id' => '1',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'AjaxSnippet',
      'description' => '',
      'editor_type' => '0',
      'category' => '2',
      'cache_type' => '0',
      'plugincode' => 'switch ($modx->event->name) {

	case \'OnLoadWebDocument\':
		if (empty($_SERVER[\'HTTP_X_REQUESTED_WITH\']) || $_SERVER[\'HTTP_X_REQUESTED_WITH\'] != \'XMLHttpRequest\') {
			return;
		}
		/** @var xPDOFileCache $cache */
		$cache = $modx->cacheManager;
		$cache_key = \'/ajaxsnippet/\';

		if (!empty($_REQUEST[\'as_action\']) && $scriptProperties = $cache->get($cache_key . $_REQUEST[\'as_action\'])) {
			$output = \'\';
			/** @var modSnippet $object */
			if ($object = $modx->getObject(\'modSnippet\', array(\'name\' => $scriptProperties[\'snippet\']))) {
				$properties = $object->getProperties();
				if (!empty($scriptProperties[\'propertySet\'])) {
					$properties = array_merge($properties, $object->getPropertySet($scriptProperties[\'propertySet\']));
				}
				$scriptProperties = array_merge($properties, $scriptProperties);

				$output = $object->process($scriptProperties);
				if (strpos($output, \'[[\') !== false) {
					$maxIterations = intval($modx->getOption(\'parser_max_iterations\', $options, 10));
					$modx->parser->processElementTags(\'\', $output, true, false, \'[[\', \']]\', array(), $maxIterations);
					$modx->parser->processElementTags(\'\', $output, true, true, \'[[\', \']]\', array(), $maxIterations);
				}
			}

			$response = array(
				\'output\' => $output,
				\'key\' => $_REQUEST[\'as_action\'],
				\'snippet\' => $scriptProperties[\'snippet\'],
			);
			if (!empty($scriptProperties[\'totalVar\'])) {
				$response[\'total\'] = $modx->getPlaceholder($scriptProperties[\'totalVar\']);
			}
			if (!empty($scriptProperties[\'pageNavVar\'])) {
				$response[\'pagination\'] = $modx->getPlaceholder($scriptProperties[\'pageNavVar\']);
			}

			echo $modx->toJSON($response);
			@session_write_close();
			exit;
		}
		break;

}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/ajaxsnippet/elements/plugins/plugin.ajaxsnippet.php',
    ),
    2 => 
    array (
      'id' => '2',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'Ace',
      'description' => 'Ace code editor plugin for MODx Revolution',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '/**
 * Ace Source Editor Plugin
 *
 * Events: OnManagerPageBeforeRender, OnRichTextEditorRegister, OnSnipFormPrerender,
 * OnTempFormPrerender, OnChunkFormPrerender, OnPluginFormPrerender,
 * OnFileCreateFormPrerender, OnFileEditFormPrerender, OnDocFormPrerender
 *
 * @author Danil Kostin <danya.postfactum(at)gmail.com>
 *
 * @package ace
 *
 * @var array $scriptProperties
 * @var Ace $ace
 */
if ($modx->event->name == \'OnRichTextEditorRegister\') {
    $modx->event->output(\'Ace\');
    return;
}

if ($modx->getOption(\'which_element_editor\', null, \'Ace\') !== \'Ace\') {
    return;
}

$ace = $modx->getService(\'ace\', \'Ace\', $modx->getOption(\'ace.core_path\', null, $modx->getOption(\'core_path\').\'components/ace/\').\'model/ace/\');
$ace->initialize();

$extensionMap = array(
    \'tpl\'   => \'text/x-smarty\',
    \'htm\'   => \'text/html\',
    \'html\'  => \'text/html\',
    \'css\'   => \'text/css\',
    \'scss\'  => \'text/x-scss\',
    \'less\'  => \'text/x-less\',
    \'svg\'   => \'image/svg+xml\',
    \'xml\'   => \'application/xml\',
    \'xsl\'   => \'application/xml\',
    \'js\'    => \'application/javascript\',
    \'json\'  => \'application/json\',
    \'php\'   => \'application/x-php\',
    \'sql\'   => \'text/x-sql\',
    \'md\'    => \'text/x-markdown\',
    \'txt\'   => \'text/plain\',
    \'twig\'  => \'text/x-twig\'
);

// Defines wether we should highlight modx tags
$modxTags = false;
switch ($modx->event->name) {
    case \'OnSnipFormPrerender\':
        $field = \'modx-snippet-snippet\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnTempFormPrerender\':
        $field = \'modx-template-content\';
        $modxTags = true;

        switch (true) {
            case $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $modx->getOption(\'pdotools_fenom_parser\'):
                $mimeType = \'text/x-smarty\';
                break;
            default:
                $mimeType = \'text/html\';
                break;
        }

        break;
    case \'OnChunkFormPrerender\':
        $field = \'modx-chunk-snippet\';
        if ($modx->controller->chunk && $modx->controller->chunk->isStatic()) {
            $extension = pathinfo($modx->controller->chunk->getSourceFile(), PATHINFO_EXTENSION);
            $mimeType = isset($extensionMap[$extension]) ? $extensionMap[$extension] : \'text/plain\';
        } else {
            $mimeType = \'text/html\';
        }
        $modxTags = true;

        switch (true) {
            case $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $modx->getOption(\'pdotools_fenom_default\'):
                $mimeType = \'text/x-smarty\';
                break;
            default:
                $mimeType = \'text/html\';
                break;
        }

        break;
    case \'OnPluginFormPrerender\':
        $field = \'modx-plugin-plugincode\';
        $mimeType = \'application/x-php\';
        break;
    case \'OnFileCreateFormPrerender\':
        $field = \'modx-file-content\';
        $mimeType = \'text/plain\';
        break;
    case \'OnFileEditFormPrerender\':
        $field = \'modx-file-content\';
        $extension = pathinfo($scriptProperties[\'file\'], PATHINFO_EXTENSION);
        $mimeType = isset($extensionMap[$extension])
            ? $extensionMap[$extension]
            : \'text/plain\';
        $modxTags = $extension == \'tpl\';
        break;
    case \'OnDocFormPrerender\':
        if (!$modx->controller->resourceArray) {
            return;
        }
        $field = \'ta\';
        $mimeType = $modx->getObject(\'modContentType\', $modx->controller->resourceArray[\'content_type\'])->get(\'mime_type\');

        switch (true) {
            case $mimeType == \'text/html\' && $modx->getOption(\'twiggy_class\'):
                $mimeType = \'text/x-twig\';
                break;
            case $mimeType == \'text/html\' && $modx->getOption(\'pdotools_fenom_parser\'):
                $mimeType = \'text/x-smarty\';
                break;
        }

        if ($modx->getOption(\'use_editor\')){
            $richText = $modx->controller->resourceArray[\'richtext\'];
            $classKey = $modx->controller->resourceArray[\'class_key\'];
            if ($richText || in_array($classKey, array(\'modStaticResource\',\'modSymLink\',\'modWebLink\',\'modXMLRPCResource\'))) {
                $field = false;
            }
        }
        $modxTags = true;
        break;
    default:
        return;
}

$modxTags = (int) $modxTags;
$script = \'\';
if ($field) {
    $script .= "MODx.ux.Ace.replaceComponent(\'$field\', \'$mimeType\', $modxTags);";
}

if ($modx->event->name == \'OnDocFormPrerender\' && !$modx->getOption(\'use_editor\')) {
    $script .= "MODx.ux.Ace.replaceTextAreas(Ext.query(\'.modx-richtext\'));";
}

if ($script) {
    $modx->controller->addHtml(\'<script>Ext.onReady(function() {\' . $script . \'});</script>\');
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'ace/elements/plugins/ace.plugin.php',
    ),
    3 => 
    array (
      'id' => '3',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'autoRedirector',
      'description' => '',
      'editor_type' => '0',
      'category' => '4',
      'cache_type' => '0',
      'plugincode' => '$resourceEvents = array(\'OnBeforeDocFormSave\', \'OnDocFormSave\');
if (in_array($modx->event->name, $resourceEvents)) {
    foreach($scriptProperties as & $object){
        if(
            is_object($object)
            AND $object instanceof modResource
            AND $original = $modx->getObject(\'modResource\', $object->id)
        ){
            $resource = $object;
            break;
        }
    }
}
switch ($modx->event->name) {
    case "OnManagerPageInit":
	$cssFile = MODX_ASSETS_URL.\'components/autoredirector/css/mgr/main.css\';
	$modx->regClientCSS($cssFile);
	break;

    case "OnBeforeDocFormSave":
        $resources = array(
                $resource,
                $modx->getObject(\'modResource\',$resource->get(\'parent\'))
            );
        if($child_ids = $modx->getChildIds($resource->id,50,array(\'context\' => $resource->context_key))){
            $resources = array_merge($resources, $modx->getCollection(\'modResource\',array("id:IN" => $child_ids)));
        }
    case "OnResourceBeforeSort":
        if (empty($resources)) {
            foreach ($nodes as $node) {
                $resources[] = $modx->getObject(\'modResource\',$node[\'id\']);
            }
        }
        foreach ($resources as $res) {
            if (!empty($res)) {
                if (!$res->getProperty(\'old_uri\',\'autoredirector\')) {
                    $res->setProperty(\'old_uri\',$res->get(\'uri\'),\'autoredirector\');
                    $res->save();
                }
            }
        }
        break;
    case "OnDocFormSave":
        $resources = array(
                $resource,
                $modx->getObject(\'modResource\',$resource->get(\'parent\'))
            );
        if($child_ids = $modx->getChildIds($resource->id,50,array(\'context\' => $resource->context_key))){
            $resources = array_merge($resources, $modx->getCollection(\'modResource\',array("id:IN" => $child_ids)));
        }
    case "OnResourceSort":
        if (empty($resources)) {
            foreach ($nodesAffected as $node) {
                $resources[] = $node;
            }
        }
        $modelPath = $modx->getOption(\'autoredirector_core_path\',null,$modx->getOption(\'core_path\').\'components/autoredirector/\').\'model/\';
		$modx->addPackage(\'autoredirector\', $modelPath);
        $processorProps = array(\'processors_path\' => $modx->getOption(\'autoredirector_core_path\',null,$modx->getOption(\'core_path\').\'components/autoredirector/\').\'processors/\');
        foreach ($resources as $res) {
            if (!empty($res)) {
                $old_uri = $res->getProperty(\'old_uri\',\'autoredirector\');
                $current_uri = $res->getAliasPath($res->get(\'alias\'));
                if ($old_uri && $current_uri != $old_uri) {
                    $currentRuleQ = array(\'uri\' => $current_uri);
                    if (!$modx->getOption(\'global_duplicate_uri_check\')) {
                        $currentRuleQ[\'context_key\'] = $res->get(\'context_key\');
                    }
                    if ($currentRule = $modx->getObject(\'arRule\', $currentRuleQ)) {
                        $response = $modx->runProcessor(\'mgr/item/remove\', $currentRule->toArray(), $processorProps);
                        if ($response->isError()) {
                            $modx->log(modX::LOG_LEVEL_ERROR, \'AutoRedirector removing error. Message: \'.$response->getMessage());
                        }
                    }
                    $arRule = array(\'uri\' => $old_uri
                        , \'context_key\' => $res->get(\'context_key\')
                        , \'res_id\' => $res->get(\'id\'));
                    if (!$modx->getObject(\'arRule\', $arRule)) {
                        $response = $modx->runProcessor(\'mgr/item/create\', $arRule, $processorProps);
                        if ($response->isError()) {
                            $modx->log(modX::LOG_LEVEL_ERROR, \'AutoRedirector creating error. Message: \'.$response->getMessage());
                        }
                    }
                }
                $res->setProperty(\'old_uri\',$current_uri,\'autoredirector\');
                $res->save();
            }
        }
        break;
    case "OnPageNotFound":
        $uri = $_SERVER[\'REQUEST_URI\'];
        $uri = str_replace($modx->getOption("site_url"),"",$uri);
        if (substr($uri, 0, 1) == "/") $uri = substr($uri, 1);
        $uri = urldecode($uri);

        $RuleQ = array(\'uri\' => $uri);
        if (!$modx->getOption(\'global_duplicate_uri_check\')) {
            $RuleQ[\'context_key\'] = $modx->context->get(\'key\');
        }
        $modelPath = $modx->getOption(\'autoredirector_core_path\',null,$modx->getOption(\'core_path\').\'components/autoredirector/\').\'model/\';
    	$modx->addPackage(\'autoredirector\', $modelPath);
        if ($Rule = $modx->getObject(\'arRule\', $RuleQ)) {
            if ($url = $modx->makeUrl($Rule->get(\'res_id\'))) {
                $modx->sendRedirect($url,array(\'responseCode\' => \'HTTP/1.1 301 Moved Permanently\'));
            }
        }
        break;
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/autoredirector/elements/plugins/plugin.autoredirector.php',
    ),
    4 => 
    array (
      'id' => '4',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'debugParser',
      'description' => '',
      'editor_type' => '0',
      'category' => '5',
      'cache_type' => '0',
      'plugincode' => 'if (empty($_REQUEST[\'debug\']) || !$modx->user->hasSessionContext(\'mgr\') || $modx->context->key == \'mgr\') {
	return;
}

switch ($modx->event->name) {

	case \'OnHandleRequest\':
		if ($modx->parser instanceof pdoParser && $modx->loadClass(\'debugPdoParser\', MODX_CORE_PATH . \'components/debugparser/model/\', false, true)) {
			$modx->parser = new debugPdoParser($modx);
		}
		elseif ($modx->loadClass(\'debugParser\', MODX_CORE_PATH . \'components/debugparser/model/\', false, true)) {
			$modx->parser = new debugParser($modx);
		}
		break;

	case \'OnWebPageInit\':
		if (method_exists($modx->parser, \'clearCache\') && empty($_REQUEST[\'cache\'])) {
			$modx->parser->clearCache();
		}
		break;

	case \'OnLoadWebPageCache\':
		if (property_exists($modx->parser, \'from_cache\')) {
			$modx->parser->from_cache = true;
		}
		break;

	case \'OnWebPagePrerender\':
		if (method_exists($modx->parser, \'generateReport\')) {
			$modx->parser->generateReport();
		}
		break;
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/debugparser/elements/plugins/plugin.debugparser.php',
    ),
    5 => 
    array (
      'id' => '5',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'MinifyX',
      'description' => '',
      'editor_type' => '0',
      'category' => '6',
      'cache_type' => '0',
      'plugincode' => 'switch ($modx->event->name) {

	case \'OnSiteRefresh\':
		if ($MinifyX = $modx->getService(\'minifyx\',\'MinifyX\', MODX_CORE_PATH.\'components/minifyx/model/minifyx/\')) {
			/** @var MinifyX $MinifyX */
			$MinifyX = new MinifyX($modx, array());
			if ($MinifyX->clearCache()) {
				$modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon(\'refresh_default\').\': MinifyX\');
			}
		}
		break;

	case \'OnWebPagePrerender\':
		$time = microtime(true);
		// Process scripts and styles
		if ($modx->getOption(\'minifyx_process_registered\', null, false, true)) {
			if (!$modx->getService(\'minifyx\',\'MinifyX\', MODX_CORE_PATH.\'components/minifyx/model/minifyx/\')) {return false;}

			$current = array(
				\'head\' => $modx->sjscripts,
				\'body\' => $modx->jscripts,
			);
			$included = $excluded = $prepared = $raw = array(
				\'head\' => array(\'css\' => array(), \'js\' => array(), \'html\' => array()),
				\'body\' => array(\'css\' => array(), \'js\' => array(), \'html\' => array()),
			);
			$exclude = $modx->getOption(\'minifyx_exclude_registered\');

			// Split all scripts and styles by type
			foreach ($current as $key => $value) {
				foreach ($value as $v) {
					if (preg_match(\'/<(?:link|script).*?(?:href|src)=[\\\'|"](.*?)[\\\'|"]/\', $v, $tmp)) {
						if (strpos($tmp[1], \'.css\') !== false) {
							if (!empty($exclude) && preg_match($exclude, $tmp[1])) {
								$excluded[$key][\'css\'][] = $tmp[1];
							}
							else {
								$included[$key][\'css\'][] = $tmp[1];
							}
						}
						if (strpos($tmp[1], \'.js\') !== false) {
							if (!empty($exclude) && preg_match($exclude, $tmp[1])) {
								$excluded[$key][\'js\'][] = $tmp[1];
							}
							else {
								$included[$key][\'js\'][] = $tmp[1];
							}
						}
					}
					elseif (strpos($v, \'<script\') !== false) {
						$raw[$key][\'js\'][] = trim(preg_replace(\'#<!--.*?-->(\\n|)#s\', \'\', $v));
					}
					elseif (strpos($v, \'<style\') !== false) {
						$raw[$key][\'css\'][] = trim(preg_replace(\'#/\\*.*?\\*/(\\n|)#s\', \'\', $v));
					}
					else {
						$excluded[$key][\'html\'][] = $v;
					}
				}
			}

			// Main options for MinifyX
			$scriptProperties = array(
				\'cacheFolder\' => $modx->getOption(\'minifyx_cacheFolder\', null, \'/assets/components/minifyx/cache/\', true),
				\'forceUpdate\' => $modx->getOption(\'minifyx_forceUpdate\', null, false, true),
				\'minifyJs\' => $modx->getOption(\'minifyx_minifyJs\', null, false, true),
				\'minifyCss\' => $modx->getOption(\'minifyx_minifyCss\', null, false, true),
				\'jsFilename\' => $modx->getOption(\'minifyx_jsFilename\', null, \'all\', true),
				\'cssFilename\' => $modx->getOption(\'minifyx_cssFilename\', null, \'all\', true),
			);

			/** @var MinifyX $MinifyX */
			$MinifyX = new MinifyX($modx, $scriptProperties);
			if (!$MinifyX->prepareCacheFolder()) {
				$this->modx->log(modX::LOG_LEVEL_ERROR, \'[MinifyX] Could not create cache dir "\'.$scriptProperties[\'cacheFolder\'].\'"\');
				return;
			}
			$cacheFolderUrl = MODX_BASE_URL . str_replace(MODX_BASE_PATH, \'\', $MinifyX->config[\'cacheFolder\']);

			// Process raw scripts and styles
			$tmp_dir = $MinifyX->getTmpDir() . \'resources/\' . $modx->resource->id . \'/\';
			foreach ($raw as $key => $value) {
				foreach ($value as $type => $rows) {
					$tmp = \'\';
					if ($type == \'css\' && $modx->getOption(\'minifyx_processRawCss\', null, false, true) ||
						$type == \'js\' && $modx->getOption(\'minifyx_processRawJs\', null, false, true)) {

						$text = \'\';
						foreach ($rows as $text) {
							$text = preg_replace(\'#^<(script|style).*?>#\', \'\', $text);
							$text = preg_replace(\'#</(script|style)>$#\', \'\', $text);
							$tmp .= $text;
						}

						if (!empty($tmp)) {
							$file = sha1($tmp) . \'.\' . $type;
							if (!file_exists($tmp_dir . $file)) {
								if (!file_exists($tmp_dir)) {
									$MinifyX->makeDir($tmp_dir);
								}
								file_put_contents($tmp_dir . $file, $tmp);
							}
							$included[$key][$type][] = $tmp_dir . $file;
							$raw[$key][$type] = array();
						}
					}
				}
			}

			// Combine and minify files
			foreach ($included as $key => $value) {
				foreach ($value as $type => $files) {
					if (empty($files)) {continue;}

					$filename = $MinifyX->config[$type.\'Filename\'] . \'_\';
					$extension = $MinifyX->config[$type.\'Ext\'];

					$files = $MinifyX->prepareFiles(implode(\',\', $files));
					$properties = array(
						\'minify\' => $MinifyX->config[\'minify\'.ucfirst($type)]
								? \'true\'
								: \'false\',
					);

					$result = $MinifyX->Munee($files, $properties);
					$file = $MinifyX->saveFile($result, $filename, $extension);
					if (!empty($file)) {
						$prepared[$key][$type][] = $cacheFolderUrl . $file;
					}
				}
			}

			// Combine files by type
			$final = array(
				\'head\' => array_merge(
					$excluded[\'head\'][\'css\'], $prepared[\'head\'][\'css\'], $raw[\'head\'][\'css\'],
					$excluded[\'head\'][\'js\'], $prepared[\'head\'][\'js\'], $raw[\'head\'][\'js\']
				),
				\'body\' => array_merge(
					$excluded[\'body\'][\'css\'], $prepared[\'body\'][\'css\'], $raw[\'body\'][\'css\'],
					$excluded[\'body\'][\'js\'], $prepared[\'body\'][\'js\'], $raw[\'body\'][\'js\']
				),
			);

			// Push files to tags
			foreach ($final as $type => &$value) {
				foreach ($value as &$file) {
					if (strpos($file, \'<script\') === false && strpos($file, \'<style\') === false) {
						$file = preg_match(\'/\\.css$/iu\', $file)
							? \'<link rel="stylesheet" href="\' . $file . \'" type="text/css" />\'
							: \'<script type="text/javascript" src="\' . $file . \'"></script>\';
					}
				}
				if (!empty($excluded[$type][\'html\'])) {
					$value[] = implode("\\n", $excluded[$type][\'html\']);
				}
			}
			unset($value);

			// Replace tags in web page
			$modx->resource->_output = str_replace(
				array($modx->getRegisteredClientStartupScripts() . "\\n</head>", $modx->getRegisteredClientScripts() . "\\n</body>"),
				array(implode("\\n", $final[\'head\']) . "\\n</head>", implode("\\n", $final[\'body\']) . "\\n</body>"),
				$modx->resource->_output
			);
		}

		// Process images
		if ($modx->getOption(\'minifyx_process_images\', null, false, true)) {
			if (!$modx->getService(\'minifyx\',\'MinifyX\', MODX_CORE_PATH.\'components/minifyx/model/minifyx/\')) {return false;}

			$connector = $modx->getOption(\'minifyx_connector\', null, \'/assets/components/minifyx/munee.php\', true);
			$exclude = $modx->getOption(\'minifyx_exclude_images\');
			$replace = array(\'from\' => array(), \'to\' => array());
			$site_url = $modx->getOption(\'site_url\');
			$default = $modx->getOption(\'minifyx_images_filters\', null, \'\', true);

			preg_match_all(\'/<img.*?>/i\', $modx->resource->_output, $tags);
			foreach ($tags[0] as $tag) {
				if (preg_match($exclude, $tag)) {
					continue;
				}
				elseif (preg_match_all(\'/(src|height|width|filters)=[\\\'|"](.*?)[\\\'|"]/i\', $tag, $properties)) {
					if (count($properties[0]) >= 2) {
						$file = $connector . \'?files=\';
						$resize = \'\';
						$filters = \'\';
						$tmp = array(\'from\' => array(), \'to\' => array());

						foreach ($properties[1] as $k => $v) {
							if ($v == \'src\') {
								$src = $properties[2][$k];
								if (strpos($src, \'://\') !== false) {
									if (strpos($src, $site_url) !== false) {
										$src = str_replace($site_url, \'\', $src);
									}
									else {
										// Image from 3rd party domain
										continue;
									}
								}
								$file .= $src;
								$tmp[\'from\'][\'src\'] = $properties[2][$k];
							}
							elseif ($v == \'height\' || $v == \'width\') {
								$resize .=  $v[0] . \'[\'.$properties[2][$k].\']\';
							}
							elseif ($v == \'filters\') {
								$filters .= $properties[2][$k];
								$tmp[\'from\'][\'filters\'] = $properties[0][$k];
								$tmp[\'to\'][\'filters\'] = \'\';
							}
						}

						if (!empty($tmp[\'from\'][\'src\'])) {
							$resize .= isset($tmp[\'from\'][\'filters\'])
								? $filters
								: $default;
							$tmp[\'to\'][\'src\'] = $file . \'?resize=\' . $resize;

							ksort($tmp[\'from\']);
							ksort($tmp[\'to\']);

							$replace[\'from\'][] = $tag;
							$replace[\'to\'][] = str_replace($tmp[\'from\'], $tmp[\'to\'], $tag);
						}
					}
				}
			}

			if (!empty($replace)) {
				$modx->resource->_output = str_replace(
					$replace[\'from\'],
					$replace[\'to\'],
					$modx->resource->_output
				);
			}
		}

		$modx->log(modX::LOG_LEVEL_INFO, \'[MinifyX] Total time for page "\'.$modx->resource->id.\'" = \'.(microtime(true) - $time));
		break;
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/minifyx/elements/plugins/plugin.minifyx.php',
    ),
    6 => 
    array (
      'id' => '6',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'miniShop2',
      'description' => '',
      'editor_type' => '0',
      'category' => '7',
      'cache_type' => '0',
      'plugincode' => 'switch ($modx->event->name) {

	case \'OnManagerPageBeforeRender\':
		$modx23 = !empty($modx->version) && version_compare($modx->version[\'full_version\'], \'2.3.0\', \'>=\');
		$modx->controller->addHtml(\'<script type="text/javascript">
			Ext.onReady(function() {
				MODx.modx23 = \'.(int)$modx23.\';
			});
		</script>\');
		if (!$modx23) {
			$modx->controller->addCss(MODX_ASSETS_URL . \'components/minishop2/css/mgr/bootstrap.min.css\');
		}
		$modx->controller->addCss(MODX_ASSETS_URL . \'components/minishop2/css/mgr/main.css\');
		break;

	case \'OnHandleRequest\':
	case \'OnLoadWebDocument\':
		$isAjax = !empty($_SERVER[\'HTTP_X_REQUESTED_WITH\']) && $_SERVER[\'HTTP_X_REQUESTED_WITH\'] == \'XMLHttpRequest\';

		if (empty($_REQUEST[\'ms2_action\']) || ($isAjax && $modx->event->name != \'OnHandleRequest\') || (!$isAjax && $modx->event->name != \'OnLoadWebDocument\')) {return;}
		$action = trim($_REQUEST[\'ms2_action\']);
		$ctx = !empty($_REQUEST[\'ctx\']) ? (string) $_REQUEST[\'ctx\'] : \'web\';
		if ($ctx != \'web\') {$modx->switchContext($ctx);}

		/* @var miniShop2 $miniShop2 */
		$miniShop2 = $modx->getService(\'minishop2\');
		$miniShop2->initialize($ctx, array(\'json_response\' => $isAjax));
		if (!($miniShop2 instanceof miniShop2)) {
			@session_write_close();
			exit(\'Could not initialize miniShop2\');
		}

		switch ($action) {
			case \'cart/add\': $response = $miniShop2->cart->add(@$_POST[\'id\'], @$_POST[\'count\'], @$_POST[\'options\']); break;
			case \'cart/change\': $response = $miniShop2->cart->change(@$_POST[\'key\'], @$_POST[\'count\']); break;
			case \'cart/remove\': $response = $miniShop2->cart->remove(@$_POST[\'key\']); break;
			case \'cart/clean\': $response = $miniShop2->cart->clean(); break;
			case \'cart/get\': $response = $miniShop2->cart->get(); break;
			case \'order/add\': $response = $miniShop2->order->add(@$_POST[\'key\'], @$_POST[\'value\']); break;
			case \'order/submit\': $response = $miniShop2->order->submit($_POST); break;
			case \'order/getcost\': $response = $miniShop2->order->getcost(); break;
			case \'order/getrequired\': $response = $miniShop2->order->getDeliveryRequiresFields(@$_POST[\'id\']); break;
			case \'order/clean\': $response = $miniShop2->order->clean(); break;
			case \'order/get\': $response = $miniShop2->order->get(); break;
			default:
				$message = ($_REQUEST[\'ms2_action\'] != $action)
					? \'ms2_err_register_globals\'
					: \'ms2_err_unknown\';
				$response = $miniShop2->error($message);
		}

		if ($isAjax) {
			@session_write_close();
			exit($response);
		}
		break;

	case \'OnWebPageInit\':
		/* @var msCustomerProfile $profile */
		$referrerVar = $modx->getOption(\'ms2_referrer_code_var\', null, \'msfrom\', true);
		$cookieVar = $modx->getOption(\'ms2_referrer_cookie_var\', null, \'msreferrer\', true);
		$cookieTime = $modx->getOption(\'ms2_referrer_time\', null, 86400 * 365, true);

		if (!$modx->user->isAuthenticated() && !empty($_REQUEST[$referrerVar])) {
			$code = trim($_REQUEST[$referrerVar]);
			if ($profile = $modx->getObject(\'msCustomerProfile\', array(\'referrer_code\' => $code))) {
				$referrer = $profile->id;
				setcookie($cookieVar, $referrer, time() + $cookieTime);
			}
		}
		elseif ($modx->user->isAuthenticated() && !empty($_COOKIE[$cookieVar])) {
			if ($profile = $modx->getObject(\'msCustomerProfile\', $modx->user->id)) {
				if (!$profile->get(\'referrer_id\') && $_COOKIE[$cookieVar] != $modx->user->id) {
					$profile->set(\'referrer_id\', $_COOKIE[$cookieVar]);
					$profile->save();
				}
			}
			setcookie($cookieVar, \'\', time() - $cookieTime);
		}
		break;

	case \'msOnChangeOrderStatus\':
		if (empty($status) || $status != 2) {return;}

		/** @var modUser $user */
		if ($user = $order->getOne(\'User\')) {
			$q = $modx->newQuery(\'msOrder\', array(\'type\' => 0));
			$q->innerJoin(\'modUser\', \'modUser\', array(\'`modUser`.`id` = `msOrder`.`user_id`\'));
			$q->innerJoin(\'msOrderLog\', \'msOrderLog\', array(
				\'`msOrderLog`.`order_id` = `msOrder`.`id`\',
				\'msOrderLog.action\' => \'status\',
				\'msOrderLog.entry\' => $status,
			));
			$q->where(array(\'msOrder.user_id\' => $user->id));
			$q->groupby(\'msOrder.user_id\');
			$q->select(\'SUM(`msOrder`.`cost`)\');
			if ($q->prepare() && $q->stmt->execute()) {
				$spent = $q->stmt->fetch(PDO::FETCH_COLUMN);
				/** @var msCustomerProfile $profile */
				if ($profile = $modx->getObject(\'msCustomerProfile\', $user->id)) {
					$profile->set(\'spent\', $spent);
					$profile->save();
				}
			}
		}
		break;
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/minishop2/elements/plugins/plugin.minishop2.php',
    ),
    9 => 
    array (
      'id' => '9',
      'source' => '1',
      'property_preprocess' => '0',
      'name' => 'pdoTools',
      'description' => '',
      'editor_type' => '0',
      'category' => '8',
      'cache_type' => '0',
      'plugincode' => '/** @var modX $modx */
switch ($modx->event->name) {

    case \'OnMODXInit\':
        $fqn = $modx->getOption(\'pdoTools.class\', null, \'pdotools.pdotools\', true);
        $path = $modx->getOption(\'pdotools_class_path\', null, MODX_CORE_PATH . \'components/pdotools/model/\', true);
        $modx->loadClass($fqn, $path, false, true);

        $fqn = $modx->getOption(\'pdoFetch.class\', null, \'pdotools.pdofetch\', true);
        $path = $modx->getOption(\'pdofetch_class_path\', null, MODX_CORE_PATH . \'components/pdotools/model/\', true);
        $modx->loadClass($fqn, $path, false, true);
        break;

    case \'OnSiteRefresh\':
        /** @var pdoTools $pdoTools */
        if ($pdoTools = $modx->getService(\'pdoTools\')) {
            if ($pdoTools->clearFileCache()) {
                $modx->log(modX::LOG_LEVEL_INFO, $modx->lexicon(\'refresh_default\') . \': pdoTools\');
            }
        }
        break;
}',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '0',
      'static_file' => 'core/components/pdotools/elements/plugins/plugin.pdotools.php',
    ),
    8 => 
    array (
      'id' => '8',
      'source' => '0',
      'property_preprocess' => '0',
      'name' => 'CKEditor',
      'description' => 'CKEditor WYSIWYG editor plugin for MODx Revolution',
      'editor_type' => '0',
      'category' => '0',
      'cache_type' => '0',
      'plugincode' => '',
      'locked' => '0',
      'properties' => NULL,
      'disabled' => '0',
      'moduleguid' => '',
      'static' => '1',
      'static_file' => 'ckeditor/elements/plugins/ckeditor.plugin.php',
    ),
  ),
  'policies' => 
  array (
    'modAccessContext' => 
    array (
      'mgr' => 
      array (
        0 => 
        array (
          'principal' => 1,
          'authority' => 0,
          'policy' => 
          array (
            'about' => true,
            'access_permissions' => true,
            'actions' => true,
            'change_password' => true,
            'change_profile' => true,
            'charsets' => true,
            'class_map' => true,
            'components' => true,
            'content_types' => true,
            'countries' => true,
            'create' => true,
            'credits' => true,
            'customize_forms' => true,
            'dashboards' => true,
            'database' => true,
            'database_truncate' => true,
            'delete_category' => true,
            'delete_chunk' => true,
            'delete_context' => true,
            'delete_document' => true,
            'delete_eventlog' => true,
            'delete_plugin' => true,
            'delete_propertyset' => true,
            'delete_role' => true,
            'delete_snippet' => true,
            'delete_template' => true,
            'delete_tv' => true,
            'delete_user' => true,
            'directory_chmod' => true,
            'directory_create' => true,
            'directory_list' => true,
            'directory_remove' => true,
            'directory_update' => true,
            'edit_category' => true,
            'edit_chunk' => true,
            'edit_context' => true,
            'edit_document' => true,
            'edit_locked' => true,
            'edit_plugin' => true,
            'edit_propertyset' => true,
            'edit_role' => true,
            'edit_snippet' => true,
            'edit_template' => true,
            'edit_tv' => true,
            'edit_user' => true,
            'element_tree' => true,
            'empty_cache' => true,
            'error_log_erase' => true,
            'error_log_view' => true,
            'export_static' => true,
            'file_create' => true,
            'file_list' => true,
            'file_manager' => true,
            'file_remove' => true,
            'file_tree' => true,
            'file_update' => true,
            'file_upload' => true,
            'file_unpack' => true,
            'file_view' => true,
            'flush_sessions' => true,
            'frames' => true,
            'help' => true,
            'home' => true,
            'import_static' => true,
            'languages' => true,
            'lexicons' => true,
            'list' => true,
            'load' => true,
            'logout' => true,
            'logs' => true,
            'menus' => true,
            'menu_reports' => true,
            'menu_security' => true,
            'menu_site' => true,
            'menu_support' => true,
            'menu_system' => true,
            'menu_tools' => true,
            'menu_user' => true,
            'messages' => true,
            'namespaces' => true,
            'new_category' => true,
            'new_chunk' => true,
            'new_context' => true,
            'new_document' => true,
            'new_document_in_root' => true,
            'new_plugin' => true,
            'new_propertyset' => true,
            'new_role' => true,
            'new_snippet' => true,
            'new_static_resource' => true,
            'new_symlink' => true,
            'new_template' => true,
            'new_tv' => true,
            'new_user' => true,
            'new_weblink' => true,
            'packages' => true,
            'policy_delete' => true,
            'policy_edit' => true,
            'policy_new' => true,
            'policy_save' => true,
            'policy_template_delete' => true,
            'policy_template_edit' => true,
            'policy_template_new' => true,
            'policy_template_save' => true,
            'policy_template_view' => true,
            'policy_view' => true,
            'property_sets' => true,
            'providers' => true,
            'publish_document' => true,
            'purge_deleted' => true,
            'remove' => true,
            'remove_locks' => true,
            'resource_duplicate' => true,
            'resourcegroup_delete' => true,
            'resourcegroup_edit' => true,
            'resourcegroup_new' => true,
            'resourcegroup_resource_edit' => true,
            'resourcegroup_resource_list' => true,
            'resourcegroup_save' => true,
            'resourcegroup_view' => true,
            'resource_quick_create' => true,
            'resource_quick_update' => true,
            'resource_tree' => true,
            'save' => true,
            'save_category' => true,
            'save_chunk' => true,
            'save_context' => true,
            'save_document' => true,
            'save_plugin' => true,
            'save_propertyset' => true,
            'save_role' => true,
            'save_snippet' => true,
            'save_template' => true,
            'save_tv' => true,
            'save_user' => true,
            'search' => true,
            'settings' => true,
            'sources' => true,
            'source_delete' => true,
            'source_edit' => true,
            'source_save' => true,
            'source_view' => true,
            'steal_locks' => true,
            'tree_show_element_ids' => true,
            'tree_show_resource_ids' => true,
            'undelete_document' => true,
            'unlock_element_properties' => true,
            'unpublish_document' => true,
            'usergroup_delete' => true,
            'usergroup_edit' => true,
            'usergroup_new' => true,
            'usergroup_save' => true,
            'usergroup_user_edit' => true,
            'usergroup_user_list' => true,
            'usergroup_view' => true,
            'view' => true,
            'view_category' => true,
            'view_chunk' => true,
            'view_context' => true,
            'view_document' => true,
            'view_element' => true,
            'view_eventlog' => true,
            'view_offline' => true,
            'view_plugin' => true,
            'view_propertyset' => true,
            'view_role' => true,
            'view_snippet' => true,
            'view_sysinfo' => true,
            'view_template' => true,
            'view_tv' => true,
            'view_unpublished' => true,
            'view_user' => true,
            'workspaces' => true,
          ),
        ),
        1 => 
        array (
          'principal' => 1,
          'authority' => 9999,
          'policy' => 
          array (
            'mscategory_save' => true,
            'msproduct_save' => true,
            'msorder_save' => true,
            'msorder_view' => true,
            'msorder_list' => true,
            'mssetting_save' => true,
            'mssetting_view' => true,
            'mssetting_list' => true,
            'msproductfile_save' => true,
            'msproductfile_generate' => true,
            'msproductfile_list' => true,
          ),
        ),
      ),
    ),
  ),
);