/*drop table Product_category;
drop table Client_addr;
drop table Favorites;
drop table Command;
drop table Product_quantity;
drop table Product_list;
drop table Categories;
drop table Products;
drop table Users;
drop table Addresses;*/


create table Addresses( id_addr integer NOT NULL AUTO_INCREMENT, 
                        Street varchar(128), 
                        Additional varchar(128), 
                        Postcode integer, 
                        City varchar(64), 
                        Country varchar(64),
                        CONSTRAINT PK_addr PRIMARY KEY (id_addr)
);


create table Users( id_usr integer NOT NULL AUTO_INCREMENT, 
                    Name varchar(128) NOT NULL, 
                    First_name varchar(128) NOT NULL, 
                    Mail varchar(128) NOT NULL, 
                    Psswd varchar(128) NOT NULL,
                    Telephone varchar(12),
                    User_permission integer NOT NULL,
                    User_sex char(1),
                    User_Bday date,
                    CONSTRAINT PK_usr PRIMARY KEY (id_usr),
                    CONSTRAINT CHK_usr CHECK (User_permission<=3 AND User_permission>=0)
);


create table Products(  id_prod integer NOT NULL AUTO_INCREMENT, 
                        Name varchar(256), 
                        Description varchar(512),
                        Price real, 
                        Stock integer, 
                        Sales real,
                        CONSTRAINT PK_prod PRIMARY KEY (id_prod),
                        CONSTRAINT CHK_prod CHECK (Price >= 0)
);


create table Categories(    id_cat integer NOT NULL AUTO_INCREMENT, 
                            Name varchar(64), 
                            Description varchar(512),
                            parent_category integer,
                            CONSTRAINT PK_cat PRIMARY KEY (id_cat),
                            CONSTRAINT FK_cat FOREIGN KEY (parent_category) REFERENCES Categories(id_cat)
);


create table Product_list(  id_list integer NOT NULL AUTO_INCREMENT,
                            CONSTRAINT PK_list PRIMARY KEY (id_list)
);


create table Product_quantity(  list integer NOT NULL, 
                                product integer NOT NULL, 
                                Quantity integer,
                                CONSTRAINT PK_prod_qty PRIMARY KEY (list,product),
                                CONSTRAINT FK_prod_qty_list FOREIGN KEY (list) REFERENCES Product_list(id_list),
                                CONSTRAINT FK_prod_qty_prod FOREIGN KEY (product) REFERENCES Products(id_prod),
                                CONSTRAINT CHK_prod_qty CHECK (Quantity>=0)
);


create table Command(   id_command integer NOT NULL AUTO_INCREMENT, 
                        Delivery_addr integer, 
                        Payment_addr integer,
                        Client integer,
                        CONSTRAINT PK_command PRIMARY KEY (id_command),
                        CONSTRAINT FK_command_delivery FOREIGN KEY (Delivery_addr) REFERENCES Addresses(id_addr),
                        CONSTRAINT FK_command_payment FOREIGN KEY (Payment_addr) REFERENCES Addresses(id_addr),
                        CONSTRAINT FK_command_client FOREIGN KEY (Client) REFERENCES Clients(id_client)
);


create table Favorites( id_fav integer NOT NULL AUTO_INCREMENT, 
                        Client integer,
                        CONSTRAINT PK_fav PRIMARY KEY (id_fav),
                        CONSTRAINT FK_fav FOREIGN KEY (Client) REFERENCES Clients(id_client)
);


create table Client_addr(   Client integer NOT NULL, 
                            Address integer NOT NULL,
                            Name varchar(64),
                            CONSTRAINT PK_client_addr PRIMARY KEY (Client, Address),
                            CONSTRAINT FK_client_addr_c FOREIGN KEY (Client) REFERENCES Clients(id_client),
                            CONSTRAINT FK_client_addr_a FOREIGN KEY (Address) REFERENCES Addresses(id_addr)
);


create table Product_category(  Product integer NOT NULL,
                                Category integer NOT NULL,
                                CONSTRAINT PK_prod_cat PRIMARY KEY (Product, Category),
                                CONSTRAINT FK_prod_cat_p FOREIGN KEY (Product) REFERENCES Products(id_prod),
                                CONSTRAINT FK_prod_cat_c FOREIGN KEY (Category) REFERENCES Categories(id_cat)
);


create unique index I_passwords on Users (Mail, Psswd);
create index I_products on Product_category (Product);
create index I_lists on Product_quantity (list);
