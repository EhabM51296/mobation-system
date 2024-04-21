<?php
function generateDropdownComponent($id, $name, $placeholder = "", $server = "", $values = [], $required = true, $errorMessage = "Required", $multidropdown = false) {
    $iconPath = ICONS_PATH;
    if ($multidropdown)
        $html = '<div class="select-dropdown multidropdown">';
    else
        $html = '<div class="select-dropdown">';
    $html .= '<button placeholder = "'.$placeholder.'" class="select-dropdown-control" type="button" data-server = "'.$server.'">';
    $html .= '<span>' . $placeholder . '</span>';
    $html .= '<img src="' . $iconPath . '/dropdownArrow.svg" width="12px" />';
    $html .= '</button>';
    if ($required) {
        $html .= '<input type="hidden" value="" class="dropdown-selected-values validate-input data-to-send" data-validate="required" data-required="' . $errorMessage . '" id="' . $id . '" name="' . $name . '" />';
    } else {
        $html .= '<input type="hidden" value="" class="dropdown-selected-values data-to-send" id="' . $id . '" name="' . $name . '" />';
    }
    $html .= '<div class="dropdown-items">';
    if($server === "")
    {
        for($i = 0; $i < count($values); $i++)
        {
            $html .= '<button class="dropdown-item" data-value="'.$values[$i]['value'].'" data-label="'.$values[$i]['label'].'"> '.$values[$i]['label'].' </button>';
        }
    }
    $html .= '</div>';
    $html .= '<div class="validation-message" id="validation-message-'.$id.'"></div>';
    $html .= '</div>';
    return $html;
}
?>
