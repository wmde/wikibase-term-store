<?php

namespace Wikibase\TermStore\Tests\Unit\InMemory;

use PHPUnit\Framework\TestCase;
use Wikibase\DataModel\Entity\PropertyId;
use Wikibase\DataModel\Term\Fingerprint;
use Wikibase\DataModel\Term\Term;
use Wikibase\DataModel\Term\TermList;
use Wikibase\TermStore\InMemory\InMemoryPropertyTermStore;

/**
 * @covers \Wikibase\TermStore\InMemory\InMemoryPropertyTermStore
 */
class InMemoryPropertyTermStoreTest extends TestCase {

	public function testWhenThereAreNoTerms_getTermsReturnsEmptyFingerprint() {
		$store = new InMemoryPropertyTermStore();

		$this->assertEquals(
			new Fingerprint(),
			$store->getTerms( new PropertyId( 'P404' ) )
		);
	}

	public function testCanStoreTerms() {
		$propertyId = new PropertyId( 'P1' );
		$terms = $this->newFingerprint();
		$store = new InMemoryPropertyTermStore();

		$store->storeTerms( $propertyId, $terms );

		$this->assertEquals(
			$terms,
			$store->getTerms( $propertyId )
		);
	}

	private function newFingerprint() {
		return new Fingerprint(
			new TermList( [
				new Term( 'en', 'EnglishTerm' )
			] )
		);
	}

	public function testCanDeleteTerms() {
		$propertyId = new PropertyId( 'P1' );
		$store = new InMemoryPropertyTermStore();

		$store->storeTerms( $propertyId, $this->newFingerprint() );
		$store->deleteTerms( $propertyId );

		$this->assertEquals(
			new Fingerprint(),
			$store->getTerms( $propertyId )
		);
	}

	public function testDeletionWithUnknownIdCausesNoWarnings() {
		$store = new InMemoryPropertyTermStore();

		$store->deleteTerms( new PropertyId( 'P404' ) );
		$this->assertTrue( true );
	}

}