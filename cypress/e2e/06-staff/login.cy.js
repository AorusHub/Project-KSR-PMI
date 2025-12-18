describe('Staff - Login', () => {
  
  beforeEach(() => {
    cy.visit('/login')
    cy.wait(1000)
  })

  it('Staff dapat login dengan kredensial valid', () => {
    cy.fixture('users').then((users) => {
      cy.get('input[name="email"]').type(users.staff.email)
      cy.get('input[name="password"]').type(users.staff.password)
      cy.get('button[type="submit"]').click()
      
      cy.wait(2000)
      cy.url().should('include', '/dashboard')
      cy.contains(/dashboard|beranda/i).should('be.visible')
      cy.log('✅ Login berhasil')
    })
  })

  it('Staff tidak dapat login dengan email salah', () => {
    cy.get('input[name="email"]').type('wrong@email.com')
    cy.get('input[name="password"]').type('password123')
    cy.get('button[type="submit"]').click()
    
    cy.wait(1000)
    cy.get('body').should('contain', /invalid|salah|gagal/i)
    cy.log('✅ Error message ditampilkan')
  })

  it('Staff tidak dapat login dengan password salah', () => {
    cy.fixture('users').then((users) => {
      cy.get('input[name="email"]').type(users.staff.email)
      cy.get('input[name="password"]').type('wrongpassword')
      cy.get('button[type="submit"]').click()
      
      cy.wait(1000)
      cy.get('body').should('contain', /invalid|salah|gagal/i)
      cy.log('✅ Error message ditampilkan')
    })
  })

  it('Validasi: Email field wajib diisi', () => {
    cy.get('input[name="password"]').type('password123')
    cy.get('button[type="submit"]').click()
    
    cy.get('input[name="email"]').then(($input) => {
      expect($input[0].validity.valid).to.be.false
    })
    cy.log('✅ Validasi email bekerja')
  })

  it('Validasi: Password field wajib diisi', () => {
    cy.get('input[name="email"]').type('staff@pmi.com')
    cy.get('button[type="submit"]').click()
    
    cy.get('input[name="password"]').then(($input) => {
      expect($input[0].validity.valid).to.be.false
    })
    cy.log('✅ Validasi password bekerja')
  })

  it('Staff diarahkan ke dashboard setelah login', () => {
    cy.loginAsStaff()
    cy.url({ timeout: 10000 }).should('include', '/dashboard')
    cy.log('✅ Redirect ke dashboard')
  })
})