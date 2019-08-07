.. include:: ../Includes.txt


.. _localization-modes:

Localization modes
^^^^^^^^^^^^^^^^^^

The localization mode defines how the system behaves if there is no
translation of a page to the language requested (ie. there is no
Alternative Page Language record). Would you like a
"Page not found" error to happen? Or should the default language be shown? Or
should another of the available languages be tried first? And if so,
would you like the menu to stay in the selected language? These are
the preferences you can obtain using this setting.


.. _localization-modes-combinations:

Overview of combinations
""""""""""""""""""""""""

Localization mode is defined by the TypoScript configuration
:code:`config.sys_language_mode`.

The table below provides an overview of the combinations of language
modes (:code:`config.sys_language_mode`) and the language uid
(:code:`config.sys_language_uid`, which is essentially defined by the input
"&L=" variable in a typical set-up).

- The first two columns display the configured values

- The next two columns display the value of internal variables in TYPO3 CMS

- The last columns describes the behavior of the page rendering process

- The settings are based on a page where:

  - none of the :ref:`Localization Setting checkboxes <localization-overview>`
    are set (meaning that neither default language, nor non-existing alternative languages are
    blocked)

  - There is a German translation but no Danish translation.

.. note::

   The behavior for the default language (English) and the existing translation
   (German) is not interesting: when they are requested, they will be shown
   because they exist. They are still shown in the table below as a comparison
   to what happens for the non existing translation (Danish).

This is the corresponding Localization overview for the example
being discussed:

.. figure:: ../Images/LocalizationModesOverview.png
   :alt: Localization overview for the home page

   The home page, translated to German but not to Danish


========================== ==================================== ======================== ============================ ==============================================================================
config.sys\_language\_mode config.sys\_language\_uid(set by &L) TSFE->sys\_language\_uid TSFE->sys\_language\_content Result
========================== ==================================== ======================== ============================ ==============================================================================
*(undefined)*              *(undefined)*                        0                        0                            Content in English, menu in English

\                          1                                    1                        1                            Content in German, menu in German

\                          2                                    0                        0                            All site content behaves like for the default language,
                                                                                                                      except that "&L=2" is passed on in links and any settings made with
                                                                                                                      TypoScript conditions selecting on "GP:L" takes effect.

                                                                                                                      Content in English, menu in English

**content_fallback**       *(undefined)*                        0                        0                            Content in English, menu in English

\                          1                                    1                        1                            Content in German, menu in German

\                          2                                    2                        0                            Content is displayed in the default language while menus are displayed
                                                                                                                      in Danish (wherever available). This mode lets the user "stay" in the selected
                                                                                                                      language, even when visiting pages that has no translated content and
                                                                                                                      falls back to default language.

                                                                                                                      Content in English, menu in Danish

**content_fallback; 1,0**  *(undefined)*                        0                        0                            Content in English, menu in English

\                          1                                    1                        1                            Content in German, menu in German

\                          2                                    2                        0                            Like the setting :code:`content_fallback` but the added "1,0" setting
                                                                                                                      means that the content display first looks for content in the "1"
                                                                                                                      language (i.e. German) and shows that if available. If not, it falls back
                                                                                                                      on the "0" language (default, i.e. English).

                                                                                                                      Content in German (falling back on English), menu in Danish

**strict**                 *(undefined)*                        0                        0                            Content in English, menu in English

\                          1                                    1                        1                            Content in German, menu in German

\                          2                                    \-                       \-                           Error message ("Page is not available in the requested language (strict)"

**ignore**                 *(undefined)*                        0                        0                            Content in English, menu in English

\                          1                                    1                        1                            Content in German, menu in German

\                          2                                    2                        2                            Does not consider if there is an Alternative Page record or not
                                                                                                                      for the language, just sets the value.

                                                                                                                      Content in Danish (falling back on English), menu in Danish
========================== ==================================== ======================== ============================ ==============================================================================


.. _localization-modes-notes:

A few additional technical notes
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

- Regardless of localization mode the "&L=" variable is always passed on
  in links (due to "config.linkVars")

- Any TypoScript conditions (for example "[globalVar = GP:L=1]") are
  still effective so any settings there are kept regardless of
  localization mode

- When saying "a translation exists" it is meant that an "Alternative
  Page Language" record exists (green background in Localization
  Overview in **WEB > Info**). This, however, does not refer to whether or not
  content elements are localized for the page yet. However, it is
  generally assumed that if an Alternative Page Language record has been
  created, so has content been translated.

- The internal values :code:`$GLOBALS['TSFE']->sys_language_uid` and
  :code:`$GLOBALS['TSFE']->sys_language_content` have different purposes:

  - :code:`$GLOBALS['TSFE']->sys_language_uid` defines the *overall language* that content
    should be displayed in. This affects menu generation, etc.

  - :code:`$GLOBALS['TSFE']->sys_language_content` defines the language of the *page
    content* and may be different. This is what makes it
    possible to request content from another language than that of
    :code:`$GLOBALS['TSFE']->sys_language_uid`

- If the "Localization Setting" of the page is set to "Hide default
  translation of page" then it will fail when used with
  "content\_fallback" and if "content\_fallback" tries to get content from
  the default language.

Content Fallback to Non-Default Language
""""""""""""""""""""""""""""""""""""""""
By setting: code:`config.sys_language_mode=content_fallback; 2,0` the language with uid 2 (Danish) will be used as Content Fallback for all non-default languages like German and Chinese. Only if the content is not available in Danish it will be displayed in the default language, English.

If the original page, was not translated into into the desired language, I.E. German, there are two possibilities:

If the page-option "Show page even if no translation exists" was set, the page will be shown with the content fallback in Danish as described above. However information corresponding to the page itself i.e. pagetitle, meta tags, .. will be in the default language, English. The page will also be displayed in the menu as with its default English title and not its Danish title.

If the page-option "Show page even if no translation exists" was *not* set an errror "Page is not available in the requested language". Will be displayed. Nevertheless the page will be displayed in the menu with it's default language (English) title.

Until TYPO3 LTS 8 in order to translate page information and page titles in menus it was necessary to employ a patch, see  `Forge Issue 17354 <https://forge.typo3.org/issues/17354>`__

With the page by setting code:`config.languageFallbackChain =2,0`it was possible to display the page in menus in the Fallback Language Danish.

Starting with LTS 9 the feature has been included into core: `TYPO3 9.5.x Changelog <https://docs.typo3.org/c/typo3/cms-core/master/en-us/Changelog/9.5.x/Feature-86762-EnhancedFallbackModesForTranslatedContent.html>`__


.. _localization-modes-best-practice:

Best-practice localization mode
"""""""""""""""""""""""""""""""

It is recommended to use:

.. code-block:: typoscript

   config.sys_language_mode = content_fallback

This is so, because the compatibility with other localization
functions are greatest in this case since the
:code:`$GLOBALS['TSFE']->sys_language_uid` value is set to that of the requested
language.

