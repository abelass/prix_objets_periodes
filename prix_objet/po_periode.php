<?php
/**
 * Fonctions relatives au fonctionnement des extension à Prix Objets
 *
 * @plugin     Prix objets par périodes
 * @copyright  2012 - 2018
 * @author     Rainer Müller
 * @licence    GNU/GPL
 * @package    SPIP\prix_objets_periodes\Extensions
 */

// Sécurité
if (!defined('_ECRIRE_INC_VERSION'))
	return;

/**
 * Détermine si une extension est applicable pour un objet
 *
 * @param integer $id_po_periode
 * @param array $contexte
 * @return boolean
 */
function prix_objet_po_periode_dist($id_po_periode, $contexte) {
	$date = date('Y-m-d H:s:m', time());
	$date_debut_contexte = isset($contexte['date_debut']) ?
		$contexte['date_debut'] :
		(_request('date_debut') ?
			_request('date_debut') :
			$date
		);
	$date_fin_contexte = isset($contexte['date_fin']) ?
		$contexte['date_fin'] :
		(
			_request('date_fin') ?
			_request('date_fin') :
			$date
		);
	$applicable = FALSE;

	$donnees_periode = sql_fetsel('*', 'spip_po_periodes', 'id_po_periode=' . $id_po_periode);

	$type = $donnes_periode['type'];
	$operateur = !empty($donnees_periode['operateur']) ? $donnees_periode['operateur'] : '==';
	$operateur_2 = !empty($donnees_periode['operateur_2']) ? $donnees_periode['operateur_2'] : '==';

	switch ($type) {
		case 'date':
			if(po_condition($date_debut_contexte,$operateur,$donnees_periode['date_debut']) and
			po_condition($date_fin_contexte,$operateur,$donnees_periode['date_fin'])) {
				$applicable = TRUE;
			}

			break;
		case 'jour_semaine':
			$jour_debut_contexte = date('w', $date_debut_contexte);
			$jour_fin_contexte = date('w', $date_fin_contexte);

			if($jour_debut_contexte == $donnees_periode['jour_debut'] and
					$jour_fin_contexte == $donnees_periode['jour_fin']
					) {
				$applicable = TRUE;
					}
			break;
		case 'jour_nombre':
			$jour_nombre_contexte = 0;
			if($date_debut_contexte < 0) {
				$difference_date = $date_debut_contexte - $date_debut_contexte;
				$jour_nombre_contexte = round($difference_date / (60 * 60 * 24));
			}

			if(po_condition($nombre_jours,$operateur,$donnees_periode['jour_nombre'])) {
				$applicable = TRUE;
			}
			break;
	}

	return $applicable;
}


function po_condition($var1, $op, $var2) {

	switch ($op) {
		case "=":
			return $var1 == $var2;
		case "!=":
			return $var1 != $var2;
		case ">=":
			return $var1 >= $var2;
		case "<=":
			return $var1 <= $var2;
		case ">":
			return $var1 >  $var2;
		case "<":
			return $var1 <  $var2;
		default:
			return true;
	}
}
