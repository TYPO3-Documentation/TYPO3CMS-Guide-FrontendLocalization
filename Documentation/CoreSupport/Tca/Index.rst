:navigation-title: Translatable tables

..  include:: /Includes.rst.txt

..  _core-support-tca:

==============================================
Making the tables of an extension translatable
==============================================

An extension describes its database tables in the
`Table Configuration Array (TCA) <https://docs.typo3.org/permalink/t3tca:start>`_.
The TCA defines the fields of a record and how the backend shows them in a
form. A translation is a record of its own in the same table, which points
to the record in the default language. To make the records of a table
translatable, set the language properties in the
`[ctrl] section <https://docs.typo3.org/permalink/t3tca:ctrl>`_ of its TCA:

..  literalinclude:: /CodeSnippets/my_extension/Configuration/TCA/tx_myextension_conference.php
    :caption: EXT:my_extension/Configuration/TCA/tx_myextension_conference.php
    :visible-lines: 4, 19-22, 29, 56-59, 62-63, 66-69, 74-77
    :emphasize-lines: 19-22

TYPO3 adds the TCA columns of these fields and the database columns behind
them. See
`Auto-created columns from 'ctrl' <https://docs.typo3.org/permalink/t3tca:ctrl-auto-created-columns>`_.
TYPO3 does not add the fields to the form. Show them in the `types` of the
table. The example above puts the language and the reference to the record in
the default language into a palette on a tab of their own.

The form of a translation shows the values of the record in the default
language below its fields:

..  figure:: /Images/GeneratedScreenshots/CoreSupport/TranslatingRecord.png
    :alt: The form of a Spanish conference, with the English title as a hint
    :class: with-shadow

    The Spanish translation of a conference, with the English title as a hint

..  contents:: **Content**
    :local:


..  _core-support-tca-languagefield:

[languageField]
===============

The first field is defined by the
`languageField <https://docs.typo3.org/permalink/t3tca:ctrl-reference-languagefield>`_
property and contains a reference to the language the record is in.

..  note::
    This field is traditionally named `sys_language_uid`, but any name can
    be used since it is registered with the `languageField` property in
    the ctrl section.

The field has the TCA type
`language <https://docs.typo3.org/permalink/t3tca:columns-language>`_, which
offers the languages of the site and the language :guilabel:`[All]`. TYPO3
migrates a field of another type to this type, and can lose parts of its
configuration on the way. See
`Migration to the language type <https://docs.typo3.org/permalink/t3tca:columns-language-migration>`_.


..  _core-support-tca-transorigpointerfield:

[transOrigPointerField]
=======================

The second field is defined by the
`transOrigPointerField <https://docs.typo3.org/permalink/t3tca:ctrl-reference-transorigpointerfield>`_
property and contains a reference to the record in the default language. The
two fields belong together, so TYPO3 uses the name `l10n_parent` for a table
that defines `languageField` and no `transOrigPointerField`.

..  note::
    This field is traditionally named `l10n_parent`, but any name can be
    used since it is registered with the `transOrigPointerField` property.

    The `l18n_parent` name used in table `tt_content` is a historical
    mistake.

The field is only displayed in a record of a language other than the default
one, as a record in the default language has nothing to point to.

It offers the records of the default language on the page of the translation
only. This means that a
**default language record and all its translations must be on the same page!**
This principle is also respected by the API function
:php-short:`\TYPO3\CMS\Core\Domain\Repository\PageRepository::getLanguageOverlay()`
which fetches translations of records for the frontend display.

The form of a translation shows the values of the record that this field
points to below its fields.

..  warning::
    The configured
    :php:`$GLOBALS['TCA'][$table]['ctrl']['transOrigPointerField']` cannot be
    excluded as this leads to inconsistent data stored in the database. This
    happens when a non-admin user creates a localization while not having the
    permission to edit the `transOrigPointerField`. Remove
    :php:`exclude => true` from TCA, if set.


..  _core-support-tca-transorigdiffsourcefield:

[transOrigDiffSourceField]
==========================

The property
`transOrigDiffSourceField <https://docs.typo3.org/permalink/t3tca:ctrl-reference-transorigdiffsourcefield>`_
defines a third field, which is optional. Each time a translation is saved,
TYPO3 stores the values of the original in this field. The form of the
translation then shows which fields of the original have changed since. In
the table `tt_content`, the field is `l18n_diffsource`. A changed header
looks like this:

..  figure:: /Images/GeneratedScreenshots/CoreSupport/TranslationChanged.png
    :alt: The header of a translation, with the change of the English header
    :class: with-shadow

    Changes in the original content are highlighted below the input field

A translator sees what changed, and can update the translation.


..  _core-support-tca-translationsource:

[translationSource]
===================

The property
`translationSource <https://docs.typo3.org/permalink/t3tca:ctrl-reference-translationsource>`_
defines the field that points to the record that a translation was made
from. The Core tables name it `l10n_source`.

A translation can be made from the record in the default language, or from
a translation in another language. The field
`transOrigPointerField <https://docs.typo3.org/permalink/t3translate:core-support-tca-transorigpointerfield>`_
always points to the record in the default language. The field
`translationSource` points to the record that the translation was made from.

For example, a `tt_content` record in English has the uid 13. Its French
translation has the uid 17. A Danish translation made from the French one
has 13 in `l18n_parent`, and 17 in `l10n_source`.


..  _core-support-tca-localization-command:

DataHandler commands for localization
=====================================

The `DataHandler <https://docs.typo3.org/permalink/t3coreapi:datahandler-basics>`_
writes the changes that the backend makes to records. Its
`commands <https://docs.typo3.org/permalink/t3coreapi:tce-command-keywords>`_
`localize` and `copyToLanguage` create a translation or a copy of a record
in another language. The
translation wizard sends `localize` for :guilabel:`Translate`, and
`copyToLanguage` for :guilabel:`Copy`.

Both commands copy the record and set its
`languageField <https://docs.typo3.org/permalink/t3translate:core-support-tca-languagefield>`_
to the target language. `localize` also sets the
`transOrigPointerField <https://docs.typo3.org/permalink/t3translate:core-support-tca-transorigpointerfield>`_
to the record in the default language. `copyToLanguage` sets it to 0, so
the copy has no connection to the original.

The command `localize` refuses to translate a record that has a translation
in the target language already. Two translations of the same record in one
language are an error, and lead to unpredictable results.


..  _core-support-tca-localization-command-options:

Localization command options per field
--------------------------------------

The TCA property
`l10n_mode <https://docs.typo3.org/permalink/t3tca:columns-properties-l10n-mode>`_
of a field changes how the commands handle it. For example, `exclude`
leaves the field out of the translation, so that the translation takes the
value of the original.
