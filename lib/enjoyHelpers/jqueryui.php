<?php

require_once 'lib/enjoyHelpers/interfaces.php';
require_once "lib/languages/$language.php"; //Exposes base_lenguage()

class navigator implements navigator_Interface {

    var $config;
    var $lang;

    function __construct($config) {

        $this->config = &$config;
    }

    public function action($act, $label, &$parametersArray = array(), $mod = null) {
        $parameters = implode("&", $parametersArray);
        $parametersArray = array();

        $app = $this->config["flow"]["app"];
        if ($mod == null) {
            $mod = $this->config["flow"]["mod"];
        }

        return "<a href='index.php?app=$app&mod=$mod&act=$act&$parameters'>$label</a>";
    }

}

class table implements table_Interface {

    var $config;

    function __construct($config) {

        $this->config = &$config;
    }

    function get($results, $headers, $additionalFiledsConfig = null) {

        $navigator = new navigator($this->config);

        $html = "<table border='1'>";
        $html.="<tr>";
        foreach ($headers as $header) {
            $html.="<td>" . $header . "</td>";
        }
        foreach ($additionalFiledsConfig["headers"] as $header) {
            $html.="<td>" . $header . "</td>";
        }
        $html.="</tr>";

        foreach ($results as $resultRow) {

            $html.="<tr>";
//            $primaryKeyValue = NULL;
            foreach ($resultRow as $resultLabel => $resultValue) {
//                if (strtolower($resultLabel) == $additionalFiledsConfig["primaryKey"]) {
//                    $primaryKeyValue = $resultValue;
//                }
                $html.="<td>" . $resultValue . "</td>";
            }

            $additionalFieldActionsCode = "";
            foreach ($additionalFiledsConfig["actions"] as $additionalFiled) {

                $label = $additionalFiled["label"];
                $module = $additionalFiled["mod"];
                $action = $additionalFiled["act"];

                if (key_exists("parameters", $additionalFiled)) {
                    $parameters = $additionalFiled["parameters"];
                }

                if (key_exists("fieldParameters", $additionalFiled)) {
                    foreach ($additionalFiled["fieldParameters"] as $fieldParameter) {
                        $parameters[] = "$fieldParameter=" . $resultRow[$fieldParameter];
                    }
                }

                $additionalFieldActionsCode .=" " . $navigator->action($action, $label, $parameters, $module) . " ";
            }

            $additionalFieldExtraCode = "";

            if (key_exists("extra", $additionalFiledsConfig)) {

                foreach ($additionalFiledsConfig["extra"] as $additionalFiled) {

                    $type = $additionalFiled["type"];
                    $source = $additionalFiled["source"];
                    $options = $additionalFiled["options"];

                    if ($type == "image") {
                        $additionalFieldExtraCode .=" <img src='$source' $options > ";
                    }
                }
            }

            if ($additionalFieldActionsCode != "") {
                $html.="<td>" . $additionalFieldActionsCode . "</td>";
            }

            if ($additionalFieldExtraCode) {
                $html.="<td>" . $additionalFieldExtraCode . "</td>";
            }

            $html.="</tr>";
        }
        $html.="</table>";

        return $html;
    }

}

class crud implements crud_Interface {

    var $config;
    var $baseAppTranslation;
    var $appLang;
    var $fieldsConfig;

    function __construct($config, $fieldsConfig) {
        $this->config = &$config;
        $baseAppTranslations = new base_language();
        $this->baseAppTranslation = $baseAppTranslations->lang;
        $this->appLang = $this->config["base"]["language"];
        $this->fieldsConfig = $fieldsConfig;
    }

    public function getForm($primaryKey, $register = null) {

        $html = "<form action='index.php' method='GET'><table>";

        if ($register != null) {
            $editing = true;
            $html.="<input type='hidden' id='$primaryKey' name='$primaryKey' value='" . $register[$primaryKey] . "'>";
        } else {
            $editing = false;
        }

        $app = $this->config["flow"]["app"];
        $mod = $this->config["flow"]["mod"];
        $act = $this->config["flow"]["act"];


        foreach ($this->fieldsConfig as $field => $configSection) {

            if ($field != $primaryKey and substr($field, 0,5)!="enjoy") {

                if (!$editing) {
                    try {
                        $value = $this->fieldsConfig[$field]["definition"]["default"];
                    } catch (Exception $exc) {
                        $value = "";
                    }

                    $crudOperation = 'insert';
                } else {
                    $value = $register[$field];
                    $crudOperation = 'update';
                }

                $type = $this->fieldsConfig[$field]["definition"]["type"];
                $options = $this->fieldsConfig[$field]["definition"]["options"];
                $label = $this->fieldsConfig[$field]["definition"]["label"][$this->appLang];
                $inputType="text";
                if (in_array("password", $options)) {
                    $inputType="password";
                }                
                
                $html.="<tr><td>$label</td><td><input type='$inputType' id='$field' name='$field' value='$value'></td></tr>";
            }
        }
        //$html.="<tr><td colspan='2'>$saveButton</td></tr>";
        $html.="<tr><td colspan='2'><input type='submit' value='" . $this->baseAppTranslation["save"] . "'></td></tr>";

        $html.="<input type='hidden' id='app' name='app' value='$app'>";
        $html.="<input type='hidden' id='mod' name='mod' value='$mod'>";
        $html.="<input type='hidden' id='act' name='act' value='$act'>";
        $html.="<input type='hidden' id='crud' name='crud' value='$crudOperation'>";
        $html.="<table></form>";
        return $html;
    }

    public function listData($primaryKey, $results, $limit = 0) {

        $navigator = new navigator($this->config);
        $createParams[] = "crud=createForm";
        $html = $navigator->action($this->config["flow"]["act"], $this->baseAppTranslation["add"], $createParams) . "<br>";

        $headers = array_keys($results[0]);
        $headersLabes = array();

        foreach ($headers as $header) {
            $label = $this->fieldsConfig[$header]["definition"]["label"][$this->appLang];
            $headersLabes[] = $label;
        }

        $additionalFiledsConfig["headers"][] = $this->baseAppTranslation["operations"];

        $additionalFiledsConfig["actions"][0]["label"] = $this->baseAppTranslation["edit"];
        $additionalFiledsConfig["actions"][0]["mod"] = $this->config["flow"]["mod"];
        $additionalFiledsConfig["actions"][0]["act"] = $this->config["flow"]["act"];
        $additionalFiledsConfig["actions"][0]["fieldParameters"][] = $primaryKey;
        $additionalFiledsConfig["actions"][0]["parameters"][] = "crud=editForm";

        $additionalFiledsConfig["actions"][1]["label"] = $this->baseAppTranslation["delete"];
        $additionalFiledsConfig["actions"][1]["mod"] = $this->config["flow"]["mod"];
        $additionalFiledsConfig["actions"][1]["act"] = $this->config["flow"]["act"];
        $additionalFiledsConfig["actions"][1]["fieldParameters"][] = $primaryKey;
        $additionalFiledsConfig["actions"][1]["parameters"][] = "crud=delete";

        $table = new Table($this->config);
        $html.=$table->get($results, $headersLabes, $additionalFiledsConfig);

        return $html;
    }

}

?>
