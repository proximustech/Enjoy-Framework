<?php

require_once 'lib/enjoyHelpers/interfaces.php';

class navigator implements navigator_Interface {

    var $config;
    var $lang;
    var $baseAppTranslation;

    function __construct($config) {

        $this->config = &$config;
        $baseAppTranslations = new base_language();
        $this->baseAppTranslation = $baseAppTranslations->lang;        
    }

    public function action($act, $label, &$parametersArray = array(), $mod = null) {
        $parameters = implode("&", $parametersArray);
        $parametersArray = array();

        $app = $this->config["flow"]["app"];
        if ($mod == null) {
            $mod = $this->config["flow"]["mod"];
        }
        
        $class="btn btn-info";
        if ($label==$this->baseAppTranslation["delete"]) {
            $class="btn btn-danger";
        }

        return "<a class='$class' href='index.php?app=$app&mod=$mod&act=$act&$parameters'>$label</a>";
    }

}

class table implements table_Interface {

    var $config;
    var $fieldsConfig;
    var $model;

    function __construct(&$model) {

        $this->model=&$model;
        $this->config = &$model->config;
        $this->fieldsConfig = &$model->fieldsConfig;
    }

    function get($results, $headers, $additionalFiledsConfig = null) {

        $navigator = new navigator($this->config);

        $html = "<table class='table'>";
        $html.="<thead><tr>";
        foreach ($headers as $header) {
            $html.="<th>" . $header . "</th>";
        }
        foreach ($additionalFiledsConfig["headers"] as $header) {
            $html.="<th>" . $header . "</th>";
        }
        $html.="</tr></thead><tbody>";

        foreach ($results as $resultRow) {

            $html.="<tr>";
//            $primaryKeyValue = NULL;
            foreach ($resultRow as $field => $resultValue) {
//                if (strtolower($resultLabel) == $additionalFiledsConfig["primaryKey"]) {
//                    $primaryKeyValue = $resultValue;
//                }

                
                //Link automatico a edicion del elemento
//                if (key_exists('dataSourceArray', $this->fieldsConfig[$field]["definition"])){
//                    $dataSourceArray=$this->fieldsConfig[$field]["definition"]['dataSourceArray'];
//                    if (!is_array($dataSourceArray)) {
//                        if (substr($dataSourceArray,0,4)=='crud')
//                            $action='index';
//                            $label=$resultValue;
//                            
//                            $parameters[]="crud=editForm";
//                            $navigator->action($action, $label, $parameters, $module);
//                    }
//                    
//                }              
                
                
                if (key_exists('dataSourceArray', $this->fieldsConfig[$field]["definition"])){
                    $dataSourceArray=$this->fieldsConfig[$field]["definition"]['dataSourceArray'];
                    $resultValue=$dataSourceArray[$resultValue];
                    
                }                
                
                if ($this->fieldsConfig[$field]["definition"]["type"]=='bool') {
                    if ($resultValue=='1') {
                        $resultValue='Si';
                    }
                    else{
                        $resultValue='No';
                    }
    
                }
                
                if (key_exists($field, $this->model->foreignKeys)) {
    
                    $parameters[]="crud=editFkForm";
                    $parameters[]="{$this->model->tables}_{$this->model->primaryKey}={$resultRow[$this->model->primaryKey]}";
                    $parameters[]="fkField=$field";
                    $html.="<td>" . $navigator->action('index', $resultValue, $parameters) . "</td>";
                }
                else{
                    $html.="<td>" . $resultValue . "</td>";
                }
                
            }
            
            $dependents="";
            
            if (count($this->model->dependents)) {
                
                $dependents.="
                    <div class='btn-group'>
                        <button class='btn btn-inverse dropdown-toggle' data-toggle='dropdown'><span class='caret'></span></button>
                        <ul class='dropdown-menu'>";
                      
                
                foreach ($this->model->dependents as $parentField =>$keyFieldConfig) {
                    $dependentModule=$keyFieldConfig['mod'];
                    $dependentAction=$keyFieldConfig['act'];
                    $dependentKeyField=$keyFieldConfig['keyField'];
                    $dependentLabel=$keyFieldConfig['label'][$this->config["base"]["language"]];

                    $parameters[]="keyField=".$dependentKeyField;
                    $parameters[]="keyValue=".$resultRow[$parentField];
                    $parameters[]="keyLabel=".$resultValue;
                    $parameters[]="modelLabel=".$this->model->label[$this->config["base"]["language"]];

                    $dependents.= "<li>".$navigator->action($dependentAction, $dependentLabel, $parameters,$dependentModule)."</li> ";
//                    $dependents.= " ".$navigator->action($dependentAction, $dependentLabel, $parameters,$dependentModule) ." ";
                }
                
                $dependents.="</ul></div>";
    
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
                        $parameters[] = "{$this->model->tables}.$fieldParameter=" . $resultRow[$fieldParameter];
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
                $html.="<td>$dependents" . $additionalFieldActionsCode . "</td>";
            }

            if ($additionalFieldExtraCode) {
                $html.="<td>" . $additionalFieldExtraCode . "</td>";
            }

            $html.="</tr>";
        }
        $html.="</tbody></table>";

        return $html;
    }

}

class crud implements crud_Interface {

    var $model;
    var $config;
    var $baseAppTranslation;
    var $appLang;
    var $fieldsConfig;

    function __construct($model) {
        $this->model=$model;
        $this->config = &$model->config;
        $baseAppTranslations = new base_language();
        $this->baseAppTranslation = $baseAppTranslations->lang;
        $this->appLang = $this->config["base"]["language"];
        $this->fieldsConfig = $model->fieldsConfig;
    }

    public function getForm($register = null) {

        $html = "<br/><form action='index.php' method='GET'><table>";

        if ($register != null) {
            $editing = true;
            
            if (key_exists('fkField', $_REQUEST)) {
    
                $crudOperation = 'fkUpdate';
                $html.="<input type='hidden' id='fkField' name='fkField' value='{$_REQUEST['fkField']}'>";
            }
            else{
                $crudOperation = 'update';
                
            }
            
            $html.="<input type='hidden' id='{$this->model->tables}_{$this->model->primaryKey}' name='{$this->model->tables}_{$this->model->primaryKey}' value='" . $register[$this->model->primaryKey] . "'>";
        } else {
            $editing = false;
            $crudOperation = 'insert';
        }

        $app = $this->config["flow"]["app"];
        $mod = $this->config["flow"]["mod"];
        $act = $this->config["flow"]["act"];


        foreach ($this->fieldsConfig as $field => $configSection) {

            if ($field != $this->model->primaryKey and substr($field, 0,5)!="enjoy") {

                if (!$editing) {
                    try {
                        $value = $this->fieldsConfig[$field]["definition"]["default"];
                    } catch (Exception $e) {
                        $value = "";
                    }
                    
                } else {
                    $value = $register[$field];
                }

                $widget = $this->fieldsConfig[$field]["definition"]["widget"];
                $type = $this->fieldsConfig[$field]["definition"]["type"];
                $options = $this->fieldsConfig[$field]["definition"]["options"];
                $label = $this->fieldsConfig[$field]["definition"]["label"][$this->appLang];
                
                $dataSourceArray=null;
                if (key_exists('dataSourceArray', $this->fieldsConfig[$field]["definition"])){
                    $dataSourceArray=$this->fieldsConfig[$field]["definition"]['dataSourceArray'];
                    if (!is_array($dataSourceArray)) {
                        if (substr($dataSourceArray,0,4)=='crud')
                            eval("\$dataSourceArray=\$this->".$dataSourceArray);
                    }
                    
                }
                
                if (key_exists($field, $this->model->foreignKeys)){
                    $keyField=$this->model->foreignKeys[$field]['keyField'];
                    $dataField=$this->model->foreignKeys[$field]['dataField'];
                    $fkModel=&$this->model->foreignKeys[$field]['model'];
                    
                    $dataSource=$fkModel->getFieldData($keyField,$dataField);
                    $dataSourceArray=$dataSource['results'];
                    
                }
                
                
                $inputType="text";
                if (in_array("password", $options)) {
                    $inputType="password";
                }                
                
                if ($type=='bool') {
                    $dataSourceArray = array(
                        0 => array(
                            'relationId'=>'1',
                            'relationField'=>'Si',
                        ),
                        1 => array(
                            'relationId'=>'0',
                            'relationField'=>'No',
                        ),
                    );
                }                  
                
                if (is_array($dataSourceArray)) {
    
                    $html.="<tr><td>$label :&nbsp;</td><td>&nbsp;<select id='{$this->model->tables}_$field' name='{$this->model->tables}_$field'>";
                    
                    if (is_array($dataSourceArray[0])) {
                        foreach ($dataSourceArray as $dataSourceRow) {

                            $selected = '';
                            if ($value == $dataSourceRow['relationId'] or $value == $dataSourceRow['relationField']) {
                                $selected = ' selected ';
                            }
                            $html.="<option $selected value='{$dataSourceRow['relationId']}'>{$dataSourceRow['relationField']}</option>";
                        }    
                    }
                    else{
                        foreach ($dataSourceArray as $dataSourceValue => $dataSourceCaption) {

                            $selected = '';
                            if ($value == $dataSourceValue or $value == $dataSourceCaption) {
                                $selected = ' selected ';
                            }
                            $html.="<option $selected value='$dataSourceValue'>$dataSourceCaption</option>";
                        }                          
                        
                    }
                    
                    $html.="</select></td></tr>";
                    
                }
                else{
                    
                    if ($type=='date') {
                        $html.="<script>jQuery( function( ) { $( '#{$this->model->tables}_$field' ).datepicker({showOn: 'button',buttonImage: 'assets/images/icons/calendar.png',showOtherMonths : true ,selectOtherMonths : true ,showButtonPanel : true ,changeMonth : true ,changeYear : true ,dateFormat : 'yy-mm-dd' ,changeMonth: true, }); });</script>";
                        $html.="<tr><td>$label :&nbsp;</td><td>&nbsp;<input type='$inputType' id='{$this->model->tables}_$field' name='{$this->model->tables}_$field' value='$value' readonly ></td></tr>";
                    }                                        
                    if ($type=='dateTime') {
                        $html.="<script>jQuery( function( ) { $( '#{$this->model->tables}_$field' ).datetimepicker({showOn: 'button',buttonImage: 'assets/images/icons/calendar.png',showOtherMonths : true ,selectOtherMonths : true ,showButtonPanel : true ,changeMonth: true,changeYear: true,dateFormat : 'yy-mm-dd',timeFormat : 'HH:mm:ss', }); });</script>";
                        $html.="<tr><td>$label :&nbsp;</td><td>&nbsp;<input type='$inputType' id='{$this->model->tables}_$field' name='{$this->model->tables}_$field' value='$value' readonly ></td></tr>";
                    }                                        
                    elseif ($type=='string') {
                        if ( $widget=='textarea') {
    
                            $html.="<tr><td>$label :&nbsp;</td><td>&nbsp;<textarea rows='4' rows='20' id='{$this->model->tables}_$field' name='{$this->model->tables}_$field' >$value</textarea></td></tr>";
                        }
                        else{
                            $html.="<tr><td>$label :&nbsp;</td><td>&nbsp;<input type='$inputType' id='{$this->model->tables}_$field' name='{$this->model->tables}_$field' value='$value'></td></tr>";
                        }
                    }                    
                    
                }
                unset($dataSourceArray);
            }
        }
        foreach($this->model->subModels as $subModelEnry => $subModelConfig) {

            $subModel=&$subModelConfig['model'];
            $linkerField=$subModelConfig['linkerField'];
            $linkedField=$subModelConfig['linkedField'];
            $linkedDataField=$subModelConfig['linkedDataField'];
            $type=$subModelConfig['type'];
            
            $linkedDataFieldRegisters=array();
            if ($editing) {
    
                $options['fields'][]=$linkedDataField;
                $options['where'][]="$linkedField='{$register[$linkerField]}'";
                $linkedDataFieldFetch=$subModel->fetch($options);
                $linkedDataFieldResultsArray=$linkedDataFieldFetch['results'];
                foreach ($linkedDataFieldResultsArray as $linkedDataFieldRegister) {
                    $linkedDataFieldRegisters[]=$linkedDataFieldRegister[$linkedDataField];
                }

            }
            
            
            $multiple="";
            $fieldNameLastPart="";
            if ($type=="multiple") {
                $multiple=" multiple ";
                $fieldNameLastPart="[]";
            }

            $dataSource=$subModel->getFieldData(null,$linkedDataField);
            $dataSourceArray=$dataSource['results'];
            $label=$dataSource['label'];
            
            $html.="<tr><td>$label :&nbsp;</td><td>&nbsp;<select id='{$subModel->tables}_$linkedDataField' name='{$subModel->tables}_$linkedDataField$fieldNameLastPart' $multiple>";
            foreach ($dataSourceArray as $dataSourceRow) {

                $selected = '';
                if (in_array($dataSourceRow['relationField'],$linkedDataFieldRegisters)) {
                    $selected = ' selected ';
                }
                $html.="<option $selected value='{$dataSourceRow['relationId']}'>{$dataSourceRow['relationField']}</option>";
            }               
            $html.="</select></td></tr>";
        }
        
        
        
        //$html.="<tr><td colspan='2'>$saveButton</td></tr>";
        $html.="<tr><td colspan='2'><br/><input class='btn btn-info' type='submit' value='" . $this->baseAppTranslation["save"] . "'></td></tr>";

        $html.="<input type='hidden' id='app' name='app' value='$app'>";
        $html.="<input type='hidden' id='mod' name='mod' value='$mod'>";
        $html.="<input type='hidden' id='act' name='act' value='$act'>";
        $html.="<input type='hidden' id='crud' name='crud' value='$crudOperation'>";
        $html.="<table></form>";
        return $html;
    }

    public function listData($resultData, $limit = 0) {
        
        $results=$resultData['results'];
        $navigator = new navigator($this->config);
        $createParams[] = "crud=createForm";
        $html = "<br/><div>".$navigator->action($this->config["flow"]["act"], $this->baseAppTranslation["add"], $createParams) . "</div><br>";

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
        $additionalFiledsConfig["actions"][0]["fieldParameters"][] = $this->model->primaryKey;
        $additionalFiledsConfig["actions"][0]["parameters"][] = "crud=editForm";

        $additionalFiledsConfig["actions"][1]["label"] = $this->baseAppTranslation["delete"];
        $additionalFiledsConfig["actions"][1]["mod"] = $this->config["flow"]["mod"];
        $additionalFiledsConfig["actions"][1]["act"] = $this->config["flow"]["act"];
        $additionalFiledsConfig["actions"][1]["fieldParameters"][] = $this->model->primaryKey;
        $additionalFiledsConfig["actions"][1]["parameters"][] = "crud=delete";

        $table = new Table($this->model);
        $html.=$table->get($results, $headersLabes, $additionalFiledsConfig);
        
        return $html;
    }
    
    function crudDataCall($app,$mod,$field,$id='') {
        
        $INNER['app']=$app;
        $INNER['mod']=$mod;
        $INNER['act']='dataCall';
        
        $_REQUEST['field']=$field;
        $_REQUEST['id']=$id;
        
//        $relationDataJson = require 'index.php';
        
        $innerUrl='http://'.$_SERVER['SERVER_NAME']. substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'],basename($_SERVER['SCRIPT_NAME'])))."?app=$app&mod=$mod&act=dataCall&field=$field&id=$id";
        $relationDataJson = file_get_contents($innerUrl);

        $resultsArray = json_decode($relationDataJson,true);
        
        return $resultsArray['results'];
    
    }    
    

}

?>
