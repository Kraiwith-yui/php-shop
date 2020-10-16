USE db_npshop;
-- CREATE TABLE
CREATE TABLE tb_product(
    Product_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    Product_name VARCHAR(50) NOT NULL,
    Product_desc VARCHAR(100),
    Product_price INT(7) NOT NULL
);

-- INSERT DATA INTO TABLE
INSERT INTO tb_product(
    Product_name, Product_desc, Product_price
) VALUES (
    'Kitchen Rise', 'This Product is Kitchen from the Rise.', 600
), (
    'Paper Mint', 'This Product has Paper and Mint.', 1500
), (
    'Chiper', 'This Product so Chippy.', 100
);
