<?php
/**
 * Gestion du formulaire de d'édition de po_periode
 *
 * @plugin     Prix objets par périodes
 * @copyright  2018
 * @author     Rainer Müller
 * @licence    GNU/GPL v3
 * @package    SPIP\Prix_objets_periodes\Formulaires
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

include_spip('inc/actions');
include_spip('inc/editer');

function formulaires_editer_po_periode_saisies_dist() {

	// Les jours de la semaine
	$jours_semaines = array();
	for ($i = 0; $i < 7; $i++) {
		$jour = $i + 1;
		$jours_semaines[] = _T('spip:date_jour_' . $jour);
	}

	$operateurs = array(
		htmlspecialchars('==') => '==',
		htmlspecialchars('!=') => '!=',
		htmlspecialchars('<') => '<',
		htmlspecialchars('<=') => '<=',
		htmlspecialchars('>') => '>',
		htmlspecialchars('>=') => '>=',
	);

	return array(
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'titre',
				'obligatoire' => 'oui',
				'datas' => $statuts,
				'cacher_option_intro' => 'on',
				'label' => _T('ecrire:info_titre'),
			)
		),
		array(
			'saisie' => 'textarea',
			'options' => array(
				'nom' => 'descriptif',
				'label' => _T('ecrire:info_descriptif'),
				'conteneur_class' => 'pleine_largeur',
				'class' => 'inserer_barre_edition',
				'rows' => 4
			)
		),
		array(
			'saisie' => 'radio',
			'options' => array(
				'obligatoire' => 'oui',
				'nom' => 'type',
				'label' => _T('po_periode:champ_type_label'),
				'data' => array(
					'date' => _T('po_periode:type_date'),
					'jour_semaine' => _T('po_periode:type_jour_semaine'),
					//'jour_nombre' => _T('po_periode:type_jour_nombre'),
				)
			),
		),
		array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'criteres',
				'label' => _T('po_periode:champ_criteres_label'),
				'obligatoire' => 'oui',
				'data' => array(
					'coincide' => _T('po_periode:choix_coincide_label'),
					'exclu' => _T('po_periode:choix_exclu_label'),
					//'specifique' => _T('po_periode:choix_specifique_label'),
				),
				'afficher_si' => '@type@ == "date" || @type@ == "jour_semaine"',
			)
		),
		/*array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'operateur',
				'label' => _T('po_periode:champ_operateur_label'),
				'data' => $operateurs,
				'afficher_si' => '(@type@ == "date" || @type@ == "jour_nombre") && @criteres@ == "specifique"',
			)
		),*/
		array(
			'saisie' => 'date',
			'options' => array(
				'nom' => 'date_debut',
				'label' => _T('dates_outils:champ_date_debut_label'),
				'afficher_si' => '@type@ == "date"',
			)
		),
		/*array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'operateur_2',
				'label' => _T('po_periode:champ_operateur_label'),
				'data' => $operateurs,
				'afficher_si' => '@type@ == "date" && @criteres@ == "specifique"',
			)
		),*/
		array(
			'saisie' => 'date',
			'options' => array(
				'nom' => 'date_fin',
				'label' => _T('dates_outils:champ_date_fin_label'),
				'afficher_si' => '@type@ == "date"',
			)
		),
		array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'jour_debut',
				'label' => _T('po_periode:champ_jour_debut_label'),
				'data' => $jours_semaines,
				'afficher_si' => '@type@ == "jour_semaine"',
			)
		),
		array(
			'saisie' => 'selection',
			'options' => array(
				'nom' => 'jour_fin',
				'label' => _T('po_periode:champ_jour_fin_label'),
				'data' => $jours_semaines,
				'afficher_si' => '@type@ == "jour_semaine"',
			)
		),
		array(
			'saisie' => 'input',
			'options' => array(
				'nom' => 'jour_nombre',
				'label' => _T('po_periode:champ_jour_nombre_label'),
				'afficher_si' => '@type@ == "jour_nombre"',
			)
		),
	);
}


/**
 * Identifier le formulaire en faisant abstraction des paramètres qui ne représentent pas l'objet edité
 *
 * @param int|string $id_po_periode
 *     Identifiant du po_periode. 'new' pour un nouveau po_periode.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un po_periode source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du po_periode, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return string
 *     Hash du formulaire
 */
function formulaires_editer_po_periode_identifier_dist($id_po_periode = 'new', $retour = '', $lier_trad = 0, $config_fonc = '', $row = array(), $hidden = '') {
	return serialize(array(intval($id_po_periode)));
}

/**
 * Chargement du formulaire d'édition de po_periode
 *
 * Déclarer les champs postés et y intégrer les valeurs par défaut
 *
 * @uses formulaires_editer_objet_charger()
 *
 * @param int|string $id_po_periode
 *     Identifiant du po_periode. 'new' pour un nouveau po_periode.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un po_periode source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du po_periode, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Environnement du formulaire
 */
function formulaires_editer_po_periode_charger_dist($id_po_periode = 'new', $retour = '', $lier_trad = 0, $config_fonc = '', $row = array(), $hidden = '') {
	$valeurs = formulaires_editer_objet_charger('po_periode', $id_po_periode, '', $lier_trad, $retour, $config_fonc, $row, $hidden);

	// Publier directement
	if ($id_po_periode == 'oui') {
		$valeurs['_hidden'] .= '<input type="hidden" name="statut" value="publie" />';
	}

	return $valeurs;
}

/**
 * Vérifications du formulaire d'édition de po_periode
 *
 * Vérifier les champs postés et signaler d'éventuelles erreurs
 *
 * @uses formulaires_editer_objet_verifier()
 *
 * @param int|string $id_po_periode
 *     Identifiant du po_periode. 'new' pour un nouveau po_periode.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un po_periode source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du po_periode, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Tableau des erreurs
 */
function formulaires_editer_po_periode_verifier_dist($id_po_periode = 'new', $retour = '', $lier_trad = 0, $config_fonc = '', $row = array(), $hidden = '') {
	$erreurs = array();

	$verifier = charger_fonction('verifier', 'inc');

	foreach (array('date_debut', 'date_fin') AS $champ) {
		$normaliser = null;
		if ($erreur = $verifier(_request($champ), 'date', array('normaliser'=>'datetime'), $normaliser)) {
			$erreurs[$champ] = $erreur;
		// si une valeur de normalisation a ete transmis, la prendre.
		} elseif (!is_null($normaliser)) {
			set_request($champ, $normaliser);
		// si pas de normalisation ET pas de date soumise, il ne faut pas tenter d'enregistrer ''
		} else {
			set_request($champ, null);
		}
	}

	$erreurs += formulaires_editer_objet_verifier('po_periode', $id_po_periode, array('titre', 'type', 'criteres'));

	return $erreurs;
}

/**
 * Traitement du formulaire d'édition de po_periode
 *
 * Traiter les champs postés
 *
 * @uses formulaires_editer_objet_traiter()
 *
 * @param int|string $id_po_periode
 *     Identifiant du po_periode. 'new' pour un nouveau po_periode.
 * @param string $retour
 *     URL de redirection après le traitement
 * @param int $lier_trad
 *     Identifiant éventuel d'un po_periode source d'une traduction
 * @param string $config_fonc
 *     Nom de la fonction ajoutant des configurations particulières au formulaire
 * @param array $row
 *     Valeurs de la ligne SQL du po_periode, si connu
 * @param string $hidden
 *     Contenu HTML ajouté en même temps que les champs cachés du formulaire.
 * @return array
 *     Retours des traitements
 */
function formulaires_editer_po_periode_traiter_dist($id_po_periode = 'new', $retour = '', $lier_trad = 0, $config_fonc = '', $row = array(), $hidden = '') {
	$retours = formulaires_editer_objet_traiter('po_periode', $id_po_periode, '', $lier_trad, $retour, $config_fonc, $row, $hidden);
	return $retours;
}
