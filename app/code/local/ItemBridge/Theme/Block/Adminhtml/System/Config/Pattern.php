<?php

/**
 * System Configuration pattern input
 *
 * @category    ItemBridge
 * @package     ItemBridge_Theme
 * @copyright   Copyright (c) 2013 InfoStyle (http://infostyle.com.ua)
 * @license     http://themeforest.net/licenses/regular_extended ThemeForest Regular & Extended License
 */

class ItemBridge_Theme_Block_Adminhtml_System_Config_Pattern extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setType('hidden');
        $src = Mage::getBaseUrl('skin') . "frontend/precise/default/img/patterns/";
        $html = '<div class="patterns-box" style="overflow: hidden;">';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'bgnoise_lg.png);" data-pattern="bgnoise_lg.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'black_linen_v2.png);" data-pattern="black_linen_v2.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'carbon_fibre_v2.png);" data-pattern="carbon_fibre_v2.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'black_scales.png);" data-pattern="black_scales.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'cardboard.png);" data-pattern="cardboard.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'circles.png);" data-pattern="circles.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'crissXcross.png);" data-pattern="crissXcross.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'crosses.png);" data-pattern="crosses.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'cubes.png);" data-pattern="cubes.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'dark_brick_wall.png);" data-pattern="dark_brick_wall.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'dark_circles.png);" data-pattern="dark_circles.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'dark_leather.png);" data-pattern="dark_leather.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'dark_mosaic.png);" data-pattern="dark_mosaic.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'diagonal-noise.png);" data-pattern="diagonal-noise.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'diamonds.png);" data-pattern="diamonds.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'elastoplast.png);" data-pattern="elastoplast.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'elegant_grid.png);" data-pattern="elegant_grid.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'fancy_deboss.png);" data-pattern="fancy_deboss.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'felt.png);" data-pattern="felt.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'flowers.png);" data-pattern="flowers.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'gold_scale.png);" data-pattern="gold_scale.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'green_dust_scratch.png);" data-pattern="green_dust_scratch.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'inflicted.png);" data-pattern="inflicted.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'light_alu.png);" data-pattern="light_alu.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'light_checkered_tiles.png);" data-pattern="light_checkered_tiles.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'littleknobs.png);" data-pattern="littleknobs.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'mirrored_squares.png);" data-pattern="mirrored_squares.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'noise_pattern_with_crosslines.png);" data-pattern="noise_pattern_with_crosslines.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'paven.png);" data-pattern="paven.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'polaroid.png);" data-pattern="polaroid.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'pool_table.png);" data-pattern="pool_table.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'project_papper.png);" data-pattern="project_papper.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'real_cf.png);" data-pattern="real_cf.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'rip_jobs.png);" data-pattern="rip_jobs.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'robots.png);" data-pattern="robots.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'roughcloth.png);" data-pattern="roughcloth.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'rubber_grip.png);" data-pattern="rubber_grip.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'silver_scales.png);" data-pattern="silver_scales.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'small_tiles.png);" data-pattern="small_tiles.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'soft_circle_scales.png);" data-pattern="soft_circle_scales.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'square_bg.png);" data-pattern="square_bg.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'squares.png);" data-pattern="squares.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'stucco.png);" data-pattern="stucco.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'triangles.png);" data-pattern="triangles.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'type.png);" data-pattern="type.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'washi.png);" data-pattern="washi.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'white_texture.png);" data-pattern="white_texture.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'whitey.png);" data-pattern="whitey.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'woven.png);" data-pattern="woven.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'xv.png);" data-pattern="xv.png"></span>';
        $html .= '<span class="pattern-scheme" onclick="changePattern(this)" style="background: url(' . $src . 'bg.png);" data-pattern="bg.png"></span>';
        $html .= '</div>';

        $html .= '<div id="pattern-preview" style="overflow: hidden;">';
        $html .= '</div>';

        $bg = Mage::getStoreConfig('ib_theme_design/general/store_pattern');

        $style = '
        	<style>
        	#pattern-preview{
        		width: 280px;
        		height: 100px;
        		background: url(' . $src . $bg .');
        	}
        	.patterns-box{margin-left: -10px;}
        	.color-scheme, .pattern-scheme, .images-bg {
			    width: 20px;
			    height: 20px;
			    border: solid 1px #cccccc;
			    float: left;
			    margin-left: 10px;
			    margin-bottom: 10px;
			    box-shadow: inset 0 9px 0 rgba(255, 255, 255, .1);
			    cursor: pointer;
			}
		    </style>';

		$script = '
			<script>
			//<![CDATA[
			function changePattern(item){
				document.getElementById("ib_theme_design_general_store_pattern").value = item.readAttribute("data-pattern");
				document.getElementById("pattern-preview").style.background = "url(' . $src .'" + item.readAttribute("data-pattern") + ")";
			}
			//]]>
			</script>
		';

        return $html . $element->getElementHtml() . $script . $style;
    }
}
