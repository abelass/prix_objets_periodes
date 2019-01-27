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
 * @param integer $id_periode
 * @param array $contexte
 * @return boolean
 */
function prix_objet_periode_dist($id_periode, $contexte = array()) {
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

	$donnees_periode = sql_fetsel('*', 'spip_periodes', 'id_periode=' . $id_periode);

	$type = trim($donnees_periode['type']);
	$criteres = $donnees_periode['criteres'];
	$operateur = !empty($donnees_periode['operateur']) ? $donnees_periode['operateur'] : '==';
	$operateur_2 = !empty($donnees_periode['operateur_2']) ? $donnees_periode['operateur_2'] : '==';
	$date_debut_periode = $donnees_periode['date_debut'];
	$date_fin_periode = $donnees_periode['date_fin'];

	switch ($type) {
		case 'date':
			switch ($criteres) {
				case 'coincide' :

					if (($date_debut_contexte <= $date_fin_periode) and ($date_fin_contexte >= $date_debut_periode)) {
						$applicable = TRUE;
					}
					break;
				case 'exclu' :
					if (($date_debut_contexte > $date_fin_periode) or ($date_fin_contexte < $date_debut_periode)) {
						$applicable = TRUE;
					}
					break;
				case 'specifique' :
					if(po_condition($date_debut_contexte, $operateur, $date_debut_periode) and
					po_condition($date_fin_contexte, $operateur_2, $date_fin_periode)) {
							$applicable = TRUE;
						}
					break;
			}
			break;
		case 'jour_semaine':
			$jour_debut_periode = $donnees_periode['jour_debut'];
			$jour_fin_periode = $donnees_periode['jour_fin'];
			$jour_debut_contexte = date('w', strtotime($date_debut_contexte));
			$jour_fin_contexte = date('w', strtotime($date_fin_contexte));
			$dates_periode = [];//array($jour_debut_periode, $jour_fin_periode);
			if ($jour_fin_periode == 0) {
				$jour_fin_periode = 7;
			}

			$i = $jour_debut_periode;
			while ($i <= $jour_fin_periode) {
				$jour = $i;
				if ($jour == 7) {
					$jour = 0;
				}
				$dates_periode[] = $jour;
				$i++;
			}
			$dates_intervalle = dates_intervalle($date_debut_contexte, $date_fin_contexte, 0, 0, FALSE, 'w');
			$coincidences = array_intersect($dates_periode, $dates_intervalle);
			switch ($criteres) {
				case 'coincide' :
					if(count($coincidences) > 0) {
						$applicable = TRUE;
					}
					break;
				case 'exclu' :
					if(count($coincidences) == 0) {
						$applicable = TRUE;
					}
					break;
				case 'specifique' :
					if($jour_debut_contexte == $jour_debut_periode and
						$jour_fin_contexte == $jour_fin_periode) {
						$applicable = TRUE;
					}
					break;
			}
			break;
		case 'jour_nombre':
			$fin = strtotime(date('Y-m-d', strtotime($date_fin_contexte)));
			$debut = strtotime(date('Y-m-d', strtotime($date_debut_contexte)));
			if ($fin >= $debut) {
				$difference_date = $fin - $debut;
				$nombre_jours_contexte = $difference_date / (60 * 60 * 24);
				$nombre_jours = $donnees_periode['jour_nombre'];

				if (po_condition($nombre_jours_contexte, $operateur, $nombre_jours)) {
					$applicable = TRUE;
				}
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
