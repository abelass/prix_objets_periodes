<?php
/**
 * Utilisation de l'action supprimer pour l'objet po_periode
 *
 * @plugin     Prix objets par périodes
 * @copyright  2018 - 2019
 * @author     Rainer Müller
 * @licence    GNU/GPL v3
 * @package    SPIP\Prix_objets_periodes\Action
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}



/**
 * Action pour supprimer un·e po_periode
 *
 * Vérifier l'autorisation avant d'appeler l'action.
 *
 * @example
 *     ```
 *     [(#AUTORISER{supprimer, po_periode, #ID_PO_PERIODE}|oui)
 *         [(#BOUTON_ACTION{<:po_periode:supprimer_po_periode:>,
 *             #URL_ACTION_AUTEUR{supprimer_po_periode, #ID_PO_PERIODE, #URL_ECRIRE{po_periodes}},
 *             danger, <:po_periode:confirmer_supprimer_po_periode:>})]
 *     ]
 *     ```
 *
 * @example
 *     ```
 *     [(#AUTORISER{supprimer, po_periode, #ID_PO_PERIODE}|oui)
 *         [(#BOUTON_ACTION{
 *             [(#CHEMIN_IMAGE{po_periode-del-24.png}|balise_img{<:po_periode:supprimer_po_periode:>}|concat{' ',#VAL{<:po_periode:supprimer_po_periode:>}|wrap{<b>}}|trim)],
 *             #URL_ACTION_AUTEUR{supprimer_po_periode, #ID_PO_PERIODE, #URL_ECRIRE{po_periodes}},
 *             icone s24 horizontale danger po_periode-del-24, <:po_periode:confirmer_supprimer_po_periode:>})]
 *     ]
 *     ```
 *
 * @example
 *     ```
 *     if (autoriser('supprimer', 'po_periode', $id_po_periode)) {
 *          $supprimer_po_periode = charger_fonction('supprimer_po_periode', 'action');
 *          $supprimer_po_periode($id_po_periode);
 *     }
 *     ```
 *
 * @param null|int $arg
 *     Identifiant à supprimer.
 *     En absence de id utilise l'argument de l'action sécurisée.
**/
function action_supprimer_po_periode_dist($arg=null) {
	if (is_null($arg)){
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
	}
	$arg = intval($arg);

	// cas suppression
	if ($arg) {
		sql_delete('spip_po_periodes',  'id_po_periode=' . sql_quote($arg));
	}
	else {
		spip_log("action_supprimer_po_periode_dist $arg pas compris");
	}
}
