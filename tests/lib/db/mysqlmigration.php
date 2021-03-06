<?php
/**
 * Copyright (c) 2014 Thomas Müller <deepdiver@owncloud.com>
 * This file is licensed under the Affero General Public License version 3 or
 * later.
 * See the COPYING-README file.
 */

class TestMySqlMigration extends \PHPUnit_Framework_TestCase {

	/** @var \Doctrine\DBAL\Connection */
	private $connection;

	/** @var string */
	private $tableName;

	public function setUp() {
		$this->connection = \OC_DB::getConnection();
		if (!$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\MySqlPlatform) {
			$this->markTestSkipped("Test only relevant on MySql");
		}

		$dbPrefix = \OC::$server->getConfig()->getSystemValue("dbtableprefix");
		$this->tableName = uniqid($dbPrefix . "_enum_bit_test");
		$this->connection->exec("CREATE TABLE $this->tableName(b BIT,  e ENUM('1','2','3','4'))");
	}

	public function tearDown() {
		$this->connection->getSchemaManager()->dropTable($this->tableName);
	}

	public function testNonOCTables() {
		$manager = new \OC\DB\MDB2SchemaManager($this->connection);
		$manager->updateDbFromStructure(__DIR__ . '/testschema.xml');

		$this->assertTrue(true);
	}

}
