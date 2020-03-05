<?php
namespace JBartels\RedisDiag\ViewHelpers;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2019 Jan Bartels <j.bartels@arcor.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class DurationViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @param int $duration The duration value
	 * @return string the HTML for the duration
	 */

	public function render( $duration = NULL ) {
		if ($duration === NULL)
			$duration = $this->renderChildren();
		$duration = (int)$duration;
		$content = '';
		$days = floor( $duration / 86400 );
		$duration = $duration - $days * 86400;
		$hours = floor( $duration / 3600 );
		$duration = $duration - $hours * 3600;
		$minutes = floor( $duration / 60 );
		$seconds = $duration % 60;

		if( $days > 0 ) {
			$content .= $days . ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'vh.days', 'redis_diag' );
		}
		if( $hours > 0 || $minutes > 0 || $seconds > 0 ) {
			$content .= ' ' . $hours . ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'vh.hours', 'redis_diag' );
		}
		if( $minutes > 0 || $seconds > 0 ) {
			$content .= ' ' . $minutes . ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'vh.minutes', 'redis_diag' );
		}
		if( $seconds > 0 ) {
			$content .= ' ' . $seconds . ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate( 'vh.seconds', 'redis_diag' );
		}
		return $content;
	}
}
