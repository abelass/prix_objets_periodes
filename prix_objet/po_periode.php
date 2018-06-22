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
 * @param integer $prix
 * @param array $contexte
 * @param string $mode
 *        	Mode de calcul de prix (global ou prorata)
 * @param array $sequence
 *        	période pour le calcul des prix prorata
 *
 * @return string si applicable le prix, sino rien
 */
function prix_objet_po_periode_dist($id_po_periode, $prix, $contexte = array(), $mode, $sequence = array()) {
	$date = date('Y-m-d H:s:m', time());
	$date_debut_contexte = isset($contexte['date_debut']) ? $contexte['date_debut'] : (_request('date_debut') ? _request('date_debut') : $date);
	$date_fin_contexte = isset($contexte['date_fin']) ? $contexte['date_fin'] : (_request('date_fin') ? _request('date_fin') : $date);
	$prix_applicable = '';

	$donnees_periode = sql_fetsel('*', 'spip_po_periodes', 'id_po_periode=' . $id_po_periode);

	$type = trim($donnees_periode['type']);
	$criteres = $donnees_periode['criteres'];
	$operateur = !empty($donnees_periode['operateur']) ? $donnees_periode['operateur'] : '==';
	$operateur_2 = !empty($donnees_periode['operateur_2']) ? $donnees_periode['operateur_2'] : '==';
	$date_debut_periode = $donnees_periode['date_debut'];
	$date_fin_periode = $donnees_periode['date_fin'];
	$jour_debut_periode = $donnees_periode['jour_debut'];
	$jour_fin_periode = $donnees_periode['jour_fin'];

	if ($mode == 'prorata' and is_array($sequence)) {
		$prix_prorata = isset($contexte['prix_prorata']) ? $contexte['prix_prorata'] : array();

		foreach ($sequence as $index => $date_sequence) {
			if ($prix_applicable = _po_obtenir_prix(
					$date_sequence,
					$date_sequence,
					$date_debut_periode,
					$date_fin_periode,
					$jour_debut_periode,
					$jour_fin_periode,
					$prix,
					$type,
					$criteres,
					$operateur,
					$operateur2)) {
				$prix_prorata[$date_sequence] = $prix_applicable;
				unset($sequence[$index]);
			}
		}
		$prix_applicable = array(
			'sequence' => $sequence,
			'prix_prorata' => $prix_prorata,
		);
	}
	else {
		$prix_applicable = _po_obtenir_prix(
			$date_debut_contexte,
			$date_fin_contexte,
			$date_debut_periode,
			$date_fin_periode,
			$jour_debut_periode,
			$jour_fin_periode,
			$prix,
			$type,
			$criteres,
			$operateur,
			$operateur2);
	}


	return $prix_applicable;
}

function _po_obtenir_prix(
	$date_debut_contexte,
	$date_fin_contexte,
	$date_debut_periode,
	$date_fin_periode,
	$jour_debut_periode,
	$jour_fin_periode,
	$prix,
	$type,
	$criteres,
	$operateur,
	$operateur2) {
	$prix_applicable = '';

	switch ($type) {
		case 'date':
			switch ($criteres) {
				case 'coincide':
					if (($date_debut_contexte <= $date_fin_periode) and ($date_fin_contexte >= $date_debut_periode)) {
						$prix_applicable = $prix;
					}
					break;
				case 'exclu':
					if (($date_debut_contexte > $date_fin_periode) or ($date_fin_contexte < $date_debut_periode)) {
						$prix_applicable = $prix;
					}
					break;
				case 'specifique':
					if (_po_condition($date_debut_contexte, $date_debut_periode, $operateur) and
							_po_condition($date_fin_contexte, $date_fin_periode, $operateur_2)) {
						$prix_applicable = $prix;
					}
					break;
			}
			break;
		case 'jour_semaine':
			$jour_debut_contexte = date('w', strtotime($date_debut_contexte));
			$jour_fin_contexte = date('w', strtotime($date_fin_contexte));
			$dates_periode = array(
				$jour_debut_periode,
				$jour_fin_periode
			);
			$dates_intervalle = dates_intervalle($date_debut_contexte, $date_fin_contexte, 0, 0, FALSE, 'w');
			$coincidences = array_intersect($dates_periode, $dates_intervalle);
			spip_log('$dates_intervalle', 'teste');
			spip_log($dates_intervalle, 'teste');
			spip_log('$dates_periode', 'teste');
			spip_log($dates_periode, 'teste');
			spip_log(count($coincidences), 'teste');
			switch ($criteres) {
				case 'coincide':
					if (count($coincidences) > 0) {
						$prix_applicable = $prix;
					}
					break;
				case 'exclu':
					if (count($coincidences) == 0) {
						$prix_applicable = $prix;
					}
					break;
				case 'specifique':
					if ($jour_debut_contexte == $jour_debut_periode and $jour_fin_contexte == $jour_fin_periode) {
						$prix_applicable = $prix;
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

				if (_po_condition($nombre_jours_contexte, $nombre_jours, $operateur)) {
					$prix_applicable = $prix;
				}
			}

			break;
	}

	return $prix_applicable;
}

/**
 * Teste deux valeurs avec l'opérateur donné.
 *
 * @param integer $valeur1
 *        	Première Valeur à tester
 * @param integer $valeur2
 *        	Deuxième Valeur à tester
 * @param string $operateur
 *        	L'opérateur à utiliser
 *
 * @return boolean True si le teste est positive.
 */
function _po_condition($valeur1, $valeur2, $operateur) {
	switch ($operateur) {
		case "=":
			return $valeur1 == $valeur2;
		case "!=":
			return $valeur1 != $valeur2;
		case ">=":
			return $valeur1 >= $valeur2;
		case "<=":
			return $valeur1 <= $valeur2;
		case ">":
			return $valeur1 > $valeur2;
		case "<":
			return $valeur1 < $valeur2;
		default:
			return true;
	}
}
