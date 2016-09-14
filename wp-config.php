<?php
/** Enable W3 Total Cache Edge Mode */
define('W3TC_EDGE_MODE', true); // Added by W3 Total Cache

# Database Configuration
define( 'DB_NAME', 'wp_bridgetown' );
define( 'DB_USER', 'bridgetown' );
define( 'DB_PASSWORD', 'BhmrwUk2Ly9sx XtXzjV' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         ')e9bxa8c;!as)5Jo +~Lr3kC&VLJapx4b|Cg*-)QXm]/p$sPi`Tsm9N-epCb)|ro');
define('SECURE_AUTH_KEY',  '&Yp|?92R&~<B;MQnbSEn;`AwE9..z,9e._A:DfR$t6I6j+3&FN%WF^Z?&+WS->rJ');
define('LOGGED_IN_KEY',    '%j:-]GS}Ozc)n:sG$!u0<4- _+vDL  AOU:]yTTxOUeTFgu2qOUJK+7V?hmyLda6');
define('NONCE_KEY',        '@Cly^1&-.YFUV-Qmv~JV14d;Y7/ZB=$PCHeUeb$R3N--@>5_l1ER?[|Eqq1}:6[h');
define('AUTH_SALT',        'c`u]UnKff&_3$h dPyJ3 Zpg+e+ltLh1IYl>gqCY&@-+dXIiw||`2hsXUX3;v8yh');
define('SECURE_AUTH_SALT', '0|&|^@XlIlAm|@*I?7;+B>=PW}| B7]Z**rD~ml[vquFkwOB$a)4i?nYud[(,h&s');
define('LOGGED_IN_SALT',   '*c3Go4Vs3E+ZB@6T_rthQ&$($b~%NbujL6Bnha?)|n#p$*?{ryRG=@C+$d|MNq7%');
define('NONCE_SALT',       'Q|W,xV@C|P7~0/oG}T3^(-|C[G%LcRe_rKlfFe<NUQR8<~ry(zd*ZXc7)k|p/%%E');


# Localized Language Stuff


define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'bridgetown' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '90ae9dca2685b71ed88cb15747688d486c89fb60' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '30122' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

 define( 'WP_DEBUG', false );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 2222 );

define( 'WPE_LBMASTER_IP', '104.130.251.211' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'bridgetown.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-30122', );

$wpe_special_ips=array ( 0 => '174.143.130.160', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );

define( 'WP_CACHE', TRUE );
define('WPLANG','');

# WP Engine ID


define('PWP_DOMAIN_CONFIG', 'bridgetown.wpengine.com' );

# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
