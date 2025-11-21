
  <style>
    .thuong-hieu-page {
      background: #f8fafc;
      color: #222;
      font-family: 'Segoe UI', sans-serif;
      padding: 50px 60px;
      min-height: 100vh;
    }

    .th-hieu-title {
      text-align: center;
      font-size: 2.4rem;
      font-weight: 700;
      margin-bottom: 40px;
      color: #111827;
    }

    .th-hieu-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(420px, 1fr));
      gap: 30px;
      justify-content: center;
      max-width: 1100px;
      margin: 0 auto;
      text-align: left;
    }

    .th-hieu-card {
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .th-hieu-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .th-hieu-img {
      position: relative;
      height: 220px;
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .th-hieu-img::after {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.3);
    }

    .th-hieu-name {
      position: relative;
      font-size: 1.8rem;
      color: #fff;
      font-weight: bold;
      z-index: 2;
      text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
    }

    .th-hieu-content {
      padding: 18px 20px 22px;
    }

    .th-hieu-content p {
      color: #4b5563;
      margin-bottom: 14px;
      font-size: 15px;
    }

    .th-hieu-row {
      display: flex;
      justify-content: space-between;
      color: #333;
      font-size: 14px;
      margin-bottom: 8px;
    }

    .th-hieu-section {
      margin-top: 10px;
    }

    .th-hieu-tags {
      margin-top: 6px;
    }

    .th-hieu-tags span {
      background: #f3f4f6;
      color: #374151;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 13px;
      margin-right: 6px;
      margin-bottom: 6px;
      display: inline-block;
      transition: all 0.2s ease;
    }

    .th-hieu-tags span:hover {
      background: #dbeafe;
      color: #1e3a8a;
    }
  </style>

  <section class="thuong-hieu-page">
    <h1 class="th-hieu-title">Thương Hiệu Nổi Bật</h1>
    <div class="th-hieu-container">

      <div class="th-hieu-card">
        <div class="th-hieu-img" style="background-image: url('HINH/apple.png');">
          <div class="th-hieu-name">Apple</div>
        </div>
        <div class="th-hieu-content">
          <p>Thiết kế tinh tế, hiệu năng mạnh mẽ với hệ điều hành iOS độc quyền.</p>
          <div class="th-hieu-row">
            <span><strong>Thành lập:</strong> 1976</span>
            <span><strong>Xuất xứ:</strong> Cupertino, California</span>
          </div>
          <div class="th-hieu-section">
            <strong>Sản phẩm nổi bật:</strong>
            <div class="th-hieu-tags">
              <span>iPhone 17</span>
              <span>iPhone 15 Pro Max</span>
              <span>iPhone 14</span>
              <span>iPhone 13 mini</span>
            </div>
          </div>
          <div class="th-hieu-section">
            <strong>Đặc trưng:</strong>
            <div class="th-hieu-tags">
              <span>iOS</span>
              <span>A-Series Chips</span>
              <span>Camera Systems</span>
              <span>Ecosystem</span>
            </div>
          </div>
        </div>
      </div>

      <div class="th-hieu-card">
        <div class="th-hieu-img" style="background-image: url('HINH/samsung.png');">
          <div class="th-hieu-name">Samsung</div>
        </div>
        <div class="th-hieu-content">
          <p>Công nghệ tiên tiến từ Hàn Quốc với dải sản phẩm đa dạng.</p>
          <div class="th-hieu-row">
            <span><strong>Thành lập:</strong> 1938</span>
            <span><strong>Xuất xứ:</strong> Seoul, Hàn Quốc</span>
          </div>
          <div class="th-hieu-section">
            <strong>Sản phẩm nổi bật:</strong>
            <div class="th-hieu-tags">
              <span>Galaxy S24 Ultra</span>
              <span>Galaxy Z Flip5</span>
              <span>Galaxy A55</span>
            </div>
          </div>
          <div class="th-hieu-section">
            <strong>Đặc trưng:</strong>
            <div class="th-hieu-tags">
              <span>Android</span>
              <span>Exynos/Snapdragon</span>
              <span>S Pen</span>
              <span>Màn hình Dynamic AMOLED</span>
            </div>
          </div>
        </div>
      </div>

      <div class="th-hieu-card">
        <div class="th-hieu-img" style="background-image: url('HINH/xiaomi.png');">
          <div class="th-hieu-name">Xiaomi</div>
        </div>
        <div class="th-hieu-content">
          <p>Thương hiệu Trung Quốc nổi tiếng với giá trị vượt trội và công nghệ hiện đại.</p>
          <div class="th-hieu-row">
            <span><strong>Thành lập:</strong> 2010</span>
            <span><strong>Xuất xứ:</strong> Bắc Kinh, Trung Quốc</span>
          </div>
          <div class="th-hieu-section">
            <strong>Sản phẩm nổi bật:</strong>
            <div class="th-hieu-tags">
              <span>Xiaomi 14 Ultra</span>
              <span>Redmi Note 13 Pro+</span>
            </div>
          </div>
          <div class="th-hieu-section">
            <strong>Đặc trưng:</strong>
            <div class="th-hieu-tags">
              <span>HyperOS</span>
              <span>Giá thành tốt</span>
              <span>Cấu hình mạnh</span>
            </div>
          </div>
        </div>
      </div>

      <div class="th-hieu-card">
        <div class="th-hieu-img" style="background-image: url('HINH/oppo.png');">
          <div class="th-hieu-name">Oppo</div>
        </div>
        <div class="th-hieu-content">
          <p>Oppo nổi tiếng với thiết kế thời trang và công nghệ camera selfie tiên tiến.</p>
          <div class="th-hieu-row">
            <span><strong>Thành lập:</strong> 2004</span>
            <span><strong>Xuất xứ:</strong> Đông Hoản, Trung Quốc</span>
          </div>
          <div class="th-hieu-section">
            <strong>Sản phẩm nổi bật:</strong>
            <div class="th-hieu-tags">
              <span>Oppo Reno10 Pro</span>
            </div>
          </div>
          <div class="th-hieu-section">
            <strong>Đặc trưng:</strong>
            <div class="th-hieu-tags">
              <span>Camera AI</span>
              <span>Sạc nhanh SuperVOOC</span>
              <span>Thiết kế mỏng nhẹ</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
