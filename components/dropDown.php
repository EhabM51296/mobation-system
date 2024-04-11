<?php
function generateDropdownComponent($id, $name, $values = [], $selectedValue = [], $required = true, $errorMessage = "", $multidropdown = false) {
    $iconPath = ICONS_PATH;
    if ($multidropdown)
        $html = '<div class="select-dropdown multidropdown">';
    else
        $html = '<div class="select-dropdown">';
    $html .= '<button type="text" class="select-dropdown-control" type="button">';
    $html .= '<span>' . $selectedValue["label"] . '</span>';
    $html .= '<img src="' . $iconPath . '/dropdownArrow.svg" width="12px" />';
    $html .= '</button>';
    if ($required) {
        $html .= '<input type="hidden" value="" class="dropdown-selected-values validate-input data-to-send" data-validate="required" data-required="' . $errorMessage . '" id="' . $id . '" name="' . $name . '" />';
    } else {
        $html .= '<input type="hidden" value="" class="dropdown-selected-values data-to-send" id="' . $id . '" name="' . $name . '" />';
    }
    $html .= '<div class="dropdown-items">';
    // $html .= '<button class="dropdown-item" data-value="" data-label="' . $defaultValue . '"> ' . $defaultValue . ' </button>';
    $html .= '</div>';
    $html .= '<div class="validation-message" id="validation-message-dropdown-client-name"></div>';
    $html .= '</div>';
    return $html;
}
?>
