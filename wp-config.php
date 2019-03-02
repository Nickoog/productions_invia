<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'productionsinvia');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'mysql');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '0MV0|nZeZZwGQmk3((@j^G_}paaj2:E*pUEClI|ddks!acZDGNAEjJ?3B;[K9zE+');
define('SECURE_AUTH_KEY',  'FpIU_)np4++57dP+c#>o&Wo!S|bE5(#v37}=<4BybaicIYjYEZE`b]>5GPKa-8!b');
define('LOGGED_IN_KEY',    'Zx~<o <^=Jc&z95<gX@c#d@rT1ZM7:o9hXOlDA-{A#,,_l p]W5QhGO7/$TWcNDu');
define('NONCE_KEY',        'n*U~y5Cy<{Z7PcK`onD)RE9k(J[8+_O-2C;sxs~;p,|t ,o6>6[4rB!WYj+>wI/j');
define('AUTH_SALT',        '%x6;XMF+#DCp7LC xQHn]PZB%3G^QWN<|qE3OQoGaV4cg`2d?m!bG,$;_dS,/T6K');
define('SECURE_AUTH_SALT', 'tY=7pz3@BO5+7%FJsHl1D3^h4yH;jxEOc[B!>$ZdoimStHikfx,<7wIn/*5{;-}<');
define('LOGGED_IN_SALT',   'RjlH))6Iq3adj+8v:NL|!=ad5eC5EK`J;7[+Q@HB!( /2M[&9C4Aslj_rZP0q<y7');
define('NONCE_SALT',       'h1Z=)s*=/7BB+fZ%,lUuo[?6%LOy+@$ElK{iZ.TnF3*:K>PtAWfE@l2^,.=fw0|}');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');