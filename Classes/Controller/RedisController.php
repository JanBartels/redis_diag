<?php
namespace JBartels\RedisDiag\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2019 Jan Bartels <j.bartels@arcor.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * RedisController
 */
class RedisController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$redisServers = $this->getCaches();
		$this->view->assign('redisServers', $redisServers);
	}

	protected function getCaches() {

/*
**  Example configuration:
**
**	'SYS' => array(
**		'caching' => array(
**			'cacheConfigurations' => array(
**				'cache_hash' => array(
**					'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\RedisBackend',
**					'options' => array(
**						'hostname' => '1.2.3.4',
**						'port:12345',
**						),
**					),
**				),
*/

		// any cache configured?
		if ( !is_array( $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] ) ) {
			return null;
		}

		// collect all redis-servers
		$servers = array();
		foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $keyCache => $valueCache ) {
			if ( $valueCache[ 'backend' ] == 'TYPO3\\CMS\\Core\\Cache\\Backend\\RedisBackend' ) {
				$hostname = '127.0.0.1';
				$port = 6379;
				if ( $valueCache[ 'options' ] ) {
					if ( $valueCache[ 'options' ][ 'hostname' ] )
						$hostname = $valueCache[ 'options' ][ 'hostname' ];
					if ( $valueCache[ 'options' ][ 'port' ] )
						$port = $valueCache[ 'options' ][ 'port' ];
				}
				$servers[ $hostname . ':' . $port ] = $valueCache[ 'options' ];
			}
		}

		if ( count( $servers ) === 0 ) {
			return null;
		}

		// add all redis-servers
		$redis = new \Redis();

		$caches = array();

		foreach( $servers as $server => $options ) {
			$serveroptions = explode( ':', $server );
			$connectionTimeout = 0;
			if ( $options[ 'connectionTimeout' ] )
				$connectionTimeout = $options[ 'connectionTimeout' ];
			if ( $redis->connect( $serveroptions[ 0 ], $serveroptions[ 1 ], $connectionTimeout ) ) {
				if ( $options[ 'password' ] !== '' ) 
					$redis->auth( $options[ 'password' ] );
				$caches[ $server ] = $redis->info();
				$redis->close();
			}
		}

		return $caches;
	}

}