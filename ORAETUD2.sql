/* Use these lines to drop former tables*/

/*drop table Product_category;
drop table Client_addr;
drop table Favorites;
drop table Command;
drop table Product_quantity;
drop table Product_list;
drop table Categories;
drop table Products;
drop table Mods;
drop table Admins;
drop table Clients;
drop table Users;
drop table Addresses;
*/


/* ----------------------------------------------------------------------*/
/* -                               TABLES                               -*/
/* ----------------------------------------------------------------------*/

/* Physical geographic postal addresses for facturation and delivery. 
   Columns indicated with a * are required values when a line is added.
		- * id_addr: 			Primary key, auto-generated
		- Street: 			Number and name of street
		- Additional:			Additional information for address, like number of building or floor
		- Postcode:			For countries using one, postcode as an integer
		- City: 			Name of city
		- Country:			Name of state
		
	TABLES LINKED:
		Client_addr, 
		Command
*/
create table Addresses( id_addr integer NOT NULL AUTO_INCREMENT, 
                        Street Nvarchar(128), 
                        Additional Nvarchar(128), 
                        Postcode integer, 
                        City Nvarchar(64), 
                        Country Nvarchar(64),
                        CONSTRAINT PK_addr PRIMARY KEY (id_addr)
);


/* Users and personal users information
   Columns indicated with a * are required values when a line is added.
		- * id_usr: 			Primary key, auto-generated
		- * Name: 			Name of the user
		- * First_name:			First Name of the user
		- * Mail:			Used to log in and for contact purposes
		- * Psswd: 			Encrypted password for authentication
		- Telephone:			Useful for contact purposes and delivery problems
		- * User_permission: 		4 levels of permission, 0:Undefined, 1:Client, 2:Moderator, 3:Administrator
		- User_sex:			User genre (usually M or F), if needed for statistic purposes
		- User_Bday:			Birthday of the User, if needed for statistics or legislation
		- Salt:				Unique string used to further encrypt the password.
		
	TABLES LINKED:
		Client_addr, 
		Command,
		Favorites
*/
create table Users( id_usr integer NOT NULL AUTO_INCREMENT, 
                    Name Nvarchar(128) NOT NULL, 
                    First_name Nvarchar(128) NOT NULL, 
                    Mail Nvarchar(128) NOT NULL UNIQUE, 
                    Psswd char(128) NOT NULL,
                    Telephone Nvarchar(12),
					User_permission integer NOT NULL,
					User_sex char(1),
					User_Bday date,
					Salt char(38),
                    			CONSTRAINT PK_usr PRIMARY KEY (id_usr),
					CONSTRAINT CHK_usr CHECK (User_permission<=3 AND User_permission>=0)
);


/* Products description and information
   Columns indicated with a * are required values when a line is added.
		- * id_prod: 			Primary key, auto-generated
		- Name: 			Name of the product
		- Description:			Description of the product, vicible to clients on the frontend
		- Price:			Base price of the product, including taxes. Must be greater or equal to 0
		- Stock: 			Number of items in storage, available for buying
		- Sales:			Percent of price to show to the client. 1 for an item sold full price, 0.7 for a 30% reduction 
		
	TABLES LINKED:
		Product_quantity
		Product_category
*/
create table Products(  id_prod integer NOT NULL AUTO_INCREMENT, 
                        Name Nvarchar(256), 
			Description Nvarchar(512),
                        Price real, 
                        Stock integer, 
                        Sales real,
                        CONSTRAINT PK_prod PRIMARY KEY (id_prod),
                        CONSTRAINT CHK_prod CHECK (Price >= 0)
);

/* Categories containing products, for an easy research of a product by the client
   Columns indicated with a * are required values when a line is added.
		- * id_cat: 			Primary key, auto-generated
		- Name: 			Name of the category, used in menus
		- Description:			Description of the category, visible to clients on the frontend
		- parent_category:		Categories are constructed as a tree, like folders. Each category references the category immediately above.
		
*/
create table Categories(	id_cat integer NOT NULL AUTO_INCREMENT, 
                            	Name Nvarchar(64), 
				Description Nvarchar(512),
                            	parent_category integer,
                            	CONSTRAINT PK_cat PRIMARY KEY (id_cat),
                            	CONSTRAINT FK_cat FOREIGN KEY (parent_category) REFERENCES Categories(id_cat)
);

/* "Abstract table" for products lists, like commands or favorites. 
   Columns indicated with a * are required values when a line is added.
		- * id_list: 	Primary key, auto-generated. The column of id_list contains the union between the IDs of the Commands and the Favorites.
		
	TABLES LINKED:
		Product_quantity

	TRIGGERS:
		BEFORE adding a line in table Command: Copy the newly added id_command into column id_list
		BEFORE adding a line in table Favorites: Copy the newly added id_fav into column id_list
*/
create table Product_list(  id_list integer NOT NULL AUTO_INCREMENT,
                            CONSTRAINT PK_list PRIMARY KEY (id_list)
);

/* Table containing the association between a product and a list, and specifying quantity to add.
   Columns indicated with a * are required values when a line is added.
		- * list: 	Primary key, referencing an id_list from table Product_list.
		- * product: 	Primary key, referencing an id_product from table Products.
		- Quantity: 	Quantity of physical products to add into the Command/Favorite list. Must be greater or equal to 0
		
	TABLES LINKED:
		Product_list
		Products

*/
create table Product_quantity(  list integer NOT NULL, 
                                product integer NOT NULL, 
                                Quantity integer,
                                CONSTRAINT PK_prod_qty PRIMARY KEY (list,product),
                                CONSTRAINT FK_prod_qty_list FOREIGN KEY (list) REFERENCES Product_list(id_list),
                                CONSTRAINT FK_prod_qty_prod FOREIGN KEY (product) REFERENCES Products(id_prod),
                                CONSTRAINT CHK_prod_qty CHECK (Quantity>=0)
);

/* Table containing the commands when a buyer confirmed his/her shopping cart.
   Columns indicated with a * are required values when a line is added.
		- * id_command: 	Primary key, also stored in table Product_list
		- Delivery_addr: 	Postal address for delivery.
		- Payment_addr: 	Postal address for facturation.
		- Client:		Client ID to link the command to a user account.
		
	TABLES LINKED:
		Clients
		Addresses

	TRIGGERS:
		BEFORE adding a line in table Command: Copy the newly added id_command into column id_list in table Product_list.
*/
create table Command(   id_command integer NOT NULL AUTO_INCREMENT, 
                        Delivery_addr integer, 
                        Payment_addr integer,
                        Client integer,
                        CONSTRAINT PK_command PRIMARY KEY (id_command),
                        CONSTRAINT FK_command_delivery FOREIGN KEY (Delivery_addr) REFERENCES Addresses(id_addr),
                        CONSTRAINT FK_command_payment FOREIGN KEY (Payment_addr) REFERENCES Addresses(id_addr),
                        CONSTRAINT FK_command_client FOREIGN KEY (Client) REFERENCES Clients(id_client)
);

/* Table containing the shopping carts a user can save to reload it later.
   Columns indicated with a * are required values when a line is added.
		- * id_fav: 		Primary key, also stored in table Product_list
		- Client:		Client ID to link the favorites list to a user account.
		
	TABLES LINKED:
		Clients

	TRIGGERS:
		BEFORE adding a line in table Favorites: Copy the newly added id_fav into column id_list in table Product_list.
*/
create table Favorites( id_fav integer NOT NULL AUTO_INCREMENT, 
                        Client integer,
                        CONSTRAINT PK_fav PRIMARY KEY (id_fav),
                        CONSTRAINT FK_fav FOREIGN KEY (Client) REFERENCES Clients(id_client)
);

/* Table linking the postal addresses to the clients. A client can save multiple addresses and give them names.
   Columns indicated with a * are required values when a line is added.
		- * Client:	Primary key, ID of the client linked, referencing table Clients.
		- * Address:	Primary key, ID of the address linked, referencing table Addresses.
		- Name:		Name of the association, given by the client to reognise the address (eg. "Facturation address", "Home", or "Santa Claus bunker")
		
	TABLES LINKED:
		Clients
		Addresses
*/
create table Client_addr(   Client integer NOT NULL, 
                            Address integer NOT NULL,
			    Name Nvarchar(64),
                            CONSTRAINT PK_client_addr PRIMARY KEY (Client, Address),
                            CONSTRAINT FK_client_addr_c FOREIGN KEY (Client) REFERENCES Clients(id_client),
                            CONSTRAINT FK_client_addr_a FOREIGN KEY (Address) REFERENCES Addresses(id_addr)
);

/* Table linking the products to their categories. A single product may be found in several categories.
   Columns indicated with a * are required values when a line is added.
		- * Product:	Primary key, ID of the product linked, referencing table Products.
		- * Category:	Primary key, ID of the category linked, referencing table Categories.
		
	TABLES LINKED:
		Products
		Categories
*/
create table Product_category(  Product integer NOT NULL,
                                Category integer NOT NULL,
                                CONSTRAINT PK_prod_cat PRIMARY KEY (Product, Category),
                                CONSTRAINT FK_prod_cat_p FOREIGN KEY (Product) REFERENCES Products(id_prod),
                                CONSTRAINT FK_prod_cat_c FOREIGN KEY (Category) REFERENCES Categories(id_cat)
);


/* */
create table Sequences( sequence_number integer NOT NULL AUTO_INCREMENT,
			description varchar(8) NOT NULL,
			CONSTRAINT PK_sequence PRIMARY KEY (sequence_number)
);

/* Index used for faster researches. Only informative, does not affect the use of the database. */
create unique index I_passwords on Users (Mail, Psswd);
create index I_products on Product_category (Product);
create index I_passwords on Product_quantity (list);



/* ----------------------------------------------------------------------*/
/* -                              TRIGGERS                              -*/
/* ----------------------------------------------------------------------*/

/* Trigger activated before the insertion of a new value in table Command.
   Inserts the newly-added command ID into table Product_list, 
   for the Product_list table shalt possess all of thee commands thy database knowst.
*/
/* ---------------------------
CREATE TRIGGER before_insert_commande BEFORE INSERT
ON Command FOR EACH ROW
BEGIN
	SET NEW.id_command = 'id';
	INSERT INTO Product_list VALUES(NEW.id_command);
END


/* Trigger activated before the insertion of a new value in table Favorites.
   Inserts the newly-added favorites ID into table Product_list, 
   for the Product_list table shalt possess all of thee favorites lists thy database knowst.
*/
/* ----------------------------
CREATE TRIGGER before_insert_fav BEFORE INSERT
ON Favorites FOR EACH ROW
BEGIN
	SET NEW.id_fav = 'F'+NEW.id_fav;
	INSERT INTO Product_list VALUES(NEW.id_fav);
END

/* ----------------------------------------------------------------------*/
/* -                             PROCEDURES                             -*/
/* ----------------------------------------------------------------------*/

/* Sequence_nextval():


*/
delimiter $$
CREATE PROCEDURE Sequence_Nextval (OUT preturn BIGINT)
BEGIN
	INSERT INTO Sequences(description) VALUES ("nexval");
	SELECT LAST_INSERT_ID() INTO preturn;
END
$$

CALL Sequence_Nextval(@a);
SELECT @a;
CALL Sequence_Nextval(@a);
SELECT @a;
CALL Sequence_Nextval(@a);
SELECT @a;
/* AddUser:
	This procedure HAS TO BE USED for adding a new user into the database.
	It inserts the values into the database, checking for potential SQL injections (types preceded with 'n') 
	and further encrypt the password with the unique salt given to each user.

	USAGE:
		AddUser(Name, First_Name, Mail,Password, Telephone, User_permission, User_sex, User_Birthday)

	OUTPUT:
		"SUCCESS" if the insert was successful, or "ERROR" if the procedure encountered a problem.
*//*
delimiter $$
CREATE PROCEDURE AddUser (
	IN pName Nvarchar(128),
	IN pFirst_name Nvarchar(128),
	IN pMail Nvarchar(128),
	IN pPsswd char(128),
	IN pTelephone Nvarchar(12),
	IN pUser_permission integer,
	IN pUser_sex char(1),
	IN pUser_Bday date,
	IN responseMessage NVARCHAR(250)
)
BEGIN
    	SET NOCOUNT ON
	
	DECLARE @vSalt char(38) = NEWID()
	BEGIN TRY
		INSERT INTO Users(Name, First_name, Mail, Psswd, Telephone, User_permission, User_sex, User_Bday, Salt)
		VALUES(@pName, @First_name, @pMail, HASHBYTES('SHA2_512', @pPsswd + CAST(@iSalt AS NVARCHAR(36))), @pTelephone, @pUser_permission, @pUser_sex, @pUser_Bday, @vSalt)
		SET @responseMessage='SUCCESS'
	END TRY
	BEGIN CATCH
        	SET @responseMessage='ERROR'
    	END CATCH

END
$$
/* AddUser:
	This procedure HAS TO BE USED for logging a new user.
	It checks the informations given for login (Mail and password) and compares it to the data stored into table Users.

	USAGE:
		Login(Mail, password)

	OUTPUT:
		The User ID if the insert was successful, or "ERROR" if the procedure encountered a problem or no result.
*//*
CREATE PROCEDURE Login
    	@pMail NVARCHAR(128),
    	@pPsswd NVARCHAR(128),
    	@responseMessage NVARCHAR(250)='' OUTPUT
AS
BEGIN
    	SET NOCOUNT ON

    	DECLARE @userID integer
    	IF EXISTS (SELECT id_usr FROM Users WHERE Mail=@pMail)
    	BEGIN
        	SET @userID=(SELECT id_usr FROM Users WHERE Mail=@pMail AND Psswd=HASHBYTES('SHA2_512', @pPsswd+CAST(Salt AS NVARCHAR(36))))

       		IF(@userID IS NULL)
           		SET @responseMessage='ERROR'
       		ELSE 
           		SET @responseMessage=@userID
    	END
    	ELSE
       		SET @responseMessage='ERROR'
END


delimiter $$
CREATE PROCEDURE AddCommand (
	IN pDelivery integer,
	IN pPayment  integer,
	IN pClient   integer,
	OUT responseMessage 
)
BEGIN
	SET NOCOUNT ON;

	INSERT INTO Command(id_command, Delivery_addr, Payment_addr, Client) VALUES ( (AUTO_INCREMENT()*10)+1, @pDelivery, @pPayment, @pClient);

END
$$


