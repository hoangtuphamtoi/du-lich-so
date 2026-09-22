# database/seed_data.py
# Sinh du lieu mau cho CSDL dulichso. Chay: python seed_data.py > seed.sql
import random, datetime as dt

random.seed(703073)  # co dinh hat giong de tai lap duoc ket qua

# ---- 1. Danh muc va diem den: liet ke co that, co ghi nguon trong bao cao ----
CATEGORIES = [
    (1, None, "Diem den", "diem-den"),
    (2, 1, "Bien dao", "bien-dao"), (3, 1, "Nui rung", "nui-rung"),
    (4, 1, "Di san van hoa", "di-san-van-hoa"), (5, 1, "Do thi", "do-thi"),
    (6, None, "Dich vu", "dich-vu"),
    (7, 6, "Tour", "tour"), (8, 6, "Luu tru", "luu-tru"),
    (9, 6, "Ve tham quan", "ve-tham-quan"), (10, 6, "Trai nghiem", "trai-nghiem"),
]

# (ten, tinh/thanh, lat, lng, loai, mua dep, thoi luong tham quan (phut))
DESTINATIONS = [
    ("Vinh Ha Long",                "Quang Ninh",     20.9101, 107.1839, 2, "thang 10 den thang 4",  300),
    ("Quan the Trang An",          "Ninh Binh",      20.2506, 105.8956, 4, "thang 1 den thang 3",   240),
    ("Pho co Hoi An",              "Da Nang",        15.8801, 108.3380, 4, "thang 2 den thang 4",   180),
    ("Kinh thanh Hue",             "Hue",            16.4698, 107.5769, 4, "thang 1 den thang 4",   210),
    ("Ba Na Hills",                "Da Nang",        15.9950, 107.9967, 3, "thang 3 den thang 9",   360),
    ("Vuon quoc gia Phong Nha",    "Quang Tri",      17.5333, 106.1167, 3, "thang 2 den thang 8",   300),
    ("Bai bien My Khe",            "Da Nang",        16.0605, 108.2470, 2, "thang 4 den thang 8",   150),
    ("Cao nguyen Moc Chau",        "Son La",         20.8333, 104.6333, 3, "thang 11 den thang 3",  480),
    ("Thi tran Sa Pa",             "Lao Cai",        22.3364, 103.8438, 3, "thang 9 den thang 11",  480),
    ("Ho Ba Be",                   "Thai Nguyen",    22.4000, 105.6167, 3, "thang 4 den thang 10", 300),
    ("Dao Phu Quoc",               "An Giang",       10.2270, 103.9670, 2, "thang 11 den thang 4",  600),
    ("Bien Nha Trang",             "Khanh Hoa",      12.2388, 109.1967, 2, "thang 1 den thang 8",   200),
    ("Cao nguyen Da Lat",          "Lam Dong",       11.9404, 108.4583, 3, "quanh nam",            420),
    ("Cho noi Cai Rang",           "Can Tho",        10.0089, 105.7469, 5, "thang 6 den thang 11",  120),
    ("Dinh Doc Lap",               "TP Ho Chi Minh", 10.7772, 106.6958, 4, "quanh nam",            120),
    ("Ho Hoan Kiem",               "Ha Noi",         21.0287, 105.8524, 5, "thang 9 den thang 11",  90),
    ("Lang Co Loa",                "Ha Noi",         21.1189, 105.8756, 4, "quanh nam",            150),
    ("Bien Cua Lo",                "Nghe An",        18.8000, 105.7167, 2, "thang 5 den thang 8",   180),
    ("Thanh Nha Ho",               "Thanh Hoa",      20.0806, 105.6019, 4, "quanh nam",            120),
    ("Cong vien dia chat Dak Nong","Dak Lak",        12.2500, 107.6833, 3, "thang 11 den thang 4",  300),
]

PROVINCE_MULT = {"Quang Ninh": 1.15, "Da Nang": 1.20, "Ha Noi": 1.10, "TP Ho Chi Minh": 1.25, "Lam Dong": 1.05}
TYPES = ["tour", "stay", "ticket", "experience", "transfer"]
HIGH_SEASON = {1, 2, 3, 4, 7, 8, 12}  # thang cao diem chung

rows = []  # danh sach cau lenh INSERT
def esc(s): return str(s).replace("'", "''")

# ---- 2. categories ----
for cid, pid, name, slug in CATEGORIES:
    rows.append("INSERT INTO categories (id,parent_id,name,slug) VALUES "
                f"({cid},{pid if pid else 'NULL'},'{esc(name)}','{slug}');")

# ---- 3. users: 1 admin + 6 supplier + 40 customer ----
HASH = '$2y$12$P91QmXk5R.dummyHashForSeedOnlyReplaceMe0123456789abcdefg'
rows.append("INSERT INTO users (id,email,password_hash,role) VALUES "
            f"(1,'admin@demo.test','{HASH}','admin');")

uid = 1
for i in range(1, 7):
    uid += 1
    rows.append("INSERT INTO users (id,email,password_hash,role) VALUES "
                f"({uid},'supplier{i}@demo.test','{HASH}','supplier');")
    rows.append("INSERT INTO suppliers (id,user_id,name,province,status) VALUES "
                f"({i},{uid},'Cong ty dich vu du lich {i}',"
                f"'{esc(DESTINATIONS[i*3 % len(DESTINATIONS)][1])}','approved');")

cust_ids = []
for i in range(1, 41):
    uid += 1
    cust_ids.append(uid)
    rows.append("INSERT INTO users (id,email,password_hash,role) VALUES "
                f"({uid},'khach{i:03d}@demo.test','{HASH}','customer');")
    rows.append("INSERT INTO customer_profiles (user_id,full_name,phone) VALUES "
                f"({uid},'Khach hang mo phong {i:03d}','09{i:08d}');")

# ---- 4. destinations: 20 ban ghi co that ----
for i, (name, prov, lat, lng, cat, season, minutes) in enumerate(DESTINATIONS, start=1):
    slug = name.lower().replace(" ", "-")
    fee = random.choice([0, 30000, 50000, 80000, 120000, 250000])
    rows.append(
        "INSERT INTO destinations (id,category_id,name,slug,province,lat,lng,"
        "best_season,visit_minutes,entrance_fee,source_note) VALUES "
        f"({i},{cat},'{esc(name)}','{slug}','{esc(prov)}',{lat},{lng},"
        f"'{esc(season)}',{minutes},{fee},'Du lieu mo - ghi ro nguon trong Chuong 2');"
    )

# ---- 5. products: 60 ban ghi ----
pid = 0
for i in range(1, 61):
    pid += 1
    d = DESTINATIONS[(i - 1) % len(DESTINATIONS)]
    ptype = TYPES[i % len(TYPES)]
    days = {"tour": random.choice([1, 2, 3, 4]), "stay": random.choice([1, 2]),
            "ticket": 1, "experience": 1, "transfer": 1}[ptype]
    base = {"tour": 850_000, "stay": 620_000, "ticket": 150_000,
            "experience": 380_000, "transfer": 300_000}[ptype]
    base *= days * PROVINCE_MULT.get(d[1], 1.0)
    base = round(base / 10_000) * 10_000
    cap = random.choice([8, 12, 16, 20, 24, 30])
    cat = 7 if ptype == "tour" else (8 if ptype == "stay" else 9)
    title = f"{ptype.capitalize()} {d[0]} {days} ngay"
    rows.append(
        "INSERT INTO products (id,supplier_id,category_id,title,slug,type,base_price,"
        "duration_days,capacity,cancel_policy,status) VALUES "
        f"({pid},{(i % 6) + 1},{cat},'{esc(title)}','sp-{pid}','{ptype}',{base},"
        f"{days},{cap},'Huy truoc 72 gio: hoan 100%; 24-72 gio: hoan 50%','published');"
    )
    # lich trinh: 1-3 diem den moi ngay
    seq = 0
    for day in range(1, days + 1):
        for k in range(random.randint(1, 3)):
            seq += 1
            dest = random.randint(1, len(DESTINATIONS))
            rows.append("INSERT INTO itineraries (product_id,destination_id,day_no,seq_no,"
                        f"duration_min) VALUES ({pid},{dest},{day},{k+1},"
                        f"{random.choice([90,120,150,180,240])});")

# ---- 6. availabilities: 60 san pham x 6 ngay = 360 ban ghi (co tinh mua vu) ----
today = dt.date(2026, 11, 1)
for p in range(1, 61):
    for k in range(6):
        d0 = today + dt.timedelta(days=random.randint(1, 150))
        mult = 1.35 if d0.month in HIGH_SEASON else 0.9
        rows.append("INSERT IGNORE INTO availabilities (product_id,service_date,seats_total,"
                    "seats_held,seats_sold,price_override) VALUES "
                    f"({p},'{d0.isoformat()}',{random.choice([10,15,20,25])},0,0,"
                    f"ROUND((SELECT base_price FROM products WHERE id={p})*{mult},-3));")

# ---- 7. bookings + payments + reviews: 120 don ----
bid = 0
for i in range(1, 121):
    bid += 1
    p = random.randint(1, 60)
    d0 = today + dt.timedelta(days=random.randint(1, 150))
    pax = random.choice([1, 2, 3, 4, 6])
    lead = random.randint(1, 90)  # so ngay dat truoc
    # ty le huy cao hon o nhom dat som
    p_cancel = 0.28 if lead > 45 else 0.09
    r = random.random()
    status = "cancelled" if r < p_cancel else ("confirmed" if r < 0.95 else "expired")
    unit = random.choice([150_000, 320_000, 620_000, 850_000, 1_250_000])
    total = unit * pax
    code = f"BK{i:06d}{random.randint(100,999)}"[:12]
    rows.append("INSERT INTO bookings (id,code,user_id,product_id,service_date,pax,"
                "unit_price,total_amount,status) VALUES "
                f"({bid},'{code}',{random.choice(cust_ids)},{p},'{d0.isoformat()}',"
                f"{pax},{unit},{total},'{status}');")
    rows.append("INSERT INTO booking_status_logs (booking_id,from_status,to_status) "
                f"VALUES ({bid},'draft','{status}');")
    if status in ("confirmed",):
        rows.append("INSERT INTO payments (booking_id,gateway,txn_ref,amount,status,paid_at) "
                    f"VALUES ({bid},'sandbox','TXN{bid:08d}',{total},'paid',NOW());")
        if random.random() < 0.55:  # 55% don da xong co danh gia
            # diem danh gia lech ve phia tich cuc
            rating = random.choices([1, 2, 3, 4, 5], weights=[3, 5, 14, 38, 40])[0]
            rows.append("INSERT INTO reviews (booking_id,product_id,rating,content,"
                        "moderated_at) VALUES "
                        f"({bid},{p},{rating},'Y kien mo phong cho muc dich kiem thu.',NOW());")

print("SET FOREIGN_KEY_CHECKS = 0;")
print("USE dulichso;")
for r in rows:
    print(r)
print("SET FOREIGN_KEY_CHECKS = 1;")
print(f"-- Tong so cau lenh INSERT: {len(rows)}")