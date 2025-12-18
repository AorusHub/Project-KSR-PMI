describe('Admin - Validation Kegiatan Donor', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/kegiatan-donor/create', { failOnStatusCode: false })
  })

  it('Nama kegiatan wajib diisi', () => {
    cy.get('textarea[name="deskripsi"]').type('Deskripsi test')
    cy.get('input[name="tanggal"]').type('2025-12-30')
    cy.get('input[name="lokasi"]').type('Test Location')
    cy.get('input[name="kuota"]').type('50')
    cy.get('button[type="submit"]').click()
    
    cy.contains(/nama.*wajib|required/i).should('be.visible')
  })

  it('Tanggal wajib diisi', () => {
    cy.get('input[name="nama_kegiatan"]').type('Test Kegiatan')
    cy.get('input[name="lokasi"]').type('Test Location')
    cy.get('input[name="kuota"]').type('50')
    cy.get('button[type="submit"]').click()
    
    cy.contains(/tanggal.*wajib|required/i).should('be.visible')
  })

  it('Lokasi wajib diisi', () => {
    cy.get('input[name="nama_kegiatan"]').type('Test Kegiatan')
    cy.get('input[name="tanggal"]').type('2025-12-30')
    cy.get('input[name="kuota"]').type('50')
    cy.get('button[type="submit"]').click()
    
    cy.contains(/lokasi.*wajib|required/i).should('be.visible')
  })

  it('Kuota wajib diisi', () => {
    cy.get('input[name="nama_kegiatan"]').type('Test Kegiatan')
    cy.get('input[name="tanggal"]').type('2025-12-30')
    cy.get('input[name="lokasi"]').type('Test Location')
    cy.get('button[type="submit"]').click()
    
    cy.contains(/kuota.*wajib|required/i).should('be.visible')
  })

  it('Tanggal tidak boleh masa lalu', () => {
    cy.fixture('kegiatan-donor').then((data) => {
      cy.get('input[name="nama_kegiatan"]').type(data.invalid.pastDate.nama)
      cy.get('input[name="tanggal"]').type(data.invalid.pastDate.tanggal)
      cy.get('input[name="lokasi"]').type(data.invalid.pastDate.lokasi)
      cy.get('input[name="kuota"]').type('50')
      cy.get('button[type="submit"]').click()
      
      cy.contains(/tanggal.*tidak valid|masa lalu|past date/i).should('be.visible')
    })
  })

  it('Kuota harus berupa angka positif', () => {
    cy.get('input[name="nama_kegiatan"]').type('Test Kegiatan')
    cy.get('input[name="tanggal"]').type('2025-12-30')
    cy.get('input[name="lokasi"]').type('Test Location')
    cy.get('input[name="kuota"]').clear().type('-10')
    cy.get('button[type="submit"]').click()
    
    cy.contains(/kuota.*positif|must be positive/i).should('be.visible')
  })

  it('Kuota harus minimal 1', () => {
    cy.get('input[name="nama_kegiatan"]').type('Test Kegiatan')
    cy.get('input[name="tanggal"]').type('2025-12-30')
    cy.get('input[name="lokasi"]').type('Test Location')
    cy.get('input[name="kuota"]').clear().type('0')
    cy.get('button[type="submit"]').click()
    
    cy.contains(/kuota.*minimal|at least 1/i).should('be.visible')
  })

  it('Nama kegiatan maksimal 255 karakter', () => {
    const longName = 'A'.repeat(300)
    cy.get('input[name="nama_kegiatan"]').type(longName)
    cy.get('button[type="submit"]').click()
    
    cy.contains(/maksimal|maximum|too long/i).should('be.visible')
  })

  it('Deskripsi bersifat opsional', () => {
    cy.get('input[name="nama_kegiatan"]').type('Test Kegiatan')
    cy.get('input[name="tanggal"]').type('2025-12-30')
    cy.get('input[name="lokasi"]').type('Test Location')
    cy.get('input[name="kuota"]').type('50')
    // Tidak mengisi deskripsi
    cy.get('button[type="submit"]').click()
    
    // Seharusnya tidak ada error deskripsi wajib
    cy.get('body').then(($body) => {
      const hasError = $body.text().match(/deskripsi.*wajib/i)
      expect(hasError).to.be.null
    })
  })
})