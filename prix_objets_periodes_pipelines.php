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

/**
 * Déclare les champs extras pour le formulaire prix.
 *
 * @pipeline prix_objets_extensions
 *
 * @param array $flux
 *        	Données du pipeline
 * @return array
 */
function prix_objets_periodes_prix_objets_extensions($flux) {

	$flux['data'][] = array (
		array(
			'objet' => 'po_periode',
			'saisie' => 'po_periodes',
			'options' => array(
				'nom' => 'id_prix_extension_po_periode',
				'label' => _T('po_periode:champ_id_prix_extension_po_periode'),
				'option_intro' => _T('po_periode:info_aucun_po_periode'),
				'defaut' => $flux['id_prix_extension_objet'],
			)
		),
		array(
			'saisie' => 'ajouter_action',
			'options' => array(
				'nom' => 'ajouter_po_periode',
				'label_action' => _T('po_periode:texte_ajouter_po_periode'),
				'action' => 'po_periode_edit',
			)
		),
	);

	return $flux;
}


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
