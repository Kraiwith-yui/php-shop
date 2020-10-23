USE db_npshop;

CREATE TABLE tb_order (
    Order_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    Order_address VARCHAR(100) NOT NULL,
    Order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    Order_phone VARCHAR(30),
    Order_price INT(7),
    Order_amount INT(7),
    Member_id INT(11),
    Product_id INT(11),
    CONSTRAINT FK_Member_id FOREIGN KEY (Member_id) REFERENCES tb_member(Member_id),
    CONSTRAINT FK_Product_id FOREIGN KEY (Product_id) REFERENCES tb_product(Product_id)
)