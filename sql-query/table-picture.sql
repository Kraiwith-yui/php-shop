USE db_npshop;

CREATE TABLE tb_picture(
    Picture_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    Picture_name VARCHAR(50) NOT NULL,
    Product_id INT(11),
    CONSTRAINT FK_Picture_Product FOREIGN KEY (Product_id) REFERENCES tb_product(Product_id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = INNODB;