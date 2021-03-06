<?php

namespace SMW\Test;

use SMW\NamespaceManager;

/**
 * @covers \SMW\NamespaceManager
 * @group semantic-mediawiki
 *
 * @license GNU GPL v2+
 * @since 1.9
 *
 * @author mwjames
 */
class NamespaceManagerTest extends \PHPUnit_Framework_TestCase {

	private function newInstance( &$test = array(), $langCode = 'en' ) {

		$default = array(
			'smwgNamespacesWithSemanticLinks' => array(),
			'wgNamespacesWithSubpages' => array(),
			'wgExtraNamespaces'  => array(),
			'wgNamespaceAliases' => array(),
			'wgLanguageCode'     => $langCode
		);

		$test = array_merge( $default, $test );

		$smwBasePath = __DIR__ . '../../../..';

		return new NamespaceManager( $test, $smwBasePath );
	}

	public function testCanConstruct() {

		$this->assertInstanceOf(
			'\SMW\NamespaceManager',
			$this->newInstance()
		);
	}

	public function testExecution() {

		$test = array();

		$this->newInstance( $test )->init();

		$this->assertNotEmpty(
			$test
		);
	}

	public function testExecutionWithIncompleteConfiguration() {

		$test = array(
			'wgExtraNamespaces'  => '',
			'wgNamespaceAliases' => ''
		);

		$this->newInstance( $test )->init();

		$this->assertNotEmpty(
			$test
		);
	}

	public function testExecutionWithLanguageFallback() {

		$test = array();

		$this->newInstance( $test, 'foo' )->init();

		$this->assertNotEmpty(
			$test
		);
	}

	public function testGetCanonicalNames() {

		$result = NamespaceManager::getCanonicalNames();

		$this->assertInternalType(
			'array',
			$result
		);

		$this->assertCount(
			6,
			$result
		);
	}

	public function testBuildNamespaceIndex() {
		$this->assertInternalType(
			'array',
			NamespaceManager::buildNamespaceIndex( 100 )
		);
	}

	public function testInitCustomNamespace() {

		$test = array();
		NamespaceManager::initCustomNamespace( $test );

		$this->assertNotEmpty( $test );
		$this->assertEquals(
			100,
			$test['smwgNamespaceIndex'],
			'Asserts that smwgNamespaceIndex is being set to a default index'
		);
	}

}
