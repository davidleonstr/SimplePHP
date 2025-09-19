<?php
require_once __DIR__ . '/../../root.php';
global $ROOTNAME;

/**
 * Class that represents paths used directly or indirectly by the API folder.
 */
class BYAPI {
    public static string $PREFIXDISCRIMINATOR;
    public static string $URL; // Base URL for development
    public static string $DYNAMICURL;
};

BYAPI::$PREFIXDISCRIMINATOR = "#^/(?:$ROOTNAME|$ROOTNAME)?/api/#";
BYAPI::$URL = "http://localhost/$ROOTNAME/api"; // Base URL for development

// Definition of dynamic URL based on current environment
BYAPI::$DYNAMICURL = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$ROOTNAME/api";

/**
 * Class that represents paths used directly or indirectly by the public folder.
 */
class BYPUBLIC {
    /**
     * Reusable path for "layouts" folder.
     * @var string $LAYOUTS Layouts path.
     */
    public static string $LAYOUTS = __DIR__ . "/../views/layouts/";

    /**
     * Reusable path for "views" folder.
     * @var string $VIEWS Views path.
     */
    public static string $VIEWS = __DIR__ . "/../views/";

    /**
     * Path for "partials" folder.
     * @var string $PARTIALS Partials path.
     */
    public static string $PARTIALS = __DIR__ . "/../views/partials/";

    /**
     * Complete path of the accessible part.
     * @var string $URL Base URL.
     */
    public static string $URL;

    /**
     * Simple path.
     * @var string $URL Simple URL.
     */
    public static string $SIMPLEURL;

    /**
     * Google Callback URI
     */
    public static string $GOOGLECALLBACKURI; // Valid URI for development

    // Definition of dynamic URI based on current environment
    public static string $DYNAMICGOOGLECALLBACKURI;
}

BYPUBLIC::$URL = "/$ROOTNAME/public";
BYPUBLIC::$SIMPLEURL = "/$ROOTNAME";
BYPUBLIC::$GOOGLECALLBACKURI = "http://localhost/$ROOTNAME/auth/callback"; // Valid URI for development

// Definition of dynamic URI based on current environment
BYPUBLIC::$DYNAMICGOOGLECALLBACKURI = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on" ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$ROOTNAME/auth/callback"; 

/**
 * Objects defined for their corresponding paths
 */
$PUBLIC = new BYPUBLIC();
$API = new BYAPI();

/**
 * Object that represents and unifies paths.
 */
class PATHS {
    public static object $PUBLIC;
    public static object $API;
}

/**
 * Assignment of objects for paths.
 */
PATHS::$PUBLIC = $PUBLIC;
PATHS::$API = $API;