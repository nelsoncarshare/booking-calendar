<?php

global $HtmlInline;
$HtmlInline = array('a', 'strong');

/*
 * data structure to display XHTML
 * see function tag() below for usage
 */
class Html {
        var $tagName;
        var $attributeList;
        var $childElements;

        function __construct() {
                $args = func_get_args();
                $this->tagName = array_shift($args);
                $this->attributeList = array();
                $this->childElements = array();

                $arg = array_shift($args);
                if($arg === NULL) return;

                if(is_a($arg, 'AttributeList')) {
                        $this->attributeList = $arg;
                        $arg = array_shift($args);
                }

                while($arg !== NULL) {
                        $this->add($arg);
                        $arg = array_shift($args);
                }
        }

        function add() {
                $htmlElements = func_get_args();
                foreach($htmlElements as $htmlElement) {
                        if(is_array($htmlElement)) {
                                foreach($htmlElement as $element) {
                                        $this->add($element);
                                }
                        } elseif(is_object($htmlElement)
                                        && !is_a($htmlElement, 'Html')) {
                                soft_error(_('Invalid class') . ': '
                                                . get_class($htmlElement));
                        } else {
                                $this->childElements[] = $htmlElement;
                        }
                }
        }

        function prepend() {
                $htmlElements = func_get_args();
                foreach(array_reverse($htmlElements) as $htmlElement) {
                        if(is_array($htmlElement)) {
                                foreach(array_reverse($htmlElement)
                                                as $element) {
                                        $this->prepend($element);
                                }
                        } elseif(is_object($htmlElement)
                                        && !is_a($htmlElement, 'Html')) {
                                soft_error(_('Invalid class') . ': '
                                                . get_class($htmlElement));
                        } else {
                                array_unshift($this->childElements,
                                                $htmlElement);
                        }
                }
        }

        function toString() {
                global $HtmlInline;

                $output = "<{$this->tagName}";

                if($this->attributeList != NULL) {
                        $output .= ' ' . $this->attributeList->toString();
                }

                if($this->childElements == NULL) {
                        $output .= " />\n";
                        return $output;
                }

                $output .= ">";

                foreach($this->childElements as $child) {
                        if(is_object($child)) {
                                if(is_a($child, 'Html')) {
                                        $output .= $child->toString();
                                } else {
                                        soft_error(_('Invalid class') . ': '
                                                        . get_class($child));
                                }
                        } else {
                                $output .= $child;
                        }
                }

                $output .= "</{$this->tagName}>";

                if(!in_array($this->tagName, $HtmlInline)) {
                        $output .= "\n";
                }
                return $output;
        }
}

/*
 * Data structure to display XML style attributes
 * see function attributes() below for usage
 */
class AttributeList {
        var $list;

        function __construct() {
                $this->list = array();
                $args = func_get_args();
                $this->add($args);
        }

        function add() {
                $args = func_get_args();
                foreach($args as $arg) {
                        if(is_array($arg)) {
                                foreach($arg as $attr) {
                                        $this->add($attr);
                                }
                        } else {
                                $this->list[] = $arg;
                        }
                }
        }

        function toString() {
                return implode(' ', $this->list);
        }
}

/*
 * creates an Html data structure
 * arguments are tagName [AttributeList] [Html | array | string] ...
 * where array contains an array, Html, or a string, same requirements for that
 * array
 */
function tag()
{
        $args = func_get_args();
        $html = new Html();
        call_user_func_array(array(&$html, '__construct'), $args);
        return $html;
}

/*
 * creates an AttributeList data structure
 * arguments are [attribute | array] ...
 * where attribute is a string of name="value" and array contains arrays or
 * attributes
 */
function attributes()
{
        $args = func_get_args();
        $attrs = new AttributeList();
        call_user_func_array(array(&$attrs, '__construct'), $args);
        return $attrs;
}

?>
