<?php

namespace Wikibase\TermStore\Tests\Unit\Implementations;

use PHPUnit\Framework\TestCase;
use Wikibase\DataModel\Entity\ItemId;
use Wikibase\DataModel\Term\Fingerprint;
use Wikibase\DataModel\Term\Term;
use Wikibase\DataModel\Term\TermList;
use Wikibase\TermStore\Implementations\InMemoryItemTermStore;

/**
 * @covers \Wikibase\TermStore\Implementations\InMemoryItemTermStore
 */
class InMemoryItemTermStoreTest extends TestCase {

	public function testWhenThereAreNoTerms_getTermsReturnsEmptyFingerprint() {
		$store = new InMemoryItemTermStore();

		$this->assertEquals(
			new Fingerprint(),
			$store->getTerms( new ItemId( 'Q404' ) )
		);
	}

	public function testCanStoreTerms() {
		$itemId = new ItemId( 'Q1' );
		$terms = $this->newFingerprint();
		$store = new InMemoryItemTermStore();

		$store->storeTerms( $itemId, $terms );

		$this->assertEquals(
			$terms,
			$store->getTerms( $itemId )
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
		$itemId = new ItemId( 'Q1' );
		$store = new InMemoryItemTermStore();

		$store->storeTerms( $itemId, $this->newFingerprint() );
		$store->deleteTerms( $itemId );

		$this->assertEquals(
			new Fingerprint(),
			$store->getTerms( $itemId )
		);
	}

	public function testDeletionWithUnknownIdCausesNoWarnings() {
		$store = new InMemoryItemTermStore();

		$store->deleteTerms( new ItemId( 'Q404' ) );
		$this->assertTrue( true );
	}

}