<?php
/**
 * Custom Helper
 *
 *
 * @category Helper
 * @package  Croogo
 * @version  1.0
 * @author   Nitish Dhar (@nitishdhar)
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class CustomHelper extends Helper {

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Html',
        'Form',
        'Session',
        'Js',
        'Layout',
    );

    public function menu($menuAlias, $options = array()) {
        $_options = array(
            'tag' => 'ul',
            'tagAttributes' => array(),
            'selected' => 'active',
            'dropdown' => false,
            'dropdownClass' => 'dropdown',
            'dropdownMenuClass' => 'dropdown-menu',
            'toggle' => 'dropdown-toggle',
            'menuClass' => 'nav nav-pills',
            'element' => 'menu',
        );
        $options = array_merge($_options, $options);

        if (!isset($this->_View->viewVars['menus_for_layout'][$menuAlias])) {
            return false;
        }
        $menu = $this->_View->viewVars['menus_for_layout'][$menuAlias];
        $output = $this->_View->element($options['element'], array(
            'menu' => $menu,
            'options' => $options,
                ));
        return $output;
    }

    /**
     * Nested Links
     *
     * @param array $links model output (threaded)
     * @param array $options (optional)
     * @param integer $depth depth level
     * @return string
     */
    public function nestedLinks($links, $options = array(), $depth = 1) {
        $_options = array();
        $options = array_merge($_options, $options);

        $output = '';
        foreach ($links AS $link) {
            $linkAttr = array(
                'id' => 'link-' . $link['Link']['id'],
                'rel' => $link['Link']['rel'],
                'target' => $link['Link']['target'],
                'title' => $link['Link']['description'],
                'class' => $link['Link']['class'],
            );

            foreach ($linkAttr AS $attrKey => $attrValue) {
                if ($attrValue == null) {
                    unset($linkAttr[$attrKey]);
                }
            }

            // if link is in the format: controller:contacts/action:view
            if (strstr($link['Link']['link'], 'controller:')) {
                $link['Link']['link'] = $this->Layout->linkStringToArray($link['Link']['link']);
            }

            // Remove locale part before comparing links
            if (!empty($this->params['locale'])) {
                $currentUrl = substr($this->_View->request->url, strlen($this->params['locale']));
            } else {
                $currentUrl = $this->_View->request->url;
            }

            if (Router::url($link['Link']['link']) == Router::url('/' . $currentUrl)) {
                if (!isset($linkAttr['class'])) {
                    $linkAttr['class'] = '';
                }
                $linkAttr['class'] .= ' ' . $options['selected'];
            }

            $linkOutput = $this->Html->link($link['Link']['title'], $link['Link']['link']);
            if (isset($link['children']) && count($link['children']) > 0) {
                $linkOutput = $this->Html->link($link['Link']['title'] . '<b class="caret"></b>', $link['Link']['link'], array('class' => $options['toggle'], 'data-toggle' => $options['dropdownClass'], 'escape' => false));
                $linkAttr['class'] .= ' ' . $options['dropdownClass'];
                $linkOutput .= $this->nestedLinks($link['children'], $options, $depth + 1);
            }
            $linkOutput = $this->Html->tag('li', $linkOutput, $linkAttr);
            $output .= $linkOutput;
        }
        if ($output != null) {
            $tagAttr = $options['tagAttributes'];
            if ($options['dropdown'] && $depth == 1) {
                $tagAttr['class'] = $options['menuClass'];
            }
            if ($depth > 1) {
                $tagAttr['class'] = $options['dropdownMenuClass'];
            }
            $output = $this->Html->tag($options['tag'], $output, $tagAttr);
        }

        return $output;
    }

}