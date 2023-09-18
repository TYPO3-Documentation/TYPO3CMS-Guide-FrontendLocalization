..  include:: /Includes.rst.txt

..  _core-support-tca:

===============================
TCA, DataHandler and FormEngine
===============================

The support for localization in the Core of TYPO3 is based around a scheme where
a record in the default language (id "0") can have other records pointing to it,
offering a translation of its content. This implies some requirements for the
structure of any database tables which we want to be available for translation:

#.  A field holding the reference to the language defined in the
    :ref:`site configuration <t3coreapi:sitehandling>` must be defined.

#.  A field holding the reference to the default language record must be
    defined.

#.  Optionally, a field holding the reference to the record it was translated
    from can be defined.

These fields are declared in the :ref:`"[ctrl]" section <t3tca:ctrl>`
of the TCA for the table.

..  contents:: **Content**
    :local:


..  _core-support-tca-languagefield:

[languageField]
===============

The first field is defined by the
":ref:`languageField <t3tca:ctrl-reference-languagefield>`" property
and contains a reference to the language the record is in.

Here is how such a field is configured (example from the :sql:`tt_content`
table):

..  code-block:: php
    :caption: EXT:frontend/Configuration/TCA/tt_content.php

    'sys_language_uid' => [
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
        'config' => [
            'type' => 'language'
        ]
    ]

The entry for the :guilabel:`[All]` language gets automatically added with the
TCA type :ref:`language <t3tca:columns-language>`.

..  note::
    This field is traditionally named :sql:`"sys_language_uid`, but any name can
    be used since it is registered with the :php:`languageField` property in the
    ctrl section.

..  deprecated:: 11.2
    This field can only be used with the TCA type "language". All other field
    types will be automatically migrated on-the-fly possibly losing configurations.
    See :ref:`Migration to the language type <t3tca:columns-languge-migration>`.


..  _core-support-tca-transorigpointerfield:

[transOrigPointerField]
=======================

The first field is defined by the
":ref:`transOrigPointerField <t3tca:ctrl-reference-transorigpointerfield>`"
property and contains a reference to the record in the default language.

Here is how such a field is configured (example from the :sql:`tt_content`
table):

..  code-block:: php
    :caption: EXT:frontend/Configuration/TCA/tt_content.php

    'l10n_parent' => [
        'displayCond' => 'FIELD:sys_language_uid:>:0',
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['', 0]
            ],
            'foreign_table' => 'tt_content',
            'foreign_table_where' => 'AND {#tt_content}.{#pid}=###CURRENT_PID### AND {#tt_content}.{#sys_language_uid} IN (-1,0)',
            'default' => 0,
        ],
    ],


..  note::
    This field is traditionally named :sql:`l10n_parent`, but any name can be
    used since it is registered with the :php:`transOrigPointerField` property.

    The :sql:`l18n_parent` name used in table :sql:`tt_content` is a historical
    mistake.

Obviously, the table name has to be adapted in properties :sql:`foreign_table`
and :sql:`foreign_table_where` for each table.

Notice the display condition set on the field, which will check the value of
the :sql:`sys_language_uid` and display the :sql:`l18n_parent` field only when
it is greater than zero (that means, it is a translation).

Another interesting point is that it will only look for a default language
record in the current pid. This means that a
**default language record and all its translations must be on the same page!**
This principle is also respected by the API function
:php:`\TYPO3\CMS\Core\Domain\Repository\PageRepository::getLanguageOverlay()`
which fetches translations of records for the frontend display.

When the :php:`transOrigPointerField` and :php:`languageField` are defined for a
table you will see references to the content of the default language
record when editing the translation:

..  figure:: /Images/ManualScreenshots/Record/CoreSupportFormEngine.png
    :alt: Original content in the Form Engine
    :class: with-shadow

    Original content shows up under the input fields when translating a record

..  warning::
    The configured :php:`$GLOBALS['TCA'][$table]['ctrl']['transOrigPointerField']`
    cannot be excluded as this leads to inconsistent data stored in the database.
    This happens when a non-admin user creates a localization while not having
    the permission to edit the :php:`transOrigPointerField`. Remove
    :php:`exclude => true` from TCA, if set.


..  _core-support-tca-transorigdiffsourcefield:

[transOrigDiffSourceField]
==========================

There is one more field which can be used on a translatable table, defined by
the property ":ref:`languageField <t3tca:ctrl-reference-transorigdiffsourcefield>`".
It is optional. It points to a blob database field which will store the content
of the default language record as it was when the translation was made. Then
this is used to display any changes that have occurred in the default record
since translation happened. For example, in the :sql:`tt_content` table, it may
look like this for the header field:

..  figure:: /Images/ManualScreenshots/Record/CoreSupportFormEngineViewDifference.png
    :alt: Changes in original content
    :class: with-shadow

    Changes in the original content are highlighted below the input field

This allows a translator to spot easily what has changed in order to adjust the
translation accordingly.


..  _core-support-tca-translationSource:

[translationSource]
===================

The ":ref:`translationSource <t3tca:ctrl-reference-translationsource>`" property
defines a name of the field used by translations to point back to the original
record (that means, the record in any language of which they are a translation).
This property is often set to :sql:`l10n_source` in Core tables.

This property is similar to
:ref:`transOrigPointerField <core-support-tca-transorigpointerfield>`.
In :ref:`connected mode <localized-content>`, while :php:`transOrigPointerField`
always contains the uid of the default language record, this field contains the
uid of the record the translation was created from.

For example, if a :sql:`tt_content` record in default language (English) with
uid 13 exists, this record is translated to French with uid 17, and the Danish
translation is later created based on the French translation, then the Danish
translation has uid 13 set as :sql:`l10n_parent` and 17 as :sql:`l10n_source`.


..  _core-support-tca-localization-command:

DataHandler commands for localization
=====================================

Localizing a record can be done by the
:ref:`"localize" command <t3coreapi:tce-command-keywords>` of the
:ref:`DataHandler <datahandler-basics>`. This is the command that is sent
when you press the translate buttons in :guilabel:`Web > List` or
:guilabel:`Web > Page` for an element.

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

