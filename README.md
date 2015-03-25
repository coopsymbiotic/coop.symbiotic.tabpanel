Contact Tab Panel
=================

CiviCRM extension to create contact tabs regrouping several custom groups like in the core Summary tab.
Right now, the display is not really user friendly and only happend the regular civicrm custom group tab in one single tab.

Configuration
=============

Create the contact custom groups you need - set the display as tab. 
Only single value groups are working right now.

Edit the initpanels.php file to init the panels as needed and execute the file with :
drush scr initpanels.php


Roadmap
=======

Extension is still in very early stage.
The goal is to :
- have an admin interface to easily configure the panels
- display custom groups more like summary to allow inline edit 
- be able to add multiple value custom group


Support
=======

Please post bug reports in the issue tracker of this project on github:
https://github.com/coopsymbiotic/coop.symbiotic.tabpanel

For general support questions, please post on the CiviCRM Extensions forum:
http://forum.civicrm.org/index.php/board,57.0.html


