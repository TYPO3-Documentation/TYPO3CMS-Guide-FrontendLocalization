:navigation-title: Translatable tables

..  include:: /Includes.rst.txt

..  _core-support-tca:

==============================================
Making the tables of an extension translatable
==============================================

An extension describes its database tables in the
`Table Configuration Array (TCA) <https://docs.typo3.org/permalink/t3tca:start>`_.
The TCA defines the fields in a record and how the backend should display them in a
form. A translation is a record which points
to the record in the default language in the same table. To make records in a table
translatable, set the language properties in the
`[ctrl] section <https://docs.typo3.org/permalink/t3tca:ctrl>`_ of the table's TCA:

..  literalinclude:: /CodeSnippets/my_extension/Configuration/TCA/tx_myextension_conference.php
    :caption: EXT:my_extension/Configuration/TCA/tx_myextension_conference.php
    :visible-lines: 4, 19-22, 29, 56-59, 62-63, 66-69, 74-77
    :emphasize-lines: 19-22,75

TYPO3 will than automatically add the TCA "columns" of these fields and the
database fields behind them. See
`Auto-created columns from 'ctrl' <https://docs.typo3.org/permalink/t3tca:ctrl-auto-created-columns>`_.
TYPO3 does not automatically display the fields in the form. You need to add
them in the `types` section. The example above adds a `language` tab to the form with
two fields: the language and a reference to the original record that is in the
default language.

The form of a translation shows the default language values of the record below
each field:

..  figure:: /Images/GeneratedScreenshots/CoreSupport/TranslatingRecord.png
    :alt: The form of a Spanish conference, with the English title as a hint
    :class: with-shadow

    The Spanish translation of a conference, with the English title as a hint

..  contents:: **Content**
    :local:


..  _core-support-tca-languagefield:

[languageField]
===============

The first field is the
`languageField <https://docs.typo3.org/permalink/t3tca:ctrl-reference-languagefield>`_
property and contains a reference to the language the record is in.

..  note::
    This field was traditionally named `sys_language_uid`, but you can register
    the field using any name.

The field has TCA type
`language <https://docs.typo3.org/permalink/t3tca:columns-language>`_, which
contains the site languages and the language :guilabel:`[All]`. TYPO3
migrates a field of another type to this type, and can lose parts of its
configuration on the way. See
`Migration to the language type <https://docs.typo3.org/permalink/t3tca:columns-language-migration>`_.


..  _core-support-tca-transorigpointerfield:

[transOrigPointerField]
=======================

The second field is the
`transOrigPointerField <https://docs.typo3.org/permalink/t3tca:ctrl-reference-transorigpointerfield>`_
property and contains a reference to the record in the default language. The
two fields belong together, so TYPO3 uses the name `l10n_parent` for a table
that defines `languageField` but not `transOrigPointerField`.

..  note::
    This field was traditionally named `l10n_parent`, but any name can be
    used since it is registered with the `transOrigPointerField` property.

    The `l18n_parent` name used in table `tt_content` is a historical
    mistake.

The field is only displayed in records that are not in the default language, as a
record in the default language has nothing to point to.

It will only reference records in the default language if those records are on
the same page as the translation. This means that a
**default language record and all its translations must be on the same page!**
This principle is respected by the API function
:php-short:`\TYPO3\CMS\Core\Domain\Repository\PageRepository::getLanguageOverlay()`
which fetches translations of records for the frontend display.

The form of a translation displays the values of the record that the field
points to below its fields.

..  warning::
    The configured
    :php:`$GLOBALS['TCA'][$table]['ctrl']['transOrigPointerField']` cannot be
    excluded as this leads to inconsistent data stored in the database. This
    happens when a non-admin user creates a localization but does not have
    permission to edit the `transOrigPointerField`. Remove
    :php:`exclude => true` from TCA, if set.


..  _core-support-tca-transorigdiffsourcefield:

[transOrigDiffSourceField]
==========================

There is one more field which can be used on a translatable table. It is defined in
the property
`transOrigDiffSourceField <https://docs.typo3.org/permalink/t3tca:ctrl-reference-transorigdiffsourcefield>`_
and is optional. It points to a blob database field which stores the
content of the default language record as it was when the translation was
originally made. This is then used to display any new changes that have occurred in the
default record since translation. For example, in the `tt_content`
table, the header field may look like this:

..  figure:: /Images/GeneratedScreenshots/CoreSupport/TranslationChanged.png
    :alt: The header of a translation, with the change of the English header
    :class: with-shadow

    Changes in the original content are highlighted below the input field

This allows a translator to easily spot what has changed.


..  _core-support-tca-translationsource:

[translationSource]
===================

The ":ref:`translationSource <t3tca:ctrl-reference-translationsource>`"
property defines the name of the field that is used by translations to point
back to the original record (that means, the record in the language of which
they are a translation). This property is often set to `l10n_source` in Core
tables.

This property is similar to
:ref:`transOrigPointerField <core-support-tca-transorigpointerfield>`.
In :ref:`connected mode <localized-content>`, while
`transOrigPointerField` always contains the uid of the default language
record, this field contains the uid of the record the translation was created
from.

For example, if there is a `tt_content` record in a default language (English) with
uid 13, and this record is translated to French with uid 17, and a Danish
translation is later created based on the French translation, then the Danish
translation will have uid 13 set as `l10n_parent` and uid 17 as `l10n_source`.


..  _core-support-tca-localization-command:

DataHandler commands for localization
=====================================

The :ref:`DataHandler <t3coreapi:datahandler-basics>` writes any changes
that the backend makes to records. The DataHandler
:ref:`"localize" command <t3coreapi:tce-command-keywords>` translates records.
The backend runs this command when you translate an element in
:guilabel:`Content > Records` or :guilabel:`Content > Layout`.

When this command is run an ordinary copy is made, but the
:ref:`languageField <core-support-tca-languagefield>` and
:ref:`transOrigPointerField <core-support-tca-transorigpointerfield>` fields are
updated.

You can only localize a record which is not already localized and which has language set to
"default" or "All" (a record with language "All" is
classed as valid for any language, but can still be translated).

It is possible to manually create two or more translations of the
same record but this is considered to be an error in the system. Although
not fatal, it can produce unpredictable results.


..  _core-support-tca-localization-command-options:

Localization command options per field
--------------------------------------

Each field may contain special instructions which will affect the "localize"
command. The most important is the
:ref:`"l10n\_mode" field <t3tca:columns-properties-l10n-mode>` which,
for example, can entirely exclude a field from the translation process.
