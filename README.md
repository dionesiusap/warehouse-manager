# Warehouse Manager
Description: A simple item/inventory database manager for stores and shops.  
Latest version: Alpha v0.1  
Date: January 3, 2018  
Author: Dionesius Agung

## Getting Started
Assumption: you already have XAMPP or other web/HTTP server installed on your computer.  

###Setup
Go to `/htdocs` folder in xampp directory. In windows, the path is usually `C:/xampp/htdocs/`.  
To go to the directory with command line type in:
```
> C:
> cd ../..
> cd /xampp/htdocs
```
Then clone or download this repository in htdocs folder.

### Setting Apache and MySQL
1. Run XAMPP Control Panel then start Apache and MySQL. Should any error occurs (for example, regarding the port, etc.) just google for solutions.  
2. Go to your browser, go to `localhost:port/` or `127.0.0.1:port/` (change port with yours).  
3. If it redirects to `localhost:port/dashboard/` or `127.0.0.1:port/dashboard` it means your Apache is working well.

### Creating Database
1. Go to `localhost:port/` then click phpmyadmin.  
2. Create new database then create new table. In this project, my database name is `test-item`.  
3. Create new table, this project uses 1 table called `itemlist` which consists of 5 fields. The fields are:  
| Field Name   | Type         | Null | Default | Key |  
| ------------ | ------------ | ---- | ------- | --- |  
| itemid       | varchar(20)  | No   | None    | Yes |  
| name         | varchar(100) | No   | None    | No  |  
| price        | int(5)       | No   | None    | No  |  
| package      | varchar(16)  | No   | None    | No  |  
| stock        | int(5)       | No   | None    | No  |

### Opening Web Page
Go to `localhost:port/warehouse-manager/search-item.php`.
