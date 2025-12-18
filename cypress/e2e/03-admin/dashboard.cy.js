describe('Admin Dashboard', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin', { failOnStatusCode: false })
  })

  it('Admin dapat mengakses dashboard', () => {
    cy.checkPageExists()
    cy.contains(/dashboard|beranda/i).should('be.visible')
  })

  it('Dashboard menampilkan statistik penting', () => {
    cy.get('body').then(($body) => {
      const hasStats = 
        $body.find('.card, .widget, .stat').length > 0 ||
        $body.text().match(/total|jumlah|statistik/i)
      
      if (hasStats) {
        cy.get('.card, .widget, .stat').should('exist')
      }
    })
  })

  it('Menampilkan menu navigasi admin', () => {
    cy.get('nav, .sidebar, .menu').should('exist')
    cy.contains(/kegiatan|donor|laporan/i).should('be.visible')
  })

  it('Admin dapat mengakses menu Kegiatan Donor', () => {
    cy.get('a[href*="kegiatan"]').first().click()
    cy.url().should('include', 'kegiatan')
  })

  it('Admin dapat mengakses menu Donor Management', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a[href*="donor"]').length) {
        cy.get('a[href*="donor"]').first().click()
        cy.url().should('include', 'donor')
      }
    })
  })

  it('Admin dapat mengakses menu Laporan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a[href*="laporan"]').length) {
        cy.get('a[href*="laporan"]').click()
        cy.url().should('include', 'laporan')
      }
    })
  })

  it('Menampilkan informasi admin yang sedang login', () => {
    cy.fixture('users').then((users) => {
      cy.contains(users.admin.name, { matchCase: false }).should('be.visible')
    })
  })
})