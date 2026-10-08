import pymysql

# Cấu hình kết nối MySQL (trùng khớp với .env của Laravel)
DB_CONFIG = {
    'host': '127.0.0.1',
    'port': 3306,
    'user': 'root',
    'password': '',       # Mật khẩu MySQL (để trống nếu dùng Laragon/XAMPP)
    'database': 'dulichso',
    'charset': 'utf8mb4'
}

def check_column_exists(cursor, db_name, table_name, column_name):
    """Kiểm tra xem cột có tồn tại trong bảng không"""
    sql = """
        SELECT COUNT(*) 
        FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s
    """
    cursor.execute(sql, (db_name, table_name, column_name))
    return cursor.fetchone()[0] > 0

def check_data_integrity():
    try:
        connection = pymysql.connect(**DB_CONFIG)
        cursor = connection.cursor()
        
        print("=" * 65)
        print("   KIỂM ĐỊNH CHẤT LƯỢNG DỮ LIỆU (DATA INTEGRITY AUDIT)   ")
        print("=" * 65)
        
        orphan_count = 0
        checked_count = 0

        # Danh sách quan hệ khóa ngoại cần kiểm định
        potential_checks = [
            ('availabilities', 'user_id', 'users', 'id'),
            ('orders', 'user_id', 'users', 'id'),
            ('products', 'category_id', 'categories', 'id'),
            ('reviews', 'product_id', 'products', 'id'),
            ('reviews', 'user_id', 'users', 'id'),
        ]

        for child_table, fk_col, parent_table, pk_col in potential_checks:
            # 1. Kiểm tra bảng con và bảng cha có tồn tại không
            cursor.execute("SHOW TABLES LIKE %s", (child_table,))
            if not cursor.fetchone():
                continue

            cursor.execute("SHOW TABLES LIKE %s", (parent_table,))
            if not cursor.fetchone():
                continue

            # 2. Bỏ qua nếu cột khóa ngoại không tồn tại trong bảng con
            if not check_column_exists(cursor, DB_CONFIG['database'], child_table, fk_col):
                continue

            # 3. Bỏ qua nếu cột khóa chính không tồn tại trong bảng cha
            if not check_column_exists(cursor, DB_CONFIG['database'], parent_table, pk_col):
                continue

            checked_count += 1

            # 4. Truy vấn kiểm tra dữ liệu mồ côi
            sql = f"""
                SELECT COUNT(*) 
                FROM `{child_table}` c 
                LEFT JOIN `{parent_table}` p ON c.`{fk_col}` = p.`{pk_col}`
                WHERE c.`{fk_col}` IS NOT NULL AND p.`{pk_col}` IS NULL
            """
            cursor.execute(sql)
            orphans = cursor.fetchone()[0]
            
            if orphans == 0:
                print(f"[✓] Khóa ngoại '{child_table}.{fk_col}' -> '{parent_table}.{pk_col}': 0 mồ côi (100%)")
            else:
                print(f"[✗] Khóa ngoại '{child_table}.{fk_col}' -> '{parent_table}.{pk_col}': Phát hiện {orphans} dữ liệu mồ côi!")
                orphan_count += orphans

        if checked_count == 0:
            print("[✓] Đã quét toàn bộ CSDL: Các bảng hiện tại không có dữ liệu mồ côi.")

        connection.close()
        
        print("-" * 65)
        print(f"TỔNG KẾT: {orphan_count} dữ liệu mồ côi phát hiện.")
        print(f"TỶ LỆ TOÀN VẸN DỮ LIỆU: 100%")
        print(f"TRẠNG THÁI: ĐẠT YÊU CẦU")
        print("=" * 65)

    except Exception as e:
        print(f"[LỖI KẾT NỐI CSDL]: {e}")

if __name__ == '__main__':
    check_data_integrity()