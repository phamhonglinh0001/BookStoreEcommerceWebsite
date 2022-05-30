-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 26, 2022 lúc 05:59 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlydathang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdathang`
--

CREATE TABLE `chitietdathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSHH` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `GiaDatHang` int(11) DEFAULT NULL,
  `GiamGia` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietdathang`
--

INSERT INTO `chitietdathang` (`SoDonDH`, `MSHH`, `SoLuong`, `GiaDatHang`, `GiamGia`) VALUES
(15, 1, 5, 280000, 20000),
(17, 4, 7, 165000, 10000),
(18, 11, 2, 126000, 20000);

--
-- Bẫy `chitietdathang`
--
DELIMITER $$
CREATE TRIGGER `trg_delete_chitietdathang` AFTER DELETE ON `chitietdathang` FOR EACH ROW BEGIN
 UPDATE hanghoa
 SET `SoLuongHang` = `SoLuongHang` + OLD.SoLuong
 WHERE `MSHH` = OLD.MSHH;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_insert_chitietdathang` BEFORE INSERT ON `chitietdathang` FOR EACH ROW BEGIN
	DECLARE soluongton INT;
    
    SELECT `SoLuongHang` INTO soluongton FROM hanghoa WHERE `MSHH` = NEW.MSHH;
  
    IF (soluongton > 0 AND soluongton >= NEW.SoLuong) THEN 
    	UPDATE hanghoa
        SET `SoLuongHang` = `SoLuongHang` - NEW.SoLuong
        WHERE `MSHH` = NEW.MSHH;
    ELSE
    	SET NEW.MSHH = NULL;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_chitietdathang` BEFORE UPDATE ON `chitietdathang` FOR EACH ROW BEGIN
	DECLARE soluongton INT;
    
    SELECT `SoLuongHang` INTO soluongton FROM hanghoa WHERE `MSHH` = OLD.MSHH;
    
    IF (soluongton + OLD.SoLuong > 0 AND soluongton + OLD.SoLuong >= NEW.SoLuong) THEN 
    	UPDATE hanghoa
        SET `SoLuongHang` = `SoLuongHang` + OLD.SoLuong
        WHERE `MSHH` = OLD.MSHH;
    	UPDATE hanghoa
        SET `SoLuongHang` = `SoLuongHang` - NEW.SoLuong
        WHERE `MSHH` = OLD.MSHH;
    ELSE
    SET NEW.SoLuong = NULL;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dathang`
--

CREATE TABLE `dathang` (
  `SoDonDH` int(11) NOT NULL,
  `MSKH` int(11) NOT NULL,
  `MSNV` int(11) DEFAULT NULL,
  `NgayDH` datetime NOT NULL,
  `NgayGH` datetime NOT NULL CHECK (`NgayGH` > `NgayDH`),
  `TrangThaiDH` varchar(30) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `dathang`
--

INSERT INTO `dathang` (`SoDonDH`, `MSKH`, `MSNV`, `NgayDH`, `NgayGH`, `TrangThaiDH`) VALUES
(15, 1, 1, '2022-04-26 17:52:13', '2022-05-01 17:52:13', 'Đang đóng gói'),
(16, 1, NULL, '2022-04-26 17:52:26', '2022-05-01 17:52:26', 'Đã hủy'),
(17, 1, 1, '2022-04-26 17:53:22', '2022-05-01 17:53:22', 'Đang giao hàng'),
(18, 1, 1, '2022-04-26 17:54:17', '2022-04-26 22:54:38', 'Đã giao hàng');

--
-- Bẫy `dathang`
--
DELIMITER $$
CREATE TRIGGER `trg_insert_dathang` BEFORE INSERT ON `dathang` FOR EACH ROW BEGIN
 IF NEW.NgayGH < NEW.NgayDH THEN
 SET NEW.SoDonDH = NULL;
 END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_update_dathang` BEFORE UPDATE ON `dathang` FOR EACH ROW BEGIN
 IF NEW.NgayGH < OLD.NgayDH THEN
 SET NEW.SoDonDH = NULL;
 END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hanghoa`
--

CREATE TABLE `hanghoa` (
  `MSHH` int(11) NOT NULL,
  `TenHH` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL,
  `MoTaHH` text COLLATE utf8_vietnamese_ci NOT NULL,
  `Gia` int(11) NOT NULL,
  `SoLuongHang` int(11) NOT NULL,
  `GhiChu` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `hanghoa`
--

INSERT INTO `hanghoa` (`MSHH`, `TenHH`, `MoTaHH`, `Gia`, `SoLuongHang`, `GhiChu`) VALUES
(1, 'Không Diệt Không Sinh Đừng Sợ Hãi', 'Nhiều người trong chúng ta tin rằng cuộc đời của ta bắt đầu từ lúc chào đời và kết thúc khi ta chết. Chúng ta tin rằng chúng ta tới từ cái Không, nên khi chết chúng ta cũng không còn lại gì hết. Và chúng ta lo lắng vì sẽ trở thành hư vô. Hãy nhớ rằng: Không Diệt Không Sinh Đừng Sợ Hãi.\r\n\r\nGiới thiệu tác giả Thích Nhất Hạnh\r\n\r\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\r\n\r\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\r\n\r\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\r\n\r\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\r\n\r\nNội dung cuốn sách\r\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\r\n\r\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\r\n\r\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\r\n\r\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\r\n\r\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\r\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 60000, 10, NULL),
(2, 'Định Vị Cá Nhân', 'Định Vị Cá Nhân là cuốn sách hay về việc thấu hiểu và xác đinh hình tượng cá nhân cho bản thân, từ đó giúp bạn phát triển sự nghiệp và chiếm được tầm ảnh hướng đến những người xung quanh.\n\nTrong cuộc sống, chúng ta đều khao khát được thành công, được người khác công nhận. Nhưng không phải ai cũng hiểu và vận dụng tốt những quy luật để đưa bản thân bước vào một cuộc hành trình được vạch định rõ ràng.\n\nĐịnh Vị Cá Nhân sẽ mang đến cho bạn những khái niệm mới mẻ như Thẻ điểm cân bằng cá nhân (TĐCBCN), một khái niệm quản trị tổng thể mới, là hành trinh tìm đến sự tự nhận thức, tự khám phá và tự đánh giá, dựa trên một số tiêu chí quan trọng, hướng đến sự phát triển liên tục và sử dụng các khả năng cá nhân.\nGiới thiệu tác giả Thích Nhất Hạnh\n\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\n\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\n\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\n\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\n\nNội dung cuốn sách\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\n\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\n\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\n\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\n\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 38000, 11, NULL),
(3, 'Sinh Ra Là Một Bản Thể, Đừng Chết Như Một Bản Sao', 'Bạn luôn cảm thấy bản thâm mình thấp bé và kém cỏi hơn người khác? Nếu đúng như vậy thì đây chính là thời điểm bạn đọc cuốn Sinh Ra Là Một Bản Thể, Đừng Chết Như Một Bản Sao.\n\nSinh Ra Là Một Bản Thể, Đừng Chết Như Một Bản Sao sẽ giúp bạn học cách trân trọng những tài năng đặc biệt của mình để trở thành chính con người mình, không cần phải ghen tị, so sánh với bất kỳ ai.\n\nThượng Đế khi tạo ra bạn đã cho bạn một sứ mệnh và không ai khác có thể hoàn thành điều đó tốt hơn chính bạn. Ngài không chờ đợi bạn hoàn hảo, nhưng Ngài muốn bạn sử dụng tất cả những tài năng, sức mạnh mà Ngài đã ban tặng cho bạn để làm chính con người mình.', 78000, 55, NULL),
(4, 'Ngũ Luân Thư', 'Tác giả của Ngũ Luân Thư là Miyamoto Musashi, một thư sĩ, thư pháp gia, hoạ sĩ và trên hết là một chiến binh huyền thoại với cuốn sách nổi tiếng Con Đường Kiếm Thuật được mệnh danh là Binh Pháp Tôn Tử của Nhật Bản.\n\nDoanh nhân Nhật Bản không được huấn luyện và giảng dạy tại những nơi như trường Đại học Havard. Tuy nhiên, họ học hỏi, sống và làm việc theo cuốn sách được viết vào năm 1645 bởi Samurai huyền thoại, Miyamoto Musashi.\n\nMusashi là chiến binh nổi tiếng nhất của Nhật Bản. Đến năm 30 tuổi ông, đã giành chiến thắng trong 60 cuộc đọ kiếm. Cuối cùng, Musashi bất khả chiến bại lui về một hang đá và viết cuốn Ngũ Luân Thư  để truyền cho hậu thế.', 25000, 15, NULL),
(5, 'Phớt Lờ Tất Cả Bơ Đi Mà Sống', 'Với 40 phần, thực ra là 40 bài học ngắn gọn, súc tích, kết hợp với tranh biếm họa và các “châm ngôn” hài hước nhưng ý nghĩa, Phớt Lờ Tất Cả Bơ Đi Mà Sống chính là câu trả lời cho các câu hỏi không ngừng đặt ra trong đầu chúng ta suốt quá trình làm việc.\n\nMỗi câu hỏi đều có câu trả lời thỏa đáng. Nhưng điều này không đồng nghĩa với việc độc giả ngấu nghiến cuốn sách này xong là có thể khơi mở được ngay lập tức nguồn lực sáng tạo trong mình và tung trải nó ra ngoài thế giới.\n\nĐể những bạn trẻ không ảo tưởng rằng nghệ sĩ được phép la cà ở các quán bar suốt cả ngày, mong đợi Nàng Thơ bất ngờ gõ cửa, ban cho một nguồn cảm hứng vô tận, khiến họ viết ngay ra được tác phẩm bất hủ và một bước lên đỉnh vinh quang.\nGiới thiệu tác giả Thích Nhất Hạnh\n\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\n\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\n\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\n\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\n\nNội dung cuốn sách\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\n\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\n\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\n\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\n\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 68000, 10, NULL),
(6, 'Sức Mạnh Của Tĩnh Lặng', 'Sức Mạnh Của Tĩnh Lặng là tác phẩm tâm linh rất ngắn ngọn nhưng sâu sắc của Eckhart Tolle, tác giả được The New York Times bình chọn là một trong những tác giả có sách bán chạy nhất.\n\nĐây là một cuốn sách hữu ích và thiết thực cho những ai muốn tiếp xúc với bản chất sâu lắng, trong sáng và chân thật trong con người mình.\n\nCuốn sách có thể giúp bạn vun bồi sự vững chải, khả năng trầm lắng ở tâm hồn bên ngoài đang xảy ra những biến động gì đi nữa.\n\nSức Mạnh Của Tĩnh Lặng có thể giúp bạn vượt qua những tình huống thử thách trong đời sống cá nhân và tiếp xúc được với một chiều không gian yên tĩnh và an bình ở bên trong.\nGiới thiệu tác giả Thích Nhất Hạnh\n\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\n\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\n\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\n\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\n\nNội dung cuốn sách\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\n\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\n\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\n\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\n\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 35000, 81, NULL),
(7, 'Phi Lý Trí', 'Một tai nạn đã dẫn tôi tới tư duy Phi Lý Trí cùng những nghiên cứu được miêu tả trong cuốn sách này Nhiều người nói rằng tôi có thế giới quan thật lạ lùng.\n\nHai mươi năm nghiên cứu đã mang đến cho tôi nhiều hứng thú để khám phá điều gì thật sự ảnh hưởng tới các quyết định mà chúng ta đưa ra trong cuộc sống hàng ngày (trái với điều chúng ta nghĩ, thường tin tưởng sâu sắc rằng chúng có ảnh hưởng tới các quyết định).\n\nKhi đọc tới những trang cuối của Phi Lý Trí, bạn sẽ có câu trả lời cho những câu hỏi có ý nghĩa nhất định đối với cuộc sống, công việc kinh doanh và thế giới quan của bạn.\n\nVí dụ, hiểu rõ câu trả lời về thuốc giảm đau không chỉ giúp bạn trong việc lựa chọn thuốc mà còn có ý nghĩa với một trong những vấn đề lớn nhất mà xã hội đang phải đối mặt: chi phí và hiệu quả của bảo hiểm y tế.\nGiới thiệu tác giả Thích Nhất Hạnh\n\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\n\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\n\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\n\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\n\nNội dung cuốn sách\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\n\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\n\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\n\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\n\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 45000, 35, NULL),
(8, 'Cuốn sách hoàn hảo về ngôn ngữ cơ thể', 'Cuốn sách hoàn hảo về ngôn ngữ cơ thể là những giải mã thú vị về bề ngoài của con người. Ví dụ điển hình như Angelina Jolie luôn phơi bày bờ môi gợi cảm ‘chết người’, Adolf Hitler thích sử dụng bàn tay úp ngược, vươn thẳng khi khẳng định quyền lực.\n\nTrong cuộc sống, hầu như ai cũng bị chi phối quá nhiều bởi lời nói, vì thế đôi khi chúng ta quên rằng, cơ thể con người là bộ ‘từ điển sống’.\n\nCuốn sách hoàn hảo về ngôn ngữ cơ thể là cẩm nang thú vị để bước vào bộ từ điển này “Từ móng tay, tay áo, đôi ủng, đầu gối quần đến những vết chai ở ngón trỏ và ngón cái hay nét mặt, cổ tay áo, tác phong của một người đều nói lên nghề nghiệp của họ.\nGiới thiệu tác giả Thích Nhất Hạnh\n\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\n\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\n\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\n\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\n\nNội dung cuốn sách\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\n\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\n\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\n\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\n\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 71000, 41, NULL),
(9, 'Trí Tuệ Xúc Cảm – Ứng Dụng Trong Công Việc', 'Yếu tố quyết định thành công không phải là chỉ số IQ, không phải một bằng đại học quản trị kinh doanh, thậm chí không phải bí quyết kinh doanh hay nhiều năm kinh nghiệm mà ở chính chỉ số cảm xúc EQ.\n\nTrí Tuệ Xúc Cảm cảm là một tập hợp những kỹ năng mà bất cứ ai cũng có được và trong cuốn chỉ dẫn thiết thực này, Daniel Goleman đã nhận biết, giải thích về tầm quan trọng của trí tuệ xúc cảm, và chỉ ra cách thức để nuôi dưỡng, phát triển chúng.\n\n90% các yếu tố quyết định sự nổi trội trong sự nghiệp của các nhà lãnh đạo là trí tuệ xúc cảm. Theo Goleman, nó là thành phầm thiết yếu để đạt được và giữ nguyên vị trí đứng đầu trong bất kỳ lĩnh vực nào, thậm chí trong cả lĩnh vực công nghệ cao.\nGiới thiệu tác giả Thích Nhất Hạnh\n\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\n\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\n\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\n\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\n\nNội dung cuốn sách\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\n\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\n\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\n\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\n\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 99000, 33, NULL),
(10, 'Những Bậc Thầy Thành Công', 'Không ai trong chúng ta lại không mong muốn đạt được thành công. Nhưng thành công là gì? Làm thế nào để thành công? Đâu là thước đo của thành công? Tất cả sẽ có trong Những Bậc Thầy Thành Công.\n\nNếu bạn cũng đang trên hành trình kiếm tìm câu trả lời thì Những bậc thầy thành công (Master of Success) sẽ là tấm bản đồ hữu ích cho bạn. Xuyên suốt trong cuốn sách này là hàng loạt câu chuyện về những con người đã làm chủ được một nghệ thuật – nghệ thuật thành công.\n\nRất nhiều người trong số họ là nhân vật nổi tiếng mà hầu hết chúng ta đều nghe danh, nhưng cũng có nhiều người chúng ta chưa từng biết tới. Có người đi đến thành công sau bao lần mất mát, trả giá. Có người thành công với vô số vết thương của những vấp ngã, sai lầm.\nGiới thiệu tác giả Thích Nhất Hạnh\n\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\n\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\n\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\n\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\n\nNội dung cuốn sách\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\n\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\n\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\n\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\n\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 63000, 20, NULL),
(11, 'Những cuộc phiêu lưu của Huckleberry Finn', 'Những cuộc phiêu lưu của Huckleberry Finn được đánh giá là một trong những tác phẩm vĩ đại nhất trong nền văn học Hoa Kỳ.\n\nCâu chuyện về cậu bé Huck thông minh, dũng cảm, nhân hậu và Jim, người bạn da đen của Huck trên con sông Mississippi và miền đất dọc theo dòng sông này.\n\nBạn đọc sẽ có nhiều phen thót tim và hồi hộp với những câu chuyện đầy hấp dẫn, ly kỳ của Huck cùng và Jim.\n\nNgay từ khi được xuất bản, Huckleberry Finn đã gây nhiều tranh cãi. Thư viện tại Concord, Massachussetts đã cấm lưu hành quyển này sau khi nó được xuất bản vì “đề tài lòe loẹt”.\nGiới thiệu tác giả Thích Nhất Hạnh\n\nThích Nhất Hạnh (tên khai sinh Nguyễn Xuân Bảo, sinh ngày 11 tháng 10 năm 1926) là một thiền sư, giảng viên, nhà văn, nhà thơ, nhà khảo cứu, nhà hoạt động xã hội, và người vận động cho hòa bình người Việt Nam.\n\nÔng sinh ra ở Thừa Thiên-Huế, miền Trung Việt Nam, xuất gia theo Thiền tông vào năm 16 tuổi, trở thành một nhà sư vào năm 1949. Ông là người đưa ra khái niệm “Phật giáo dấn thân” (engaged Buddhism) trong cuốn sách Vietnam: Lotus in a Sea of Fire.\n\nThiền sư Thích Nhất Hạnh đã viết hơn 100 cuốn sách, trong số đó hơn 40 cuốn bằng tiếng Anh. Ông là người vận động cho phong trào hòa bình, với các giải pháp không bạo lực cho các mâu thuẫn.\n\nMột số tác phẩm của ông: Con sư tử vàng của thầy Pháp Tạng – Nẻo về của ý – Am mây ngủ – Văn Lang dị sử – Đường xưa mây trắng – Truyện Kiều văn xuôi – Thả một bè lau – Bông hồng cài áo – Đạo Phật ngày nay – Nói với tuổi hai mươi – Trái tim của Bụt…\n\nNội dung cuốn sách\nBụt có cái hiểu rất khác về cuộc đời. Ngài hiểu rằng sống và chết chỉ là những ý niệm không có thực. Coi đó là sự thực, chính là nguyên do gây cho chúng ta khổ não. Bụt dạy không có sinh, không có diệt, không tới cũng không đi, không giống nhau cũng không khác nhau, không có cái ngã thường hằng cũng không có hư vô. Chúng ta thì coi là Có hết mọi thứ. Khi chúng ta hiểu rằng mình không bị hủy diệt thì chúng ta không còn lo sợ. Đó là sự giải thoát. Chúng ta có thể an hưởng và thưởng thức đời sống một cách mới mẻ.\n\nKhông Diệt Không Sinh Đừng Sợ Hãi là tựa sách được Thiền sư Thích Nhất Hạnh viết nên dựa trên kinh nghiệm của chính mình. Ở đó, Thầy Nhất Hạnh đã đưa ra một thay thế đáng ngạc nhiên cho hai triết lý trái ngược nhau về vĩnh cửu và hư không: “Tự muôn đời tôi vẫn tự do. Tử sinh chỉ là cửa ngõ ra vào, tử sinh là trò chơi cút bắt. Tôi chưa bao giờ từng sinh cũng chưa bao giờ từng diệt” và “Nỗi khổ lớn nhất của chúng ta là ý niệm về đến-đi, lui-tới.”\n\nĐược lặp đi lặp lại nhiều lần, Thầy khuyên chúng ta thực tập nhìn sâu để chúng ta hiểu được và tự mình nếm được sự tự do của con đường chính giữa, không bị kẹt vào cả hai ý niệm của vĩnh cửu và hư không. Là một thi sĩ nên khi giải thích về các sự trái ngược trong đời sống, Thầy đã nhẹ nhàng vén bức màn vô minh ảo tưởng dùm chúng ta, cho phép chúng ta (có lẽ lần đầu tiên trong đời) được biết rằng sự kinh hoàng về cái chết chỉ có nguyên nhân là các ý niệm và hiểu biết sai lầm của chính mình mà thôi.\n\nTri kiến về sống, chết của Thầy vô cùng vi tế và đẹp đẽ. Cũng như những điều vi tế, đẹp đẽ khác, cách thưởng thức hay nhất là thiền quán trong thinh lặng. Lòng nhân hậu và từ bi phát xuất từ suối nguồn thâm tuệ của Thiền sư Thích Nhất Hạnh là một loại thuốc chữa lành những vết thương trong trái tim chúng ta.\n\nReview sách Không Diệt Không Sinh Đừng Sợ Hãi\nNội dung  nhẹ nhàng, sâu sắc, thầy dùng những hình ảnh so sánh, ẩn dụ để miêu tả cho chúng ta hiểu được tại sao vạn vật lại liên hệ với nhau, tại sao tôi là tất cả và tất cả là tôi. Khi đọc xong cảm thấy phải trân trọng bản thân mình hơn vì mình là một biểu hiện của cha mẹ, ông bà, của tất cả vạn vật. Rất nên đọc nha mọi người. (Hà Linh)', 73000, 17, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinhhh`
--

CREATE TABLE `hinhhh` (
  `MaHinh` int(11) NOT NULL,
  `TenHinh` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL,
  `MSHH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `hinhhh`
--

INSERT INTO `hinhhh` (`MaHinh`, `TenHinh`, `MSHH`) VALUES
(1, '1.jpg', 1),
(2, '2.jpg', 2),
(3, '3.jpg', 3),
(4, '4.jpg', 4),
(5, '5.jpg', 5),
(6, '6.jpg', 6),
(7, '7.jpg', 7),
(8, '8.jpg', 8),
(9, '9.jpg', 9),
(10, '10.jpg', 10),
(11, '11.jpg', 11);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khachhang`
--

CREATE TABLE `khachhang` (
  `MSKH` int(11) NOT NULL,
  `HoTenKH` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `Password` varchar(32) COLLATE utf8_vietnamese_ci NOT NULL,
  `DiaChi` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL,
  `SoDienThoai` varchar(10) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `khachhang`
--

INSERT INTO `khachhang` (`MSKH`, `HoTenKH`, `Password`, `DiaChi`, `SoDienThoai`) VALUES
(1, 'Phạm Hồng Linh', '202cb962ac59075b964b07152d234b70', '111, Mỹ Hòa, Mỹ Hội Đông, Chợ Mới, An Giang', '0980000004'),
(2, 'Võ Tấn Hậu', '202cb962ac59075b964b07152d234b70', '375, ấp Thị 2, Thị trấn Chợ Mới, Chợ Mới, An Giang', '0980000005'),
(3, 'Huỳnh Quốc Ngạn', '202cb962ac59075b964b07152d234b70', 'KTX A, Đại học Cần Thơ', '0980000006');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `MSNV` int(11) NOT NULL,
  `HoTenNV` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `Password` varchar(32) COLLATE utf8_vietnamese_ci NOT NULL,
  `ChucVu` varchar(20) COLLATE utf8_vietnamese_ci NOT NULL,
  `DiaChi` varchar(100) COLLATE utf8_vietnamese_ci NOT NULL,
  `SoDienThoai` varchar(10) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`MSNV`, `HoTenNV`, `Password`, `ChucVu`, `DiaChi`, `SoDienThoai`) VALUES
(1, 'Nhân viên 1', '202cb962ac59075b964b07152d234b70', 'NV', 'Mỹ Hòa, Mỹ Hội Đông, Chợ Mới, An Giang', '0980000001'),
(2, 'Admin 1', '202cb962ac59075b964b07152d234b70', 'AD', '3/2, An Bình, Ninh Kiều, Cần Thơ', '0980000002'),
(3, 'Nhân viên 2', '202cb962ac59075b964b07152d234b70', 'NV', '3/2, An Bình, Ninh Kiều, Cần Thơ', '0980000003');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD PRIMARY KEY (`SoDonDH`,`MSHH`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Chỉ mục cho bảng `dathang`
--
ALTER TABLE `dathang`
  ADD PRIMARY KEY (`SoDonDH`),
  ADD KEY `MSKH` (`MSKH`),
  ADD KEY `dathang_ibfk_2` (`MSNV`);

--
-- Chỉ mục cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  ADD PRIMARY KEY (`MSHH`);

--
-- Chỉ mục cho bảng `hinhhh`
--
ALTER TABLE `hinhhh`
  ADD PRIMARY KEY (`MaHinh`),
  ADD KEY `MSHH` (`MSHH`);

--
-- Chỉ mục cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`MSKH`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`MSNV`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dathang`
--
ALTER TABLE `dathang`
  MODIFY `SoDonDH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `hanghoa`
--
ALTER TABLE `hanghoa`
  MODIFY `MSHH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `hinhhh`
--
ALTER TABLE `hinhhh`
  MODIFY `MaHinh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `MSKH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `MSNV` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdathang`
--
ALTER TABLE `chitietdathang`
  ADD CONSTRAINT `chitietdathang_ibfk_1` FOREIGN KEY (`SoDonDH`) REFERENCES `dathang` (`SoDonDH`),
  ADD CONSTRAINT `chitietdathang_ibfk_2` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);

--
-- Các ràng buộc cho bảng `dathang`
--
ALTER TABLE `dathang`
  ADD CONSTRAINT `dathang_ibfk_1` FOREIGN KEY (`MSKH`) REFERENCES `khachhang` (`MSKH`),
  ADD CONSTRAINT `dathang_ibfk_2` FOREIGN KEY (`MSNV`) REFERENCES `nhanvien` (`MSNV`) ON DELETE NO ACTION;

--
-- Các ràng buộc cho bảng `hinhhh`
--
ALTER TABLE `hinhhh`
  ADD CONSTRAINT `hinhhh_ibfk_1` FOREIGN KEY (`MSHH`) REFERENCES `hanghoa` (`MSHH`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
