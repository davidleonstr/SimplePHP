<?php
require_once __DIR__ . '/../app/helpers/JsonFile.php';
require_once __DIR__ . '/../app/helpers/Cypher.php';
require_once __DIR__ . '/../app/core/Paths.php';
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class responsible for encompassing configurations
 */
class CONFIG {
    public static object $DATABASE;
    public static object $JWT;
    public static object $GOOGLEAUTH;
}

/**
 * Class responsible for storing database data.
 */
class BYDB {
    public static string $DBNAME;
    public static string $DBUSER;
    public static string $DBPASSWORD;
    public static string $DBHOST;
    public static string $DBPORT;
}

/**
 * Class responsible for storing data related to JWT tokens.
 */
class BYJWT {
    public static string $JWTSECRETKEY;
    public static int $JWTTOKENLIFETIME;
}

/**
 * Configuration data for Google Auth.
 */
class BYGOOGLEAUTH {
    public static string $CREDENTIALSJSON;
}

/**
 * Path to the JSON configuration file.
 * 
 * @var string
 */
$__configPath__ = __DIR__ . '/config.json';

/**
 * Creates a new JsonFile instance to handle reading and writing
 * of a JSON configuration file.
 *
 * @var JsonFile $__configFile__ Object representing the JSON configuration file.
 */
$__configFile__ = new JsonFile(filepath: $__configPath__);

if (!$__configFile__->load()) {
    throw new Exception('Error: ' . $__configFile__->getLastError());
}

/**
 * Dictionary with application configuration.
 * @var array<string, string>
 */
$__config__ = $__configFile__->getData();

/**
 * Dictionary of encryption keys.
 * 
 * @var array<string, string>
 */
$__cypherDict__ = [
    'K32bytes' => '4a3cd46ea382526e43c6ad2c60bc5d19ca0b0a2af20911c5e4c3144bad418de1',
    'I16bytes' => '1fccf58b09c4ebd7121a87dbfdc420e5'
];

/**
 * Cypher class instance for encryption and decryption.
 * 
 * @var Cypher
 */
$__cypher__ = new Cypher(keyHex: $__cypherDict__['K32bytes'], ivHex: $__cypherDict__['I16bytes']);

/**
 * PostgreSQL database name, decrypted from configuration file.
 *
 * @var string $DBNAME
 */
BYDB::$DBNAME = $__cypher__->decrypt(encrypted: $__config__['postgres']['db']);

/**
 * PostgreSQL database user, decrypted from configuration file.
 *
 * @var string $DBUSER
 */
BYDB::$DBUSER = $__cypher__->decrypt(encrypted: $__config__['postgres']['user']);

/**
 * PostgreSQL database password, decrypted from configuration file.
 *
 * @var string $DBPASSWORD
 */
BYDB::$DBPASSWORD = $__cypher__->decrypt(encrypted: $__config__['postgres']['password']);

/**
 * PostgreSQL server host, decrypted from configuration file.
 *
 * @var string $DBHOST
 */
BYDB::$DBHOST = $__cypher__->decrypt(encrypted: $__config__['postgres']['host']);

/**
 * PostgreSQL server port, decrypted from configuration file.
 *
 * @var int|string $DBPORT Port as number or string, depending on configuration.
 */
BYDB::$DBPORT = $__cypher__->decrypt(encrypted: $__config__['postgres']['port']);

/**
 * Secret key for encrypting session tokens.
 */
BYJWT::$JWTSECRETKEY = '💀🙏💔🥀';

/**
 * JWT token lifetime.
 */
BYJWT::$JWTTOKENLIFETIME = time() + 3600;

/**
 * Google Auth Credentials JSON
 */
BYGOOGLEAUTH::$CREDENTIALSJSON = __DIR__ . '/credentials.json';

$BYDB = new BYDB();
$BYJWT = new BYJWT();
$BYGOOGLEAUTH = new BYGOOGLEAUTH();

/**
 * Assignment of configurations to CONFIG class.
 */
CONFIG::$DATABASE = $BYDB;
CONFIG::$JWT = $BYJWT;
CONFIG::$GOOGLEAUTH = $BYGOOGLEAUTH;