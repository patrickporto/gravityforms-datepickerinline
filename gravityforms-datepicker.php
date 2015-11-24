<?php
/**
 * @package GravityForms_DatePicker
 * @version 1.6
 */
/*
Plugin Name: Date Picker Inline
Description: This is a plugin for display date picker inline.
Author: Patrick Porto
Version: 1.0
Author URI: http://github.com/patrickporto
*/
add_filter('gform_add_field_buttons', 'wps_add_dateinline_field');
add_filter('gform_field_type_title', 'wps_dateinline_title');
add_action('gform_field_input', 'wps_dateinline_field_input', 10, 5 );
function wps_add_dateinline_field( $field_groups ) {
    foreach($field_groups as &$group ){
        if( $group["name"] === "advanced_fields" ){
            $group["fields"][] = array(
                "class"=>"button",
                "value" => __("Date Inline", "gravityforms"),
                "onclick" => "StartAddField('dateinline');"
            );
            break;
        }
    }
    return $field_groups;
}
function wps_dateinline_title( $type ) {
    if ($type === 'dateinline') {
        return __('Date Inline', 'gravityforms');
    }
}
function wps_dateinline_field_input ( $input, $field, $value, $lead_id, $form_id ){
    if ($field["type"] === "dateinline") {
        $input_id = $field["id"];
        $input_name = $form_id .’_’ . $input_id;
        $input_class = 'dateinline-' . $input_id . ' ' . esc_attr(isset($field['cssClass'] ) ? $field['cssClass'] : '');
        $div_class = 'div-dateinline-' . $input_id . ' div-' . esc_attr(isset($field['cssClass'] ) ? $field['cssClass'] : '');
        $tabindex = GFCommon::get_tabindex();
        return "<div class='ginput_container'>
                    <div class='dateinline $div_class'></div>
                    <input type='hidden' id='$input_id' name='input_$input_name' class='gform_dateinline $input_class'
                        value='$value_safe' tabindex='$tabindex'/>
                </div>";
    }
    return $input;
}
add_action('gform_editor_js', 'editor_script');
function editor_script(){
    ?>
    <script type='text/javascript'>
        //adding setting to fields of type "text"
        fieldSettings["dateinline"] += ",.label_setting,.visibility_setting,.duplicate_setting,.default_value_setting,.placeholder_setting,.description_setting,.css_class_setting";
    </script>
    <?php
}
// Add a script to the display of the particular form only if tos field is being used
add_action('gform_enqueue_scripts', 'wps_gform_enqueue_scripts', 10 , 2 );
function wps_gform_enqueue_scripts( $form, $ajax ) {
    // cycle through fields to see if tos is being used
    foreach ( $form['fields'] as $field ) {
        if ($field['type'] === 'dateinline') {
            $url = plugins_url('gform_dateinline.js', __FILE__ );
            wp_enqueue_script("gform_dateinline_script", $url , array("jquery", "jquery-ui-datepicker"), '1.0'); // Note WPS_JS is a constant I’ve set for all my child theme’s custom JS.
            break;
        }
    }
}
?>
