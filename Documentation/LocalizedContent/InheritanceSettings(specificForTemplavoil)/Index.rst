.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


Inheritance settings (specific for TemplaVoilà!)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The “Inheritance” localization mode of FlexForms can be modified
further. It is possible to completely disable inheritance by the
“dontInheritValueFromDefault” property of the tx\_templavoila\_pi1”
plugin. For content elements this can be done with ::

   plugin.tx_templavoila_pi1.dontInheritValueFromDefault = 1

It can also be used for TemplaVoilà page templates, typically ::

   page.10.dontInheritValueFromDefault = 1


<langOverlayMode>
"""""""""""""""""

More advanced is the tag “<langOverlayMode>” applicable in both Data
Structures and the local processing of Template Objects.

With this tag you can set modes like “ifFalse”, “ifBlank”, “never”,
“removeIfBlank”. The latter will enable you to exclude the display of
elements if a certain field is blank, thus making up for some of the
flexibility lost when using the “Inheritance” mode compared to
“Separate”.

You must consult the TemplaVoilà documentation on the Data Structure
XML for more information.


Advanced usage of Inheritance - an example
""""""""""""""""""""""""""""""""""""""""""

In this example I will show how <langOverlayMode> can be used to
change number of link objects displayed for this Flexible Content
Element:

|img-69|

The setting we will use for “<langOverlayMode>” is “removeIfBlank” and
we will apply it to the “Link text” field! With that setting this is
what happens for each link:

- Link, top: Has content for both default and danish, will be shown of
  course.

- Link, middle: Has no content for the danish URL. This will be
  inherited from the default url (default setting, no effect of
  <langOverlayMode>)

- Link, bottom: Has no content for the danish “Link text” and  *that*
  affects the whole display of that link because <langOverlayMode> is
  “removeIfBlank” for the “Link text” field and according to the
  documentation that will block the rendering of the whole group of
  fields.

Visually, this is how the default links render:

|img-70|

And this is how they render in Danish. Obviously the last link is
missing altogether:

|img-71|


**Where to set <langOverlayMode>?**
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Well, you can set it in the Data Structure (DS), but alternatively you
can set it in a Template Objects (TO) “Local processing” field. This
allows you to vary the setting based on which TO renders the DS.

The “Local processing” field looked like this::

   <T3DataStructure>
       <ROOT type="array">
           <el type="array">
               <field_links type="array">
                   <el type="array">
                       <field_linkcontent type="array">
                           <el type="array">
                               <field_linktext type="array">
                                   <tx_templavoila type="array">
                                       <langOverlayMode>removeIfBlank</langOverlayMode>
                                   </tx_templavoila>
                               </field_linktext>
                           </el>
                       </field_linkcontent>
                   </el>
               </field_links>
           </el>
       </ROOT>
   </T3DataStructure>

*Notice: If “Free” paradigm is used, FlexForm content using
Inheritance or Separate modes is possible only if the same element is
used from each languages content structure. These problems are a main
objection agains the “Free” paradigm because it so easily leads to
confusion.*


Limiting access to FlexForm fields for translators
""""""""""""""""""""""""""""""""""""""""""""""""""

Strictly, this is related to permissions, but it is interesting in the
context. Consider if you wanted translators to only deal with the
“Link text” fields of the form above, not the “Url” fields? Or it
could be an image field where you want to inherit the default image -
but translators would mistakenly insert new images if they see the
field is blank. Well, what you can do is use a special display
condition in the Data Structure to block display of some fields for
translators::

   <TCEforms type="array">
           <displayCond>HIDE_L10N_SIBLINGS:except_admin</displayCond>
           <config type="array">
                   <type>input</type>
                   <size>15</size>
                   ...

Now, the magic lies in “HIDE\_L10N\_SIBLINGS” and the added parameter
“except\_admin” means that admin-users  *will* see the URL fields
(thus they can set exceptional values if needed). But the point is:
Any other user will see this form  *with no Url* fields:

|img-72|

