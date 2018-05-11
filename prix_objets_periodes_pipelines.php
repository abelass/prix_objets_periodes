<?php
/**
 * Utilisations de pipelines par Prix objets par périodes
 *
 * @plugin     Prix objets par périodes
 * @copyright  2018
 * @author     Rainer Müller
 * @licence    GNU/GPL v3
 * @package    SPIP\Prix_objets_periodes\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/*
 * Un fichier de pipelines permet de regrouper
 * les fonctions de branchement de votre plugin
 * sur des pipelines existants.
 */





/**
 * Optimiser la base de données
 *
 * Supprime les objets à la poubelle.
 *
 * @pipeline optimiser_base_disparus
 * @param  array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function prix_objets_periodes_optimiser_base_disparus($flux) {

	sql_delete('spip_po_periodes', "statut='poubelle' AND maj < " . $flux['args']['date']);

	return $flux;
}
