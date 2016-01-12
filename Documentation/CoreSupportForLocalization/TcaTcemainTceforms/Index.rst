.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


TCA, TCEmain, TCEforms
^^^^^^^^^^^^^^^^^^^^^^

The support for localization in the core of TYPO3 is based around a
scheme where a record in the default language (0) can have other
records pointing to it, offering a translation of its content. This
sets up some requirements to the table of such records:

#. A field holding the reference to the system language (sys\_language
   table) must be defined.

#. A field holding the reference to the default language record must be
   defined

Both these fields are defined in TCAs [ctrl] section for a table.


[languageField]
"""""""""""""""

The first field (referring to the language of the record) is defined
by [languageField]. The value of this field is also used to control
access to localized content (see later)

The [columns] configuration of this field can look like this::

   'sys_language_uid' => Array (
       'exclude' => 1,
       'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
       'config' => Array (
           'type' => 'select',
           'foreign_table' => 'sys_language',
           'foreign_table_where' => 'ORDER BY sys_language.title',
           'items' => Array(
               Array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
               Array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
           )
       )
   ),

Notice how it includes two static items for "Default" and "[All]"
languages.


[transOrigPointerField]
"""""""""""""""""""""""

The second field (referring to the default language record) is defined
by [transOrigPointerField].

The configuration of this field could look like this::

   'l18n_parent' => Array (
       'displayCond' => 'FIELD:sys_language_uid:>:0',
       'exclude' => 1,
       'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
       'config' => Array (
           'type' => 'select',
           'items' => Array (
               Array('', 0),
           ),
           'foreign_table' => 'tt_content',
           'foreign_table_where' => 'AND tt_content.pid=###CURRENT_PID### AND tt_content.sys_language_uid IN (-1,0)',
       )
   ),

The example is from the "tt\_content" table and the "foreign\_table"
settings should be adjusted accordingly when using other tables of
course!

Notice how there is a display condition set on the field which will
look what the value of the sys\_language\_uid field is and only when
that is larger than zero (a language is defined for the record) will
this field be shown.

Another interesting point is that it will only look for a default
language record in the current pid. This means that a  **default
language record an all its translations must be on the same page!**
Thisprinciple is also respected by the API function
t3lib\_page::getRecordOverlay() which fetches translations of records
for the frontend display (when "config.sys\_language\_overlay = 1 /
hideNonTranslated")!

When the "transOrigPointerField" and "languageField" are defined for a
table you will have a nice view of the default content shown along
with the translation in the TCEforms:

|img-99|


Optional fields
"""""""""""""""

There are some optional fields to include when using the localization
support. One is [transOrigDiffSourceField]. This can point to a blob
field in the record which will store the content of the default
langauge record as it was when the translation was made. This is then
used to display any changes that has occured in the default record
since translation happened. In the "Content Elements" (tt\_content
table) it looks like this:

|img-100|

This allows a translator to easily spot what has changed and he can
adjust his translation accordingly.


TCEmain commands for localization
"""""""""""""""""""""""""""""""""

Localizing a record can be done by the command "localize" sent in the
cmd-array to TCEmain. This is documented in "TYPO3 Core API". This is
the command sent when you press the localize button in Web>List or
Web>Page for an element.

When this command is issued what happens is that an ordinary copy is
made but the fields "languageField" and "transOrigPointerField" are
updated accordingly.

You can only localize a record which is not already localized and
which is in "default" or "[All]" language modes.

The "[All]" mode is meant for elements which represent universal
content that does not need localization (like the insertion of a
plugin or other records). However they  *can* optionally be translated
if a special case is needed.

It is possible to manually create two or more localizations of the
same record but this is considered an error in the system, although
not fatal, yet producing unpredictable results.


Localization command options per field
""""""""""""""""""""""""""""""""""""""

When a localization command is executed from TCEmain the configuration
of each field can contain special instructions. For instance; You can
have a label prefixed a field (like you see "[Translate to Danish:]"
in some screenshots) or you can have the copying of fields disabled
all together (like an image field where you wish to inherit the
default value by default).

This is done by the [columns][l10n\_mode] setting, documented in
"TYPO3 Core API".



