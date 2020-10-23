USE db_npshop;

CREATE TABLE tb_product(
    Product_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    Product_name VARCHAR(50) NOT NULL,
    Product_description VARCHAR(100),
    Product_price INT(7) NOT NULL
);
