USE db_npshop;
CREATE TABLE tb_picture(
    Picture_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    Picture_name VARCHAR(50) NOT NULL,
    Product_id INT(11),
    CONSTRAINT FK_Product_id FOREIGN KEY (Product_id) REFERENCES tb_product(Product_id)
);

USE db_npshop;
INSERT INTO tb_picture(
    Picture_name, Product_id
) VALUES (
    'image.jpg', 1
), (
    'image.jpg', 1
), (
    'image.jpg', 1
), (
    'image.jpg', 2
), (
    'image2.jpg', 3
);