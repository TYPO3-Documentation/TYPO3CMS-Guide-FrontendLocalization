.. include:: Images.txt

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


TemplaVoilà: Translator workflow
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

When you are limited users to languages you effectively define
translator roles. This can have a few pleasant effects in terms of
simplified interfaces in TYPO3. One is the use of display conditions
in FlexForms, “HIDE\_L10N\_SIBLINGS” (see elsewhere).

Another is that TemplaVoilà's Page module will scale down its buttons
when a user  *does not* have access to the default language (thus
assumed to be a translator). It works out of the box:


((generated))
"""""""""""""

Translators (with access to only alternative languages):
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Notice how all buttons has been stripped away. There are not even
context menu links on item icons and no texts are clickable.
Translators simply doesn't need any of this; all they need is links to
translate the content.

|img-94|


Users with access to default language:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This is the normal view of the Page module for TemplaVoilà. Here you
see all the additional buttons.

|img-95|

The concept of the scaled down view for translators is to provide a
very simply rule for them: “Click the flag!”. All flags either leads
to localization of a record or to editing of an existing translation.
No confusion possible.

|img-96|

Another feature is that the view page icon will send the &L parameter
according to language selected:

|img-97|

Having Danish selected will automatically add “&L=xx” to the preview
URL:

|img-98|

