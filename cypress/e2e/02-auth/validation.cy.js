describe('Authentication Validation', () => {
  context('Login Validation', () => {
    beforeEach(() => {
      cy.visit('/login')
    })

    it('Email wajib diisi', () => {
      cy.get('input[name="password"]').type('password123')
      cy.get('button[type="submit"]').click()
      
      cy.get('input[name="email"]:invalid').should('exist')
    })

    it('Password wajib diisi', () => {
      cy.get('input[name="email"]').type('test@test.com')
      cy.get('button[type="submit"]').click()
      
      cy.get('input[name="password"]:invalid').should('exist')
    })

    it('Email harus format yang valid', () => {
      cy.get('input[name="email"]').type('invalidemail')
      cy.get('button[type="submit"]').click()
      
      cy.get('input[name="email"]:invalid').should('exist')
    })
  })
})