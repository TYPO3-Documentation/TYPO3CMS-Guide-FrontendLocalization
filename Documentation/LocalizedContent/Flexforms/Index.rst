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


FlexForms
^^^^^^^^^

FlexForms has the interesting capability of being able to store
localizations internally in its XML. Whether this is enabled or not
depends on the <meta>-tags in the Data Structure. But a prerequisite
is that an ISO-code has been associated with the system languages:

|img-44|

(This requires “static\_info\_tables”).

Where localized content in TYPO3 identifies its language by a uid-
value (the content of [languageField]) pointing to a “Website
Language” record, flexforms use the universal ISO-code which is a
newer and better architecture of course.

In the following the FlexForm localization modes are described. They
apply universally to FlexForms but to illustrate the usage they are
described in the context of a TemplaVoilà based website and in
relation to “Flexible Content Elements”. This is far the most typical
application of FlexForm fields carrying localized content. Other
applications are for Plugin configuration but in this case you will
most likely disable localization all together.


FlexForm Localization modes
"""""""""""""""""""""""""""

There are three localization modes possible for FlexForm content:

- **Disabled:** No inline localization of the element.

- **Inheritance:** Each default value in the FlexForm can be translated
  1-1. Thus the translation closely follows the default language. This
  also allows for inheritance of default language values (like link
  values or images)

- **Separate:** Each localization of the element can have a separate
  structure. This is only relevant if the flexform element provides deep
  structures like link lists which must be different in each language.

These modes are configured by the <meta> tag in the Data Structure.

As soon as you have begun using a Data Structure you cannot switch
between Inheritance and Separate (<langChildren> = 1/0) without
loosing localized content. However default content is never lost.
(There might exist tools to make this conversion for you).


Overview
""""""""

This overview shows the possible localization modes for a FlexForm
field.

Where a FlexForm field is used to store references to content elements
- called “container elements” - additional consideration especially
related to TemplaVoilà applies. For a discussion of this, please refer
to subsequent chapters.

.. ### BEGIN~OF~TABLE ###

.. container:: table-row

   a
   
   
   Disabled
         Disabled
   
   Inheritance
         Inheritance
   
   Separate
         Separate


.. container:: table-row

   a
         **Description:**
   
   Disabled
         No inline localization of the element.
   
   Inheritance
         Each default value in the FlexForm can be translated 1-1. The
         translations follows the default language.
   
   Separate
         Each localization of the element can have a separate, independent
         structure. Translation has no technical relation to default language.


.. container:: table-row

   a
         **Usage:**
   
   Disabled
         **Universal:** For all languages
   
   Inheritance
         **Translation:** Default content is faithfully translated 1-1 in each
         language.
   
   Separate
         **Localization:** Content in other languages can divert from the
         structure of the default language


.. container:: table-row

   a
         **Record language**
         
         **(“languageField” value)**
   
   Disabled
         Use: [All] language
         
         Alternatively you can of course localize the record with the core
         supported localization like any other record.
   
   Inheritance
         Use: [All] language
   
   Separate
         Use: [All] language


.. container:: table-row

   a
         **Data Structure configuration:**
   
   Disabled
         <meta>
         
         <langDisable>1</langDisable>
         
         </meta>
         
         *Notice:* <langChildren> is insignificant in this case.
   
   Inheritance
         <meta>
         
         <langChildren>1</langChildren>
         
         <langDisable>0</langDisable>
         
         </meta>
   
   Separate
         <meta>
         
         <langChildren>0</langChildren>
         
         <langDisable>0</langDisable>
         
         </meta>


.. container:: table-row

   a
         **Inheriting default content:**
   
   Disabled
         Not Applicable
   
   Inheritance
         Default content is inherited if there is no translated content
         (“blank” string or zero).
         
         Configurations apply, see later
   
   Separate
         Not possible since there is no technical relation between localized
         content.


.. container:: table-row

   a
         **Recommended usage:**
   
   Disabled
         Use this type for FlexForm fields working as “container elements”
         providing structures for other content elements. In such cases it is
         unlikely that you want localization of the content element
         references(\*).
         
         Could also be Plugin configuration (also independent of language)
         
         **Recommended for container elements!**
   
   Inheritance
         Recommended typesince most websites only need a 1-1 translation of
         content. In cases where certain elements should be ignored in the
         translation there are ways to work around that.
         
         **Recommended for content!**
   
   Separate
         Could be considered for Data Structures with substructures of
         sections/arrays (like the link list below) but for any Data Structure
         with only a single level you should avoid this type since its less
         flexible.
         
         **Avoid, unless expert**


.. container:: table-row

   a
         **Warnings:**
   
   Disabled
   
   
   Inheritance
         - Be careful if using them as “container elements”
   
   Separate
         - Never use as “container element”


.. container:: table-row

   a
         **Special notice related to “Free” paradigm (see later) and container
         elements**
   
   Disabled
         In the “Free” paradigm, “Disabled” usually indicates that no
         localization is intended for a container element. This is opposite to
         the “Bound” paradigm where “Disabled” is the recommended mode.
         
         The reason is that the “Free” paradigm doesn't expect localization
         overlays of default language records but rather base itself on
         building separate structures of localized elements, hence needing
         either “Inheritance” or “Separate” modes. However, there are some
         flaws which makes that paradigm problematic. Please refer to
         discussion later.
   
   Inheritance
         In the “Free” paradigm, this mode is recommended since a separate
         structure of content elements is built. However, as a content
         structure grows deeper than a single level this makes it impossible to
         keep the order in sync with the default language since that will be
         located in another element.
   
   Separate
         See note for “Inheritance” mode, same applies.


.. ###### END~OF~TABLE ######

In the following each type will be illustrated:


Disabled
""""""""

This is a FlexForm element with localization disabled. It appears
under the exact same terms as any other content element does: Based on
its language setting in the field defined by “[languageField]” (see
later).

Since this Data Structure is used to display the differences between
localization modes lets take a look at it:

- There is a Header and Body field on the root level

- Then, there is a link section where we can add zero to many items,
  which in turn lets us choose between the item type “Link header”
  (single field) or “Link” (header + url field)

|img-45|

In the output on the page it looks like this:

|img-46|


Inheritance
"""""""""""

With Inheritance the translation is included closely bound to the
default value. In the FlexForm it looks like this:

|img-47|

Notice that for each field (“Header”) you find a counterpart for the
available languages (“Header (vDA)”).

The code indicating the language (“vDA”) is a “v” + language ISO code.

Notice that the field “Url (vDA)” for the second link is blank. When
this is the case the value from the “Url” field (default value) is
inherited. This can be useful for such as URLs which doesn't change
between languages - or might just change in which case you can
optionally supply them!

The website display of the default record is this:

|img-48|

The danish display is this:

|img-49|

As you can see the text is translated. Only a mouse-over or click on
the second link will show that the URL is inherited - but trust me, it
is ;-)


Separate
""""""""

In the “Separate” mode the two languages are separated completely in
the form. This doesn't make any difference for the “Header” and “Body”
fields but the “Link section” can be composed differently in the two
languages. Below it is very easy to see this difference because for
the Danish translation (“DA”) there is only one “Link” entry contrary
to the “Link header” / “Link” / “Link” composition of the default
language.

|img-50|

The result on the website is as expected.

First the Default display:

|img-51|

Then the Danish “localization”:

|img-52|

This is the flexibility of the “Separate” approach - that you can
truely  *localize* you content, not just translate it. But the price
is that the relation between the default and translated content is
lost in a technical sense.


FlexForm Data XML
"""""""""""""""""

The following is quite technical but for those who wish to take a look
at how the FlexForm XML data is different in each scenario you can
compare these listings:


“Disabled”:
~~~~~~~~~~~

::

      1: <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
      2: <T3FlexForms>
      3:     <data type="array">
      4:         <sheet index="sDEF" type="array">
      5:             <language index="lDEF" type="array">
      6:                 <field index="field_header" type="array">
      7:                     <vDEF>Localization: Disabled</vDEF>
      8:                 </field>
      9:                 <field index="field_body" type="array">
     10:                     <vDEF>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Cras id quam ut sem ullamcorper aliquam. Aliquam faucibus urna sit amet massa. Quisque rutrum enim sed libero mollis fringilla. Maecenas eget sapien ac est vehicula ullamcorper. Aenean nunc tellus, sollicitudin id, ornare nec, euismod non, nunc. Sed aliquam, pede eu suscipit posuere, elit quam facilisis neque, vel dignissim arcu lacus at nulla.</vDEF>
     11:                 </field>
     12:                 <field index="field_links" type="array">
     13:                     <el type="array">
     14:                         <field index="1" type="array">
     15:                             <field_linkheader type="array">
     16:                                 <el type="array">
     17:                                     <field index="field_headerstr" type="array">
     18:                                         <vDEF>Maecenas eget</vDEF>
     19:                                     </field>
     20:                                 </el>
     21:                             </field_linkheader>
     22:                         </field>
     23:                         <field index="2" type="array">
     24:                             <field_linkcontent type="array">
     25:                                 <el type="array">
     26:                                     <field index="field_linktext" type="array">
     27:                                         <vDEF>My link to TYPO3.org</vDEF>
     28:                                     </field>
     29:                                     <field index="field_url" type="array">
     30:                                         <vDEF>http://typo3.org/</vDEF>
     31:                                     </field>
     32:                                 </el>
     33:                             </field_linkcontent>
     34:                         </field>
     35:                         <field index="3" type="array">
     36:                             <field_linkcontent type="array">
     37:                                 <el type="array">
     38:                                     <field index="field_linktext" type="array">
     39:                                         <vDEF>My link to TYPO3.com</vDEF>
     40:                                     </field>
     41:                                     <field index="field_url" type="array">
     42:                                         <vDEF>http://typo3.com/</vDEF>
     43:                                     </field>
     44:                                 </el>
     45:                             </field_linkcontent>
     46:                         </field>
     47:                     </el>
     48:                 </field>
     49:             </language>
     50:         </sheet>
     51:     </data>
     52: </T3FlexForms>
    


“Inheritance”:
~~~~~~~~~~~~~~

::

     1: <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
      2: <T3FlexForms>
      3:     <data type="array">
      4:         <sheet index="sDEF" type="array">
      5:             <language index="lDEF" type="array">
      6:                 <field index="field_header" type="array">
      7:                     <vDEF>Localization: Inheritance</vDEF>
      8:                     <vDA>Danish alternative header (Localization: Inheritance)</vDA>
      9:                     <vRU></vRU>
     10:                 </field>
     11:                 <field index="field_body" type="array">
     12:                     <vDEF>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Cras id quam ut sem ullamcorper aliquam. Aliquam faucibus urna sit amet massa. Quisque rutrum enim sed libero mollis fringilla. Maecenas eget sapien ac est vehicula ullamcorper. Aenean nunc tellus, sollicitudin id, ornare nec, euismod non, nunc. Sed aliquam, pede eu suscipit posuere, elit quam facilisis neque, vel dignissim arcu lacus at nulla.</vDEF>
     13:                     <vDA>Danish alternative bodytext here. Maecenas eget sapien ac est vehicula ullamcorper. Aenean nunc tellus, sollicitudin id, ornare nec, euismod non, nunc. Sed aliquam, pede eu suscipit posuere, elit quam facilisis neque, vel dignissim arcu lacus at nulla.</vDA>
     14:                     <vRU></vRU>
     15:                 </field>
     16:                 <field index="field_links" type="array">
     17:                     <el type="array">
     18:                         <field index="1" type="array">
     19:                             <field_linkheader type="array">
     20:                                 <el type="array">
     21:                                     <field index="field_headerstr" type="array">
     22:                                         <vDEF>Maecenas eget</vDEF>
     23:                                         <vDA>Danish header</vDA>
     24:                                         <vRU></vRU>
     25:                                     </field>
     26:                                 </el>
     27:                             </field_linkheader>
     28:                         </field>
     29:                         <field index="2" type="array">
     30:                             <field_linkcontent type="array">
     31:                                 <el type="array">
     32:                                     <field index="field_linktext" type="array">
     33:                                         <vDEF>My link to TYPO3.org</vDEF>
     34:                                         <vDA>Mit link til TYPO3.org</vDA>
     35:                                         <vRU></vRU>
     36:                                     </field>
     37:                                     <field index="field_url" type="array">
     38:                                         <vDEF>http://typo3.org/</vDEF>
     39:                                         <vDA>http://typo3.org/dk/</vDA>
     40:                                         <vRU></vRU>
     41:                                     </field>
     42:                                 </el>
     43:                             </field_linkcontent>
     44:                         </field>
     45:                         <field index="3" type="array">
     46:                             <field_linkcontent type="array">
     47:                                 <el type="array">
     48:                                     <field index="field_linktext" type="array">
     49:                                         <vDEF>My link to TYPO3.com</vDEF>
     50:                                         <vDA>Mit link til TYPO3.com</vDA>
     51:                                         <vRU></vRU>
     52:                                     </field>
     53:                                     <field index="field_url" type="array">
     54:                                         <vDEF>http://typo3.com/</vDEF>
     55:                                         <vDA></vDA>
     56:                                         <vRU></vRU>
     57:                                     </field>
     58:                                 </el>
     59:                             </field_linkcontent>
     60:                         </field>
     61:                     </el>
     62:                 </field>
     63:             </language>
     64:         </sheet>
     65:     </data>
     66: </T3FlexForms>


“Separate”:
~~~~~~~~~~~

::

     1: <?xml version="1.0" encoding="utf-8" standalone="yes" ?>
      2: <T3FlexForms>
      3:     <data type="array">
      4:         <sheet index="sDEF" type="array">
      5:             <language index="lDEF" type="array">
      6:                 <field index="field_header" type="array">
      7:                     <vDEF>Localization: Separate</vDEF>
      8:                 </field>
      9:                 <field index="field_body" type="array">
     10:                     <vDEF>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Cras id quam ut sem ullamcorper aliquam. Aliquam faucibus urna sit amet massa. Quisque rutrum enim sed libero mollis fringilla. Maecenas eget sapien ac est vehicula ullamcorper. Aenean nunc tellus, sollicitudin id, ornare nec, euismod non, nunc. Sed aliquam, pede eu suscipit posuere, elit quam facilisis neque, vel dignissim arcu lacus at nulla.</vDEF>
     11:                 </field>
     12:                 <field index="field_links" type="array">
     13:                     <el type="array">
     14:                         <field index="1" type="array">
     15:                             <field_linkheader type="array">
     16:                                 <el type="array">
     17:                                     <field index="field_headerstr" type="array">
     18:                                         <vDEF>Maecenas eget</vDEF>
     19:                                     </field>
     20:                                 </el>
     21:                             </field_linkheader>
     22:                         </field>
     23:                         <field index="2" type="array">
     24:                             <field_linkcontent type="array">
     25:                                 <el type="array">
     26:                                     <field index="field_linktext" type="array">
     27:                                         <vDEF>My link to TYPO3.org</vDEF>
     28:                                     </field>
     29:                                     <field index="field_url" type="array">
     30:                                         <vDEF>http://typo3.org/</vDEF>
     31:                                     </field>
     32:                                 </el>
     33:                             </field_linkcontent>
     34:                         </field>
     35:                         <field index="3" type="array">
     36:                             <field_linkcontent type="array">
     37:                                 <el type="array">
     38:                                     <field index="field_linktext" type="array">
     39:                                         <vDEF>My link to TYPO3.com</vDEF>
     40:                                     </field>
     41:                                     <field index="field_url" type="array">
     42:                                         <vDEF>http://typo3.com/</vDEF>
     43:                                     </field>
     44:                                 </el>
     45:                             </field_linkcontent>
     46:                         </field>
     47:                     </el>
     48:                 </field>
     49:             </language>
     50:             <language index="lDA" type="array">
     51:                 <field index="field_header" type="array">
     52:                     <vDEF>Danish alternative header (Localization: Separate)</vDEF>
     53:                 </field>
     54:                 <field index="field_body" type="array">
     55:                     <vDEF>Danish alternative bodytext here. Maecenas eget sapien ac est vehicula ullamcorper. Aenean nunc tellus, sollicitudin id, ornare nec, euismod non, nunc. Sed aliquam, pede eu suscipit posuere, elit quam facilisis neque, vel dignissim arcu lacus at nulla.</vDEF>
     56:                 </field>
     57:                 <field index="field_links" type="array">
     58:                     <el type="array">
     59:                         <field index="1" type="array">
     60:                             <field_linkcontent type="array">
     61:                                 <el type="array">
     62:                                     <field index="field_linktext" type="array">
     63:                                         <vDEF>Danish link to a completely other site</vDEF>
     64:                                     </field>
     65:                                     <field index="field_url" type="array">
     66:                                         <vDEF>http://joomla.org/</vDEF>
     67:                                     </field>
     68:                                 </el>
     69:                             </field_linkcontent>
     70:                         </field>
     71:                     </el>
     72:                 </field>
     73:             </language>
     74:             <language index="lRU" type="array">
     75:                 <field index="field_header" type="array">
     76:                     <vDEF></vDEF>
     77:                 </field>
     78:                 <field index="field_body" type="array">
     79:                     <vDEF></vDEF>
     80:                 </field>
     81:             </language>
     82:         </sheet>
     83:     </data>
     84: </T3FlexForms>


Conclusion:
~~~~~~~~~~~

The interesting difference is that for “Inheritance” you find the
translation of the default value (<vDEF>) in a tag on the same level
in the XML (e.g. “<vDA>”) - all within the <language index=”lDEF”>
tag. With “Separate” you find the translation in a separate structure
under <language index=”lDA”> while all values are stored with <vDEF>.
In both cases the default language content is stored in the same way.

This also tells you why you cannot switch between the two types when
you have first added localized content: You will simply loose it since
TYPO3 will look for the translation of content in another position in
the XML. There might be tools that can re-map the content for you if
you need to make this change.


Language access control
"""""""""""""""""""""""

If a translator is restricted to a single language (here: Danish) then
the flexform will display only that/those languages - and the default
language content (to be translated) is displayed read-only:

|img-53|

