<?php

call_user_func(

	static function () {
				'Deprecated PHP entry point used for ImageMapEdit extension. ' .
				'Please use wfLoadExtension instead, ' .
				'see https://www.mediawiki.org/wiki/Extension_registration ' .
				'for more details.'
			);
			return;
		} else {
			die( 'This extension requires MediaWiki 1.29+' );
		}
	}
);
