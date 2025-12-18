// Import commands.js using ES2015 syntax:
import './commands'

// Alternatively you can use CommonJS syntax:
// require('./commands')

// Global configuration
Cypress.on('uncaught:exception', (err, runnable) => {
  // Returning false here prevents Cypress from failing the test
  // on uncaught exceptions from your application
  
  // Ignore common network errors
  if (err.message.includes('Network Error')) {
    return false
  }
  
  // Ignore CORS errors
  if (err.message.includes('CORS')) {
    return false
  }
  
  // Ignore ResizeObserver errors (common in modern apps)
  if (err.message.includes('ResizeObserver')) {
    return false
  }
  
  // Let other errors fail the test
  return true
})

// Before each test
beforeEach(() => {
  // Clear cookies and local storage before each test
  cy.clearCookies()
  cy.clearLocalStorage()
  
  // Set default viewport
  cy.viewport(1280, 720)
})

// After each test
afterEach(function() {
  // Take screenshot on failure
  if (this.currentTest.state === 'failed') {
    cy.screenshot(`failed-${this.currentTest.title}`)
  }
})

// Global constants
Cypress.env('API_URL', Cypress.config('baseUrl'))