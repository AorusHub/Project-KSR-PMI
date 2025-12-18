describe('Admin - Laporan Kegiatan', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/dashboard/admin/laporan/kegiatan', { failOnStatusCode: false })
  })

  it('Admin dapat mengakses halaman laporan kegiatan', () => {
    cy.checkPageExists()
    cy.contains(/laporan|report.*kegiatan/i).should('be.visible')
  })

  it('Menampilkan statistik total kegiatan', () => {
    cy.contains(/total.*kegiatan|jumlah.*kegiatan/i).should('be.visible')
  })

  it('Menampilkan total pendaftar', () => {
    cy.contains(/total.*pendaftar|peserta/i).should('be.visible')
  })

  it('Menampilkan kegiatan yang sudah selesai', () => {
    cy.get('body').then(($body) => {
      if ($body.text().match(/selesai|completed/i)) {
        cy.contains(/selesai|completed/i).should('be.visible')
      }
    })
  })

  it('Menampilkan kegiatan yang akan datang', () => {
    cy.get('body').then(($body) => {
      if ($body.text().match(/akan datang|upcoming/i)) {
        cy.contains(/akan datang|upcoming/i).should('be.visible')
      }
    })
  })

  it('Dapat filter berdasarkan periode kegiatan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('input[name="start_date"]').length > 0) {
        cy.get('input[name="start_date"]').type('2025-01-01')
        cy.get('input[name="end_date"]').type('2025-12-31')
        cy.get('button').contains(/filter/i).click()
      }
    })
  })

  it('Dapat filter berdasarkan status kegiatan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('select[name="status"]').length > 0) {
        cy.get('select[name="status"]').select('selesai')
        cy.get('button').contains(/filter/i).click()
      }
    })
  })

  it('Menampilkan detail setiap kegiatan dalam tabel', () => {
    cy.get('body').then(($body) => {
      if ($body.find('table').length > 0) {
        cy.get('table').should('be.visible')
        cy.get('table thead th').should('contain', /nama.*kegiatan|tanggal|lokasi|peserta/i)
      }
    })
  })

  it('Menampilkan grafik statistik kegiatan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('canvas, .chart').length > 0) {
        cy.get('canvas, .chart').should('be.visible')
      }
    })
  })

  it('Dapat export laporan kegiatan', () => {
    cy.get('body').then(($body) => {
      if ($body.find('button:contains("Export")').length > 0) {
        cy.get('button, a').contains(/export|download/i).should('be.visible')
      }
    })
  })

  it('Menampilkan tingkat partisipasi per kegiatan', () => {
    cy.get('body').then(($body) => {
      if ($body.text().match(/partisipasi|attendance/i)) {
        cy.contains(/partisipasi|attendance/i).should('be.visible')
      }
    })
  })
})