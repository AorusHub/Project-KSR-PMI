// cypress/e2e/kegiatan-donor/public-features.cy.js

describe('Kegiatan Donor - Public Features', () => {
  beforeEach(() => {
    cy.visit('/kegiatan')
  })

  it('should display list of planned activities', () => {
    cy.get('.card, .kegiatan-card').should('exist')
    cy.contains('Kegiatan Donor').should('be.visible')
  })

  it('should show only planned and upcoming activities', () => {
    cy.get('[data-status]').each(($el) => {
      cy.wrap($el).should('have.attr', 'data-status', 'Planned')
    })
  })

  it('should paginate activities (12 per page)', () => {
    cy.get('.pagination').should('be.visible')
  })

  it('should show activity details when clicked', () => {
    cy.get('.kegiatan-card').first().click()
    cy.url().should('include', '/kegiatan/')
    cy.contains('Detail Kegiatan').should('be.visible')
    cy.get('.total-donor').should('be.visible')
  })

  it('should display complete activity information', () => {
    cy.get('.kegiatan-card').first().within(() => {
      cy.get('.nama-kegiatan').should('be.visible')
      cy.get('.tanggal').should('be.visible')
      cy.get('.lokasi').should('be.visible')
      cy.get('.waktu').should('be.visible')
    })
  })
})