.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


Defining the "default" language flag
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you want to specify the name of the default language and a flag
icon you can do so for a branch of the page tree by setting this Page
TSconfig for the root page of your website:

If you want to specify the name of the default language and a flag
icon you can do so for a branch of the page tree by setting this Page
TSconfig for the root page of your website.

TSConfig:

.. code-block:: typoscript

      mod.SHARED {
        defaultLanguageFlag = gb.gif

        defaultLanguageLabel = English
      }


|img-6|

This setting is for example used by the Web>Page module, Web>List and
TemplaVoilà Page module.

