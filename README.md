# Suma Session Manager

**Suma Session Manager** is a tool for modifying data that has previously been submitted to **Suma: A Space Assessment Toolkit** (https://github.com/cazzerson/Suma). Suma is a space usage/statistics package; it natively does not allow users to delete or modify data once it has been submitted. This session manager allows the user to "delete" (actually hide from reporting) or to alter the timestamps on individual sessions. 

**Note:** The good folks who wrote **Suma** very deliberately elected not to offer functions that delete or alter the data once submitted. Suma Session Manager does all sorts of things they didn't intend. I respect their original decision making and offer this project for other Suma users who want more flexibility. Remember: with great power comes great responsibility. 

## Installation

Install the Suma Retroactive Data Importer in a folder *outside* of the main Suma web space. Copy the **config-sample.php** file to be **config.php**, then configure the **config.php** file with the MySQL connection information for your Suma Server. 

### Security

Suma Manager should be installed in a secure directory, as anyone with access to the page will be able to alter the information in your Suma database. Consult your system adminitstrator for the most sensible access restriction in your environment.

## Usage


## Demo

Link to demo vid? 

## Acknowledgements
   * Jason Casden & Bret Davidson are the project lead and technical lead for the original Suma project. Thanks for their help in understanding the underpinnings of their project enough to implement this add-on.
   