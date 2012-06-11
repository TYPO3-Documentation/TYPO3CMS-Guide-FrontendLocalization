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


Localization mode: “config.sys\_language\_mode”
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The localization mode defines how the system behaves  *if there is no
translation of a page to the language requested (ie. there is no
Alternative Page Language record)* . For instance: Would you like a
“page not found” error? Or should the default language be shown? Or
should another of the available languages be tried first? And if so,
would you like the menu to stay in the selected language? These are
the preferences you can obtain using this setting.


Overview of combinations
""""""""""""""""""""""""

Localization mode is defined by the TypoScript configuration
“config.sys\_language\_mode”.

The table below provides an overview of the combinations of language
modes (config.sys\_language\_mode) and the language uid
(config.sys\_language\_uid, which is essentially defined by the input
“&L=” variable in a typical set-up).

- The first two columns displays the configured values (blue)

- The last three columns display the value of internal variables in
  TYPO3 plus a description of the behavior

- The settings are based on a page where:

- none of the “Localization Setting” checkboxes is set (meaning that
  neither default language, nor non-existing alternative languages are
  blocked)

- There is a Danish translation (Alternative Page Record) but no Russian
  translation.

- The default behavior of default language (English) and Danish
  translation is of course to show the translation and hence they are
  not interesting. These scenarios are included in the table but grayed
  out since they are the  *same* for each combination of
  “sys\_language\_mode”. The interesting rows are those where the
  Russian language is requested.

This is how the localization overview is set for the page tested:

|img-27|

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   config.sys\_language\_mode
         config.
         
         
         sys\_
         
         
         language\_
         
         
         mode
   
   config.sys\_language\_uid(set by &L)
         config.
         
         
         sys\_
         
         
         language
         
         
         \_uid
         
         
         (set by &L)
   
   TSFE->sys\_language\_uid
         TSFE->
         
         
         sys\_
         
         
         language
         
         
         \_uid
   
   TSFE->sys\_language\_content
         TSFE->
         
         
         sys\_
         
         
         language
         
         
         \_content
   
   Result
         Result


.. container:: table-row

   config.sys\_language\_mode
         **[blank]**
   
   config.sys\_language\_uid(set by &L)
   
   
   TSFE->sys\_language\_uid
         0
   
   TSFE->sys\_language\_content
         0
   
   Result
         - Content: English
         
         - Menu: English


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         1
   
   TSFE->sys\_language\_uid
         1
   
   TSFE->sys\_language\_content
         1
   
   Result
         - Content: Danish
         
         - Menu: Danish


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         2
   
   TSFE->sys\_language\_uid
         0
   
   TSFE->sys\_language\_content
         0
   
   Result
         Behaviour: All site content behaves like for the default language
         except “&L=2” is passed on in links and any settings made with
         TypoScript conditions selecting on “GP:L” will take effect.
         
         - Content: English
         
         - Menu: English
         
         - Warning: “Localization Settings” for pages are not observed correctly!
           See more info where “Localization Settings” are discussed (eg. “Hide
           page if no translation exists”)


.. container:: table-row

   config.sys\_language\_mode
         **content\_fallback**
   
   config.sys\_language\_uid(set by &L)
   
   
   TSFE->sys\_language\_uid
         0
   
   TSFE->sys\_language\_content
         0
   
   Result
         - Content: English
         
         - Menu: English


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         1
   
   TSFE->sys\_language\_uid
         1
   
   TSFE->sys\_language\_content
         1
   
   Result
         - Content: Danish
         
         - Menu: Danish


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         2
   
   TSFE->sys\_language\_uid
         2
   
   TSFE->sys\_language\_content
         0
   
   Result
         Behavior: Content displayed in default language while menus are
         rendered in Russian. This mode lets the user “stay” in the selected
         language, even when visiting pages that has no translated content and
         falls back to default content.
         
         - Content: English
         
         - Menu: Russian


.. container:: table-row

   config.sys\_language\_mode
         **content\_fallback : 1,0**
   
   config.sys\_language\_uid(set by &L)
   
   
   TSFE->sys\_language\_uid
         0
   
   TSFE->sys\_language\_content
         0
   
   Result
         - Content: English
         
         - Menu: English


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         1
   
   TSFE->sys\_language\_uid
         1
   
   TSFE->sys\_language\_content
         1
   
   Result
         - Content: Danish
         
         - Menu: Danish


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         2
   
   TSFE->sys\_language\_uid
         2
   
   TSFE->sys\_language\_content
         1
   
   Result
         Behavior: Like the setting “content\_fallback” but the added values
         “1,0” means that the content displays first looks for content in the
         language “1” (in this case Danish) and shows that if available,
         otherwise looks for content in language “0”.
         
         Of course it makes no sense to display Danish instead of Russian, but
         in cases like Portuguese/Brazil Portuguese it might make sense to
         define such a second priority language.
         
         - Content: Danish
         
         - Menu: Russian


.. container:: table-row

   config.sys\_language\_mode
         **strict**
   
   config.sys\_language\_uid(set by &L)
   
   
   TSFE->sys\_language\_uid
         0
   
   TSFE->sys\_language\_content
         0
   
   Result
         - Content: English
         
         - Menu: English


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         1
   
   TSFE->sys\_language\_uid
         1
   
   TSFE->sys\_language\_content
         1
   
   Result
         - Content: Danish
         
         - Menu: Danish


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         2
   
   TSFE->sys\_language\_uid
         -
   
   TSFE->sys\_language\_content
         -
   
   Result
         Error message: “Page is not available in the requested language
         (strict).”


.. container:: table-row

   config.sys\_language\_mode
         **ignore**
   
   config.sys\_language\_uid(set by &L)
   
   
   TSFE->sys\_language\_uid
         0
   
   TSFE->sys\_language\_content
         0
   
   Result
         - Content: English
         
         - Menu: English


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         1
   
   TSFE->sys\_language\_uid
         1
   
   TSFE->sys\_language\_content
         1
   
   Result
         - Content: Danish
         
         - Menu: Danish


.. container:: table-row

   config.sys\_language\_mode
   
   
   config.sys\_language\_uid(set by &L)
         2
   
   TSFE->sys\_language\_uid
         2
   
   TSFE->sys\_language\_content
         2
   
   Result
         Behavior: Doesn't consider if there is an Alternative Page Record or
         not for the language, just sets the value.
         
         - Content: Russian (nothing shown of course)
         
         - Menu: Russian


.. ###### END~OF~TABLE ######


A few additional technical notes:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

- Regardless of localization mode the “&L=” variable is always passed on
  in links (due to “config.linkVars”)

- Any TypoScript conditions (for example “[globalVar = GP:L=1]”) are
  still effective so any settings there are kept regardless of
  localization mode

- When saying “a translation exists” it is meant that an “Alternative
  Page Language” record exists (green background in Localization
  Overview in Web>Info). This, however, does not refer to whether or not
  content elements are localized for the page yet. However, it is
  generally assumed that if an Alternative Page Language record has been
  created, so has translated content.

- Generally, the internal values TSFE->sys\_language\_uid and
  TSFE->sys\_language\_content maintains different functions:

- TSFE->sys\_language\_uid defines the  *overall language* that content
  should be displayed in. This affects templates in TemplaVoilà, menu
  generations etc.

- TSFE->sys\_language\_content defines the language of the  *page
  content* and may be different, especially this is what makes it
  possible to request content from another language than that of
  TSFE->sys\_language\_uid

- If the “Localization Setting” of the page is set to “Hide default
  translation of page” then it will fail when used with
  content\_fallback and if content\_fallback tries to get content from
  the default language.


Best-practice localization mode
"""""""""""""""""""""""""""""""

It is recommended to use

::

   config.sys_language_mode = content_fallback

This is so, because the compatibility with other localization
functions are greatest in this case since the
“TSFE->sys\_language\_uid” value is set to that of the requested
language.

