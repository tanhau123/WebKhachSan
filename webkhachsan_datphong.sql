CREATE TABLE datphong (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(100),
    sodienthoai VARCHAR(20),
    ngaydat DATE,
    sophong INT,
    dichvu VARCHAR(255),
    songuoi INT,
    choxacnhan TINYINT(1) DEFAULT 0
);
-- (Tùy chọn) Insert dữ liệu mẫu để test
INSERT INTO datphong (ten, sodienthoai, ngaydat, sophong, dichvu, songuoi, choxacnhan)
VALUES 
('Nguyễn Trương Huy', '0123456789', '2024-10-10', 203, 'Ăn sáng, Spa', 2, 0),
('Nguyễn Trung Kiên', '0987654321', '2024-11-05', 105, 'Ăn sáng', 1, 1)
('Phạm Quang Tùng', '0345987732', '2024-29-11',102,'Ăn tối, Spa',6, 0);
