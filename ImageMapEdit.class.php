<?php

use MediaWiki\MediaWikiServices;

class ImageMapEdit {

	public static function onOutputPageBeforeHTML( &$oParserOutput, &$sText ) {
		$oCurrentTitle = $oParserOutput->getTitle();
		if ( $oCurrentTitle === null || $oCurrentTitle->getNamespace() != NS_FILE || $oParserOutput->getRequest()->getVal( 'action', 'view' ) != 'view' ) {
			return true;
		}
		$repoGroup = MediaWikiServices::getInstance()->getRepoGroup();
		$oCurrentFile = $repoGroup->findFile( $oCurrentTitle );
		if ( $oCurrentFile && !$oCurrentFile->canRender() ) {
			return true;
		}
		return true;
	}

	/**
	 *
	 * @param OutputPage &$oOutputPage
	 * @param Skin &$oSkin
	 *
	 * @return bool
	 */
	public static function onBeforePageDisplay( &$oOutputPage, &$oSkin ) {
		if ( $oOutputPage->getTitle()->getNamespace() != NS_FILE || $oOutputPage->getRequest()->getVal( 'action', 'view' ) != 'view' ) {
			return true;
		}

		$user = $oSkin->getUser();
		$title = $oSkin->getTitle();

		$titleParts = explode( '.', $title->getText() );
		$fileType = $titleParts[count( $titleParts ) - 1];

		$userCanEdit = MediaWikiServices::getInstance()->getPermissionManager()->userCan( 'edit', $user, $title );
		if ( !$userCanEdit || !in_array( $fileType, $GLOBALS['imeFileTypeList'] ) ) {
			return true;
		}

		$oOutputPage->addModules( 'ext.imagemapedit' );

		return true;
	}
}
