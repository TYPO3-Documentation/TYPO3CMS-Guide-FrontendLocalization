.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


llXML (locallang-XML) in plugins and TypoScript
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


Using llXML labels in TypoScript structures
"""""""""""""""""""""""""""""""""""""""""""

llXML files are XML files containing labels that the system can fetch
in a localized version if a language pack is installed. If you want to
retrieve values from llXML files in TypoScript you can do it like
this::

   page.20 = TEXT
   page.20.data = LLL:EXT:indexed_search/pi/locallang.xml:submit_button_label

This looks for the label "submit\_button\_label" in the file
"pi/locallang.xml" from the extension "indexed\_search".

If the "config.language" value is set to "dk" and the Danish language
pack is installed in "typo3conf/l10n/dk/" the output should be "Søg"
(and not "Search" which is what you will get if the label is retrieved
from the default language).


Using llXML labels in frontend plugins
""""""""""""""""""""""""""""""""""""""

How to use llXML labels in your PHP code is not covered in this guide
(see "Inside TYPO3"), but properly made frontend plugins will use
llXML files with the plugins to generate translated labels for their
output.

For instance, if "config.language = dk" and the Danish language pack
is installed you will see this page for "indexed search":

|img-28| You can use TypoScript to override with custom values
(supported by most extensions made by kickstarter and using the piBase
API). Here is an example for how the search button label can be
overridden::

   plugin.tx_indexedsearch._LOCAL_LANG.dk.submit_button_label = SØØG!

This yields this output:

|img-29|

You must look into the file "indexed\_search/pi/locallang.xml" to know
that the label key was "submit\_button\_label" and of course "dk" is
the language key. The prefix "plugin.tx\_indexedsearch.\_LOCAL\_LANG"
is exposed using the TypoScript Object Browser:

|img-30|


Providing a translation to a frontend plugin for a language key not found in the system?
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""

There is an unfortunate binding between the system languages of TYPO3
(those you can select for the backend users) and the translations of
frontend extensions. As long as you are making a website in a language
supported in the backend you just install the language pack and you
are done. But what if we wanted to make a translation of the site to
"Marsian"?

Well, we can actually do that using the "\_LOCAL\_LANG" overriding
feature!

So a setup like this will translate the search button label to
"Marsian"::

   config.language = marsian

   plugin.tx_indexedsearch._LOCAL_LANG.marsian {
     submit_button_label = !"#€%&/(
   }
   |img-31|


