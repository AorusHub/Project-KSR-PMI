export const authSelectors = {
  emailInput: 'input[name="email"]',
  passwordInput: 'input[name="password"]',
  nameInput: 'input[name="name"]',
  submitButton: 'button[type="submit"]',
  registerLink: 'a[href*="register"]',
  loginLink: 'a[href*="login"]',
  logoutButton: 'a[href*="logout"], button:contains("Logout")'
}

export const kegiatanDonorSelectors = {
  namaInput: 'input[name="nama_kegiatan"]',
  deskripsiTextarea: 'textarea[name="deskripsi"]',
  tanggalInput: 'input[name="tanggal"]',
  lokasiInput: 'input[name="lokasi"]',
  kuotaInput: 'input[name="kuota"]',
  createButton: 'a:contains("Tambah"), button:contains("Create")',
  editButton: 'a:contains("Edit"), button:contains("Edit")',
  deleteButton: 'a:contains("Hapus"), button:contains("Delete")',
  detailButton: 'a:contains("Detail"), button:contains("Detail")'
}

export const donorSelectors = {
  approveButton: 'button:contains("Approve"), button:contains("Setujui")',
  rejectButton: 'button:contains("Reject"), button:contains("Tolak")',
  detailButton: 'a:contains("Detail")',
  searchInput: 'input[name="search"]',
  filterButton: 'button:contains("Filter")'
}

export const pendaftaranSelectors = {
  daftarButton: 'button:contains("Daftar")',
  cancelButton: 'button:contains("Batal")',
  statusBadge: '.badge, .status'
}

export const profileSelectors = {
  nameInput: 'input[name="name"]',
  phoneInput: 'input[name="phone"]',
  alamatTextarea: 'textarea[name="alamat"]',
  golonganDarahSelect: 'select[name="golongan_darah"]',
  editButton: 'button:contains("Edit")',
  saveButton: 'button:contains("Simpan"), button[type="submit"]'
}