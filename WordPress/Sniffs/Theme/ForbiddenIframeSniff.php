<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPress\Sniffs\Theme;

use WordPress\Sniff;
use PHP_CodeSniffer_Tokens as Tokens;

/**
 * Check for use of <iframe>. Often used for malicious code.
 *
 * @link    https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/#info
 *
 * @package WPCS\WordPressCodingStandards
 *
 * @since   0.xx.0
 */
class ForbiddenIframeSniff extends Sniff {

	/**
	 * The regex to catch usage of <iframe ...>.
	 *
	 * This regex will prevent matches being made on `<iframe>` without attributes.
	 *
	 * @var string
	 */
	const IFRAME_REGEX = '`(<iframe\s+[^>]+>)`i';

	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register() {
		return Tokens::$textStringTokens;
	}

	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param int $stackPtr The position of the current token in the stack.
	 *
	 * @return void
	 */
	public function process_token( $stackPtr ) {
		if ( preg_match( self::IFRAME_REGEX, $this->tokens[ $stackPtr ]['content'], $matches ) > 0 ) {
			$this->phpcsFile->addError(
				'Usage of the iframe HTML element is prohibited. Found: %s',
				$stackPtr,
				'Found',
				array( $matches[1] )
			);
		}
	}

}
