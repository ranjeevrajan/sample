<?php
/**
 * @version   1.0 12.0.2012
 * @author    Olegnax http://www.olegnax.com <mail@olegnax.com>
 * @copyright Copyright (C) 2010 - 2012 Olegnax
 */

class Etheme_Dresscodenavigation_Block_Navigation extends Mage_Catalog_Block_Navigation
{

	/**
     * columns html
     *
     * @var array
     */
    protected $_columnOutput;

	/**
     * Render category to html
     *
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @param boolean Whether ot not this item is first, affects list item class
     * @param boolean Whether ot not this item is outermost, affects list item class
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @param boolean Whether ot not to add on* attributes to list item
     * @return string
     */
    protected function _renderCategoryMenuItemHtml($category, $level = 0, $isLast = false, $isFirst = false,
        $isOutermost = false, $outermostItemClass = '', $childrenWrapClass = '', $noEventAttributes = false)
    {
        if (!$category->getIsActive()) {
            return '';
        }
        $html = array();

        // get all children
        if (Mage::helper('catalog/category_flat')->isEnabled()) {
            $children = (array)$category->getChildrenNodes();
            $childrenCount = count($children);
        } else {
            $children = $category->getChildren();
            $childrenCount = $children->count();
        }
        $hasChildren = ($children && $childrenCount);

	    // select active children
        $activeChildren = array();
        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $activeChildren[] = $child;
            }
        }
        $activeChildrenCount = count($activeChildren);
        $hasActiveChildren = ($activeChildrenCount > 0);

        // prepare list item html classes
        $classes = array();
        $classes[] = 'level' . $level;
        $classes[] = 'nav-' . $this->_getItemPosition($level);
        if ($this->isCategoryActive($category)) {
            $classes[] = 'active';
        }
        $linkClass = '';
        if ($isOutermost && $outermostItemClass) {
            $classes[] = $outermostItemClass;
            $linkClass = ' class="'.$outermostItemClass.'"';
        }
        if ($isFirst) {
            $classes[] = 'first';
        }
        if ($isLast) {
            $classes[] = 'last';
        }
        if ($hasActiveChildren) {
            $classes[] = 'parent';
        }

	    // prepare list item attributes
        $attributes = array();
        if (count($classes) > 0) {
            $attributes['class'] = implode(' ', $classes);
        }
        if ($hasActiveChildren && !$noEventAttributes) {
             $attributes['onmouseover'] = 'toggleMenu(this,1)';
             $attributes['onmouseout'] = 'toggleMenu(this,0)';
        }

        // assemble list item with attributes
        $htmlLi = '<li';
        foreach ($attributes as $attrName => $attrValue) {
            $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
        }
        $htmlLi .= '>';
        $html[] = $htmlLi;

        $html[] = '<a href="'.$this->getCategoryUrl($category).'"'.$linkClass.'>';
        $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
        $html[] = '</a>';

	    $columns = 3;

        if ($level==0)
        {
            $this->_columnOutput = array();
            $description = Mage::getModel('catalog/category')->load($category->getId())->getDescription();
            $count_of_items_in_column = array_fill(0, $columns, floor($activeChildrenCount/$columns));
            $lost=$activeChildrenCount % $columns;
		    if ($lost > 0) for ($i = 0; $i < ($lost); $i++) $count_of_items_in_column[$i]++;
        }

        // render children
        $htmlChildren = '';
        $j = 0; 	   

        foreach ($activeChildren as $child)
        {
	        $childOutput = $this->_renderCategoryMenuItemHtml(
                $child,
                ($level + 1),
		        false,
                ($j == 0),
                false,
                $outermostItemClass,
                $childrenWrapClass,
                $noEventAttributes
            );
	        $j++;
            if ($level==0) $this->_columnOutput[] = $childOutput; else $htmlChildren .= $childOutput;
        }

	    $k = 0;
        if ($this->_columnOutput && ($level==0))
        {
		    foreach ( $count_of_items_in_column as $countColumn ) {
			    $chunk = array_slice($this->_columnOutput, $k, $countColumn);
			    $k += $countColumn;
			    $htmlChildren.= '<li class="list_column"><ul class="list_in_column">'; foreach($chunk as $item) $htmlChildren.= $item; $htmlChildren.= '</ul></li>';
		    }
	    }
	    if (!empty($description) && !empty($htmlChildren))  $htmlChildren .= '<li class="clearfix category_desc_in_menu"><a></a>'.$description.'</li>';

        if (!empty($htmlChildren)) {
            if ($childrenWrapClass) {
                $html[] = '<div class="' . $childrenWrapClass . '">';
            }
            $html[] = '<ul class="level' . $level . '">';
            $html[] = $htmlChildren;
            $html[] = '</ul>';
            if ($childrenWrapClass) {
                $html[] = '</div>';
            }
        }
        $html[] = '</li>';
        $html = implode("\n", $html);
        return $html;
    }


}
