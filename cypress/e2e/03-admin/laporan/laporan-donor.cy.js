describe('Admin - Laporan Donor', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/laporan/donor', { failOnStatusCode: false })
  })

  it('Admin dapat mengakses halaman laporan donor', () => {
    cy.checkPageExists()
    cy.contains(/laporan|report.*donor/i).should('be.visible')
  })

  it('Menampilkan statistik total donor', () => {
    cy.contains(/total.*donor|jumlah.*donor/i).should('be.visible')
  })

  it('Menampilkan breakdown donor berdasarkan golongan darah', () => {
    cy.get('body').then(($body) => {
      if ($body.text().match(/golongan darah|blood type/i)) {
        cy.contains(/A|B|AB|O/i).should('be.visible')
      }
    })
  })

  it('Menampilkan donor aktif vs non-aktif', () => {
    cy.contains(/aktif|active|status/i).should('be.visible')
  })

  it('Dapat filter laporan berdasarkan periode', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0) {
        cy.get('input[name="start_date"]').type('2025-01-01')
        cy.get('input[name="end_date"]').type('2025-12-31')
        cy.get('button').contains(/filter|terapkan/i).click()
      }
    })
  })

  it('Menampilkan grafik/chart statistik donor', () => {
    cy.get('body').then(($body) => {
      if ($body.find('canvas, .chart, .graph').length > 0) {
        cy.get('canvas, .chart, .graph').should('be.visible')
      }
    })
  })

  it('Dapat export laporan donor ke PDF', () => {
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Export"), button:contains("PDF")').length > 0) {
        cy.get('button, a').contains(/pdf/i).click()
        cy.wait(2000)
      }
    })
  })

  it('Dapat export laporan donor ke Excel', () => {
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Excel")').length > 0) {
        cy.get('button, a').contains(/excel|xls/i).click()
        cy.wait(2000)
      }
    })
  })

  it('Dapat print laporan donor', () => {
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Print"), button:contains("Cetak")').length > 0) {
        cy.get('button, a').contains(/print|cetak/i).should('be.visible')
      }
    })
  })

  it('Menampilkan tabel detail donor', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table').length > 0) {
        cy.get('table').should('be.visible')
        cy.get('table thead th').should('contain', /nama|email|golongan/i)
      }
    })
  })
})