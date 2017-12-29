<?php

/**
 * JCH Optimize - Aggregate and minify external resources for optmized downloads
 * 
 * @author Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2010 Samuel Marshall
 * @license GNU/GPLv3, See LICENSE file
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
 */
defined('_JCH_EXEC') or die('Restricted access');

class JchOptimizeLinkBuilderBase
{

        /**
         * 
         * @return string
         */
        protected function getAsyncAttribute($iIndex)
        {
                return '';
        }

        /**
         * 
         * @param type $sUrl
         */
        protected function loadCssAsync($sUrl)
        {
                
        }

}

/**
 * 
 * 
 */
class JchOptimizeLinkBuilder extends JchOptimizelinkBuilderBase
{

        /** @var JchOptimizeParser Object       Parser object */
        public $oParser;

        /** @var string         Document line end */
        protected $sLnEnd;

        /** @var string         Document tab */
        protected $sTab;

        /** @var string cache id * */
        protected $params;

        /**
         * Constructor
         * 
         * @param JchOptimizeParser Object  $oParser
         */
        public function __construct($oParser = null)
        {
                $this->oParser = $oParser;
                $this->params  = $this->oParser->params;
                $this->sLnEnd  = $this->oParser->sLnEnd;
                $this->sTab    = $this->oParser->sTab;
        }

        /**
         * Prepare links for the combined files and insert them in the processed HTML
         * 
         */
        public function insertJchLinks()
        {
                $aLinks = $this->oParser->getReplacedFiles();

                if (!JchOptimizeHelper::isMsieLT10() && $this->params->get('combine_files_enable', '1') && !$this->oParser->bAmpPage)
                {
                       // if ($this->params->get('htaccess', 2) == 2)
                       // {
                       //         JchOptimizeHelper::checkModRewriteEnabled($this->params);
                       // }

                        $replace_css_links = false;
			$css_combined = false;
			$js_combined = false;

                        if ($this->params->get('css', 1) && !empty($aLinks['css']))
                        {
                                $sCssCacheId = $this->getCacheId($aLinks['css']);
				//Optimize and cache css files
                                $sCssCache   = $this->getCombinedFiles($aLinks['css'], $sCssCacheId, 'css');

                                if ($this->params->get('pro_optimizeCssDelivery_enable', '0'))
                                {
                                        $sCriticalCss = '<style type="text/css">' . $this->sLnEnd .
                                                $this->getCriticalCss($sCssCacheId) . $this->sLnEnd .
                                                '</style>' . $this->sLnEnd .
                                                '</head>';

                                        $sHeadHtml = preg_replace(
                                                '#' . self::getEndHeadTag() . '#i', JchOptimizeHelper::cleanReplacement($sCriticalCss), $this->oParser->getHeadHtml(), 1);

                                        $this->oParser->setHeadHtml($sHeadHtml);

                                        $sUrl = $this->buildUrl($sCssCacheId, 'css');
                                        $sUrl = str_replace('JCHI', '0', $sUrl);

                                        $this->loadCssAsync($sUrl);
                                }
                                else
                                {
					//If Optimize CSS Delivery feature not enabled then we'll need to insert the link to
					//the combined css file in the HTML
                                        $replace_css_links = true;
                                }

				$css_combined = true;
                        }

                        if ($this->params->get('javascript', 1) && !empty($aLinks['js']))
                        {
                                $sJsCacheId = $this->getCacheId($aLinks['js']);
				//Optimize and cache javascript files
                                $this->getCombinedFiles($aLinks['js'], $sJsCacheId, 'js');

				//Insert link to combined javascript file in HTML
                                $this->replaceLinks($sJsCacheId, 'js');

				$js_combined = true;
                        }

                        if ($replace_css_links)
                        {
				//Insert link to combined css file in HTML
                                $this->replaceLinks($sCssCacheId, 'css');
                        }

			if ($css_combined || $js_combined)
			{
				$this->runCronTasks();
			}
                }

                if (!empty($aLinks['img']))
                {
                        $this->addImgAttributes($aLinks['img']);
                }
        }

	/**
	 *
	 *
	 */
	protected function getCriticalCss($sCssId)
	{
		$sId = md5($this->oParser->getHtmlHash() . $this->oParser->params->get('pro_optimizeCssDelivery', '200'));

                return $this->loadCache(array($this, 'processCriticalCss'), array($sCssId), $sId);
	}
	
	/**
	 *
	 *
	 */
	public function processCriticalCss($sCssId)
	{
		$oParser = $this->oParser;
		$oParser->params->set('pro_InlineScripts', '1');
		$oParser->params->set('pro_InlineStyles', '1');

		$sHtml = $oParser->cleanHtml();

		$oCssParser = new JchOptimizeCssParser($this->params, false);
		$aGet = array(
			'f' => $sCssId,
			'i' => 0,
			'type' => 'css'
		);

		$sCss = JchOptimizeOutput::getCombinedFile($aGet, false);
		$aCssContents = $oCssParser->optimizeCssDelivery($sCss, $sHtml);
		$sCriticalCss = $oCssParser->sortImports($aCssContents['criticalcss']);

		return $sCriticalCss;
	}

        /**
         * 
         * @return type
         */
        protected function getNewJsLink()
        {
                return '<script type="application/javascript" src="URL"></script>';
        }

        /**
         * 
         * @return string
         */
        protected function getNewCssLink()
        {
                return '<link rel="stylesheet" type="text/css" href="URL" />';
        }

        /**
         * Use generated id to cache aggregated file
         *
         * @param string $sType           css or js
         * @param string $sLink           Url for aggregated file
         */
        protected function getCombinedFiles($aLinks, $sId, $sType)
        {
                JCH_DEBUG ? JchPlatformProfiler::start('GetCombinedFiles - ' . $sType) : null;

                $aArgs = array($aLinks, $sType);

                $oCombiner = new JchOptimizeCombiner($this->params, $this->oParser);
                $aFunction = array(&$oCombiner, 'getContents');

                $bCached = $this->loadCache($aFunction, $aArgs, $sId);

                JCH_DEBUG ? JchPlatformProfiler::stop('GetCombinedFiles - ' . $sType, TRUE) : null;

                return $bCached;
        }

        /**
         * 
         * @param type $aImgs
         */
        protected function addImgAttributes($aImgs)
        {
                JCH_DEBUG ? JchPlatformProfiler::start('AddImgAttributes') : null;

                $sHtml = $this->oParser->getBodyHtml();
                $sId   = md5(serialize($aImgs));

		try
		{
			$aImgAttributes = $this->loadCache(array($this, 'getCachedImgAttributes'), array($aImgs), $sId);
		}
		catch(Exception $e)
		{
			return;
		}

                $this->oParser->setBodyHtml(str_replace($aImgs[0], $aImgAttributes, $sHtml));

                JCH_DEBUG ? JchPlatformProfiler::stop('AddImgAttributes', true) : null;
        }

        /**
         * 
         * @param type $aImgs
         */
        public function getCachedImgAttributes($aImgs)
        {
                $aImgAttributes = array();
                $total          = count($aImgs[0]);

                for ($i = 0; $i < $total; $i++)
                {
                        $sUrl = !empty($aImgs[1][$i]) ? $aImgs[1][$i] : (!empty($aImgs[2][$i]) ? $aImgs[2][$i] : $aImgs[3][$i]);

                        if (JchOptimizeUrl::isInvalid($sUrl)
                                || !$this->oParser->isHttpAdapterAvailable($sUrl)
                                || JchOptimizeUrl::isSSL($sUrl) && !extension_loaded('openssl')
                                || !JchOptimizeUrl::isHttpScheme($sUrl))
                        {
                                $aImgAttributes[] = $aImgs[0][$i];
                                continue;
                        }

                        $sPath = JchOptimizeHelper::getFilePath($sUrl);

                        if (file_exists($sPath))
                        {
                                $aSize = getimagesize($sPath);

                                if ($aSize === false || empty($aSize) || ($aSize[0] == '1' && $aSize[1] == '1'))
                                {
                                        $aImgAttributes[] = $aImgs[0][$i];
                                        continue;
                                }

                                $sImg             = preg_replace('#(?:width|height)\s*+=(?:\s*+"([^">]*+)"|\s*+\'([^\'>]*+)\'|([^\s>]++))#i', '',
                                                                 $aImgs[0][$i]);
                                $aImgAttributes[] = preg_replace('#\s*+/?>#', ' ' . $aSize[3] . ' />', $sImg);
                        }
                        else
                        {
                                $aImgAttributes[] = $aImgs[0][$i];
                                continue;
                        }
                }

                return $aImgAttributes;
        }

        /**
         * 
         */
        protected function runCronTasks()
        {
                JCH_DEBUG ? JchPlatformProfiler::start('RunCronTasks') : null;

                $sId = md5($this->oParser->sFileHash . 'CRONTASKS');

                $aArgs = array($this->oParser);

                $oCron     = new JchOptimizeCron($this->params);
                $aFunction = array(&$oCron, 'runCronTasks');

		try
		{
			$bCached = $this->loadCache($aFunction, $aArgs, $sId);
		}
		catch(Exception $e)
		{
		}

                JCH_DEBUG ? JchPlatformProfiler::stop('RunCronTasks', TRUE) : null;
        }

        /**
         * 
         * @param type $aUrlArrays
         * @return type
         */
        private function getCacheId($aUrlArrays)
        {
                $id = md5(serialize($aUrlArrays));

                return $id;
        }

        /**
         * Returns url of aggregated file
         *
         * @param string $sFile		Aggregated file name
         * @param string $sType		css or js
         * @param mixed $bGz		True (or 1) if gzip set and enabled
         * @param number $sTime		Expire header time
         * @return string			Url of aggregated file
         */
        protected function buildUrl($sId, $sType)
        {
                $bGz   = $this->isGZ();

                $htaccess = $this->params->get('htaccess', 2);

		switch ($htaccess)
		{
			case '1':
			case '3':

				$sPath = JchPlatformPaths::assetPath();
				$sPath = $htaccess == 3 ? $sPath . '3' : $sPath;
				$sUrl  = $sPath . JchPlatformPaths::rewriteBase()
					. ($bGz ? 'gz' : 'nz') . '/JCHI/' . $sId . '.' . $sType;

				break;

			case '0':

				$oUri = clone JchPlatformUri::getInstance(JchPlatformPaths::assetPath());

				$oUri->setPath($oUri->getPath() . '2/jscss.php');

				$aVar         = array();
				$aVar['f']    = $sId;
				$aVar['type'] = $sType;
				$aVar['gz']   = $bGz ? 'gz' : 'nz';
				$aVar['i']    = 'JCHI';

				$oUri->setQuery($aVar);

				$sUrl = htmlentities($oUri->toString());

				break;

			case '2':
			default:

				$sPath = JchPlatformPaths::cachePath();
				$sUrl = $sPath . '/' . $sId . '_JCHI.' . $sType;// . ($bGz ? '.gz' : ''); 

				$this->createStaticFiles($sId, $sType);

				break;	
		}

		if($this->params->get('pro_cookielessdomain_enable', '0') && !JchOptimizeUrl::isRootRelative($sUrl))
		{
			$sUrl = JchOptimizeUrl::toRootRelative($sUrl);
		}

                return JchOptimizeHelper::cookieLessDomain($this->params, $sUrl, $sUrl);
        }

	/**
	 *
	 *
	 *
	 */
	protected function createStaticFiles($sId, $sType)
	{
                JCH_DEBUG ? JchPlatformProfiler::start('CreateStaticFiles - ' . $sType) : null;

		$iIndex = $this->oParser->{'iIndex_' . $sType};
		$sCacheFolder = JchPlatformPaths::cachePath(false);

		if(!file_exists($sCacheFolder))
		{
			JchPlatformUtility::createFolder($sCacheFolder);
		}

		for($i = 0; $i <= $iIndex; $i++)
		{
			$sCombinedFile = $sCacheFolder . '/' . $sId . '_' . $i . '.' . $sType; 
				//. ($this->isGZ() ? '.gz' : ''); 

			if(!file_exists($sCombinedFile))
			{
				$aGet = array(
					'f' => $sId,
					'i' => $i,
					'type' => $sType
				);

				$sContent = JchOptimizeOutput::getCombinedFile($aGet, false);

				if($sContent === false)
				{
					throw new Exception('Error retrieving combined contents');
				}

				JchPlatformUtility::write($sCombinedFile, $sContent);
			}
		}

                JCH_DEBUG ? JchPlatformProfiler::stop('CreateStaticFiles - ' . $sType, TRUE) : null;
	}


        /**
	 *
         * 
         * @return type
         */
        protected function cookieLessDomain($sType)
        {
                if ($this->params->get('pro_cookielessdomain_enable', '0'))
                {
                        return JchOptimizeHelper::cookieLessDomain($this->params, JchPlatformPaths::assetPath(true));
                }

                return JchPlatformPaths::assetPath();
        }

        /**
         * Insert url of aggregated file in html
         *
         * @param string $sNewLink   Url of aggregated file
         */
        protected function replaceLinks($sId, $sType)
        {
                JCH_DEBUG ? JchPlatformProfiler::start('ReplaceLinks - ' . $sType) : null;

                $sSearchArea = $this->oParser->getFullHtml();

                $sLink = $this->{'getNew' . ucfirst($sType) . 'Link'}();
                $sUrl  = $this->buildUrl($sId, $sType);

                $sNewLink = str_replace('URL', $sUrl, $sLink);

		//If files were excluded while preserving execution order and a combined js file falls below the last excluded file,
		//or if no files were excluded, we may need to add the async attribute or place it at the bottom 
		if($sType == 'js' && !$this->oParser->bExclude_js)
		{
			//Get last js index
			$iIndex = $this->oParser->iIndex_js;
			$sNewLinkLast = str_replace('JCHI', $iIndex, $sNewLink);

			//Place last combined js file at bottom of page if option is set
			if ($this->params->get('pro_bottom_js', '0') == '1')
			{
				//Add async attribute to last combined js file if option is set
				$sNewLinkLast = str_replace('></script>', $this->getAsyncAttribute($iIndex) . '></script>', $sNewLinkLast);
				$sSearchArea = preg_replace('#' . self::getEndBodyTag() . '#i', $this->sTab . $sNewLinkLast . $this->sLnEnd . '</body>', 
					$sSearchArea, 1);
			}
			//Or put it at the bottom of the HEAD section
			else
			{
				$sSearchArea = preg_replace('#' . self::getEndHeadTag() . '#i', $this->sTab . $sNewLinkLast . $this->sLnEnd . '</head>', 
					$sSearchArea, 1);
			}
		}

		$sSearchArea = preg_replace_callback('#<JCH_' . strtoupper($sType) . '([^>]++)>#',
									   function($aM) use ($sNewLink)
		{
			return str_replace('JCHI', $aM[1], $sNewLink);
		}, $sSearchArea);

                $this->oParser->setFullHtml($sSearchArea);

                JCH_DEBUG ? JchPlatformProfiler::stop('ReplaceLinks - ' . $sType, TRUE) : null;
        }

        /**
         * Create and cache aggregated file if it doesn't exists.
         *
         * @param array $aFunction    Name of function used to aggregate files
         * @param array $aArgs        Arguments used by function above
         * @param string $sId         Generated id to identify cached file
         * @return boolean           True on success
         */
        public function loadCache($aFunction, $aArgs, $sId)
        {
                $bCached   = JchPlatformCache::getCallbackCache($sId, $aFunction, $aArgs);

                if ($bCached === FALSE)
                {
                        throw new Exception('Error creating cache file');
                }

                return $bCached;
        }

        /**
         * Check if gzip is set or enabled
         *
         * @return boolean   True if gzip parameter set and server is enabled
         */
        public function isGZ()
        {
                return ($this->params->get('gzip', 0) && extension_loaded('zlib') && !ini_get('zlib.output_compression')
                        && (ini_get('output_handler') != 'ob_gzhandler'));
        }

        /**
         * Determine if document is of XHTML doctype
         * 
         * @return boolean
         */
        public function isXhtml()
        {
                return (bool) preg_match('#^\s*+(?:<!DOCTYPE(?=[^>]+XHTML)|<\?xml.*?\?>)#i', trim($this->oParser->sHtml));
        }

        /**
         * 
         * @param type $sScript
         * @return type
         */
        protected function cleanScript($sScript)
        {
                if (!$this->isXhtml())
                {
                        $sScript = str_replace(array('<script type="text/javascript"><![CDATA[', ']]></script>'),
                                               array('<script type="text/javascript">', '</script>'), $sScript);
                }

                return $sScript;
        }

	public static function getEndBodyTag()
	{
		$regex = '</body\s*+>(?=(?>[^<>]*+('. JchOptimizeParser::ifRegex() .')?)*?(?:</html\s*+>|$))';

		return $regex;
	}

	public static function getEndHeadTag()
	{
		return '</head\s*+>(?=(?>[^<>]*+('. JchOptimizeParser::ifRegex() .')?)*?(?:<body|$))';
	}

        
}
