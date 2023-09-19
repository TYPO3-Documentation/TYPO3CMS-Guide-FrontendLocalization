..  include:: /Includes.rst.txt

..  _core-support-permissions:

===========
Permissions
===========

You can restrict backend users and groups to edit records in specific languages
only. The permissions are enforced across all tables by checking the language
specified in the :ref:`TCA <t3tca:start>` configuration of the
:ref:`"languageField" of the table <core-support-tca-languagefield>`.
Navigate to the backend module :guilabel:`System > Backend Users`. Select a
backend user group. The :guilabel:`Limit to languages` setting is found in the
:guilabel:`Access Lists` tab:

..  figure:: /Images/ManualScreenshots/BackendUsers/CoreSupportLimitToLanguages.png
    :alt: Setting language limitations
    :class: with-shadow

    Restricting backend users or groups to one or more languages

Settings from groups and sub-groups are merged.

If a user has no :guilabel:`Limit to languages` checkboxes set at all they can
edit *all languages*.

Regardless of :guilabel:`Limit to languages` all users can edit records with
:guilabel:`[All]` language.

Setting :guilabel:`Limit to languages` is not only good to protect translators
from editing other languages or default content - it is also helpful
to limit the confusion a user might have when faced with modules
displaying translations for a variety of other languages!
