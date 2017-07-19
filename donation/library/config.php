<?php
/* PHP Config */
ini_set("soap.wsdl_cache_enabled", 0);
define("PHP_DIR", __DIR__);

/* Salesforce Config */
define("SF_USERNAME", "lndemo2@interaktiv.sg");
define("SF_PASSWORD", "interaktiv.1");
define("SF_SECURITY_TOKEN", "VmhMij2PJ2YQDboVR7JLRLpO");

/* MCP Config */
define("MCP_CURRENCY", "SGD");
define("MCP_MID", "3116090007");
define("MCP_KEY", "3116090007");
define("MCP_URL", "https://map.uat.mcpayment.net/Payment/DoPayment");
define("STATUS_URL", 'https://test.interaktiv.sg/demo/donation/status.php');
define("RETURN_URL", 'https://test.interaktiv.sg/demo/donation/result.php');
define("REGISTRATION_URL", 'https://test.interaktiv.sg/demo/donation/index.php');
define("PAYPAL_URL", 'https://www.sandbox.paypal.com/cgi-bin/webscr');
define("PAYPAL_SUCCESS_URL", 'http://www.lndemo.dev/donation/success.php');
define("PAYPAL_CANCEL_URL", 'http://www.lndemo.dev/donation/index.php');
define("PAYPAL_SELLER_EMAIL", 'adminrht@gmail.com');
