.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


Localized TemplaVoilà Template Objects
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

|img-73| TemplaVoilà offers to select an alternative Template Object
(TO) when the language is changed. What you do is to create an TO as a
“Sub-template” of the main TO:

Of course you must select the correct language and then provide a
mapping for this TO as well.

In the Web > TemplaVoilà module you see the sub template displayed
indented with the parent TO:

|img-74|

The localized template is selected based on the value of
TSFE->sys\_language\_uid

