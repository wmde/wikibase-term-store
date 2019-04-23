<?php

namespace Wikibase\TermStore;

interface TermStoreInstaller {

	/**
	 * @throws TermStoreException
	 */
	public function installOrUpdate();

	/**
	 * @throws TermStoreException
	 */
	public function uninstall();

}