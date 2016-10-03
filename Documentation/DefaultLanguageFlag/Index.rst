.. include:: ../Includes.txt


.. _default-language-flag:

The "default" language flag
^^^^^^^^^^^^^^^^^^^^^^^^^^^

As mentioned already, the default language is whatever you
decide it to be. In order to help editors, you can define
a label and a flag for the default language, using TSconfig
placed on the root page of your web site:

.. code-block:: typoscript

      mod.SHARED {
            defaultLanguageFlag = gb
            defaultLanguageLabel = English
      }


This setting is used in particular by the **WEB > Page** and the
**WEB > List** modules.

.. figure:: ../Images/DefaultLanguageFlag.png
   :alt: Default language flag

   The flag for the default language used in the Web > Page module
