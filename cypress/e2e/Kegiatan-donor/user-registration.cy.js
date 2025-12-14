// cypress/e2e/kegiatan-donor/user-registration.cy.js

describe('Kegiatan Donor - User Registration', () => {
  beforeEach(() => {
    cy.loginAsPendonor()
    cy.visit('/kegiatan')
  })

  it('should allow registered user to view activities', () => {
    cy.get('.kegiatan-card').should('have.length.at.least', 1)
  })

  it('should successfully register for an activity', () => {
    cy.get('.kegiatan-card').first().click()
    cy.get('button').contains('Daftar').click()
    
    cy.get('.alert-success, .swal2-success').should('be.visible')
    cy.contains('Berhasil mendaftar').should('be.visible')
  })

  it('should prevent double registration', () => {
    cy.intercept('POST', '/kegiatan/*/daftar').as('daftar')
    
    cy.get('.kegiatan-card').first().click()
    cy.get('button').contains('Daftar').click()
    cy.wait('@daftar')
    
    cy.reload()
    cy.get('button').contains('Daftar').click()
    
    cy.get('.alert-error, .swal2-error').should('be.visible')
    cy.contains('sudah terdaftar').should('be.visible')
  })

  it('should show error for unauthenticated users', () => {
    cy.clearCookies()
    cy.visit('/kegiatan')
    
    cy.get('.kegiatan-card').first().click()
    cy.get('button').contains('Daftar').click()
    
    cy.contains('harus login terlebih dahulu').should('be.visible')
  })

  it('should show error for users without pendonor data', () => {
    cy.loginAsUserWithoutPendonor()
    cy.visit('/kegiatan')
    
    cy.get('.kegiatan-card').first().click()
    cy.get('button').contains('Daftar').click()
    
    cy.contains('belum melengkapi data pendonor').should('be.visible')
  })

  it('should create donasi_darah record with correct data', () => {
    cy.intercept('POST', '/kegiatan/*/daftar').as('daftar')
    
    cy.get('.kegiatan-card').first().then(($card) => {
      const kegiatanId = $card.attr('data-id')
      cy.wrap($card).click()
      
      cy.get('button').contains('Daftar').click()
      cy.wait('@daftar').its('response.statusCode').should('eq', 200)
      
      // Verify the donasi_darah was created with correct fields
      cy.request(`/api/verify-donasi/${kegiatanId}`).then((response) => {
        expect(response.body).to.have.property('jenis_donor', 'Sukarela')
        expect(response.body).to.have.property('status_donasi', 'Terdaftar')
        expect(response.body).to.have.property('lokasi_donor')
      })
    })
  })
})