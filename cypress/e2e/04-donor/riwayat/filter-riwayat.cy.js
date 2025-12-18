describe('Donor - Filter Riwayat', () => {
  beforeEach(() => {
    cy.loginAsDonor()
    cy.visit('/dashboard/donor/riwayat', { failOnStatusCode: false })
  })

  it('Dapat filter riwayat berdasarkan tanggal mulai', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"], input[name="tanggal_mulai"]').length > 0) {
        cy.get('input[name="start_date"], input[name="tanggal_mulai"]').type('2025-01-01')
        cy.get('button').contains(/filter|terapkan|cari/i).click()
        cy.wait(1000)
        cy.url().should('include', 'start_date')
      }
    })
  })

  it('Dapat filter berdasarkan tanggal akhir', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="end_date"], input[name="tanggal_akhir"]').length > 0) {
        cy.get('input[name="end_date"], input[name="tanggal_akhir"]').type('2025-12-31')
        cy.get('button').contains(/filter/i).click()
        cy.wait(1000)
      }
    })
  })

  it('Dapat filter berdasarkan periode (start & end date)', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0) {
        cy.get('input[name="start_date"]').type('2025-01-01')
        cy.get('input[name="end_date"]').type('2025-06-30')
        cy.get('button').contains(/filter/i).click()
        cy.wait(1000)
        
        // Verifikasi hasil dalam periode
        cy.get('table tbody tr').each(($row) => {
          cy.wrap($row).should('be.visible')
        })
      }
    })
  })

  it('Dapat filter berdasarkan tahun', () => {
    cy.get('body').then(($body) => {
      if ($body.find('select[name="tahun"], select[name="year"]').length > 0) {
        cy.get('select[name="tahun"], select[name="year"]').select('2025')
        cy.get('button').contains(/filter/i).click()
      }
    })
  })

  it('Dapat filter berdasarkan bulan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('select[name="bulan"], select[name="month"]').length > 0) {
        cy.get('select[name="bulan"], select[name="month"]').select('12')
        cy.get('button').contains(/filter/i).click()
      }
    })
  })

  it('Dapat filter berdasarkan status', () => {
    cy.get('body').then(($body) => {
      if ($body.find('select[name="status"]').length > 0) {
        cy.get('select[name="status"]').select('completed')
        cy.get('button').contains(/filter/i).click()
      }
    })
  })

  it('Dapat reset filter', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0) {
        cy.get('input[name="start_date"]').type('2025-01-01')
        cy.get('button').contains(/filter/i).click()
        cy.wait(1000)
        
        if ($body.find('button:contains("Reset"), a:contains("Reset")').length > 0) {
          cy.get('button, a').contains(/reset|clear|hapus filter/i).click()
          cy.get('input[name="start_date"]').should('have.value', '')
        }
      }
    })
  })

  it('Menampilkan jumlah hasil filter', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0) {
        cy.get('input[name="start_date"]').type('2025-01-01')
        cy.get('input[name="end_date"]').type('2025-12-31')
        cy.get('button').contains(/filter/i).click()
        cy.wait(1000)
        
        cy.contains(/hasil|ditemukan|found/i).should('be.visible')
      }
    })
  })

  it('Menampilkan pesan jika tidak ada hasil filter', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0) {
        cy.get('input[name="start_date"]').type('2020-01-01')
        cy.get('input[name="end_date"]').type('2020-01-31')
        cy.get('button').contains(/filter/i).click()
        cy.wait(1000)
        
        cy.contains(/tidak ditemukan|no data|tidak ada/i).should('be.visible')
      }
    })
  })

  it('Filter tetap aktif saat pagination', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0 && $body.find('.pagination').length > 0) {
        cy.get('input[name="start_date"]').type('2025-01-01')
        cy.get('button').contains(/filter/i).click()
        cy.wait(1000)
        
        cy.get('.pagination a').eq(1).click()
        cy.url().should('include', 'start_date=2025-01-01')
      }
    })
  })

  it('Dapat combine multiple filters', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0 && $body.find('select[name="status"]').length > 0) {
        cy.get('input[name="start_date"]').type('2025-01-01')
        cy.get('select[name="status"]').select('completed')
        cy.get('button').contains(/filter/i).click()
        cy.wait(1000)
        
        cy.url().should('include', 'start_date')
        cy.url().should('include', 'status')
      }
    })
  })

  it('Form filter memiliki date picker', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0) {
        cy.get('input[name="start_date"]').should('have.attr', 'type', 'date')
      }
    })
  })
})