describe('Admin - Read Kegiatan Donor', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
  })

  it('Admin dapat melihat halaman daftar kegiatan', () => {
    cy.checkPageExists()
    cy.contains(/daftar|kegiatan|list/i).should('be.visible')
  })

  it('Menampilkan tabel/list kegiatan donor', () => {
    cy.get('table, .card, .kegiatan-item').should('exist')
  })

  it('Menampilkan tombol tambah kegiatan baru', () => {
    cy.get('a, button').contains(/tambah|create|buat/i).should('be.visible')
  })

  it('Setiap kegiatan menampilkan informasi penting', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table tbody tr, .kegiatan-item').length > 0) {
        cy.contains(/nama|tanggal|lokasi|kuota/i).should('be.visible')
      }
    })
  })

  it('Menampilkan tombol aksi (edit, hapus)', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table tbody tr, .kegiatan-item').length > 0) {
        cy.get('a, button').contains(/edit|ubah/i).should('exist')
        cy.get('a, button').contains(/hapus|delete/i).should('exist')
      }
    })
  })

  it('Dapat melihat detail kegiatan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Detail"), button:contains("Detail")').length > 0) {
        cy.get('a, button').contains(/detail|lihat/i).first().click()
        cy.url().should('include', '/kegiatan-donor/')
      }
    })
  })

  it('Menampilkan pagination jika data banyak', () => {
    cy.get('body').then(($body) => {
      if ($body.find('.pagination, nav[aria-label="pagination"]').length > 0) {
        cy.get('.pagination').should('be.visible')
      }
    })
  })

  it('Menampilkan pesan jika belum ada data', () => {
    cy.get('body').then(($body) => {
      if (!$body.find('table tbody tr, .kegiatan-item').length) {
        cy.contains(/belum ada|tidak ada|no data/i).should('be.visible')
      }
    })
  })
})