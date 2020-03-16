# iCollect
By Scarlett Kim and Robert Cox
### Description
iCollect is a website where users can signup and login to create collections. 
To each collection items can be added. Users can edit the values of item 
attributes, delete items and delete entire collections. New users can upload
a profile image at sign-up and a collection image at collection creation. 
Premium users (chosen at sign-up) can have more than 5 collections and create 
premium collections. With premium collections users can add new attributes for 
items to the collection.
### Requirements
##### Separates all database/business logic using the MVC pattern.
All Session handling is performed by the controller class 
(/controller/iCollect-controller.php). Data validation and 
database access is handled by the model classes (/model/database.php and 
model/validate php). 
##### Routes all URLs and leverages a templating language using the Fat-Free framework.
All routing handled by the index page through the creation of an 
ICollectController object. All views contained in /view and access the
controller through the Fat-free framework templating to display dynamic content.
##### Has a clearly defined database layer using PDO and prepared statements. You should have at least two related tables.
The Database class (/model/database.php) handles all database access through
a PDO instance variable. Each method of Database uses a prepared statement to 
access the database and return a result for use in the controller. The iCollect
database consists of five interconnected tables to manage user data.
##### Data can be viewed, added, updated, and deleted.
Once a user has signed-up and created a collection, they can then view the 
collection and add new items and attributes (premium only) to the collection. 
Item values can be edited/updated, assuming they pass validation. Users can also
delete individual items or entire collections.
##### Has a history of commits from both team members to a Git repository.
https://github.com/scarkim/iCollect
#####Uses OOP, and defines multiple classes, including at least one inheritance relationship.
iCollect uses a total of six classes to handle all aspects routing and MVC. 
Already mention were the controller and model classes. A User class 
(/classes/user.php) is implemented for use in the controller to track the 
session user. And a Collection class (/classes/collection.php) for the 
controller to track the session collection. A PremiumCollection class 
(/classes/premiumcollection.php) extends Collection for tracking added 
attributes.
##### Contains full Docblocks for all PHP files and follows PEAR standards.
Seemingly
##### Has full validation on the client side through JavaScript and server side through PHP.
/scripts contains all client-side validation and server-side is handle through 
the controller (by use of Validate from the model).
##### BONUS:  Incorporates Ajax that access data from a JSON file, PHP script, or API. If you implement Ajax, be sure to talk about it in your presentation.
iCollect implements Ajax in a few ways. First, when a new user signs up, a live
message is displayed to the user telling them if the username or email already 
exists in the database and therefore available/unavailable. Next is the edit 
item feature which validates, updates the database, and displays the result 
in real time. Also both delete item and delete collection perform similar 
actions.
