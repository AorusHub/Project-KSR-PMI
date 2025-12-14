// cypress/e2e/kegiatan-donor/participants.cy.js

describe('Kegiatan Donor - Participants Management', () => {
  beforeEach(() => {
    cy.loginAsAdmin()
  })

  it('should view participants list', () => {
    cy.visit('/managemen-kegiatan')
    cy.get('.btn-peserta').first().click()
    
    cy.url().should('include', '/peserta')
    cy.contains('Daftar Partisipan').should('be.visible')
    cy.get('.partisipan-table, .partisipan-list').should('be.visible')
  })

  it('should only show participants with valid pendonor and user', () => {
    cy.visit('/managemen-kegiatan')
    cy.get('.btn-peserta').first().click()
    
    cy.get('.partisipan-row').each(($row) => {
      cy.wrap($row).find('.nama-pendonor').should('exist')
      cy.wrap($row).find('.status-donasi').should('exist')
    })
  })

  it('should search participants by name', () => {
    cy.visit('/managemen-kegiatan')
    cy.get('.btn-peserta').first().click()
    
    cy.get('input[name="search"]').type('John')
    cy.get('button[type="submit"]').click()
    
    cy.get('.partisipan-row').each(($row) => {
      cy.wrap($row).find('.nama-pendonor').invoke('text').should('include', 'John')
    })
  })

  it('should paginate participants (10 per page)', () => {
    cy.visit('/managemen-kegiatan')
    cy.get('.btn-peserta').first().click()
    
    cy.get('.pagination').should('be.visible')
  })

  it('should preserve search query in pagination', () => {
    cy.visit('/managemen-kegiatan')
    cy.get('.btn-peserta').first().click()
    
    cy.get('input[name="search"]').type('Test')
    cy.get('button[type="submit"]').click()
    
    cy.get('.pagination a').contains('2').click()
    cy.url().should('include', 'search=Test')
    cy.url().should('include', 'page=2')
  })

  it('should deny access for non-admin/staf users', () => {
    cy.loginAsPendonor()
    cy.visit('/kegiatan-donor/1/peserta', { failOnStatusCode: false })
    
    cy.get('body').should('contain', '403')
  })
})