document.addEventListener('DOMContentLoaded', function () {
  const searchForm = document.getElementById('searchForm');
  const searchInput = document.getElementById('searchInput');
  const menuItems = Array.from(document.querySelectorAll('.menu-item'));
  const orderForm = document.getElementById('orderForm');
  const orderInput = document.getElementById('orderInput');
  const body = document.body;
  const yearSpan = document.getElementById('year');

  // tampilkan tahun berjalan
  if (yearSpan) yearSpan.textContent = new Date().getFullYear();

  // fitur pencarian menu
  if (searchForm && searchInput) {
    searchForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const keyword = (searchInput.value || '').toLowerCase().trim();

      if (!keyword) {
        menuItems.forEach(item => { item.style.backgroundColor = ''; item.style.fontWeight = ''; });
        return;
      }

      menuItems.forEach(item => {
        const text = (item.textContent || '').toLowerCase();
        if (text.includes(keyword)) {
          item.style.backgroundColor = '#ffebcc';
          item.style.fontWeight = '700';
        } else {
          item.style.backgroundColor = '';
          item.style.fontWeight = '';
        }
      });
    });

    searchInput.addEventListener('input', function () {
      if (searchInput.value.trim() === '') {
        menuItems.forEach(i => { i.style.backgroundColor = ''; i.style.fontWeight = ''; });
      }
    });
  }

  // fitur order form
  if (orderForm && orderInput) {
    orderForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const pesanan = (orderInput.value || '').trim();
      if (!pesanan) {
        alert('Masukkan nama pesanan terlebih dahulu!');
        orderInput.focus();
        return;
      }
      alert(`Pesanan "${pesanan}" telah ditambahkan. Driver segera mengantar!`);
      orderInput.value = '';
    });
  }

  // klik menu untuk autofill
  if (menuItems.length && orderInput) {
    menuItems.forEach(item => {
      item.addEventListener('click', function () {
        const raw = item.textContent.trim();
        const parts = raw.split('—');
        const name = parts[0].trim();
        orderInput.value = name;
        orderInput.focus();
      });
    });
  }

  // tombol dark mode
  const darkToggle = document.createElement('button');
  darkToggle.type = 'button';
  darkToggle.textContent = '🌙 Dark Mode';
  darkToggle.className = 'btn btn-primary';
  darkToggle.style.marginLeft = '.5rem';

  const headerContainer = document.querySelector('.site-header .container');
  if (headerContainer) headerContainer.appendChild(darkToggle);

  darkToggle.addEventListener('click', function () {
    body.classList.toggle('dark');
    darkToggle.textContent = body.classList.contains('dark') ? '☀️ Light Mode' : '🌙 Dark Mode';
  });
});
