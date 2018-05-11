<?php

/**
 *  Fichier généré par la Fabrique de plugin v6
 *   le 2018-05-11 11:19:14
 *
 *  Ce fichier de sauvegarde peut servir à recréer
 *  votre plugin avec le plugin «Fabrique» qui a servi à le créer.
 *
 *  Bien évidemment, les modifications apportées ultérieurement
 *  par vos soins dans le code de ce plugin généré
 *  NE SERONT PAS connues du plugin «Fabrique» et ne pourront pas
 *  être recréées par lui !
 *
 *  La «Fabrique» ne pourra que régénerer le code de base du plugin
 *  avec les informations dont il dispose.
 *
**/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$data = array (
  'fabrique' => 
  array (
    'version' => 6,
  ),
  'paquet' => 
  array (
    'prefixe' => 'prix_objets_periodes',
    'nom' => 'Prix objets par périodes',
    'slogan' => 'Des prix selon la date',
    'description' => 'Adapter les prix selon la/les date/s choisis',
    'logo' => 
    array (
      0 => '',
    ),
    'version' => '1.0.0',
    'auteur' => 'Rainer Müller',
    'auteur_lien' => 'https://websimple.be',
    'licence' => 'GNU/GPL v3',
    'categorie' => 'divers',
    'etat' => 'dev',
    'compatibilite' => '[3.0.0;3.2.*]',
    'documentation' => 'https://github.com/abelass/prix_objets_periodes',
    'administrations' => 'on',
    'schema' => '1.0.0',
    'formulaire_config' => 'on',
    'formulaire_config_titre' => 'Paramètres Prix objets par périodes',
    'fichiers' => 
    array (
      0 => 'autorisations',
      1 => 'fonctions',
      2 => 'pipelines',
    ),
    'inserer' => 
    array (
      'paquet' => '',
      'administrations' => 
      array (
        'maj' => '',
        'desinstallation' => '',
        'fin' => '',
      ),
      'base' => 
      array (
        'tables' => 
        array (
          'fin' => '',
        ),
      ),
    ),
    'scripts' => 
    array (
      'pre_copie' => '',
      'post_creation' => '',
    ),
    'exemples' => 'on',
  ),
  'objets' => 
  array (
    0 => 
    array (
      'nom' => 'Périodes prix',
      'nom_singulier' => 'Période prix',
      'genre' => 'feminin',
      'logo' => 
      array (
        0 => '',
        32 => '',
        24 => '',
        16 => '',
        12 => '',
      ),
      'logo_variantes' => '',
      'table' => 'spip_po_periodes',
      'cle_primaire' => 'id_po_periode',
      'cle_primaire_sql' => 'bigint(21) NOT NULL',
      'table_type' => 'po_periode',
      'champs' => 
      array (
        0 => 
        array (
          'nom' => 'Titre',
          'champ' => 'titre',
          'sql' => 'varchar(255) NOT NULL DEFAULT \'\'',
          'caracteristiques' => 
          array (
            0 => 'editable',
            1 => 'versionne',
            2 => 'obligatoire',
          ),
          'recherche' => '8',
          'saisie' => 'input',
          'explication' => '',
          'saisie_options' => '',
        ),
        1 => 
        array (
          'nom' => 'Déscriptif',
          'champ' => 'descriptif',
          'sql' => 'text NOT NULL DEFAULT \'\'',
          'caracteristiques' => 
          array (
            0 => 'editable',
            1 => 'versionne',
          ),
          'recherche' => '5',
          'saisie' => 'textarea',
          'explication' => '',
          'saisie_options' => 'conteneur_class=pleine_largeur, class=inserer_barre_edition, rows=4',
        ),
        2 => 
        array (
          'nom' => 'type',
          'champ' => 'type',
          'sql' => 'varchar(20) NOT NULL DEFAULT \'\'',
          'caracteristiques' => 
          array (
            0 => 'editable',
            1 => 'versionne',
            2 => 'obligatoire',
          ),
          'recherche' => '',
          'saisie' => 'radio',
          'explication' => '',
          'saisie_options' => 'data=[(#ARRAY{cle1,valeur1,cle2,valeur2})]',
        ),
        3 => 
        array (
          'nom' => 'Date début',
          'champ' => 'date_debut',
          'sql' => 'datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\'',
          'caracteristiques' => 
          array (
            0 => 'editable',
            1 => 'versionne',
          ),
          'recherche' => '',
          'saisie' => 'date',
          'explication' => '',
          'saisie_options' => '',
        ),
        4 => 
        array (
          'nom' => 'Date fin',
          'champ' => 'date_fin',
          'sql' => 'datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\'',
          'caracteristiques' => 
          array (
            0 => 'editable',
            1 => 'versionne',
          ),
          'recherche' => '',
          'saisie' => 'date',
          'explication' => '',
          'saisie_options' => '',
        ),
        5 => 
        array (
          'nom' => 'Premier jour',
          'champ' => 'jour_debut',
          'sql' => 'int(1) NOT NULL DEFAULT 0',
          'caracteristiques' => 
          array (
            0 => 'editable',
            1 => 'versionne',
          ),
          'recherche' => '',
          'saisie' => 'selection',
          'explication' => '',
          'saisie_options' => 'data=[(#ARRAY{cle1,valeur1,cle2,valeur2})]',
        ),
        6 => 
        array (
          'nom' => 'Dernier jour',
          'champ' => 'jour_fin',
          'sql' => 'int(1) NOT NULL DEFAULT 0',
          'caracteristiques' => 
          array (
            0 => 'editable',
            1 => 'versionne',
          ),
          'recherche' => '',
          'saisie' => 'selection',
          'explication' => '',
          'saisie_options' => 'data=[(#ARRAY{cle1,valeur1,cle2,valeur2})]',
        ),
        7 => 
        array (
          'nom' => 'Nombre de jours',
          'champ' => 'jour_nombre',
          'sql' => 'int(11) NOT NULL DEFAULT 0',
          'caracteristiques' => 
          array (
            0 => 'editable',
            1 => 'versionne',
          ),
          'recherche' => '',
          'saisie' => 'input',
          'explication' => '',
          'saisie_options' => '',
        ),
      ),
      'champ_titre' => 'titre',
      'champ_date' => 'date',
      'statut' => 'on',
      'chaines' => 
      array (
        'titre_objets' => 'Périodes prix',
        'titre_objet' => 'Période prix',
        'info_aucun_objet' => 'Aucune période prix',
        'info_1_objet' => 'Une période prix',
        'info_nb_objets' => '@nb@ périodes prix',
        'icone_creer_objet' => 'Créer une période prix',
        'icone_modifier_objet' => 'Modifier cette période prix',
        'titre_logo_objet' => 'Logo de cette période prix',
        'titre_langue_objet' => 'Langue de cette période prix',
        'texte_definir_comme_traduction_objet' => 'Cette période prix est une traduction de la période prix numéro :',
        'titre_\\objets_lies_objet' => 'Liés à cette période prix',
        'titre_objets_rubrique' => 'Périodes prix de la rubrique',
        'info_objets_auteur' => 'Les périodes prix de cet auteur',
        'retirer_lien_objet' => 'Retirer cette période prix',
        'retirer_tous_liens_objets' => 'Retirer toutes les périodes prix',
        'ajouter_lien_objet' => 'Ajouter cette période prix',
        'texte_ajouter_objet' => 'Ajouter une période prix',
        'texte_creer_associer_objet' => 'Créer et associer une période prix',
        'texte_changer_statut_objet' => 'Cette période prix est :',
        'supprimer_objet' => 'Supprimer cette période prix',
        'confirmer_supprimer_objet' => 'Confirmez-vous la suppression de cette période prix ?',
      ),
      'liaison_directe' => '',
      'table_liens' => '',
      'afficher_liens' => '',
      'roles' => '',
      'auteurs_liens' => '',
      'vue_auteurs_liens' => '',
      'fichiers' => 
      array (
        'echafaudages' => 
        array (
          0 => 'prive/squelettes/contenu/objets.html',
          1 => 'prive/objets/infos/objet.html',
          2 => 'prive/squelettes/contenu/objet.html',
        ),
        'explicites' => 
        array (
          0 => 'action/supprimer_objet.php',
        ),
      ),
      'saisies' => 
      array (
        0 => 'objets',
      ),
      'autorisations' => 
      array (
        'objet_creer' => '',
        'objet_voir' => '',
        'objet_modifier' => '',
        'objet_supprimer' => '',
        'associerobjet' => '',
      ),
      'boutons' => 
      array (
        0 => 'menu_edition',
      ),
    ),
  ),
  'images' => 
  array (
    'paquet' => 
    array (
      'logo' => 
      array (
        0 => 
        array (
          'extension' => 'png',
          'contenu' => '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',
        ),
      ),
    ),
    'objets' => 
    array (
      0 => 
      array (
        'logo' => 
        array (
          0 => 
          array (
            'extension' => 'png',
            'contenu' => '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',
          ),
        ),
      ),
    ),
  ),
);
