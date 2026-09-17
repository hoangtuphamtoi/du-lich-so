# Du lich so - CSE703073 Nhóm 03

## 1. Giới thiệu
Mức đề tài: DT-07. Phạm vi: sàn đặt dịch vụ lưu trú cộng đồng, đặc sản và quà lưu niệm có truy xuất nguồn gốc.

## 2. Kiến trúc
- Frontend: Vue 3
- Backend: Laravel 11
- Database: MySQL 8
- AI & Data Service: FastAPI (python-service)
- Sơ đồ kiến trúc: docs/architecture.png

## 3. Yêu cầu môi trường
- PHP >= 8.2
- Composer >= 2.7
- MySQL >= 8.0
- Node >= 20
- Python >= 3.11

## 4. Cài đặt nhanh bằng Docker
cp .env.example .env
docker compose up -d --build
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
# Mở http://localhost:8080

## 5. Cài đặt thủ công
(Các bước chi tiết cho backend, frontend, python-service)

## 6. Tài khoản kiểm thử
| Vai trò | Tài khoản | Mật khẩu |
|---|---|---|
| Quản trị | admin@demo.test | ... |

## 7. Thành viên và phân công
| Họ tên | MSSV | Vai trò | Phạm vi phụ trách |
|---|---|---|---|
| Phạm Xuân Phán | [Mã số sinh viên] | Thành viên | [Phần việc được phân công] |

## 8. Giấy phép và nguồn dữ liệu
Nguồn dữ liệu: ... (ghi rõ điều kiện sử dụng lại)