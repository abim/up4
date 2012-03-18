<?php
/*
+-------------------------------------------------------------------+
|       INDOBIT-TECHNOLOGIES
|       based           : 02-04-2005
|       continue        : December 2011
|
|       Released under the terms and conditions of the
|       GNU General Public License (http://gnu.org).
|
|       Rosi Abimanyu Yusuf     (bima@abimanyu.net) | Pontianak, INDONESIA
|       (c)2005 INDOBIT.COM | http://www.indobit.com
+-------------------------------------------------------------------+
*/

class form_class{

        function buka($form_method, $form_action, $form_name="", $form_target = "", $form_enctype="", $form_js=""){
                $method = ($form_method ? "method='".$form_method."'" : "");
                $target = ($form_target ? " target='".$form_target."'" : "");
                $name = ($form_name ? " id='".$form_name."' " : " id='com3lform'");
				$enctype = ($form_enctype ? " enctype='".$form_enctype."'" : "");
                return "\n  <form action='".$form_action."' ".$method.$target.$name.$enctype.$form_js.">";
        }

        function text($form_name, $form_size="", $form_value="", $form_maxlength="", $form_tooltip="", $form_js_on_focus="", $form_js="", $form_class="input", $form_readonly=""){
                $name = ($form_name ? " id='".$form_name."' name='".$form_name."'" : "");
                $value = ($form_value ? " value='".$form_value."'" : "");
                $size = ($form_size ? " size='".$form_size."'" : "");
                $maxlength = ($form_maxlength ? " maxlength='".$form_maxlength."'" : "");
                $readonly = ($form_readonly ? " readonly='readonly'" : "");
                $tooltip = ($form_tooltip ? " title='".$form_tooltip."'" : "");
				$on_focus = ($form_js_on_focus ? " onfocus=\"if (this.value == '".$form_js_on_focus."') {this.value = '';}\" onblur=\"if (this.value == '') {this.value = '".$form_js_on_focus."';}\"" : "");
				
                return "\n  <input class='".$form_class."' type='text' ".$name.$value.$size.$maxlength.$readonly.$tooltip.$on_focus.$form_js." />";
        }

        function password($form_name, $form_size="", $form_value="", $form_maxlength="", $form_class="input", $form_readonly="", $form_tooltip="", $form_js=""){
                $name = ($form_name ? " id='".$form_name."' name='".$form_name."'" : "");
                $value = ($form_value ? " value='".$form_value."'" : "");
                $size = ($form_size ? " size='".$form_size."'" : "");
                $maxlength = ($form_maxlength ? " maxlength='".$form_maxlength."'" : "");
                $readonly = ($form_readonly ? " readonly='readonly'" : "");
                $tooltip = ($form_tooltip ? " title='".$form_tooltip."'" : "");
                return "\n  <input class='".$form_class."' type='password' ".$name.$value.$size.$maxlength.$readonly.$tooltip.$form_js." />";
        }

        function button($form_type, $form_name, $form_value, $form_js="", $form_image="", $form_tooltip="", $form_class="button-primary"){
                $name = ($form_name ? " id='".$form_name."' name='".$form_name."'" : "");
                $image = ($form_image ? " src='".$form_image."' " : "");
                $tooltip = ($form_tooltip ? " title='".$form_tooltip."' " : "");
				
                return "\n  <input class='".$form_class."' type='".$form_type."' ".$form_js." value='".$form_value."'".$name.$image.$tooltip." />";
        }

        function textarea($form_name, $form_columns="10", $form_rows="5", $form_value="", $form_js="", $form_style="", $form_wrap="", $form_readonly="", $form_class="", $form_tooltip=""){
                $name = ($form_name ? " id='".$form_name."' name='".$form_name."'" : "");
                $readonly = ($form_readonly ? " readonly='readonly'" : "");
                $tooltip = ($form_tooltip ? " title='".$form_tooltip."'" : "");
                $wrap = ($form_wrap ? " wrap='".$form_wrap."'" : "");
                $style = ($form_style ? " style='".$form_style."'" : "");
				$class = ($form_class ? " class='".$form_class."'" : "class='input' ");
                return "\n  <textarea ".$class." cols='".$form_columns."' rows='".$form_rows."' ".$name.$form_js.$style.$wrap.$readonly.$tooltip.">".$form_value."</textarea>";
        }

        function checkbox($form_name, $form_value, $form_checked=0, $form_tooltip="", $form_js=""){
                $name = ($form_name ? " id='".$form_name.$form_value."' name='".$form_name."'" : "");
                $checked = ($form_checked ? " checked='checked'" : "");
                $tooltip = ($form_tooltip ? " title='".$form_tooltip."'" : "");
                return "\n  <input type='checkbox' value='".$form_value."'".$name.$checked.$tooltip.$form_js." />";

        }

        function radio($form_name, $form_value, $form_checked=0, $form_text="", $form_tooltip="",  $form_js=""){
                $name = ($form_name ? " id='".$form_name.$form_value."' name='".$form_name."'" : "");
                $checked = ($form_checked ? " checked='checked'" : "");
				$text = ($form_text ? " ".$form_text : "");
                $tooltip = ($form_tooltip ? " title='".$form_tooltip."'" : "");
                return "\n  <input type='radio' value='".$form_value."'".$name.$checked.$tooltip.$form_js." />".$text;

        }

        function files($form_name, $form_size, $form_tooltip="", $form_js=""){
                $name = ($form_name ? " name='".$form_name."' id='".$form_name."'" : "");
                $tooltip = ($form_tooltip ? " title='".$form_tooltip."'" : "");
                return "\n  <input type='file' class='input' size='".$form_size."'".$name.$tooltip.$form_js." />";
        }

        function buka_select($form_name, $form_class="input", $form_js=""){
                return "\n  <select id='".$form_name."' name='".$form_name."' class='".$form_class."' ".$form_js." >";
        }

        function tutup_select(){
                return "\n  </select>";
        }

        function option($form_option, $form_selected="", $form_value="", $form_js=""){
                $value = ($form_value ? " value='".$form_value."'" : " value=''");
                $selected = ($form_selected ? " selected='selected'" : "");
                return "\n  <option".$value.$selected.$form_js.">".$form_option."</option>";
        }

        function hidden($form_name, $form_value){
                return "\n  <input type='hidden' id='".$form_name."' name='".$form_name."' value='".$form_value."' />";
        }

        function tutup(){
                return "\n  </form>";
        }
}
?>