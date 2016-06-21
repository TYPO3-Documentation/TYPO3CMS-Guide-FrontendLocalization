.. include:: ../../Includes.txt


realurl
^^^^^^^

Realurl produces URLs which are human-readable. Eg.
"mysite.com/products/" or "mysite.com/dk/products/".

If you wish realurl to encode the &L variable nicely into the URL,
here is a configuration which will work for you::

      1: $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['realurl'] = array(
      2:     '_DEFAULT' => array(
      3:         'preVars' => array(
      4:             array(
      5:                 'GETvar' => 'L',
      6:                 'valueMap' => array(
      7:                     'danish' => 1,
      8:                     'dk' => 1,
      9:                     'ru' => 2,
     10:                 ),
     11:                 'noMatch' => 'bypass'
     12:             )
     13:         ),
     14:         'pagePath' => array(
     15:             'spaceCharacter' => '-',
     16:         ),
     17:     )
     18: );

The important part is the lines 4-12 where the GET variable "L" is
mapped to string values. As you can see a string value of "dk" or "ru"
will be translated to a value for L variable which is 1 and 2 respectively.
Also, you can see that an alternative value for "dk" can be used,
namely "danish".

The "noMatch" setting defines that if neither "dk", "ru" or "danish"
is found as the first segment of the URL path, then the path is
forwarded to decoding for the page id and other variables.

An interesting effect is that if you create a page which is called
"Danish" in the page tree you will never be able to access it in the
default language! The reason is that if you access the page "/danish/"
then "danish" is mapped to "&L=1" and nothing is left for page
decoding!

This table shows the mapping of "L" with realurl

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Without realurl
         index.php?id=22&L=0

   With realurl
         products/


.. container:: table-row

   Without realurl
         index.php?id=22&L=1

   With realurl
         dk/products/


.. container:: table-row

   Without realurl
         index.php?id=22&L=2

   With realurl
         ru/products/


.. ###### END~OF~TABLE ######

Notice, that when a new language is added to the website you will have
to update the realurl configuration!

