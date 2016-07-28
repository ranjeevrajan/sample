<?php
	
/**
 * Top menu block
 *
 * @category    ItemBridge
 * @package     ItemBridge_Theme
 * @copyright   Copyright (c) 2012 InfoStyle (http://infostyle.com.ua)
 * @license     http://themeforest.net/licenses/regular_extended ThemeForest Regular & Extended License
 */

/**
 * Top menu block
 *
 * @category    Mage
 * @package     Mage_Page
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class ItemBridge_Theme_Block_Page_Html_Topmenu extends Mage_Core_Block_Template
{
    /**
     * Top menu data tree
     *
     * @var Varien_Data_Tree_Node
     */
    protected $_menu;

    /**
     * Init top menu tree structure
     */
    public function _construct()
    {
        $this->_menu = new Varien_Data_Tree_Node(array(), 'root', new Varien_Data_Tree());
    }

    /**
     * Get top menu html
     *
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @return string
     */
    public function getHtml($outermostClass = '', $childrenWrapClass = '')
    {
        Mage::dispatchEvent('page_block_html_topmenu_gethtml_before', array(
            'menu' => $this->_menu
        ));

        $this->_menu->setOutermostClass($outermostClass);
        $this->_menu->setChildrenWrapClass($childrenWrapClass);

        $html = $this->_getHtml($this->_menu, $childrenWrapClass);

        Mage::dispatchEvent('page_block_html_topmenu_gethtml_after', array(
            'menu' => $this->_menu,
            'html' => $html
        ));

        return $html;
    }

    /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param Varien_Data_Tree_Node $menuTree
     * @param string $childrenWrapClass
     * @return string
     */
    protected function _getHtml(Varien_Data_Tree_Node $menuTree, $childrenWrapClass)
    {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = is_null($parentLevel) ? 0 : $parentLevel + 1;

        $counter = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        foreach ($children as $child) {

            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }

            // $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
            if ($child->hasChildren()){
                $childToggle = 'data-toggle="dropdown"';
                $html .= '<li class="dropdown">';
            }
            else{
                $childToggle = '';
                $html .= '<li>';
            }
            $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . ' ' . $childToggle . '>'
                . $this->escapeHtml($child->getName()) . '</a>';

            if ($child->hasChildren()) {
                $childrenLevelTwo = $child->getChildren();
                $is_nested = true;

                foreach ($childrenLevelTwo as $childLevelTwo) {
                    if (!$childLevelTwo->hasChildren()) {
                        $is_nested = false;
                        break;
                    }
                }

                if ($is_nested) {
                    $html .= '<div class="dropdown-menu span12">';
                    foreach ($childrenLevelTwo as $childLevelTwo) {
                        $html .= '<div class="dropdown-section pull-left">';
                        $html .= '<a href="' . $childLevelTwo->getUrl() . '" class="title">'
                            . $this->escapeHtml($childLevelTwo->getName()) . '</a>';
                            if ($childLevelTwo->hasChildren()) {
                                $childrenLevelThird = $childLevelTwo->getChildren();
                                $html .= '<ul>';
                                foreach ($childrenLevelThird as $childLevelThird) {
                                    $html .= '<li><a href="' . $childLevelThird->getUrl() . '">'
                                        . $this->escapeHtml($childLevelThird->getName()) . '</a></li>';
                                }
                                $html .= '</ul>';
                            }
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                } else {
                    $html .= '<ul class="dropdown-menu one">';
                    foreach ($childrenLevelTwo as $childLevelTwo) {
                        if ($childLevelTwo->hasChildren()){
                            $html .= '<li class="dropdown">';
                            $childLevelTwoToggle = 'data-toggle="dropdown"';
                        } else {
                            $html .= '<li>';
                            $childLevelTwoToggle = '';
                        }
                        $html .= '<a href="' . $childLevelTwo->getUrl() . '" class="title" ' . $childLevelTwoToggle . '>'
                            . $this->escapeHtml($childLevelTwo->getName()) . '</a>';
                            if ($childLevelTwo->hasChildren()) {
                                $childrenLevelThird = $childLevelTwo->getChildren();
                                $html .= '<ul class="dropdown-menu">';
                                foreach ($childrenLevelThird as $childLevelThird) {
                                    $html .= '<li><a href="' . $childLevelThird->getUrl() . '">'
                                        . $this->escapeHtml($childLevelThird->getName()) . '</a></li>';
                                }
                                $html .= '</ul>';
                            }
                        $html .= '</li>';
                    }
                    $html .= '</ul>';
                }

            }
            $html .= '</li>';

            $counter++;
        }

        return $html;
    }

    /**
     * Generates string with all attributes that should be present in menu item element
     *
     * @param Varien_Data_Tree_Node $item
     * @return string
     */
    protected function _getRenderedMenuItemAttributes(Varien_Data_Tree_Node $item)
    {
        $html = '';
        $attributes = $this->_getMenuItemAttributes($item);
		
		if ($item->hasChildren())
			$attributes['class'] = $attributes['class'] . ' dropdown';

        foreach ($attributes as $attributeName => $attributeValue) {
            $html .= ' ' . $attributeName . '="' . str_replace('"', '\"', $attributeValue) . '"';
        }

        return $html;
    }

    /**
     * Returns array of menu item's attributes
     *
     * @param Varien_Data_Tree_Node $item
     * @return array
     */
    protected function _getMenuItemAttributes(Varien_Data_Tree_Node $item)
    {
        $menuItemClasses = $this->_getMenuItemClasses($item);
        $attributes = array(
            'class' => implode(' ', $menuItemClasses)
        );

        return $attributes;
    }

    /**
     * Returns array of menu item's classes
     *
     * @param Varien_Data_Tree_Node $item
     * @return array
     */
    protected function _getMenuItemClasses(Varien_Data_Tree_Node $item)
    {
        $classes = array();

        $classes[] = 'level' . $item->getLevel();
        $classes[] = $item->getPositionClass();

        if ($item->getIsFirst()) {
            $classes[] = 'first';
        }

        if ($item->getIsActive()) {
            $classes[] = 'active';
        }

        if ($item->getIsLast()) {
            $classes[] = 'last';
        }

        if ($item->getClass()) {
            $classes[] = $item->getClass();
        }

        if ($item->hasChildren()) {
            $classes[] = 'parent';
        }

        return $classes;
    }
}
