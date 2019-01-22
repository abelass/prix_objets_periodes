<?php
/**
 * Déclarations relatives à la base de données
 *
 * @plugin     Prix objets par périodes
 * @copyright  2018 - 2019
 * @author     Rainer Müller
 * @licence    GNU/GPL v3
 * @package    SPIP\Prix_objets_periodes\Pipelines
 */
if (! defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 * @param array $interfaces
 *        	Déclarations d'interface pour le compilateur
 * @return array Déclarations d'interface pour le compilateur
 */
function prix_objets_periodes_declarer_tables_interfaces($interfaces) {
	$interfaces['table_des_tables']['po_periodes'] = 'po_periodes';

	return $interfaces;
}

/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 * @param array $tables
 *        	Description des tables
 * @return array Description complétée des tables
 */
function prix_objets_periodes_declarer_tables_objets_sql($tables) {
	$tables['spip_po_periodes'] = array(
		'type' => 'po_periode',
		'principale' => 'oui',
		'table_objet_surnoms' => array(
			'poperiode'
		), // table_objet('po_periode') => 'po_periodes'
		'field' => array(
			'id_po_periode' => 'bigint(21) NOT NULL',
			'titre' => 'varchar(255) NOT NULL DEFAULT ""',
			'descriptif' => 'text NOT NULL DEFAULT ""',
			'type' => 'varchar(20) NOT NULL DEFAULT ""',
			'criteres' => 'varchar(10) NOT NULL DEFAULT ""',
			'operateur' => 'varchar(3) NOT NULL DEFAULT ""',
			'operateur_2' => 'varchar(3) NOT NULL DEFAULT ""',
			'date_debut' => 'datetime NOT NULL DEFAULT "0000-00-00 00:00:00"',
			'date_fin' => 'datetime NOT NULL DEFAULT "0000-00-00 00:00:00"',
			'jour_debut' => 'int(1) NOT NULL DEFAULT 0',
			'jour_fin' => 'int(1) NOT NULL DEFAULT 0',
			'jour_nombre' => 'int(11) NOT NULL DEFAULT 0',
			'date' => 'datetime NOT NULL DEFAULT "0000-00-00 00:00:00"',
			'statut' => 'varchar(20)  DEFAULT "0" NOT NULL',
			'maj' => 'TIMESTAMP'
		),
		'key' => array(
			'PRIMARY KEY' => 'id_po_periode',
			'KEY statut' => 'statut'
		),
		'titre' => 'titre AS titre, "" AS lang',
		'date' => 'date',
		'champs_editables' => array(
			'titre',
			'descriptif',
			'type',
			'criteres',
			'operateur',
			'operateur_2',
			'date_debut',
			'date_fin',
			'jour_debut',
			'jour_fin',
			'jour_nombre'
		),
		'champs_versionnes' => array(
			'titre',
			'descriptif',
			'type',
			'criteres',
			'operateur',
			'operateur_2',
			'date_debut',
			'date_fin',
			'jour_debut',
			'jour_fin',
			'jour_nombre'
		),
		'rechercher_champs' => array(
			"titre" => 8,
			"descriptif" => 5
		),
		'tables_jointures' => array(),
		'statut_textes_instituer' => array(
			'prepa' => 'texte_statut_en_cours_redaction',
			'prop' => 'texte_statut_propose_evaluation',
			'publie' => 'texte_statut_publie',
			'refuse' => 'texte_statut_refuse',
			'poubelle' => 'texte_statut_poubelle'
		),
		'statut' => array(
			array(
				'champ' => 'statut',
				'publie' => 'publie',
				'previsu' => 'publie,prop,prepa',
				'post_date' => 'date',
				'exception' => array(
					'statut',
					'tout'
				)
			)
		),
		'texte_changer_statut' => 'po_periode:texte_changer_statut_po_periode'
	);

	return $tables;
}
