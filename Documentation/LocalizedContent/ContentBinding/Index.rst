.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


Content binding
^^^^^^^^^^^^^^^

When working with the classic column based content delivery in TYPO3
(Web>Page module) you have the choice of two different localization
approaches:

- **No binding:** Each language can have varying number of content
  elements in their own order and possibly without a relation to any
  default language element.

- **Binding to default language:** All translations follow the elements
  of the default language 1-1

The modes are described visually here:


No binding
""""""""""

This is the default situation. No additional configuration of the
backend or frontend is needed.

The Web>Page module has a view like this:

|img-34|

As you can see, there are three Danish elements and only two default
elements.

The translations all have the language setting set to Danish (seen by
the Danish flag) but may or may not have a relation to "Transl. Orig":

|img-35|

If there is a "Transl.Orig" value it will be used to display what the
default language content is (useful for translators):

|img-36|

The website displays the content like this:


|img-37|


Binding
"""""""

Binding translations to follow the default language translations
requires a configuration of both frontend and backend:

- **Web>Page:** The page module must know that a translation must be
  bound 1-1 to the default translation. This is configured by setting
  **"mod.web\_layout.defLangBinding = 1" in Page TSconfig.**

- **TypoScript:** You must ask the frontend rendering to select content
  from the default language and look for overlay records from the
  translation. This is configured with  **"config.sys\_language\_overlay
  = 1" in the TypoScript Template.**

In the Web>Page module this is reflected like this:

|img-38|

Notice how the elements in the "Danish" column is aligned in rows
bound to each element in the Default column. For the element in the
middle there turn out to be no Danish translation at all.

The binding from the Danish element to the Default element is done
with the "Transl. Orig" field which plays a crucial role now.

You can also notice that for each default element a localization
button "Copy default content elements" will prepare a record ready for
Danish translation.

In the frontend the result looks like this:

|img-39|

You see to the right how the top and button element is displayed in
the Danish translation while the middle element is displayed in the
default original since no translation exists.

Conclusion is: With content binding it is the default elements which
decide over the element order and appearance on the page.


Overlay modes
"""""""""""""

When using the overlay mode you can choose a few variants::

   config.sys_language_overlay = hideNonTranslated

This will change the output to this:

|img-40|

As you can see, the element that was not translated is simply not
displayed in the default language.

Another one is this setting::

   config.sys_language_softMergeIfNotBlank = tt_content:image, tt_content:header

This setting will look if the "image" and "header" fields of
translations are blank and if that is the case the value of the
default language record is allowed to be used.

Since the translation of the lower element has no images entered, the
image field is blank and the images from the default element is used
instead:

|img-41|

So with this setting you can inherit values from the original record
(default language) by leaving a field blank - or provide a translation
(like for the "header" field which had a value in the translation:
"[Translate to Danish:] Nullam fermentum...").

**Notice:** If the "l10n\_mode" for columns in TCA is set to "exclude"
or "mergeIfNotBlank", inheritance of values from default records is
already happening. But since you might like to enable this on a per-
site basis, "config.sys\_language\_softmergeIfNotBlank" has been
provided to add the "mergeIfNotBlank" setting to additional fields
from the template record.

If you are designing a database table for localization you should look
closer at the "l10n\_mode" setting from TCA. You should also consider
that when using the core localization features, references between
records should ideally be between the default language records and
never to the translations themselves; translations should be selected
and overlaid default language records during rendering (assuming
"config.sys\_language\_overlay" is set). Inheritance of field values
from the original record will also happen only when a translation is
shown through selecting its default language original and applying the
translation over it.


Elements with language "[All]"
""""""""""""""""""""""""""""""

When using language binding combined with
"config.sys\_language\_overlay = hideNonTranslated" there is a special
significance of the language value "[All]" (technically the -1 value):
These elements will  *not* be hidden in the translation - and they are
not meant to be translated although you can choose to do so.

The setting looks like this:

|img-42|

It is reflected in the Web>Page module like this (notice the flag):

|img-43|

Typical applications of the "[All]" language is for "Insert Record",
"Plugin" elements (placeholders for something else).


Notes
"""""

- " **Hide default translation of the page" incompatible with content
  binding:** When using the "Binding" method (ie.
  "config.sys\_language\_overlay = 1 / hideNonTranslated") you must
  supply placeholder records in the default language if you use the
  "Localization setting" for pages "Hide default translation of the
  page".

- **Support for content binding:** The TypoScript cObjects CONTENT and
  RECORD both supports the "sys\_language\_overlay" setting by selecting
  default language elements and overlaying according to the setting.
  This should be observed anywhere else content is selected (like in
  extension plugins). Technically, the function
  $GLOBALS['TSFE']->sys\_page->getRecordOverlay() does this, but before
  using it, please look at how it has been used inside a class like
  "class.tslib\_content.php" from the "cms" extension (tslib/)

- " **Search" content elements:** "Search" content elements should be
  thought carefully about since they should search in the chosen
  language. The search query executed with the "SEARCHRESULT" cObject
  takes "sys\_language\_uid" into the query. Therefore the best is to
  create a search form element for each language (that is; do not
  inherit it). Alternatively let the search form reside on a page which
  is not translated at all (provided that "content\_fallback" is used!)

