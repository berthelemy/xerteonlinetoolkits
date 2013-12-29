# Upgrading an existing installation

**Important:** if you are already familiar with upgrading an existing Xerte installations there are important additional steps outlined in this guide. There are also two methods outlined here:

1.  [Easy option](upgrading#easy-option) – some previous files will remain duplicated in new locations
2.  [Clean upgrade](upgrading#clean-upgrade) – this involves removing non-unique files before applying the updated files 

**Even more important**

As always whichever of these methods you choose you should backup your existing database and directory first in case of problems.

## Easy option

This is the easiest upgrade option but some previous files will remain duplicated as in version 2 they have been moved to new locations

**Note:** If your existing installation is already 1.9 a file named auth_config.php exists and is where the authentication method is set. Avoid overwriting this file if you don't want to revert back to guest access).

### Step 1. Backup first.

Backup your existing database and directory first in case of problems.

### Step 2.

Drop the latest code over the top of the existing code being careful to merge or protect any local customisations or restore those after upgrade e.g. auth_config.php, Static.php styles.css etc

### Step 3.

If your existing installation was older and didn’t contain auth_config.php or was overwritten then your upgrade will initially have guest access set. In this case it’s an opportunity to test the basics are working ok via guest access (e.g. create and test an LO) before changing the authentication back to your usual method.

### Step 4. 

Important new step: Now visit http://yourinstall/upgrade.php This will copy any ldap details form the sitedetails table to the ldap table as well as setting other new default values.

### Step 5. 

Change from guest to ldap or one of the other authentication options in auth_config.php by commenting/un-commenting the relevant line. 

### Step 6. 

If you are using Moodle for authentication read and follow the instructions in the moodle_integration_readme file

### Step 7. 

Refresh index.php and test login and creation etc again 

### Step 8.

Remove the folder named setup or move it outside of the web root.

## Clean upgrade

This method is very similar to the easy option except that it involves removing most of the existing installation files before applying the upgrade.

### Step 1. Backup first.

Backup your existing database and directory first in case of problems.

### Step 2. 

Remove most of the existing installation files being careful not to remove user files and files/folders unique to your installation. The list and screenshot below outlines the files and folders that **should NOT be removed**:

* error_logs

This may contain previous error logs which should obviously be investigated anyway but as the folders probably also has different permissions shouldn’t be removed.

* import

Again this folder probably also has different permissions and may contain imported projects so shouldn’t be removed.

* library

This folder can actually be removed unless you are using static authentication. If you are using static authentication then backup or protect \library\Xerte\Authentication\Static.php as this will contain your static usernames and passwords.

* USER-FILES

This is where all user projects are saved and definitely should not be removed.

* auth_config.php

This is where the authentication method is set. If your existing installation contains and uses this file this should not be overwritten.

* database.php

This contains the unique database credentials for your installation so be careful not to remove this file. Note: the Xerte Online Toolkits download does not contain database.php as this is created during initial installation.  
 
### Step 3.

If your existing installation was older and didn’t contain auth_config.php or was overwritten then your upgrade will initially have guest access set. In this case it’s an opportunity to test the basics are working ok via guest access (e.g. create and test an LO) before changing the authentication back to your usual method.

### Step 4. 

Important new step: Now visit http://yourinstall/upgrade.php This will copy any ldap details form the sitedetails table to the ldap table as well as setting other new default values.

### Step 5. 

Change from guest to ldap or one of the other authentication options in auth_config.php by commenting/un-commenting the relevant line. 

### Step 6. 

If you are using Moodle for authentication read and follow the instructions in the moodle_integration_readme file.

### Step 7. 

Refresh index.php and test login and creation etc again. 

### Step 8.

Remove the folder named setup or move it outside of the web root.

## Common Issues/Considerations

1. Common configuration issues
    * Directory permissions e.g. code can’t write to user-files
    * PHP upload settings e.g. max upload set too small preventing upload of larger files such as video or importing projects exported from another installation
    * Mime types especially on Windows/IIS servers
    * xwd, rlt & rlm as mime-type 'text/xml'  possibly flv too. 
2. General issues with installation/upgrading
    * Contact Xerte technical list for free help – provide as much info as possible: http://lists.nottingham.ac.uk/mailman/listinfo/xerte 