<?php
/**
 * Image Replacement Handler
 *
 * @package Kadence Starter Templates
 */

namespace KadenceWP\KadenceStarterTemplates\ContentReplace;

/**
 * Image Replacer Class
 */
class Image_Replacer {

	/**
	 * Replace single image in content
	 *
	 * @param string $content The content to replace images in.
	 * @param array  $replacement The replacement array.
	 * @return string
	 */
	private static function replace_image_string( $content, $replacement ) {
		$info = strpos($content, '"url":"' . $replacement['from'] . '"');
		if (false !== $info) {
			$content = substr_replace($content, '"url":"' . $replacement['to'] . '"', $info, strlen('"url":"' . $replacement['from'] . '"'));
			$pos = strpos($content, $replacement['from']);
			if (false !== $pos) {
				$content = substr_replace($content, $replacement['to'], $pos, strlen($replacement['from']));
			}
		} else {
			$pos = strpos($content, $replacement['from']);
			if (false !== $pos) {
				$content = substr_replace($content, $replacement['to'], $pos, strlen($replacement['from']));
			}
		}
		return $content;
	}
	/**
	 * Replace images in content
	 *
	 * @param string $content The content to replace images in.
	 * @param array  $images The image collection data.
	 * @param array  $categories The categories.
	 * @param mixed  $context The context.
	 * @param int    $variation The variation number.
	 * @param array  $team_collection The team collection data.
	 * @param bool   $hero Whether this is a hero section.
	 * @return string
	 */
	public static function replace_images( $content, $images, $categories = [], $context = null, $variation = 0, $team_collection = [], $hero = false ) {
		if ( empty( $content ) ) {
			return $content;
		}
		if ( empty( $images['data'][0]['images'] ) ) {
			return $content;
		}

		$a_roll = $images['data'][0]['images'];
		$b_roll = ! empty( $images['data'][1]['images'] ) ? $images['data'][1]['images'] : $images['data'][0]['images'];
		$p_roll = ! empty( $images['data'][2]['images'] ) ? $images['data'][2]['images'] : null;

		if ( empty( $p_roll ) && ! empty( $categories[0] ) && ( $categories[0] === 'team' || $categories[0] === 'testimonials' ) && ! empty( $team_collection['data'][0]['images'] ) ) {
			$p_roll = $team_collection['data'][0]['images'];
		}
		if ( empty( $p_roll ) ) {
			$p_roll = ! empty( $images['data'][1]['images'] ) ? $images['data'][1]['images'] : $images['data'][0]['images'];
		}

		$reset_variation = 0;
		$b_variation = $variation;
		if ( $b_variation > count( $b_roll ) ) {
			$b_variation = $b_variation - count( $b_roll );
		}
		if ( $b_variation > count( $b_roll ) ) {
			$b_variation = $b_variation - count( $b_roll );
		}

		$p_variation = $variation;
		if ( $p_variation > count( $p_roll ) ) {
			$p_variation = $p_variation - count( $p_roll );
		}
		if ( $p_variation > count( $p_roll ) ) {
			$p_variation = $p_variation - count( $p_roll );
		}

		$imgs = array(
			'a1' => self::get_image_src( $a_roll, $variation, 0 ),
			'a2' => self::get_image_src( $a_roll, $variation + 1, $reset_variation ),
			'a3' => self::get_image_src( $a_roll, $variation + 2, $reset_variation + 1 ),
			'a4' => self::get_image_src( $a_roll, $variation + 3, $reset_variation + 2 ),
			'a5' => self::get_image_src( $a_roll, $variation + 4, $reset_variation + 3 ),
			'b1' => self::get_image_src( $b_roll, $b_variation, 0 ),
			'b2' => self::get_image_src( $b_roll, $b_variation + 1, 1 ),
			'b3' => self::get_image_src( $b_roll, $b_variation + 2, 2, 1 ),
			'b4' => self::get_image_src( $b_roll, $b_variation + 3, 3, 2 ),
			'b5' => self::get_image_src( $b_roll, $b_variation + 4, 4, 3 ),
			'b6' => self::get_image_src( $b_roll, $b_variation + 5, 5, 4 ),
			'p1' => self::get_image_src( $p_roll, $p_variation, 0 ),
			'p2' => self::get_image_src( $p_roll, $p_variation + 1, 1 ),
			'p3' => self::get_image_src( $p_roll, $p_variation + 2, 2, 1 ),
			'p4' => self::get_image_src( $p_roll, $p_variation + 3, 3, 2 ),
			'p5' => self::get_image_src( $p_roll, $p_variation + 4, 4, 3 ),
			'p6' => self::get_image_src( $p_roll, $p_variation + 5, 5, 4 ),
			'p7' => self::get_image_src( $p_roll, $p_variation + 6, 6, 5 ),
			'p8' => self::get_image_src( $p_roll, $p_variation + 7, 7, 6, 0 ),
			'p9' => self::get_image_src( $p_roll, $p_variation + 8, 8, 7, 1 ),
		);

		if ( $hero && $hero === 'hero' ) {
			$variation = 0;
		}
		if ( $hero && $hero === 'secondary' ) {
			$imgs['p1'] = self::get_image_src( $a_roll, 0, 0 );
		}

		// Handle special contexts
		if ( $context && ( $context == '14499' || $context == '18895' ) ) {
			// Cards 21 & Video 23
			$card_source = 'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-A-Roll-Image-scaled.jpg';
			$card_replacements = array(
				array( 'from' => $card_source, 'to' => $imgs['a1'] ),
				array( 'from' => $card_source, 'to' => $imgs['a1'] ),
				array( 'from' => $card_source, 'to' => $imgs['a2'] ),
				array( 'from' => $card_source, 'to' => $imgs['a2'] ),
				array( 'from' => $card_source, 'to' => $imgs['a3'] ),
				array( 'from' => $card_source, 'to' => $imgs['a3'] ),
				array( 'from' => $card_source, 'to' => $imgs['a4'] ),
				array( 'from' => $card_source, 'to' => $imgs['a4'] ),
			);

			foreach ( $card_replacements as $replacement ) {
				// This needs to replace the first instance of the image for each replacement.
				$content = self::replace_image_string( $content, $replacement );
			}
		}
		if ( ! empty( $categories[0] ) && ( $categories[0] === 'team' || $categories[0] === 'testimonials' ) ) {
			// Team and Testimonial People
			$team_source = 'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-Portrait-Image-scaled.jpg';
			$team_source_2 = 'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-819x1024.jpg';
			$team_replacements = array(
				array( 'from' => $team_source, 'to' => $imgs['p1'] ),
				array( 'from' => $team_source, 'to' => $imgs['p2'] ),
				array( 'from' => $team_source, 'to' => $imgs['p3'] ),
				array( 'from' => $team_source, 'to' => $imgs['p4'] ),
				array( 'from' => $team_source, 'to' => $imgs['p5'] ),
				array( 'from' => $team_source, 'to' => $imgs['p6'] ),
				array( 'from' => $team_source_2, 'to' => $imgs['p6'] ),
				array( 'from' => $team_source_2, 'to' => $imgs['p5'] ),
				array( 'from' => $team_source_2, 'to' => $imgs['p4'] ),
				array( 'from' => $team_source_2, 'to' => $imgs['p3'] ),
				array( 'from' => $team_source_2, 'to' => $imgs['p2'] ),
				array( 'from' => $team_source_2, 'to' => $imgs['p1'] ),
			);

			foreach ( $team_replacements as $replacement ) {
				// This needs to replace the first instance of the image for each replacement. Have to verify that the needle is in the haystack.
				$content = self::replace_image_string( $content, $replacement );
			}
		}

		// Replace A Roll images
		$a_roll_replacements = self::get_a_roll_replacements( $imgs );
		foreach ( $a_roll_replacements as $replacement ) {
			$content = self::replace_image_string( $content, $replacement );
		}

		// Replace B Roll images
		$b_roll_replacements = self::get_b_roll_replacements( $imgs );
		foreach ( $b_roll_replacements as $replacement ) {
			$content = self::replace_image_string( $content, $replacement );
		}

		// Replace Portrait images
		$portrait_replacements = self::get_portrait_replacements( $imgs );
		foreach ( $portrait_replacements as $replacement ) {
			$content = self::replace_image_string( $content, $replacement );
		}

		// Replace extra images
		$extra_replacements = self::get_extra_replacements( $imgs );
		foreach ( $extra_replacements as $replacement ) {
			$content = self::replace_image_string( $content, $replacement );
		}

		return $content;
	}

	/**
	 * Get image source from roll
	 *
	 * @param array $roll The image roll.
	 * @param int   $primary_index Primary index to check.
	 * @param int   $fallback_index First fallback index.
	 * @param int   $fallback_index_2 Second fallback index.
	 * @param int   $fallback_index_3 Third fallback index.
	 * @return string
	 */
	private static function get_image_src( $roll, $primary_index, $fallback_index, $fallback_index_2 = null, $fallback_index_3 = null ) {
		if ( ! empty( $roll[ $primary_index ]['sizes'][0]['src'] ) ) {
			return $roll[ $primary_index ]['sizes'][0]['src'];
		}
		if ( ! empty( $roll[ $fallback_index ]['sizes'][0]['src'] ) ) {
			return $roll[ $fallback_index ]['sizes'][0]['src'];
		}
		if ( ! is_null( $fallback_index_2 ) && ! empty( $roll[ $fallback_index_2 ]['sizes'][0]['src'] ) ) {
			return $roll[ $fallback_index_2 ]['sizes'][0]['src'];
		}
		if ( ! is_null( $fallback_index_3 ) && ! empty( $roll[ $fallback_index_3 ]['sizes'][0]['src'] ) ) {
			return $roll[ $fallback_index_3 ]['sizes'][0]['src'];
		}
		return ! empty( $roll[0]['sizes'][0]['src'] ) ? $roll[0]['sizes'][0]['src'] : '';
	}

	/**
	 * Get A Roll replacements
	 *
	 * @param array $imgs The image array.
	 * @return array
	 */
	private static function get_a_roll_replacements( $imgs ) {
		$aRollS =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-A-Roll-Image-scaled.jpg';
		$aRollS1 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-A-Roll-Image-scaled-1.jpg';
		$aRollSML =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-A-Roll-Image-scaled-600x465.jpg';
		$aRollBG =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-A-Roll-Image-2048x1586.jpg';
		$aRollXL =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-A-Roll-Image-1536x1189.jpg';
		$aRollL =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-A-Roll-Image-1024x793.jpg';
		$aReplacements = [
			array( 'from' => $aRollS, 'to' => $imgs['a1'] ),
			array( 'from' => $aRollS, 'to' => $imgs['a2'] ),
			array( 'from' => $aRollS, 'to' => $imgs['a3'] ),
			array( 'from' => $aRollS, 'to' => $imgs['a4'] ),
			array( 'from' => $aRollS, 'to' => $imgs['a5'] ),
			array( 'from' => $aRollS, 'to' => $imgs['a1'] ),
			array( 'from' => $aRollS, 'to' => $imgs['a2'] ),
			array( 'from' => $aRollS, 'to' => $imgs['b1'] ),
			array( 'from' => $aRollS, 'to' => $imgs['b2'] ),
			array( 'from' => $aRollS, 'to' => $imgs['b3'] ),
			array( 'from' => $aRollS1, 'to' => $imgs['a1'] ),
			array( 'from' => $aRollSML, 'to' => $imgs['a2'] ),
			array( 'from' => $aRollBG, 'to' => $imgs['a3'] ),
			array( 'from' => $aRollBG, 'to' => $imgs['a4'] ),
			array( 'from' => $aRollBG, 'to' => $imgs['a5'] ),
			array( 'from' => $aRollBG, 'to' => $imgs['a1'] ),
			array( 'from' => $aRollBG, 'to' => $imgs['a2'] ),
			array( 'from' => $aRollBG, 'to' => $imgs['b1'] ),
			array( 'from' => $aRollBG, 'to' => $imgs['b2'] ),
			array( 'from' => $aRollBG, 'to' => $imgs['b3'] ),
			array( 'from' => $aRollXL, 'to' => $imgs['a3'] ),
			array( 'from' => $aRollL, 'to' => $imgs['a1'] ),
			array( 'from' => $aRollL, 'to' => $imgs['a2'] ),
			array( 'from' => $aRollL, 'to' => $imgs['a3'] ),
			array( 'from' => $aRollL, 'to' => $imgs['a4'] ),
			array( 'from' => $aRollL, 'to' => $imgs['a5'] ),
			array( 'from' => $aRollL, 'to' => $imgs['a3'] ),
		];
		return $aReplacements;
	}

	/**
	 * Get B Roll replacements
	 *
	 * @param array $imgs The image array.
	 * @return array
	 */
	private static function get_b_roll_replacements( $imgs ) {
		// B Roll.
		// B Roll.
		$bRoll8L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-8-819x1024.jpg';
		$bRoll6L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-6-819x1024.jpg';
		$bRoll4L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-4-819x1024.jpg';
		$bRoll1L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-1-819x1024.jpg';
		$bRoll7L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-7-819x1024.jpg';
		$bRoll5L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-5-819x1024.jpg';
		$bRoll3L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-3-819x1024.jpg';
		$bRoll2L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-2-819x1024.jpg';
		$bRoll9L =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-9-819x1024.jpg';
		$bRollS =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-scaled.jpg';
		$bRollS1 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-1-scaled.jpg';
		$bRollS2 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-2-scaled.jpg';
		$bRollS3 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-3-scaled.jpg';
		$bRollL =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-819x1024.jpg';
		$bRollL1 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-B-Roll-Image-819x1024-1.jpg';
		$bRollML =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-B-Roll-Image-768x960.jpg';
		$bg5 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Image-5.jpeg';
		$bg51 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Image-5-1.jpeg';
		$exampleBG =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-Background-Image.jpg';
		$exampleBGL =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-Background-Image-1024x672.jpg';
		$bgReplacements = [
			array( 'from' => $bRoll8L, 'to' => $imgs['a5'] ),
			array( 'from' => $bRoll6L, 'to' => $imgs['a4'] ),
			array( 'from' => $bRoll4L, 'to' => $imgs['a3'] ),
			array( 'from' => $bRoll1L, 'to' => $imgs['a2'] ),
			array( 'from' => $bRoll7L, 'to' => $imgs['b1'] ),
			array( 'from' => $bRoll5L, 'to' => $imgs['b2'] ),
			array( 'from' => $bRoll3L, 'to' => $imgs['b3'] ),
			array( 'from' => $bRoll2L, 'to' => $imgs['b4'] ),
			array( 'from' => $bRoll9L, 'to' => $imgs['b5'] ),
			array( 'from' => $bRollS, 'to' => $imgs['b1'] ),
			array( 'from' => $bRollS, 'to' => $imgs['b2'] ),
			array( 'from' => $bRollS, 'to' => $imgs['b3'] ),
			array( 'from' => $bRollS1, 'to' => $imgs['b4'] ),
			array( 'from' => $bRollS2, 'to' => $imgs['b5'] ),
			array( 'from' => $bRollS3, 'to' => $imgs['b6'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b1'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b2'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b3'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b4'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b5'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b6'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b1'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b2'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b3'] ),
			array( 'from' => $bRollL, 'to' => $imgs['b4'] ),
			array( 'from' => $bRollL1, 'to' => $imgs['b5'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b1'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b2'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b3'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b4'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b5'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b6'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b1'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b2'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b3'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b4'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b5'] ),
			array( 'from' => $bRollML, 'to' => $imgs['b6'] ),
			array( 'from' => $bg5, 'to' => $imgs['b1'] ),
			array( 'from' => $bg5, 'to' => $imgs['b2'] ),
			array( 'from' => $bg5, 'to' => $imgs['b3'] ),
			array( 'from' => $bg51, 'to' => $imgs['b4'] ),
			array( 'from' => $exampleBG, 'to' => $imgs['b1'] ),
			array( 'from' => $exampleBG, 'to' => $imgs['b2'] ),
			array( 'from' => $exampleBG, 'to' => $imgs['b3'] ),
			array( 'from' => $exampleBGL, 'to' => $imgs['b4'] ),
			array( 'from' => $exampleBGL, 'to' => $imgs['b5'] ),
		];
		return $bgReplacements;
	}

	/**
	 * Get Portrait replacements
	 *
	 * @param array $imgs The image array.
	 * @return array
	 */
	private static function get_portrait_replacements( $imgs ) {
		$portS1 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-Portrait-Image-scaled-1-1224x683.jpg';
		$portS =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-Portrait-Image-scaled.jpg';
		$port = 'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-Portrait-Image.jpg';
		$portL =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-Portrait-Image-1024x683.jpg';
		$portT =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-Portrait-Image-150x150.jpg';
		$portM =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/02/Example-Portrait-Image-300x200.jpg';
		$portraitL =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-Portrait-Image-1024x683.jpg';
		$portraitT =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-Portrait-Image-150x150.jpg';
		$portraitTS =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-Portrait-Image-scaled-150x150.jpg';
		$portraitTS1 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-Portrait-Image-scaled-1-150x150.jpg';
		$portraitM =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-Portrait-Image-300x200.jpg';
		$portraitMS =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-Portrait-Image-scaled-300x200.jpg';
		$portraitMS1 =
		'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/Example-Portrait-Image-scaled-1-300x200.jpg';
		$portraitReplacements = [
			array( 'from' => $portS1, 'to' => $imgs['p1'] ),
			array( 'from' => $portS, 'to' => $imgs['p1'] ),
			array( 'from' => $portS, 'to' => $imgs['p2'] ),
			array( 'from' => $portS, 'to' => $imgs['p3'] ),
			array( 'from' => $port, 'to' => $imgs['p1'] ),
			array( 'from' => $port, 'to' => $imgs['p2'] ),
			array( 'from' => $port, 'to' => $imgs['p3'] ),
			array( 'from' => $port, 'to' => $imgs['p4'] ),
			array( 'from' => $port, 'to' => $imgs['p5'] ),
			array( 'from' => $portL, 'to' => $imgs['p1'] ),
			array( 'from' => $portL, 'to' => $imgs['p2'] ),
			array( 'from' => $portL, 'to' => $imgs['p3'] ),
			array( 'from' => $portL, 'to' => $imgs['p4'] ),
			array( 'from' => $portL, 'to' => $imgs['p5'] ),
			array( 'from' => $portL, 'to' => $imgs['p6'] ),
			array( 'from' => $portL, 'to' => $imgs['p7'] ),
			array( 'from' => $portL, 'to' => $imgs['p8'] ),
			array( 'from' => $portL, 'to' => $imgs['p9'] ),
			array( 'from' => $portT, 'to' => $imgs['p1'] ),
			array( 'from' => $portT, 'to' => $imgs['p2'] ),
			array( 'from' => $portT, 'to' => $imgs['p3'] ),
			array( 'from' => $portT, 'to' => $imgs['p4'] ),
			array( 'from' => $portM, 'to' => $imgs['p1'] ),
			array( 'from' => $portM, 'to' => $imgs['p2'] ),
			array( 'from' => $portM, 'to' => $imgs['p3'] ),
			array( 'from' => $portM, 'to' => $imgs['p4'] ),
			array( 'from' => $portraitL, 'to' => $imgs['p1'] ),
			array( 'from' => $portraitL, 'to' => $imgs['p2'] ),
			array( 'from' => $portraitL, 'to' => $imgs['p3'] ),
			array( 'from' => $portraitL, 'to' => $imgs['p4'] ),
			array( 'from' => $portraitT, 'to' => $imgs['p1'] ),
			array( 'from' => $portraitT, 'to' => $imgs['p2'] ),
			array( 'from' => $portraitT, 'to' => $imgs['p3'] ),
			array( 'from' => $portraitT, 'to' => $imgs['p4'] ),
			array( 'from' => $portraitTS, 'to' => $imgs['p1'] ),
			array( 'from' => $portraitTS, 'to' => $imgs['p2'] ),
			array( 'from' => $portraitTS, 'to' => $imgs['p3'] ),
			array( 'from' => $portraitTS, 'to' => $imgs['p4'] ),
			array( 'from' => $portraitTS1, 'to' => $imgs['p1'] ),
			array( 'from' => $portraitTS1, 'to' => $imgs['p2'] ),
			array( 'from' => $portraitTS1, 'to' => $imgs['p3'] ),
			array( 'from' => $portraitTS1, 'to' => $imgs['p4'] ),
			array( 'from' => $portraitM, 'to' => $imgs['p1'] ),
			array( 'from' => $portraitM, 'to' => $imgs['p2'] ),
			array( 'from' => $portraitM, 'to' => $imgs['p3'] ),
			array( 'from' => $portraitM, 'to' => $imgs['p4'] ),
			array( 'from' => $portraitM, 'to' => $imgs['p5'] ),
			array( 'from' => $portraitM, 'to' => $imgs['p6'] ),
			array( 'from' => $portraitMS, 'to' => $imgs['p1'] ),
			array( 'from' => $portraitMS, 'to' => $imgs['p2'] ),
			array( 'from' => $portraitMS, 'to' => $imgs['p3'] ),
			array( 'from' => $portraitMS, 'to' => $imgs['p4'] ),
			array( 'from' => $portraitMS, 'to' => $imgs['p5'] ),
			array( 'from' => $portraitMS, 'to' => $imgs['p6'] ),
			array( 'from' => $portraitMS1, 'to' => $imgs['p1'] ),
			array( 'from' => $portraitMS1, 'to' => $imgs['p2'] ),
			array( 'from' => $portraitMS1, 'to' => $imgs['p3'] ),
			array( 'from' => $portraitMS1, 'to' => $imgs['p4'] ),
			array( 'from' => $portraitMS1, 'to' => $imgs['p5'] ),
			array( 'from' => $portraitMS1, 'to' => $imgs['p6'] ),
		];
		return $portraitReplacements;
	}

	/**
	 * Get extra replacements
	 *
	 * @param array $imgs The image array.
	 * @return array
	 */
	private static function get_extra_replacements( $imgs ) {
		return array(
			array( 'from' => 'https://base.startertemplatecloud.com/wp-content/uploads/2023/12/Example-A-Roll-Image-scaled-2.jpg', 'to' => $imgs['a3'] ),
			array( 'from' => 'https://base.startertemplatecloud.com/wp-content/uploads/2023/12/Example-A-Roll-Image-scaled-1.jpg', 'to' => $imgs['a1'] ),
			array( 'from' => 'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/mug-product-2.jpg', 'to' => $imgs['a1'] ),
			array( 'from' => 'https://patterns.startertemplatecloud.com/wp-content/uploads/2023/03/mug-product-2-300x300.jpg', 'to' => $imgs['a1'] ),
		);
	}
} 