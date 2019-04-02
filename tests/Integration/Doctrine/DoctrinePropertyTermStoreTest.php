<?php

declare( strict_types = 1 );

namespace Wikibase\TermStore\Tests\Integration\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use PHPUnit\Framework\TestCase;
use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\DataModel\Term\Fingerprint;
use Wikibase\DataModel\Term\Term;
use Wikibase\DataModel\Term\TermList;
use Wikibase\TermStore\DoctrineStoreFactory;
use Wikibase\TermStore\PropertyTermStore;

/**
 * @covers \Wikibase\TermStore\PackagePrivate\Doctrine\DoctrinePropertyTermStore
 */
class DoctrinePropertyTermStoreTest extends TestCase {

	const UNKNOWN_PROPERTY_ID = 'P404';

	/**
	 * @var PropertyTermStore
	 */
	private $store;

	/**
	 * @var Connection
	 */
	private $connection;

	public function setUp() {
		$this->connection = DriverManager::getConnection( [
			'driver' => 'pdo_sqlite',
			'memory' => true,
		] );

		$factory = new DoctrineStoreFactory( $this->connection );

		$factory->createSchema();

		$this->store = $factory->newPropertyTermStore();
	}

	public function testWhenPropertyIsNotStored_getTermsReturnsEmptyFingerprint() {
		$this->assertEquals(
			new Fingerprint(),
			$this->store->getTerms( new PropertyId( self::UNKNOWN_PROPERTY_ID ) )
		);
	}

	public function testTempPropertyTerms() {
		$propertyId = new PropertyId( 'P1' );
		$fingerprint = new Fingerprint(
			new TermList( [ new Term( 'en', 'EnglishLabel' ) ] )
		);

		$this->store->storeTerms( $propertyId, $fingerprint );

		$this->assertEquals(
			[
				'id' => 1,
				'property_id' => 1,
				'term_in_lang_id' => 1,
			],
			$this->connection->executeQuery( 'SELECT * FROM wbt_property_terms' )->fetch()
		);
	}

	public function testLabelRoundtrip() {
		$propertyId = new PropertyId( 'P1' );
		$fingerprint = new Fingerprint(
			new TermList( [ new Term( 'en', 'EnglishLabel' ) ] )
		);

		$this->store->storeTerms( $propertyId, $fingerprint );

		$this->assertEquals(
			$fingerprint,
			$this->store->getTerms( $propertyId )
		);
	}

}
