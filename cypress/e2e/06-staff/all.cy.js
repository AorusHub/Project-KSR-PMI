describe('Staff - Complete Flow', () => {
  
  beforeEach(() => {
    cy.loginAsStaff()
  })

  it('FLOW 1: Verifikasi dan Approve Donor Baru', () => {
    cy.visit('/staff/donor/pending')
    cy.contains('Approve').first().click()
    cy.contains('Konfirmasi').click()
    cy.contains('Berhasil').should('be.visible')
  })

  it('FLOW 2: Approve Pendaftaran Donor ke Kegiatan', () => {
    cy.visit('/staff/pendaftaran')
    cy.contains('Approve').first().click()
    cy.contains('Konfirmasi').click()
    cy.contains('Berhasil').should('be.visible')
  })

  it('FLOW 3: Check-in Donor di Kegiatan', () => {
    cy.visit('/staff/kegiatan/1/checkin')
    cy.get('input[name="search"]').type('Donor Name')
    cy.contains('Check-in').click()
    cy.contains('Success').should('be.visible')
  })

  it('FLOW 4: Input Hasil Donor', () => {
    cy.visit('/staff/kegiatan/1/hasil')
    cy.get('select[name="status"]').select('Success')
    cy.get('input[name="kantong"]').type('1')
    cy.contains('Submit').click()
    cy.contains('Berhasil').should('be.visible')
  })

  it('FLOW 5: Generate Sertifikat', () => {
    cy.visit('/staff/sertifikat')
    cy.contains('Generate').first().click()
    cy.contains('Download').should('be.visible')
  })

  it('FLOW 6: View Laporan', () => {
    cy.visit('/staff/laporan')
    cy.get('input[name="from"]').type('2025-01-01')
    cy.get('input[name="to"]').type('2025-12-31')
    cy.contains('Generate Laporan').click()
    cy.contains('Export PDF').should('be.visible')
  })
})