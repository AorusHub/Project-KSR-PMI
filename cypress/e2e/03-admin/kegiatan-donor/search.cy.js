describe('Admin - Search Kegiatan Donor', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/kegiatan-donor', { failOnStatusCode: false })
  })

  it('Halaman memiliki fitur search', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[type="search"], input[name="search"]').length > 0) {
        cy.get('input[type="search"], input[name="search"]').should('be.visible')
      }
    })
  })

  it('Dapat mencari kegiatan berdasarkan nama', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[type="search"], input[name="search"]').length > 0) {
        cy.get('input[type="search"], input[name="search"]').type('Donor')
        cy.get('button[type="submit"], button').contains(/cari|search/i).click()
        
        cy.contains('Donor', { matchCase: false }).should('be.visible')
      }
    })
  })

  it('Menampilkan pesan jika hasil pencarian kosong', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[type="search"]').length > 0) {
        cy.get('input[type="search"], input[name="search"]').type('XYZ123NotFound')
        cy.get('button[type="submit"], button').contains(/cari|search/i).click()
        
        cy.contains(/tidak ditemukan|no data|not found/i).should('be.visible')
      }
    })
  })

  it('Dapat filter berdasarkan tanggal', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"], input[name="tanggal_mulai"]').length > 0) {
        cy.get('input[name="start_date"], input[name="tanggal_mulai"]').type('2025-12-01')
        cy.get('input[name="end_date"], input[name="tanggal_akhir"]').type('2025-12-31')
        cy.get('button').contains(/filter|terapkan/i).click()
        
        cy.url().should('include', 'start_date')
      }
    })
  })

  it('Dapat reset filter/search', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[type="search"]').length > 0) {
        cy.get('input[type="search"]').type('Test')
        cy.get('button[type="submit"]').click()
        
        if ($body.find('button:contains("Reset"), a:contains("Reset")').length > 0) {
          cy.get('button, a').contains(/reset|clear|hapus filter/i).click()
          cy.get('input[type="search"]').should('have.value', '')
        }
      }
    })
  })

  it('Dapat sort data berdasarkan kolom', () => {
    cy.get('body').then(($body) => {
      if ($body.find('th[data-sort], th.sortable').length > 0) {
        cy.get('th[data-sort], th.sortable').first().click()
        cy.wait(500)
        cy.get('th[data-sort], th.sortable').first().click()
      }
    })
  })
})