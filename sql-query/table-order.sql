USE db_npshop;

CREATE TABLE tb_order (
    Order_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    Order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    Order_address VARCHAR(100) NOT NULL,
    Order_phone VARCHAR(30),
    Order_price INT(7),
    Order_status VARCHAR(10),
    Order_products LONGTEXT,
    Member_id INT(11),
    CONSTRAINT FK_Order_Member FOREIGN KEY (Member_id) REFERENCES tb_member(Member_id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE = INNODB;