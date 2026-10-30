..  include:: /Includes.rst.txt

..  _core-support-permissions:

===========
Permissions
===========

You can allow backend users and groups to edit records in some languages
only. TYPO3 checks this permission in every table that has a
`language field <https://docs.typo3.org/permalink/t3translate:core-support-tca-languagefield>`_.

To limit a backend user group to some languages:

#.  Go to the module :guilabel:`Administration > Users`.
#.  Open the backend user group.
#.  On the tab :guilabel:`Record Permissions`, check the languages in the
    field :guilabel:`Limit to languages`.

..  figure:: /Images/GeneratedScreenshots/Permissions/LimitToLanguages.png
    :alt: The field Limit to languages, with Español checked
    :class: with-shadow

    A group of translators who edit Spanish records only

A backend user has the field :guilabel:`Limit to languages` as well. TYPO3
merges the languages of the user and of all their groups and subgroups. If
none of them checks a language, the user can edit all languages.

Every user can edit records in the language :guilabel:`[All]`.

The limit protects the default language and the other languages from changes
by a translator. The language menus of the modules offer the translator
only the languages that they can edit.
