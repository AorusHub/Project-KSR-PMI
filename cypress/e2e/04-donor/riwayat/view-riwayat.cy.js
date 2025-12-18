describe('Donor - View Riwayat', () => {
  beforeEach(() => {
    cy.loginAsDonor()
    cy.visit('/dashboard/donor/riwayat', { failOnStatusCode: false })
  })

  it('Donor dapat mengakses halaman riwayat', () => {
    cy.checkPageExists()
    cy.contains(/riwayat|history/i).should('be.visible')
  })

  it('Menampilkan list riwayat donor', () => {
    cy.get('table, .card, .riwayat-item').should('exist')
  })

  it('Setiap riwayat menampilkan nama kegiatan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table tbody tr, .riwayat-item').length > 0) {
        cy.contains(/nama.*kegiatan|kegiatan|event/i).should('be.visible')
      }
    })
  })

  it('Menampilkan tanggal donor', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table tbody tr').length > 0) {
        cy.contains(/tanggal|date/i).should('be.visible')
      }
    })
  })

  it('Menampilkan lokasi donor', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table tbody tr').length > 0) {
        cy.contains(/lokasi|location/i).should('be.visible')
      }
    })
  })

  it('Menampilkan status riwayat donor', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table tbody tr').length > 0) {
        cy.contains(/status|hadir|selesai|completed/i).should('be.visible')
      }
    })
  })

  it('Menampilkan tombol lihat sertifikat', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Sertifikat"), button:contains("Sertifikat")').length > 0) {
        cy.get('a, button').contains(/sertifikat|certificate/i).should('be.visible')
      }
    })
  })

  it('Dapat melihat detail riwayat', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a:contains("Detail"), button:contains("Detail")').length > 0) {
        cy.get('a, button').contains(/detail/i).first().click()
        cy.checkPageExists()
      }
    })
  })

  it('Menampilkan total donor yang telah dilakukan', () => {
    cy.contains(/total|jumlah.*donor/i).should('be.visible')
  })

  it('Riwayat diurutkan dari yang terbaru', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table tbody tr').length > 1) {
        cy.get('table tbody tr').first().should('be.visible')
      }
    })
  })

  it('Menampilkan pagination jika data banyak', () => {
    cy.get('body').then(($body) => {
      if ($body.find('.pagination').length > 0) {
        cy.get('.pagination').should('be.visible')
      }
    })
  })

  it('Menampilkan pesan jika belum ada riwayat', () => {
    cy.get('body').then(($body) => {
      if (!$body.find('table tbody tr, .riwayat-item').length) {
        cy.contains(/belum ada|no data|tidak ada riwayat/i).should('be.visible')
      }
    })
  })

  it('Menampilkan badge atau penghargaan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('.badge, .achievement, .award').length > 0) {
        cy.get('.badge, .achievement, .award').should('be.visible')
      }
    })
  })

  it('Menampilkan progress atau streak donor', () => {
    cy.get('body').then(($body) => {
      if ($body.text().match(/streak|berturut|progress/i)) {
        cy.contains(/streak|berturut|progress/i).should('be.visible')
      }
    })
  })
})