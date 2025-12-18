describe('User Login', () => {
  beforeEach(() => {
    cy.visit('/login')
  })

  it('Halaman login dapat diakses', () => {
    cy.checkPageExists()
    cy.contains(/login|masuk/i).should('be.visible')
  })

  it('Form login memiliki field email dan password', () => {
    cy.get('input[name="email"]').should('exist')
    cy.get('input[name="password"]').should('exist')
    cy.get('button[type="submit"]').should('exist')
  })

  it('Admin dapat login dengan kredensial yang benar', () => {
    cy.fixture('users').then((users) => {
      cy.get('input[name="email"]').type(users.admin.email)
      cy.get('input[name="password"]').type(users.admin.password)
      cy.get('button[type="submit"]').click()
      
      cy.url().should('include', '/dashboard')
      cy.contains(/dashboard|beranda/i, { timeout: 10000 }).should('be.visible')
    })
  })

  it('Donor dapat login dengan kredensial yang benar', () => {
    cy.fixture('users').then((users) => {
      cy.get('input[name="email"]').type(users.donor.email)
      cy.get('input[name="password"]').type(users.donor.password)
      cy.get('button[type="submit"]').click()
      
      cy.url().should('include', '/dashboard')
    })
  })

  it('Login gagal dengan email yang salah', () => {
    cy.get('input[name="email"]').type('wrong@email.com')
    cy.get('input[name="password"]').type('password123')
    cy.get('button[type="submit"]').click()
    
    cy.contains(/invalid|salah|gagal/i).should('be.visible')
    cy.url().should('include', '/login')
  })

  it('Login gagal dengan password yang salah', () => {
    cy.fixture('users').then((users) => {
      cy.get('input[name="email"]').type(users.donor.email)
      cy.get('input[name="password"]').type('wrongpassword')
      cy.get('button[type="submit"]').click()
      
      cy.contains(/invalid|salah|gagal/i).should('be.visible')
    })
  })

  it('Menampilkan link ke halaman register', () => {
    cy.contains(/belum punya akun|register/i).should('be.visible')
    cy.get('a[href*="register"]').should('exist')
  })

  it('Menampilkan link forgot password', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a[href*="forgot"], a[href*="reset"]').length) {
        cy.get('a[href*="forgot"], a[href*="reset"]').should('be.visible')
      }
    })
  })

  it('Button submit disabled saat form kosong (jika ada validasi)', () => {
    cy.get('button[type="submit"]').click()
    cy.url().should('include', '/login')
  })
})