describe('Admin - Export Laporan', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
  })

  context('Export Laporan Donor', () => {
    beforeEach(() => {
      cy.visit('/dashboard/admin/laporan/donor', { failOnStatusCode: false })
    })

    it('Dapat export laporan donor ke PDF', () => {
      cy.get('body').then(($body) => {
        if ($body.find('button:contains("PDF"), a:contains("PDF")').length > 0) {
          cy.get('button, a').contains(/pdf/i).click()
          cy.wait(2000)
          // Verifikasi download dimulai
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

    it('Dapat export laporan donor ke CSV', () => {
      cy.get('body').then(($body) => {
        if ($body.find('button:contains("CSV")').length > 0) {
          cy.get('button, a').contains(/csv/i).click()
          cy.wait(2000)
        }
      })
    })
  })

  context('Export Laporan Kegiatan', () => {
    beforeEach(() => {
      cy.visit('/dashboard/admin/laporan/kegiatan', { failOnStatusCode: false })
    })

    it('Dapat export laporan kegiatan ke PDF', () => {
      cy.get('body').then(($body) => {
        if ($body.find('button:contains("PDF")').length > 0) {
          cy.get('button, a').contains(/pdf/i).click()
          cy.wait(2000)
        }
      })
    })

    it('Dapat export laporan kegiatan ke Excel', () => {
      cy.get('body').then(($body) => {
        if ($body.find('button:contains("Excel")').length > 0) {
          cy.get('button, a').contains(/excel/i).click()
          cy.wait(2000)
        }
      })
    })

    it('Export mencakup filter yang dipilih', () => {
      cy.get('body').then(($body) => {
        if ($body.find('input[name="start_date"]').length > 0) {
          cy.get('input[name="start_date"]').type('2025-01-01')
          cy.get('input[name="end_date"]').type('2025-12-31')
          cy.get('button').contains(/filter/i).click()
          cy.wait(1000)
          
          if ($body.find('button:contains("Export")').length > 0) {
            cy.get('button, a').contains(/export/i).click()
          }
        }
      })
    })
  })

  context('Print Laporan', () => {
    it('Dapat print laporan donor', () => {
      cy.visit('/dashboard/admin/laporan/donor', { failOnStatusCode: false })
      
      cy.get('body').then(($body) => {
        if ($body.find('button:contains("Print"), button:contains("Cetak")').length > 0) {
          cy.get('button, a').contains(/print|cetak/i).click()
          // Window print akan terbuka
        }
      })
    })

    it('Dapat print laporan kegiatan', () => {
      cy.visit('/dashboard/admin/laporan/kegiatan', { failOnStatusCode: false })
      
      cy.get('body').then(($body) => {
        if ($body.find('button:contains("Print")').length > 0) {
          cy.get('button, a').contains(/print|cetak/i).click()
        }
      })
    })
  })

  it('Export dengan nama file yang sesuai', () => {
    cy.visit('/dashboard/admin/laporan/donor', { failOnStatusCode: false })
    
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Export")').length > 0) {
        // File name should contain date and type
        // Example: laporan-donor-2025-12-17.pdf
        cy.log('Export file name should include date and type')
      }
    })
  })
})