// cypress/e2e/kegiatan-donor/status-update.cy.js

describe('Kegiatan Donor - Status Update', () => {
  beforeEach(() => {
    cy.loginAsStaf()
    cy.visit('/managemen-kegiatan')
  })

  it('should allow staf to update status', () => {
    cy.get('.btn-status, .status-dropdown').first().click()
    cy.contains('Ongoing').click()
    
    cy.intercept('PATCH', '/kegiatan-donor/*/status').as('updateStatus')
    cy.get('.btn-confirm-status').click()
    
    cy.wait('@updateStatus').its('response.statusCode').should('eq', 200)
    cy.contains('Status kegiatan berhasil diupdate').should('be.visible')
  })

  it('should only allow valid status values', () => {
    const validStatuses = ['Planned', 'Ongoing', 'Completed', 'Cancelled']
    
    cy.get('.status-dropdown').first().within(() => {
      validStatuses.forEach(status => {
        cy.contains(status).should('exist')
      })
    })
  })
})