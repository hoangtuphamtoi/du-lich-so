// ==========================================
// 1. CẤU HÌNH API POST (CSRF TOKEN)
// ==========================================
export async function post(url, body) {
    // Đọc CSRF Token động tại thời điểm gọi hàm
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    const res = await fetch(url, {
        method: 'POST',
        credentials: 'same-origin', // Gửi kèm cookie phiên
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf ?? '', // Thêm header chống CSRF
        },
        body: JSON.stringify(body),
    });

    if (res.status === 419) {
        throw new Error('Phiên làm việc đã hết hạn, vui lòng tải lại trang.');
    }
    if (!res.ok) {
        const errorData = await res.json().catch(() => ({}));
        throw new Error(errorData.message ?? 'Lỗi không xác định');
    }
    return res.json();
}

// ==========================================
// 2. KHỞI TẠO CÁC CHỨC NĂNG KHI DOM SẴN SÀNG
// ==========================================
document.addEventListener("DOMContentLoaded", function () {
    // A. Đếm ngược thời gian
    initCountdownTimer();

    // B. Các hiệu ứng giao diện trang chủ
    initTypingEffect();
    initScrollNavbar();
    initScrollReveal();
    initAnimatedCounters();
    initTiltEffect();
});

// ------------------------------------------
// A. CHỨC NĂNG ĐẾM NGƯỢC THỜI GIAN
// ------------------------------------------
function initCountdownTimer() {
    const timerBoxes = document.querySelectorAll('.s54 .tm b');
    if (timerBoxes.length < 4) return;

    // Đặt thời gian đếm ngược: 2 ngày, 14 giờ, 35 phút, 8 giây tính từ hiện tại
    let targetDate = new Date().getTime() + 
        (2 * 24 * 60 * 60 * 1000) + 
        (14 * 60 * 60 * 1000) + 
        (35 * 60 * 1000) + 
        (8 * 1000);

    const daysEl = timerBoxes[0];
    const hoursEl = timerBoxes[1];
    const minutesEl = timerBoxes[2];
    const secondsEl = timerBoxes[3];

    function updateTimer() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance <= 0) {
            clearInterval(timerInterval);
            daysEl.textContent = "00";
            hoursEl.textContent = "00";
            minutesEl.textContent = "00";
            secondsEl.textContent = "00";
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        daysEl.textContent = String(days).padStart(2, '0');
        hoursEl.textContent = String(hours).padStart(2, '0');
        minutesEl.textContent = String(minutes).padStart(2, '0');
        secondsEl.textContent = String(seconds).padStart(2, '0');
    }

    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);
}

// ------------------------------------------
// B.1. HIỆU ỨNG GÕ CHỮ TỰ ĐỘNG (TYPING)
// ------------------------------------------
function initTypingEffect() {
    const typingElement = document.getElementById("typing-text");
    if (!typingElement) return;

    const words = [
        "Việt Nam Tươi Đẹp", 
        "Vịnh Hạ Long", 
        "Thủ Đô Hà Nội", 
        "Thành Phố Đà Nẵng", 
        "Đảo Ngọc Phú Quốc"
    ];
    let wordIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    const typingSpeed = 120;
    const deletingSpeed = 60;

    function type() {
        const currentWord = words[wordIndex];
        
        if (isDeleting) {
            typingElement.textContent = currentWord.substring(0, charIndex - 1);
            charIndex--;
        } else {
            typingElement.textContent = currentWord.substring(0, charIndex + 1);
            charIndex++;
        }

        if (!isDeleting && charIndex === currentWord.length) {
            isDeleting = true;
            setTimeout(type, 1500);
            return;
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            wordIndex = (wordIndex + 1) % words.length;
        }

        setTimeout(type, isDeleting ? deletingSpeed : typingSpeed);
    }

    type();
}

// ------------------------------------------
// B.2. THAY ĐỔI THANH NAVBAR KHI CUỘN TRANG
// ------------------------------------------
function initScrollNavbar() {
    const navbar = document.getElementById("navbar");
    if (!navbar) return;

    window.addEventListener("scroll", () => {
        if (window.scrollY > 20) {
            navbar.classList.add("bg-white/80", "backdrop-blur-md", "shadow-sm");
            navbar.classList.remove("py-4");
            navbar.classList.add("py-3");
        } else {
            navbar.classList.remove("bg-white/80", "backdrop-blur-md", "shadow-sm");
            navbar.classList.remove("py-3");
            navbar.classList.add("py-4");
        }
    });
}

// ------------------------------------------
// B.3. TRƯỢT HIỆN NỘI DUNG KHI CUỘN (SCROLL REVEAL)
// ------------------------------------------
function initScrollReveal() {
    const reveals = document.querySelectorAll(".reveal");
    if (!reveals.length) return;

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("active");
            }
        });
    }, { threshold: 0.1 });

    reveals.forEach(el => revealObserver.observe(el));
}

// ------------------------------------------
// B.4. ĐẾM SỐ TĂNG DẦN (ANIMATED COUNTER)
// ------------------------------------------
function initAnimatedCounters() {
    const counters = document.querySelectorAll('.counter');
    if (!counters.length) return;

    const counterObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = +counter.getAttribute('data-target');
                let count = 0;
                const speed = target / 50;

                const updateCount = () => {
                    count += speed;
                    if (count < target) {
                        counter.innerText = Math.ceil(count);
                        setTimeout(updateCount, 30);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
                observer.unobserve(counter);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => counterObserver.observe(counter));
}

// ------------------------------------------
// B.5. THẺ NGHIÊNG 3D THEO CON TRỎ CHUỘT
// ------------------------------------------
function initTiltEffect() {
    const heroCard = document.getElementById('heroCard');
    if (!heroCard) return;

    heroCard.addEventListener('mousemove', (e) => {
        const rect = heroCard.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        heroCard.style.transform = `perspective(1000px) rotateX(${-y / 15}deg) rotateY(${x / 15}deg)`;
    });

    heroCard.addEventListener('mouseleave', () => {
        heroCard.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg)';
    });
}