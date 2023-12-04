<?php

/**
 * $fk ist Foreign Key in einer Tabelle zu PK der ersten Klasse
 */
class HtmlHelper
{
    public static function getSelectOptionElement(string $uebergabeVariable, ITableBasics $object, int $fk = null): string
    {
        $html = '<select name="' . $uebergabeVariable
            . '" id="' . $uebergabeVariable . '">';
        $objects = $object->getAllAsObjects();
        if (!isset($fk)) {
            // Ziel: hartcodierten Code aus db dynamisch zu erstellen
            foreach ($objects as $o) {
                $html .= '<option value="' . $o->getId() . '">' . $o->getName() . '</option>';
            }
        } else {
            foreach ($objects as $o) {
                $selected = '';
                if ($fk === $o->getId()){
                    $selected = ' selected';
                }
                $html .= '<option value="' . $o->getId() . '"' . $selected. '>'
                    . $o->getName() . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }
}