<?php

declare( strict_types = 1 );

namespace Wikibase\TermStore\PackagePrivate\Doctrine;

use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;

class DoctrineSchemaCreator {

	private $schemaManager;

	public function __construct( AbstractSchemaManager $schemaManager ) {
		$this->schemaManager = $schemaManager;
	}

	public function createSchema() {
		$this->schemaManager->createTable( $this->newItemTermsTable() );
		$this->schemaManager->createTable( $this->newPropertyTermsTable() );
		$this->schemaManager->createTable( $this->newTermInLangTable() );
		$this->schemaManager->createTable( $this->newTextInLangTable() );
		$this->schemaManager->createTable( $this->newTextTable() );
		$this->schemaManager->createTable( $this->newTypeTable() );

	}

	private function newItemTermsTable(): Table {
		$table = new Table( 'wbt_item_terms' );

		$table->addColumn( 'id', Type::BIGINT, [ 'autoincrement' => true, 'unsigned' => true ] );
		$table->addColumn( 'item_id', Type::INTEGER, [ 'unsigned' => true ] );
		$table->addColumn( 'term_in_lang_id', Type::INTEGER, [ 'unsigned' => true ] );

		return $table;
	}

	private function newPropertyTermsTable(): Table {
		$table = new Table( 'wbt_property_terms' );

		$table->addColumn( 'id', Type::INTEGER, [ 'autoincrement' => true, 'unsigned' => true ] );
		$table->addColumn( 'property_id', Type::INTEGER, [ 'unsigned' => true ] );
		$table->addColumn( 'term_in_lang_id', Type::INTEGER, [ 'unsigned' => true ] );

		return $table;
	}

	private function newTermInLangTable(): Table {
		$table = new Table( 'wbt_term_in_lang' );

		$table->addColumn( 'id', Type::INTEGER, [ 'autoincrement' => true, 'unsigned' => true ] );
		$table->addColumn( 'type_id', Type::INTEGER, [ 'unsigned' => true ] );
		$table->addColumn( 'text_in_lang_id', Type::INTEGER, [ 'unsigned' => true ] );

		return $table;
	}

	private function newTextInLangTable(): Table {
		$table = new Table( 'wbt_text_in_lang' );

		$table->addColumn( 'id', Type::INTEGER, [ 'autoincrement' => true, 'unsigned' => true ] );
		$table->addColumn( 'language', Type::BINARY, [ 'length' => 10 ] );
		$table->addColumn( 'text_id', Type::INTEGER, [ 'unsigned' => true ] );

		return $table;
	}

	private function newTextTable(): Table {
		$table = new Table( 'wbt_text' );

		$table->addColumn( 'id', Type::INTEGER, [ 'autoincrement' => true, 'unsigned' => true ] );
		$table->addColumn( 'text', Type::BINARY, [ 'length' => 255 ] );

		return $table;
	}

	private function newTypeTable(): Table {
		$table = new Table( 'wbt_type' );

		$table->addColumn( 'id', Type::INTEGER, [ 'autoincrement' => true, 'unsigned' => true ] );
		$table->addColumn( 'name', Type::BINARY, [ 'length' => 45 ] );

		return $table;
	}

}
