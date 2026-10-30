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

There is one more field which can be used on a translatable table, defined by
the property
`transOrigDiffSourceField <https://docs.typo3.org/permalink/t3tca:ctrl-reference-transorigdiffsourcefield>`_.
It is optional. It points to a blob database field which will store the
content of the default language record as it was when the translation was
made. Then this is used to display any changes that have occurred in the
default record since translation happened. For example, in the `tt_content`
table, it may look like this for the header field:

..  figure:: /Images/GeneratedScreenshots/CoreSupport/TranslationChanged.png
    :alt: The header of a translation, with the change of the English header
    :class: with-shadow

    Changes in the original content are highlighted below the input field

This allows a translator to spot easily what has changed in order to adjust the
translation accordingly.


..  _core-support-tca-translationsource:

[translationSource]
===================

The ":ref:`translationSource <t3tca:ctrl-reference-translationsource>`"
property defines a name of the field used by translations to point back to the
original record (that means, the record in any language of which they are a
translation). This property is often set to `l10n_source` in Core tables.

This property is similar to
:ref:`transOrigPointerField <core-support-tca-transorigpointerfield>`.
In :ref:`connected mode <localized-content>`, while
`transOrigPointerField` always contains the uid of the default language
record, this field contains the uid of the record the translation was created
from.

For example, if a `tt_content` record in default language (English) with
uid 13 exists, this record is translated to French with uid 17, and the Danish
translation is later created based on the French translation, then the Danish
translation has uid 13 set as `l10n_parent` and 17 as `l10n_source`.


..  _core-support-tca-localization-command:

DataHandler commands for localization
=====================================

The :ref:`DataHandler <t3coreapi:datahandler-basics>` writes the changes
that the backend makes to records. Its
:ref:`"localize" command <t3coreapi:tce-command-keywords>` translates a record.
The backend sends this command when you translate an element in
:guilabel:`Content > Records` or :guilabel:`Content > Layout`.

When this command is issued an ordinary copy is made but the fields
:ref:`languageField <core-support-tca-languagefield>` and
:ref:`transOrigPointerField <core-support-tca-transorigpointerfield>` are
updated accordingly.

You can only localize a record which is not already localized and which is in
"default" or "All" language (a record in "All" language is supposed to be
somehow valid for any language, but can still be translated if needed).

It is possible to manually create two or more translations of the
same record but this is considered an error in the system, although
not fatal, yet producing unpredictable results.


..  _core-support-tca-localization-command-options:

Localization command options per field
--------------------------------------

Each field may contain special instructions which will affect the "localize"
command. Most important is the
:ref:`"l10n\_mode" field <t3tca:columns-properties-l10n-mode>` with which,
for example, a field can be entirely excluded from the translation process.
