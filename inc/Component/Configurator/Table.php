<?php
namespace Ergopack\Component\Configurator;

/**
 * Class Table
 *
 * @deprecated
 *
 * @author Effecticore
 * @since 0.1
 */

class Table
{
    /** @var string TBL_VERSION  */
    const TBL_VERSION = '1.0';

    /** @var string TBL_VERSION_OPTION  */
    const TBL_VERSION_OPTION = 'ep_configurator_tbl_version';

    /** @var string TBL_NAME */
    const TBL_NAME = 'ep_configurator';

    /**
     * The single instance of the class.
     *
     * @var Table
     */
    protected static $_instance = null;

    /**
     * Main Table Instance.
     *
     * @static
     * @return Table - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Run
     */
    public function run()
    {
        add_action( 'plugins_loaded', [&$this, 'check_tbl'] );

        register_activation_hook(ERGO_FILE, [&$this, 'install_tbl'] );
    }

    /**
     * Get table name
     *
     * @return string
     */
    public function table_name()
    {
        global $wpdb;
        return $wpdb->prefix . self::TBL_NAME;
    }

    /**
     * Install table
     */
    public function install_tbl()
    {
        global $wpdb;

        if ( get_site_option( self::TBL_VERSION_OPTION ) == self::TBL_VERSION ) {
            return;
        }

        $table_name = $this->table_name();

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$table_name} (
            ID bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id bigint(20) UNSIGNED,
            created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            system_name varchar(20) NOT NULL,
            special_triplex tinyint(1) DEFAULT 0,
            special_locking_device tinyint(1) DEFAULT 0,
            special_laser tinyint(1) DEFAULT 0,
            special_brake tinyint(1) DEFAULT 0,
            special_slide varchar(20) DEFAULT '',
            special_head_deflector tinyint(1) DEFAULT 0,
            acc_mobile tinyint(1) DEFAULT 0,
            acc_tunnel_stationary tinyint(1) DEFAULT 0,
            acc_tunnel_mobile tinyint(1) DEFAULT 0,
            acc_battery_trolley tinyint(1) DEFAULT 0,
            accessory_mobile tinyint(1) DEFAULT 0,
            PRIMARY KEY  (ID)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        error_log( "Table '{$table_name}' updated to version ".self::TBL_VERSION."!" );

        update_option( self::TBL_VERSION_OPTION, self::TBL_VERSION );
    }

    /**
     * Check table's version
     */
    public function check_tbl()
    {
        if ( get_site_option( self::TBL_VERSION_OPTION ) != self::TBL_VERSION ) {
            $this->install_tbl();
        }
    }
}