<?php

declare( strict_types = 1 );

namespace Wikibase\TermStore;

interface InstallationEventHandler {

	public function onStartedInstall();

	public function onFinishedInstall();

	public function onAlreadyInstalled();

}
