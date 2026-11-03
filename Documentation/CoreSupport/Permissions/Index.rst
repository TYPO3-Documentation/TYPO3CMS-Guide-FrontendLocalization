..  include:: /Includes.rst.txt

..  _core-support-permissions:

===========
Permissions
===========

You can allow backend users and groups to edit records in some languages
only. TYPO3 checks this permission in every table that has a
`language field <https://docs.typo3.org/permalink/t3translate:core-support-tca-languagefield>`_.

To limit a backend user group to certain languages:

#.  Go to the :guilabel:`Administration > Users` module.
#.  Open the backend user group.
#.  On the tab :guilabel:`Record Permissions`, check the languages in the
    field :guilabel:`Limit to languages`.

..  figure:: /Images/GeneratedScreenshots/Permissions/LimitToLanguages.png
    :alt: The field Limit to languages, with Español checked
    :class: with-shadow

    A group of translators who edit Spanish records only

A backend user has the field :guilabel:`Limit to languages` as well. TYPO3
merges the languages of the user and of all their groups and subgroups. If
no languages are checked in any of these places, the user can edit all languages.

Every user can edit records in the language :guilabel:`[All]`.

This protects the default language and the other languages from being changed
by translators. Language menus in the modules only list
the languages that a translator can edit.
