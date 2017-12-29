<?php

/**
 * JCH Optimize - Joomla! plugin to aggregate and minify external resources for
 * optmized downloads
 *
 * @author Samuel Marshall <sdmarshall73@gmail.com>
 * @copyright Copyright (c) 2014 Samuel Marshall
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
defined('_WP_EXEC') or die('Restricted access');

class JchPlatformUri implements JchInterfaceUri
{

        private $aUri;
        private static $aInstances;
        private static $base = array();

        /**
         * 
         * @param type $path
         */
        public function setPath($path)
        {
                $this->aUri['path'] = $path;
        }

        /**
         * 
         * @return type
         */
        public function getPath()
        {
                return isset($this->aUri['path']) ? $this->_cleanPath($this->aUri['path']) : '';
        }

        /**
         * 
         * @param array $parts
         * @return type
         */
        public function toString(array $parts = array('scheme', 'user', 'pass', 'host', 'port', 'path', 'query', 'fragment'))
        {
                $url = '';

                if (in_array('scheme', $parts) && isset($this->aUri['scheme']))
                {

                        $url .= $this->aUri['scheme'] . '://';
                }

                if (in_array('user', $parts) && isset($this->aUri['user']))
                {

                        $url .= $this->aUri['user'];

                        if (in_array('pass', $parts) && isset($this->aUri['pass']))
                        {

                                $url .= ':' . $this->aUri['pass'];
                        }

                        $url .= '@';
                }

                if (in_array('host', $parts) && isset($this->aUri['host']))
                {

                        $url .= $this->aUri['host'];
                }

                if (in_array('port', $parts) && isset($this->aUri['port']))
                {
                        $url .= ':' . $this->aUri['port'];
                }

                if (in_array('path', $parts) && isset($this->aUri['path']))
                {
                        $url .= $this->getPath();
                }

                if (in_array('query', $parts) && isset($this->aUri['query']))
                {
                        $url .= '?' . $this->aUri['query'];
                }

                if (in_array('fragment', $parts) && isset($this->aUri['fragment']))
                {
                        $url .= '#' . $this->aUri['fragment'];
                }

                return $url;
        }

        /**
         * 
         * @param type $pathonly
         * @return type
         */
        public static function base($pathonly = FALSE)
        {
                if(empty(self::$base))
                {
                        $uri = self::getInstance();
                        
                        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                        $path = str_replace('/wp-admin', '', $path);
                        
                        self::$base['pathonly'] = $path;
                        self::$base['base'] = $uri->toString(array('scheme', 'host', 'port')) . $path . '/';
                }

                return $pathonly ? self::$base['pathonly'] : self::$base['base'];
        }

        /**
         * 
         * @param type $uri
         * @return \JchPlatformUri
         */
        public static function getInstance($uri = 'SERVER')
        {
                if (empty(self::$aInstances[$uri]))
                {
                        self::$aInstances[$uri] = new JchPlatformUri($uri);
                }

                return self::$aInstances[$uri];
        }

        /**
         * 
         * @param type $uri
         * @return type
         */
        private function __construct($uri)
        {
                
                if($uri == 'SERVER')
                {
                        $scheme = is_ssl() ? 'https://' : 'http://';
                        $uri = $scheme . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        
                        // Extra cleanup to remove invalid chars in the URL to prevent injections through the Host header
                        $uri = str_replace(array("'", '"', '<', '>'), array("%27", "%22", "%3C", "%3E"), $uri);
                }

                $this->aUri = JchOptimizeHelper::parseUrl($uri);
        }

        /**
         * 
         * @param type $query
         */
        public function setQuery($query)
        {
                $this->aUri['query'] = http_build_query($query);
        }

        /**
         * 
         * @return type
         */
        public static function currentUrl()
        {
                $oUri = JchPlatformUri::getInstance();

                return $oUri->toString(array('scheme', 'host', 'port', 'path'));
        }


        /**
         * 
         * @param type $path
         * @return type
         */
        private function _cleanPath($path)
        {
                $path = explode('/', preg_replace('#(/+)#', '/', $path));

                for ($i = 0, $n = count($path); $i < $n; $i++)
                {
                        if ($path[$i] == '.' || $path[$i] == '..')
                        {
                                if (($path[$i] == '.') || ($path[$i] == '..' && $i == 1 && $path[0] == ''))
                                {
                                        unset($path[$i]);
                                        $path = array_values($path);
                                        $i--;
                                        $n--;
                                }
                                elseif ($path[$i] == '..' && ($i > 1 || ($i == 1 && $path[0] != '')))
                                {
                                        unset($path[$i]);
                                        unset($path[$i - 1]);
                                        $path = array_values($path);
                                        $i -= 2;
                                        $n -= 2;
                                }
                        }
                }

                return implode('/', $path);
        }

        /**
         * 
         * @param type $host
         */
        public function setHost($host)
        {
                $this->aUri['host'] = $host;
        }

        /**
         * 
         * @return type
         */
        public function getHost()
        {
                return $this->aUri['host'];
        }

        /**
         * 
         * @return type
         */
        public function getQuery()
        {
                return $this->aUri['query'];
        }

        /**
         * 
         * @return type
         */
        public function getScheme()
        {
                return $this->aUri['scheme'];
        }

        /**
         * 
         * @param type $scheme
         */
        public function setScheme($scheme)
        {
                $this->aUri['scheme'] = $scheme;
        }

}
