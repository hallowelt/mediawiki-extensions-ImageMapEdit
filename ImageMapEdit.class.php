<?php
class ImageMapEdit {

	public static function onOutputPageBeforeHTML( &$oParserOutput, &$sText ) {
		$oCurrentTitle = $oParserOutput->getTitle();
		if ( $oCurrentTitle === null || $oCurrentTitle->getNamespace() != NS_FILE || $oParserOutput->getRequest()->getVal( 'action', 'view' ) != 'view' ) {
			return true;
		}
		$oCurrentFile = wfFindFile( $oCurrentTitle );
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

		if ( !$title->userCan( 'edit', $user ) || !in_array( $fileType, $GLOBALS['imeFileTypeList'] ) ) {
			return true;
		}

		$oOutputPage->addModules( 'ext.imagemapedit' );

		return true;
	}
}
