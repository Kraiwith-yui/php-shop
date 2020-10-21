USE db_npshop;

CREATE TABLE tb_member(
    Member_id int(11) PRIMARY KEY AUTO_INCREMENT,
    Member_username VARCHAR(20) NOT NULL,
    Member_password VARCHAR(20) NOT NULL,
    Member_fullname VARCHAR(50) NOT NULL,
    Member_gender VARCHAR(3),
    Member_idcard VARCHAR(13),
    Member_address VARCHAR(100),
    Member_age int(2)
);

USE db_npshop;

INSERT INTO
    tb_member(
        Member_username,
        Member_password,
        Member_fullname,
        Member_gender,
        Member_idcard,
        Member_address,
        Member_age,
        Member_email
    )
VALUES
    (
        'yuria',
        '123',
        'mikoto yuria',
        'ชาย',
        '1234567890123',
        '54 mo 5 ban khokklang district.lumpuk area.khamkhuankeao province.yasothon',
        26,
        'kk@kk.com'
    );