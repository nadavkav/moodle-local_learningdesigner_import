# Learning Designer to Moodle importer #

Import UCL Learning Designer (LDJ files) into a Moodle course.

The [Learning Designer](https://www.ucl.ac.uk/learning-designer/) is a tool to help teachers and lecturers design teaching and learning activities and share their learning designs with each other. It was developed by a team led by Diana Laurillard at the UCL Knowledge Lab and is free for anyone to use.

This Moodle plugin, enables a teacher to import a LDJ file of a previously exported LD instructional design topic or class session schema, directly into the teacher's Moodle course at any course topic (section/week). 

| Learning designer  | to | Moodle course |
|---|---|---|
|  ![Learning designer](https://github.com/nadavkav/moodle-local_learningdesigner_import/blob/master/docs/learning-designer.png) | --> | ![Moodle course](https://github.com/nadavkav/moodle-local_learningdesigner_import/blob/master/docs/output-moodle-course.png) |

To use it, you need to be a teacher in a course.
The "import LD file" action in under the course settings (cog). 

## Install ## 

Click on the button to ["Clone or Download"](https://github.com/nadavkav/moodle-local_learningdesigner_import) . 
When downloaded to your computer, unzip it. It should create a folder named "moodle-local_learningdesigner_import-master". 
Rename the folder so that it is "learningdesigner_import" (without quotes). Now you need to copy/upload (SFTP/SSH) that folder to your Moodle site into /moodle/local/ directory. 
Or you can create a new ZIP file of the "learningdesigner_import" folder and upload and install it via the Plugin Administration in Site Administration.
Finally, login into your Moodle admin notification page, to finish the install process.

## Updates ##

Updates will always be available at: https://github.com/nadavkav/moodle-local_learningdesigner_import .

## Report issues ##

Due to limited resources, the functionality of this plugin is primarily implemented for our own local needs and published as-is to the community. 

But please feel free to give feedback and report issues with the plugin at: https://github.com/nadavkav/moodle-local_learningdesigner_import/issues ,
and I will try to be responsive as much as I can. 

## Moodle release support ##

Due to limited resources, this plugin is only maintained for the most recent major release of Moodle. However, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that this plugin still works with a new major relase - please let us know on Github.

If you are running a legacy version of Moodle, but want or need to run the latest version of this plugin, you can get the latest version of the plugin, remove the line starting with $plugin->requires from version.php and use this latest plugin version then on your legacy Moodle. However, please note that you will run this setup completely at your own risk. We can't support this approach in any way and there is a undeniable risk for erratic behavior.

## Translation ##

This Moodle plugin is shipped with an english language pack only. All translations into other languages must be managed through [AMOS](https://lang.moodle.org) by what they will become part of Moodle's official language pack.

As the plugin creator, I manage the translation into Hebrew for our own local needs on AMOS. Please contribute your translation into all other languages in AMOS where they will be reviewed by the official language pack maintainers for Moodle.

## Right-to-left support ##

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send us a pull request on Github with modifications.

## License ##

2019 Nadav Kavalerchik <nadavkav@gmail.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <http://www.gnu.org/licenses/>.
