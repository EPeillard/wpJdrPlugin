<?php
/*
Plugin Name: Gestion club JDR
Plugin URI: 
Description: Un plugin pour la gestion des tables et evenements du club JDR
Version: 0.1
Author: Etienne Peillard
Author URI: 
*/

class Jdr_Plugin
{
    public function __construct()
    {
        register_activation_hook(__FILE__, array('Jdr_Plugin', 'install'));
		register_uninstall_hook(__FILE__, array('Jdr_Plugin', 'uninstall'));
    }

    public static function install()
    {
		global $wpdb;

		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}jdr_table (
			id INT AUTO_INCREMENT PRIMARY KEY, 
			type ENUM('table','oneshot','oneshotm','multitable','murder'),
			numero INT NOT NULL, 
			dateDebut DATE, 
			dateFin DATE,
			mj INT,
			lieu VARCHAR(255),
			heure TIME,
			archivage TINYINT DEFAULT 0);");
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}jdr_seance (
			id INT AUTO_INCREMENT PRIMARY KEY, 
			tableID INT NOT NULL, 
			date DATE, 
			lieu VARCHAR(255), 
			heure TIME, 
			annulee TINYINT DEFAULT 0);");
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}jdr_presenceSeance (
			id INT AUTO_INCREMENT PRIMARY KEY,
			seanceID INT NOT NULL,
			membreID INT NOT NULL, 
			presence TINYINT DEFAULT 0);");
		$wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}jdr_attributionTable (
			id INT AUTO_INCREMENT PRIMARY KEY,
			tableID INT NOT NULL,
			membreID INT NOT NULL);");
    }
	
	public static function uninstall()
	{
		global $wpdb;

		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jdr_table;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jdr_seance;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jdr_presenceSeance;");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}jdr_attributionTable;");
	}
}

new Jdr_Plugin();