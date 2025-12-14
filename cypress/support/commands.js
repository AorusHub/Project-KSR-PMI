// cypress/support/commands.js

Cypress.Commands.add('loginAsAdmin', () => {
  cy.session('admin', () => {
    cy.visit('/login')
    cy.get('input[name="email"]').type('admin@test.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })
})

Cypress.Commands.add('loginAsStaf', () => {
  cy.session('staf', () => {
    cy.visit('/login')
    cy.get('input[name="email"]').type('staf@test.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })
})

Cypress.Commands.add('loginAsPendonor', () => {
  cy.session('pendonor', () => {
    cy.visit('/login')
    cy.get('input[name="email"]').type('pendonor@test.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })
})

Cypress.Commands.add('loginAsUserWithoutPendonor', () => {
  cy.session('user-no-pendonor', () => {
    cy.visit('/login')
    cy.get('input[name="email"]').type('user@test.com')
    cy.get('input[name="password"]').type('password')
    cy.get('button[type="submit"]').click()
    cy.url().should('not.include', '/login')
  })
})

Cypress.Commands.add('createTestKegiatan', (data = {}) => {
  const defaultData = {
    nama_kegiatan: 'Test Kegiatan',
    tanggal: '2024-12-31',
    waktu_mulai: '09:00',
    waktu_selesai: '14:00',
    lokasi: 'Test Location',
    status: 'Planned',
    ...data
  }
  
  return cy.request({
    method: 'POST',
    url: '/kegiatan-donor',
    body: defaultData,
    headers: {
      'Accept': 'application/json'
    }
  })
})

Cypress.Commands.add('deleteTestKegiatan', (id) => {
  return cy.request({
    method: 'DELETE',
    url: `/kegiatan-donor/${id}`,
    headers: {
      'Accept': 'application/json'
    },
    failOnStatusCode: false
  })
})