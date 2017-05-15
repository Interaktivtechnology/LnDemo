<?php
/* PHP Config */
ini_set("soap.wsdl_cache_enabled", 0);
define("PHP_DIR", __DIR__);

/* Salesforce Config */
define("SF_USERNAME", "lndemo2@interaktiv.sg");
define("SF_PASSWORD", "interaktiv.3");
define("SF_SECURITY_TOKEN", "qZZ13ujzgxOMZjNQsAJHxzg1O");

/* MCP Config */
define("MCP_CURRENCY", "SGD");
define("MCP_MID", "3115060001");
define("MCP_KEY", "DV8DgLRYAF4nuZhqgZMTqsAtdr9Cx0bM");
define("MCP_URL", "https://maptest.mcpayment.net/payment/dopayment");
define("STATUS_URL", 'http://'.$_SERVER['HTTP_HOST']."/donation/status.php");
define("RETURN_URL", 'http://'.$_SERVER['HTTP_HOST']."/donation/result.php");
define("REGISTRATION_URL", 'http://'.$_SERVER['HTTP_HOST']."/donation/index.php");