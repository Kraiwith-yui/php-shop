USE db_npshop;
CREATE TABLE tb_image(
    Image_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    Image_name VARCHAR(50) NOT NULL,
    Product_id INT(11),
    CONSTRAINT FK_Product_id FOREIGN KEY (Product_id) REFERENCES tb_product(Product_id)
);

INSERT INTO tb_image(
    image_name, product_id
) VALUES (
    'image.jpg', 1
), (
    'image.jpg', 1
), (
    'image.jpg', 1
), (
    'image.jpg', 2
), (
    'image.jpg', 3
);