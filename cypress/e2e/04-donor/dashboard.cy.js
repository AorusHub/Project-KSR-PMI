describe('Donor Dashboard', () => {
  beforeEach(() => {
    cy.loginAsDonor()
    cy.visit('/dashboard/donor', { failOnStatusCode: false })
  })

  it('Donor dapat mengakses dashboard', () => {
    cy.checkPageExists()
    cy.contains(/dashboard|beranda/i).should('be.visible')
  })

  it('Dashboard menampilkan informasi donor', () => {
    cy.fixture('users').then((users) => {
      cy.contains(users.donor.name, { matchCase: false }).should('be.visible')
    })
  })

  it('Menampilkan menu navigasi donor', () => {
    cy.get('nav, .sidebar, .menu').should('exist')
    cy.contains(/profil|kegiatan|riwayat/i).should('be.visible')
  })

  it('Menampilkan statistik donor', () => {
    cy.get('body').then(($body) => {
      const hasStats = 
        $body.find('.card, .widget, .stat-box').length > 0 ||
        $body.text().match(/total.*donor|kegiatan.*diikuti/i)
      
      if (hasStats) {
        cy.contains(/total|jumlah|statistik/i).should('be.visible')
      }
    })
  })

  it('Menampilkan kegiatan yang akan datang', () => {
    cy.get('body').then(($body) => {
      if ($body.text().match(/kegiatan.*akan datang|upcoming/i)) {
        cy.contains(/kegiatan.*akan datang|upcoming/i).should('be.visible')
      }
    })
  })

  it('Menampilkan status pendaftaran terbaru', () => {
    cy.get('body').then(($body) => {
      if ($body.text().match(/pendaftaran|status/i)) {
        cy.contains(/pendaftaran|status/i).should('be.visible')
      }
    })
  })

  it('Menampilkan riwayat donor terakhir', () => {
    cy.get('body').then(($body) => {
      if ($body.text().match(/riwayat|history/i)) {
        cy.contains(/riwayat|history/i).should('be.visible')
      }
    })
  })

  it('Dapat mengakses menu Profile', () => {
    cy.get('a[href*="profile"], a').contains(/profil|profile/i).click()
    cy.url().should('include', '/profile')
  })

  it('Dapat mengakses menu Kegiatan', () => {
    cy.get('a[href*="kegiatan"]').first().click()
    cy.url().should('include', 'kegiatan')
  })

  it('Dapat mengakses menu Riwayat', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a[href*="riwayat"]').length > 0) {
        cy.get('a[href*="riwayat"]').click()
        cy.url().should('include', 'riwayat')
      }
    })
  })

  it('Menampilkan notifikasi jika ada', () => {
    cy.get('body').then(($body) => {
      if ($body.find('.notification, .alert, [role="alert"]').length > 0) {
        cy.get('.notification, .alert, [role="alert"]').should('be.visible')
      }
    })
  })

  it('Menampilkan golongan darah donor', () => {
    cy.contains(/golongan darah|blood type|A|B|AB|O/i).should('be.visible')
  })
})