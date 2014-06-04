<?php

class error {

    var $config;
    
    public function __construct($config) {
        $this->config=$config;
    }
    
    public function log($message) {
        
        if ($this->config['appServerConfig']['base']['platform']=='windows')
            $directorySeparator="\\";
        else
            $directorySeparator="/";        
        
        $file=$this->config['appServerConfig']['base']['controlPath'] . "errorLog" . $directorySeparator . date('Y_m_d') . '_error.txt';
        
        
        $message=$message;
        $message=date('H:i:s '). "Query String:"  . $_SERVER['QUERY_STRING']. "\nError Message:" .$message . "\n\n#######################";
        
        $handle = fopen($file, "a+");
        fwrite($handle, $message."\n");
        fclose($handle);
    }
    
    function show($message,$exception) {
        $log=false;
        $debug=false;
        
        if (isset($this->config['base']['errorLog'])) {
            if ($this->config['base']['errorLog']) {
                $log=true;
            }
        }
        else if (isset($this->config['appServerConfig']['base']['errorLog'])) {
            if ($this->config['appServerConfig']['base']['errorLog']) {
                $log=true;
            }
        }
        
        if (isset($this->config['base']['debug'])) {
            if ($this->config['base']['debug']) {
                $debug=true;
            }
        }
        else if (isset($this->config['appServerConfig']['base']['debug'])) {
            if ($this->config['appServerConfig']['base']['debug']) {
                $debug=true;
            }
        }        
        
        if ($log) {
            $logMessage=$message.','.$exception->getMessage();
            $this->log($logMessage);
        }        
        
        if ($debug) {
            session_start();

            $result = "
                <script src='assets/js/jquery/jquery-1.7.1.min.js'></script>
                <script src='assets/js/jquery/ui/jquery-ui.js'></script>
                <link rel='stylesheet' href='assets/js/jquery/themes/hot-sneaks/jquery-ui.css' />              

                <div id='debugInfo' style='font-size:12px;'>
                    <ul>
                        <li><a href='#general'>General</a></li>
						<li><a href='#get'>\$_GET</a></li>
						<li><a href='#post'>\$_POST</a></li>
						<li><a href='#request'>\$_REQUEST</a></li>
						<li><a href='#session'>\$_SESSION</a></li>
						<li><a href='#cookie'>\$_COOKIE</a></li>
                    </ul>
                    <div id='general'>";

            $result.="
                <style type='text/css'>
                .auto-style {
                        font-size: medium;
                        font-family: Georgia;
                }
                </style>

                <table style='width: 100%; border-collapse: collapse; table-layout: auto; vertical-align: middle; border-spacing: 0px; margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: normal; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);'>
                    <tr style='background-color: rgb(255, 255, 255);'>
                        <td class='auto-style' style='background-color: #eef6fa;border-collapse: collapse; vertical-align: middle; border-width: 0px 1px 1px 0px; border-style: solid; border-color: rgb(45, 91, 0); padding: 10px;  color: rgb(0, 0, 0);'>
                            Error Message:</td>
                        <td class='auto-style' style='border-collapse: collapse; vertical-align: middle; border-width: 0px 0px 1px; border-style: solid; border-color: rgb(45, 91, 0); padding: 10px; color: rgb(0, 0, 0);'>
                            $message</td>
                    </tr>
                    <tr >
                        <td class='auto-style' style='background-color: #eef6fa;border-collapse: collapse; vertical-align: middle; text-align: left; border-width: 0px 1px 0px 0px; border-style: solid; border-color: rgb(45, 91, 0); padding: 10px; font-size: 13px; font-family: Georgia; font-weight: normal; color: rgb(0, 0, 0);'>
                            Exception:</td>
                        <td class='auto-style' style='border-collapse: collapse; vertical-align: middle; text-align: left; border: 0px solid rgb(45, 91, 0); padding: 10px; font-size: 13px; font-family: Georgia; font-weight: normal; color: rgb(0, 0, 0);'>
                            <pre>{$exception->getMessage()}</pre></td>
                    </tr>
                ";
                            
            $tracePoints=explode('#', $exception->getTraceAsString());
            foreach ($tracePoints as $tracePoint) {
                
                if ($tracePoint=='') {
                    $result.="
                    <tr>
                        <td class='auto-style' colspan='2' class='auto-style' style='background-color: #eef6fa;border-collapse: collapse; vertical-align: middle; border-width: 0px 1px 1px 0px; border-style: solid; border-color: rgb(45, 91, 0); padding: 10px;  color: rgb(0, 0, 0);'>
                            <center>Trace:</center>
                        </td>
                    </tr>                        
                    ";
                }
                else 
                $result.="<tr>
                        <td colspan='2' class='auto-style2' style='border-collapse: collapse; vertical-align: middle; text-align: left; border-width: 0px 1px 1px 0px; border-style: solid; border-color: rgb(45, 91, 0); padding: 10px;'>
                            $tracePoint
                        </td>

                    </tr>
                ";
            }
            $result.="</table>";                  

            $result.="</div>
                    <div id='get'>
 						<pre>
							".print_r($_GET,true)." 
						</pre>               
					</div>
                    <div id='post'>
 						<pre>
							".print_r($_POST,true)." 
						</pre>               
					</div>
                    <div id='request'>
 						<pre>
							".print_r($_REQUEST,true)." 
						</pre>               
					</div>
                    <div id='session'>
						<pre>
							".print_r($_SESSION,true)." 
						</pre>                
					</div>					
                    <div id='cookie'>
						<pre>
							".print_r($_COOKIE,true)." 
						</pre>                
					</div>					
                </div>
                <script>
                    $( '#debugInfo' ).tabs();
                </script>";

            exit($result);
        }
        
    }
    
}

?>
