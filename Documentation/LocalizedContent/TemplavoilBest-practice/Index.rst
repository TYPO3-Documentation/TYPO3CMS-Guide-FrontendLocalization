.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


TemplaVoilà: Best-practice
^^^^^^^^^^^^^^^^^^^^^^^^^^

This table shows various best-practice recommendations for localized
websites when using TemplaVoilà. The assumption is that the "Bound"
paradigm is used.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   Topic
         Topic

   Recommendation
         Recommendation


.. container:: table-row

   Topic
         TypoScript Template Configuration

   Recommendation
         A typical, generic TypoScript configuration for setting up support for
         one additional language (here "dk") looks like this::

            # Localization:
            config {
              linkVars = L
              sys_language_mode = content_fallback
              sys_language_overlay = hideNonTranslated
            }

            [globalVar = GP:L=1]
            config {
              sys_language_uid = 1
              language = dk
              locale_all = da_DK
            }
            [global]

         Setting "sys\_language\_overlay" to at least "1" is mandatory for the
         "Bound" paradigm and TemplaVoilà (only column based websites and the
         "Free" paradigm can do without) and most likely you would like to set
         the more strict "hideNonTranslated" keyword which requires a record to
         have a translation before it can be displayed.


.. container:: table-row

   Topic
         Page Data Structure localization mode

   Recommendation
         Create a page template using TemplaVoilà's wizard. Modify the Data
         Structure XML so localization is "Disabled". In rare cases you might
         like the ability to localize some pages with entirely different
         structures of content elements in which case "Inheritance" is a good
         option.

         Stay clear of "Separate" mode.


.. container:: table-row

   Topic
         FCE Data Structures localization mode

   Recommendation
         For Flexible Content Elements you should localize them according to
         their characteristics:

         - Pure container elements: Use "Disabled" localization mode (least
           complex)

         - Pure hierarchical content: Use "Inheritance" localization mode (least
           complex, most features)

         - Mixed containers and content: Use "Inheritance" localization (least
           complex)

         Stay clear of "Separate" mode.

         *Always use the "[All]" language for a Flexible Content Element! See
         below.*


.. container:: table-row

   Topic
         "[All]" language?

   Recommendation
         If "sys\_language\_overlay" is set to "hideNonTranslated" it becomes
         very important that all "multilanguagerecords" like all Flexible
         Content Elements is set to "[All]" - otherwise they will not be
         selected in translations.

         Generally these content element types should use the "[All]" language:

         - "Insert Plugins"

         - "Insert Records" (and make relations to default language records!)

         - "Flexible Content Elements" (internally localized in FlexForm)

         The "[All]" langauge is set in the "languageField" of the record, for
         Content Elements:

         |img-92|

         This will be clearly reflected in the Page module of TemplaVoilà:

         |img-93|


.. ###### END~OF~TABLE ######

