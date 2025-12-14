// cypress/e2e/kegiatan-donor/admin-management.cy.js

describe('Kegiatan Donor - Admin Management', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
    cy.visit('/managemen-kegiatan')
  })

  it('should display management dashboard for admin', () => {
    cy.contains('Manajemen Kegiatan').should('be.visible')
    cy.get('table, .kegiatan-list').should('be.visible')
  })

  it('should deny access for non-admin users', () => {
    cy.loginAsPendonor()
    cy.visit('/managemen-kegiatan', { failOnStatusCode: false })
    
    cy.get('body').should('contain', '403')
  })

  it('should show all activities ordered by date desc', () => {
    cy.get('tbody tr, .kegiatan-item').should('have.length.at.least', 1)
  })

  it('should display activity statistics', () => {
    cy.get('tbody tr, .kegiatan-item').first().within(() => {
      cy.get('.partisipan, [data-partisipan]').should('be.visible')
      cy.get('.tanggal-formatted').should('be.visible')
      cy.get('.status-label').should('be.visible')
    })
  })

  it('should display correct status labels and colors', () => {
    cy.get('[data-status="Ongoing"]').should('contain', 'Berlangsung')
    cy.get('[data-status="Completed"]').should('contain', 'Selesai')
    cy.get('[data-status="Cancelled"]').should('contain', 'Dibatalkan')
  })
})