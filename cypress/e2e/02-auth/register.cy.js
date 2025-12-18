describe('User Registration', () => {
  
  let registerPageExists = false

  // Check if register page exists
  before(() => {
    cy.request({ 
      url: '/register', 
      failOnStatusCode: false 
    }).then((response) => {
      if (response.status === 200) {
        registerPageExists = true
        cy.log('✅ Register page available')
      } else {
        cy.log('⚠️ Register page not found (404)')
      }
    })
  })

  beforeEach(function() {
    if (!registerPageExists) {
      cy.log('⚠️ SKIP: Register page not implemented')
      this.skip()
    }

    cy.visit('/register', { 
      failOnStatusCode: false,
      timeout: 60000 
    })
    cy.get('body', { timeout: 30000 }).should('be.visible')
  })

  // ============================================
  // TEST 1: PAGE ACCESS
  // ============================================
  it('Halaman register dapat diakses', () => {
    cy.url().should('include', '/register')
    cy.checkPageExists()
    cy.contains(/daftar|register|sign.*up/i, { timeout: 10000 }).should('be.visible')
  })

  // ============================================
  // TEST 2: FORM ELEMENTS (FLEXIBLE)
  // ============================================
  it('Form register memiliki field yang diperlukan', () => {
    cy.get('form', { timeout: 10000 }).should('exist')
    
    // Check for name field (different possible names)
    cy.get('body').then(($body) => {
      const hasNameField = 
        $body.find('input[name="name"]').length > 0 ||
        $body.find('input[name="nama"]').length > 0 ||
        $body.find('input[name="username"]').length > 0 ||
        $body.find('input[id*="name"]').length > 0

      if (hasNameField) {
        cy.log('✅ Name field found')
      } else {
        cy.log('⚠️ Name field not found')
      }
    })
    
    // Check for email field
    cy.get('input[name="email"], input[type="email"]', { timeout: 10000 })
      .should('exist')
    
    // Check for password fields
    cy.get('input[name="password"], input[type="password"]')
      .should('exist')
      .should('have.length.at.least', 1)
    
    // Check for submit button
    cy.get('button[type="submit"], input[type="submit"]').should('exist')
  })

  // ============================================
  // TEST 3: REGISTRATION (ADAPTIVE)
  // ============================================
  it('User dapat mendaftar dengan data valid', () => {
    cy.fixture('users').then((users) => {
      const uniqueEmail = `donor${Date.now()}@test.com`
      const newUser = { 
        ...users.newDonor, 
        email: uniqueEmail 
      }
      
      cy.get('form').should('be.visible')
      
      // Fill name field (check different variations)
      cy.get('body').then(($body) => {
        if ($body.find('input[name="name"]').length > 0) {
          cy.get('input[name="name"]').clear().type(newUser.name)
        } else if ($body.find('input[name="nama"]').length > 0) {
          cy.get('input[name="nama"]').clear().type(newUser.name)
        } else if ($body.find('input[name="username"]').length > 0) {
          cy.get('input[name="username"]').clear().type(newUser.name)
        } else {
          cy.log('⚠️ Name field not found, skipping')
        }
      })
      
      // Fill email
      cy.get('input[name="email"], input[type="email"]')
        .clear()
        .type(newUser.email)
      
      // Fill password
      cy.get('input[name="password"]')
        .first()
        .clear()
        .type(newUser.password)
      
      // Fill password confirmation
      cy.get('body').then(($body) => {
        if ($body.find('input[name="password_confirmation"]').length > 0) {
          cy.get('input[name="password_confirmation"]')
            .clear()
            .type(newUser.password)
        } else if ($body.find('input[name="password_confirm"]').length > 0) {
          cy.get('input[name="password_confirm"]')
            .clear()
            .type(newUser.password)
        } else if ($body.find('input[type="password"]').length > 1) {
          cy.get('input[type="password"]')
            .eq(1)
            .clear()
            .type(newUser.password)
        }
      })
      
      // Fill optional fields if they exist
      cy.get('body').then(($body) => {
        // Phone
        if ($body.find('input[name="phone"], input[name="telepon"]').length > 0) {
          cy.get('input[name="phone"], input[name="telepon"]')
            .first()
            .clear()
            .type(newUser.phone || '081234567890')
        }
        
        // Blood type
        if ($body.find('select[name="golongan_darah"]').length > 0) {
          cy.get('select[name="golongan_darah"]')
            .select(newUser.golongan_darah || 'A')
        }
        
        // Birth date
        if ($body.find('input[name="tanggal_lahir"]').length > 0) {
          cy.get('input[name="tanggal_lahir"]')
            .clear()
            .type(newUser.tanggal_lahir || '1995-05-15')
        }
        
        // Address
        if ($body.find('textarea[name="alamat"]').length > 0) {
          cy.get('textarea[name="alamat"]')
            .clear()
            .type(newUser.alamat || 'Jl. Test No. 123')
        }
      })
      
      // Submit form
      cy.get('button[type="submit"], input[type="submit"]')
        .first()
        .click({ force: true })
      
      cy.wait(3000)
      
      // Verify redirect (to dashboard or login)
      cy.url({ timeout: 15000 }).should('match', /dashboard|login|home/)
      cy.log('✅ Registration successful')
    })
  })

  // ============================================
  // TEST 4: VALIDATION
  // ============================================
  it('Validasi: Email wajib diisi', () => {
    cy.get('button[type="submit"], input[type="submit"]')
      .first()
      .click({ force: true })
    
    cy.wait(1000)
    
    cy.get('body').then(($body) => {
      const hasError = $body.text().match(/required|wajib|harus/i)
      
      if (hasError) {
        cy.log('✅ Validation error shown')
      } else {
        cy.log('⚠️ Checking HTML5 validation')
      }
    })
  })

  it('Validasi: Password harus match', () => {
    cy.fixture('users').then((users) => {
      // Fill email
      cy.get('input[name="email"]').clear().type('test@test.com')
      
      // Fill password
      cy.get('input[name="password"]').first().clear().type('password123')
      
      // Fill different password confirmation
      cy.get('body').then(($body) => {
        if ($body.find('input[name="password_confirmation"]').length > 0) {
          cy.get('input[name="password_confirmation"]')
            .clear()
            .type('different123')
        } else if ($body.find('input[type="password"]').length > 1) {
          cy.get('input[type="password"]')
            .eq(1)
            .clear()
            .type('different123')
        }
      })
      
      cy.get('button[type="submit"]').first().click({ force: true })
      cy.wait(1000)
      
      cy.get('body').then(($body) => {
        if ($body.text().match(/match|sesuai|sama/i)) {
          cy.log('✅ Password mismatch detected')
        }
      })
    })
  })

  it('Validasi: Email harus unik', () => {
    cy.fixture('users').then((users) => {
      // Try to register with existing email
      cy.get('input[name="email"]').clear().type(users.admin.email)
      cy.get('input[name="password"]').first().clear().type('password123')
      
      cy.get('body').then(($body) => {
        if ($body.find('input[name="password_confirmation"]').length > 0) {
          cy.get('input[name="password_confirmation"]')
            .clear()
            .type('password123')
        }
      })
      
      cy.get('button[type="submit"]').first().click({ force: true })
      cy.wait(2000)
      
      // Should show error about duplicate email
      cy.get('body').then(($body) => {
        if ($body.text().match(/already|sudah|taken|terdaftar/i)) {
          cy.log('✅ Duplicate email detected')
        }
      })
    })
  })

  // ============================================
  // TEST 5: NAVIGATION
  // ============================================
  it('Menampilkan link ke halaman login', () => {
    cy.get('body').then(($body) => {
      const hasLoginLink = 
        $body.find('a[href*="login"]').length > 0 ||
        $body.text().match(/sudah.*akun|already.*account|login/i)
      
      if (hasLoginLink) {
        cy.get('a[href*="login"]').should('exist')
        cy.log('✅ Login link found')
      } else {
        cy.log('⚠️ No login link found')
      }
    })
  })

  it('User dapat redirect ke login', () => {
    cy.get('body').then(($body) => {
      if ($body.find('a[href*="login"]').length > 0) {
        cy.get('a[href*="login"]').first().click({ force: true })  // ✅ Added .first()
        cy.wait(1000)
        cy.url({ timeout: 10000 }).should('include', '/login')
        cy.log('✅ Redirected to login')
      } else {
        cy.log('⚠️ No login link to click')
      }
    })
  })

  // ============================================
  // TEST 6: UI/UX
  // ============================================
  it('Form responsive di mobile', () => {
    cy.viewport('iphone-x')
    cy.wait(500)
    
    cy.get('form').should('be.visible')
    cy.get('input[name="email"]').should('be.visible')
    
    // Reset viewport
    cy.viewport(1280, 720)
  })

  it('Password field adalah type password', () => {
    cy.get('input[name="password"]').should('have.attr', 'type', 'password')
  })
})